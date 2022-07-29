<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\OrganizationResource;

class OrganizationService
{
    public function update($request, $organization): OrganizationResource
    {
        $organization->update($request->only('name', 'description', 'phone'));
        return new OrganizationResource($organization);
    }
}
