<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\DonationHistoryResource;

class ContributorService
{
    public function getDonationHistory(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DonationHistoryResource::collection(auth()->user()->contributor->lots()->orderBy('contributor_lot.created_at', 'desc')->paginate(10));
    }
}
