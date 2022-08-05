<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;

class PaypalPaymentService
{
    public function __construct(private readonly PaypalService $paypalService)
    {}

    public function donate($request)
    {
        $contributor = Contributor::findOrFail(auth()->user()->contributor->id);
        return $this->paypalService->createPayment($contributor->merchant_id, floatval($request->price));
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
