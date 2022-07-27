<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterContributorRequest;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerOrganization(RegisterOrganizationRequest $request, AuthService $authService)
    {
        return response($authService->registerOrganization($request));
    }

    public function registerContributor(RegisterContributorRequest $request, AuthService $authService)
    {
        return response($authService->registerContributor($request));
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        return response($authService->login($request));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(['message' => 'Logged out']);
    }
}
