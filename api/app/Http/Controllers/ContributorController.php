<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ContributorDonationHistoryResource;
use App\Repositories\DonationsRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ContributorController extends Controller
{
    public function __construct(private readonly DonationsRepository $donationsRepository)
    {}

    public function getDonationHistory(): AnonymousResourceCollection
    {
        return ContributorDonationHistoryResource::collection($this->donationsRepository->getAllContributorHistory(Auth::user()));
    }
}
