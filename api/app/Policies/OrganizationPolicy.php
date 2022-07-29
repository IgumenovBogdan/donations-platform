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

    public function update(User $user, Organization $organization): Response
    {
        return $user->organization()->first()
            ? Response::allow()
            : Response::deny('You are not an organization.');
    }
}
