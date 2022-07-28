<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LotPolicy
{
    use HandlesAuthorization;

    public function create(User $user): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasOne|null
    {
        return $user->organization()->first();
    }

    public function update(User $user, Lot $lot): bool
    {
        return $user->organization()->first()->id  === $lot->organization_id;
    }

    public function delete(User $user, Lot $lot): bool
    {
        return $user->organization()->first()->id === $lot->organization_id;
    }
}
