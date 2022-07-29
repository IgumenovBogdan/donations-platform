<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Organization $organization)
    {
        return $user->id ?? null === $organization->user_id
                ? Response::allow()
                : Response::deny('You do not own this organization.');
    }
}
