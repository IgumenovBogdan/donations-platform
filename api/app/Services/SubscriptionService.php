<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ChangeSubscritionTariffRequest;
use App\Http\Requests\SubscribeToOrganizationRequest;
use App\Models\Contributor;
use App\Models\Organization;
use App\Models\Subscription;
use App\Repositories\SubscriptionsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function __construct(
        private readonly StripeService $stripeService,
        private readonly SubscriptionsRepository $subscriptionsRepository
    )
    {}

    public function getSubscriptionTariffs(): array
    {
        return config('enums.tariffs');
    }

    public function payForSubscription(SubscribeToOrganizationRequest $request, string $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $contributor = Contributor::findOrFail($request->user()->contributor->id);

        DB::beginTransaction();

        try {
            $customer = $this->stripeService->checkCustomer($request, $contributor);

            $this->stripeService->createCharge(customerId: $customer, price: $request->amount);

            $subscription = $this->subscriptionsRepository->createSubscription($request, $contributor->id, $organization->id);

            $this->subscriptionsRepository->createSubscriptionHistory($subscription->id);

            DB::commit();

            return response()->json([
                'message' => 'Subscription completed!'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \DomainException('Subscribe error');
        }
    }

    public function changeTariff(ChangeSubscritionTariffRequest $request, string $id): Subscription
    {
        return $this->subscriptionsRepository->updateSubscriptionTariff($request, $id);
    }
}
