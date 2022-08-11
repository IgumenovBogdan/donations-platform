<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangeSubscritionTariffRequest;
use App\Http\Requests\SubscribeToOrganizationRequest;
use App\Models\Contributor;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    public function changeTariff(ChangeSubscritionTariffRequest $request, string $id): JsonResponse
    {
        $this->authorize('update', Subscription::findOrFail($id));
        return response()->json($this->subscriptionService->changeTariff($request, $id));
    }
}
