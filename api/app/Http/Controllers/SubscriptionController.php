<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeToOrganizationRequest;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionService $subscriptionService)
    {}

    public function getSubscriptionTariffs(): JsonResponse
    {
        return response()->json($this->subscriptionService->getSubscriptionTariffs());
    }

    public function payForSubscription(SubscribeToOrganizationRequest $request, string $id): JsonResponse
    {
        return $this->subscriptionService->payForSubscription($request, $id);
    }
}
