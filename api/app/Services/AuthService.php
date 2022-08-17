<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\ContributorResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return throw ValidationException::withMessages(['password' => 'Invalid password']);
        }

        if($user->organization()->first()) {
            return [
                'user' => new UserResource($user),
//                'role_data' => new OrganizationResource($user->organization()->first()),
                'token' => $user->createToken('organizationToken')->plainTextToken
            ];
        }

        if($user->contributor()->first()) {
            return [
                'user' => new UserResource($user),
//                'role_data' => new ContributorResource($user->contributor()->first()),
                'token' => $user->createToken('organizationToken')->plainTextToken
            ];
        }
    }

    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();
        return ['message' => 'Logged out'];
    }

    public function getUserByToken(Request $request): array
    {
        $user = User::findOrFail($request->user()->id);

        if($user->organization()->first()) {
            return [
                'user' => new UserResource($user),
                'role_data' => new OrganizationResource($user->organization()->first())
            ];
        }

        if($user->contributor()->first()) {
            return [
                'user' => new UserResource($user),
                'role_data' => new ContributorResource($user->contributor()->first())
            ];
        }
    }
}
