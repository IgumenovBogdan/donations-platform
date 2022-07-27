<?php
declare(strict_types=1);
namespace App\Services;

use App\Http\Resources\ContributorResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserResource;
use App\Models\Contributor;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function registerOrganization($request): array
    {
        $user = User::create(
            [
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]
        );

        $organization = Organization::create(
            [
                'user_id' => $user->id,
                'name' => $request->name,
                'description' => $request->description,
                'phone' => $request->phone
            ]
        );

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

        $contributor = Contributor::create(
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name
            ]
        );

        $token = $user->createToken('contributorToken')->plainTextToken;

        session()->put('token', $token);

        return [
            'user' => new UserResource($user),
            'role_data' => new ContributorResource($contributor)
        ];
    }

    public function login($request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return throw ValidationException::withMessages(['password' => 'Invalid password']);
        }

        if($user->organization()->first()) {
            return [
                'user' => new UserResource($user),
                'role_data' => new OrganizationResource($user->organization()->first()),
                'token' => $user->createToken('organizationToken')->plainTextToken
            ];
        }

        if($user->contributor()->first()) {
            return [
                'user' => new UserResource($user),
                'role_data' => new ContributorResource($user->contributor()->first()),
                'token' => $user->createToken('organizationToken')->plainTextToken
            ];
        }
    }
}
