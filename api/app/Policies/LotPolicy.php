<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LotPolicy
{
    use HandlesAuthorization;

    public function create(User $user): Response
    {
        return $user->organization()->first()
            ? Response::allow()
            : Response::deny('You are not an organization.');
    }

    public function update(User $user, Lot $lot): Response
    {
        return $user->organization()->first()->id ?? null === $lot->organization_id
            ? Response::allow()
            : Response::deny('You do not own this lot.');
    }

    public function delete(User $user, Lot $lot): Response
    {
        return $user->organization()->first()->id ?? null === $lot->organization_id
            ? Response::allow()
            : Response::deny('You do not own this lot.');
    }
}
