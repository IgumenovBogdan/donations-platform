<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PaypalPaymentService;
use Illuminate\Http\Request;

class PaypalPaymentController extends Controller
{
    public function __construct(private readonly PaypalPaymentService $paymentService)
    {}

    public function donate(Request $request)
    {
        return $this->paymentService->donate($request);
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
