<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StripeDonateRequest;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function __construct(private readonly StripePaymentService $paymentService)
    {}

    public function donate(StripeDonateRequest $request, $id): array
    {
        return $this->paymentService->donate($request, $id);
    }
}
