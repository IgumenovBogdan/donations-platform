<?php

namespace App\Repositories;

use App\Models\User;

class DonationsRepository
{
    public function getAllHistory(User $user)
    {
        return $user->contributor->lots()->orderBy('contributor_lot.created_at', 'desc')->paginate(10);
    }
}
