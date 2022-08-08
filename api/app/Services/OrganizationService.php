<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\UpdateOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;

class OrganizationService
{
    public function update(UpdateOrganizationRequest $request, Organization $organization): OrganizationResource
    {
        $organization->update($request->only('name', 'description', 'phone'));
        return new OrganizationResource($organization);
    }
}
