<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaypalDonateRequest;
use App\Services\PaypalPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redirect;

class PaypalPaymentController extends Controller
{
    public function __construct(private readonly PaypalPaymentService $paymentService)
    {}

    public function donate(PaypalDonateRequest $request): JsonResponse
    {
        return response()->json($this->paymentService->donate($request));
    }

    public function capture(Request $request, string $id, string $lotId): JsonResponse
    {
        return response()->json($this->paymentService->capture($request, $id, $lotId));
    }

    public function registerMerchant(): RedirectResponse
    {
        return Redirect::to($this->paymentService->registerMerchant());
    }

    public function setMerchantId(Request $request, string $id): array
    {
        return $this->paymentService->setMerchantId($request, $id);
    }
}
