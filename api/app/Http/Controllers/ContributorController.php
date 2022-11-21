<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContributorSettingsRequest;
use App\Http\Resources\ContributorDonationHistoryResource;
use App\Http\Resources\LastMonthDonatesResource;
use App\Repositories\ContributorsRepository;
use App\Repositories\DonationsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContributorController extends Controller
{
    public function __construct(
        private readonly DonationsRepository $donationsRepository,
        private readonly ContributorsRepository $contributorsRepository
    ) {}

    public function getDonationHistory(): AnonymousResourceCollection
    {
        return ContributorDonationHistoryResource::collection($this->donationsRepository->getAllContributorHistory(Auth::user()));
    }

    public function getSettings(Request $request): JsonResponse
    {
        return response()->json($this->contributorsRepository->getContributorSettings($request));
    }

    public function updateSettings(UpdateContributorSettingsRequest $request): JsonResponse
    {
        return response()->json($this->contributorsRepository->updateContributorSettings($request));
    }

    public function lastMonthDonates(Request $request): AnonymousResourceCollection
    {
        return LastMonthDonatesResource::collection($this->donationsRepository->getLastMonthDonates($request));
    }

    public function averagePerMonth(Request $request): JsonResponse
    {
        return response()->json($this->donationsRepository->getAveragePerMonth($request));
    }

    public function donatedTheMost(Request $request): JsonResponse
    {
        return response()->json($this->donationsRepository->getTheMostImportantCompanies($request));
    }
}
