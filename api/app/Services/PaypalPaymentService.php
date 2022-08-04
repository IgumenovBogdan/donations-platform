<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Contributor;

class PaypalPaymentService
{
    public function __construct(private readonly PaypalService $paypalService)
    {}

    public function registerMerchant(): \Illuminate\Http\RedirectResponse
    {
        $links = $this->paypalService->getRegisterCustomerLinks('https://api-m.sandbox.paypal.com/v2/customer/partner-referrals');
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
