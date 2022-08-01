<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ContributorService;
use Illuminate\Http\Request;

class ContributorController extends Controller
{
    public function __construct(private readonly ContributorService $contributorService)
    {}

    public function getDonationHistory(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $this->contributorService->getDonationHistory();
    }
}
