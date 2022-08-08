<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;
use App\Models\Lot;

class PaypalPaymentService
{
    public function __construct(private readonly PaypalService $paypalService)
    {}

    public function donate($request): \stdClass
    {
        return $this->paypalService->createPayment(floatval($request->price));
    }

    public function capture($id, $lotId): \stdClass
    {
        $lot = Lot::findOrFail($lotId);
        $contributor = Contributor::findOrFail(auth()->user()->contributor->id);

        $payment = $this->paypalService->capturePayment($id);
        $price = intval($payment->purchase_units[0]->payments->captures[0]->amount->value);

        $lot->total_collected += $price;
        $lot->save();

        $lot->contributors()->attach($contributor->id, [
           'total_sent' => $price
        ]);

        return $payment;
    }

    public function registerMerchant(): \Illuminate\Http\RedirectResponse
    {
        $links = $this->paypalService->getRegisterCustomerLinks();
        return \Redirect::to($links[1]['href']);
    }

    public function setMerchantId($id): array
    {
        $contributor = Contributor::findOrFail(auth()->user()->contributor->id);
        $contributor->merchant_id = $id;
        $contributor->save();
        return ['message' => 'Id was set'];
    }
}
