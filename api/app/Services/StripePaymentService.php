<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\StripeDonateRequest;
use App\Models\Contributor;
use App\Models\Lot;
use Illuminate\Http\JsonResponse;

class StripePaymentService
{
    public function __construct(private readonly StripeService $stripeService)
    {}

    public function donate(StripeDonateRequest $request, string $id): JsonResponse
    {
        $lot = Lot::findOrFail($id);
        $contributor = Contributor::findOrFail($request->user()->contributor->id);

        if($lot->is_completed) {
            return response()->json([
                'message' => 'Lot fees are over.'
            ], 405);
        }

        $customer = $this->stripeService->checkCustomer($request, $contributor);

        $this->stripeService->createCharge(customerId: $customer, price: $request->price);

        $lot->total_collected += $request->price;
        $lot->save();

        $lot->contributors()->attach($contributor->id, [
            'total_sent' => $request->price
        ]);

        return response()->json([
            'message' => 'Payment success!'
        ], 200);
    }
}
