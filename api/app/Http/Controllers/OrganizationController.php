<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationDonationHistoryResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Repositories\DonationsRepository;
use App\Services\OrganizationService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organizationService,
        private readonly DonationsRepository $donationsRepository
    )
    {}

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
        $this->authorize('update', $organization);
        return $this->organizationService->update($request, $organization);
    }

    public function getLotDonationHistory(string $id): AnonymousResourceCollection
    {
        return OrganizationDonationHistoryResource::collection($this->donationsRepository->getAllLotHistory($id));
    }
}
