<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;
use App\Models\Organization;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function __construct(
        private readonly StripeService $stripeService
    )
    {}

    public function getSubscriptionTariffs(): array
    {
        return config('enums.tariffs');
    }

    public function payForSubscription(Request $request, string $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $contributor = Contributor::findOrFail($request->user()->contributor->id);

        DB::beginTransaction();

        try {
            if($contributor->customer_id === null) {
                $customer = $this->stripeService->createCustomerByCard(...$request->only('email', 'number', 'expMonth', 'expYear', 'cvc'));
                $contributor->customer_id = $customer;
                $contributor->save();
            } else {
                $customer = $contributor->customer_id;
            }

            $this->stripeService->createCharge(customerId: $customer, price: floatval($request->amount));

            $subscription = Subscription::create([
                'contributor_id' => $contributor->id,
                'organization_id' => $organization->id,
                'amount' => $request->amount,
            ]);

            SubscriptionHistory::create([
                'subscription_id' => $subscription->id,
                'payed_at' => Carbon::now()->toDateString()
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Subscription completed!'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \DomainException('Subscribe error');
        }
    }
}
