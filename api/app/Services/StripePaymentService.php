<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\StripeDonateRequest;
use App\Models\Contributor;
use App\Models\Lot;

class StripePaymentService
{
    public function __construct(private readonly StripeService $stripeService)
    {}

    public function donate(StripeDonateRequest $request, string $id): array
    {
        $lot = Lot::findOrFail($id);
        $contributor = Contributor::findOrFail($request->user()->contributor->id);

        if($contributor->customer_id === null) {
            $customer = $this->stripeService->createCustomerByCard(...$request->only('email', 'number', 'expMonth', 'expYear', 'cvc'));
            $contributor->customer_id = $customer;
            $contributor->save();
        } else {
            $customer = $contributor->customer_id;
        }

        $this->stripeService->createCharge(customerId: $customer, price: $request->price);

        $lot->total_collected += $request->price;
        $lot->save();

        $lot->contributors()->attach($contributor->id, [
            'total_sent' => $request->price
        ]);

        return ['message' => 'Payment success!'];
    }
}
