<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\ContributorResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserResource;
use App\Models\Contributor;
use App\Models\Organization;
use App\Models\User;

class RegisterService
{
    public function registerOrganization($request): array
    {
        $user = User::create(
            [
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );

        $organization = Organization::create(array_merge(
            $request->only('name', 'description', 'phone'),
            ['user_id' => $user->id]
        ));

        $token = $user->createToken('organizationToken')->plainTextToken;

        session()->put('token', $token);

        return [
            'user' => new UserResource($user),
            'role_data' => new OrganizationResource($organization)
        ];
    }

    public function registerContributor($request): array
    {
        $user = User::create(
            [
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );

        $contributor = Contributor::create(array_merge(
            $request->only('first_name', 'middle_name', 'last_name'),
            ['user_id' => $user->id]
        ));

        $token = $user->createToken('contributorToken')->plainTextToken;

        session()->put('token', $token);

        return [
            'user' => new UserResource($user),
            'role_data' => new ContributorResource($contributor)
        ];
    }
}
