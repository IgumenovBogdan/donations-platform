<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Repositories\DonationsRepository;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organizationService,
        private readonly DonationsRepository $donationsRepository
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return OrganizationResource::collection(Organization::paginate(10));
    }

    public function show(Organization $organization): OrganizationResource
    {
        return new OrganizationResource($organization);
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization): OrganizationResource
    {
        $this->authorize('owner', $organization);
        return $this->organizationService->update($request, $organization);
    }

    public function getOrganizationStatistics(Request $request): JsonResponse
    {
        $this->authorize('owner', $request->user()->organization);
        return response()->json($this->donationsRepository->getAllOrganizationTotalHistoryByPeriod($request));
    }

    public function lastWeekContributorsDonates(Request $request): JsonResponse
    {
        return response()->json($this->donationsRepository->getLastWeekContributorsDonates($request));
    }

    public function lastWeekContributorsTransactions(Request $request): JsonResponse
    {
        return response()->json($this->donationsRepository->getLastWeekContributorsTransactions($request));
    }

    public function topContributorsForTheYear(Request $request): JsonResponse
    {
        return response()->json($this->donationsRepository->getTopContributorsForTheYear($request));
    }
}
