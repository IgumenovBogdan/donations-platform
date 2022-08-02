<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;

class OrganizationController extends Controller
{
    public function __construct(protected readonly OrganizationService $organizationService)
    {
        $this->authorizeResource(Organization::class);
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OrganizationResource::collection(Organization::paginate(10));
    }

    public function show(Organization $organization): OrganizationResource
    {
        return new OrganizationResource($organization);
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization): OrganizationResource
    {
        return $this->organizationService->update($request, $organization);
    }
}
