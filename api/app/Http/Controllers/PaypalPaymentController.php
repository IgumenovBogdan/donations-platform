<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaypalDonateRequest;
use App\Services\PaypalPaymentService;

class PaypalPaymentController extends Controller
{
    public function __construct(private readonly PaypalPaymentService $paymentService)
    {}

    public function donate(PaypalDonateRequest $request): \stdClass
    {
        return $this->paymentService->donate($request);
    }

    public function capture($id, $lotId): \stdClass
    {
        return $this->paymentService->capture($id, $lotId);
    }

    public function registerMerchant(): \Illuminate\Http\RedirectResponse
    {
        return $this->paymentService->registerMerchant();
    }

    public function setMerchantId($id): array
    {
        return $this->paymentService->setMerchantId($id);
    }
}
