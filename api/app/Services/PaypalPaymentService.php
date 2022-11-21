<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\PaypalDonateRequest;
use App\Models\Contributor;
use App\Models\Lot;
use Illuminate\Http\Request;

class PaypalPaymentService
{
    public function __construct(private readonly PaypalService $paypalService)
    {}

    public function donate(PaypalDonateRequest $request): array
    {
        return $this->paypalService->createPayment($request->price);
    }

    public function capture(Request $request, string $id, string $lotId): array
    {
        $lot = Lot::findOrFail($lotId);
        $contributor = Contributor::findOrFail($request->user()->contributor->id);

        $payment = $this->paypalService->capturePayment($id);
        $price = intval($payment['purchase_units'][0]['payments']['captures'][0]['amount']['value']);

        $lot->total_collected += $price;
        $lot->save();

        $lot->contributors()->attach($contributor->id, [
           'total_sent' => $price
        ]);

        $contributor->organizations()->attach($lot->organization->id, [
            'sent' => $request->price
        ]);

        return $payment;
    }

    public function registerMerchant(): string
    {
        $links = $this->paypalService->getRegisterCustomerLinks();
        return $links[1]['href'];
    }

    public function setMerchantId(Request $request, string $id): array
    {
        $contributor = Contributor::findOrFail($request->user()->contributor->id);
        $contributor->merchant_id = $id;
        $contributor->save();
        return ['message' => 'Id was set'];
    }
}
