<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, Subscription $subscription): Response
    {
        $condition = $user->id ?? null;
        return $condition === $subscription->contributor->user->id
            ? Response::allow()
            : Response::deny('You are not this contributor.');
    }
}
