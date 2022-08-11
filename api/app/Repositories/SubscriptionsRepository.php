<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\ChangeSubscritionTariffRequest;
use App\Http\Requests\SubscribeToOrganizationRequest;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Carbon\Carbon;

class SubscriptionsRepository
{
    public function createSubscription(SubscribeToOrganizationRequest $request, int $contributorId, int $organizationId): Subscription
    {
        return Subscription::create([
            'contributor_id' => $contributorId,
            'organization_id' => $organizationId,
            'amount' => $request->amount,
            'tariff' => $request->tariff,
            'subscribed_at' => Carbon::now()
        ]);
    }

    public function createSubscriptionHistory(int $subscriptionId): void
    {
        SubscriptionHistory::create([
            'subscription_id' => $subscriptionId,
            'payed_at' => Carbon::now()
        ]);
    }

    public function updateSubscriptionDate(int $subscriptionId): void
    {
        Subscription::findOrFail($subscriptionId)->update([
            'subscribed_at' => Carbon::now()
        ]);
    }

    public function updateSubscriptionTariff(ChangeSubscritionTariffRequest $request, string $id): Subscription
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->amount = $request->amount;
        $subscription->tariff = $request->tariff;
        $subscription->subscribed_at = $subscription->subscribed_at->addMonths(1);
        $subscription->save();
        return $subscription;
    }
}
