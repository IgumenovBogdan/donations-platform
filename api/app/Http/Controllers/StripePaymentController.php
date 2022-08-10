<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StripeDonateRequest;
use App\Services\StripePaymentService;
use Illuminate\Http\JsonResponse;

class StripePaymentController extends Controller
{
    public function __construct(private readonly StripePaymentService $paymentService)
    {}

    public function donate(StripeDonateRequest $request, $id): JsonResponse
    {
        return $this->paymentService->donate($request, $id);
    }
}
