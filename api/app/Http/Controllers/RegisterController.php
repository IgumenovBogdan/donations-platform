<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterContributorRequest;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Services\RegisterService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $registerService)
    {}

    public function registerOrganization(RegisterOrganizationRequest $request): Response|Application|ResponseFactory
    {
        $organization = $this->registerService->registerOrganization($request);
        session()->put('token', $organization->only('token'));
        return response($organization->only('user', 'role_data'));
    }

    public function registerContributor(RegisterContributorRequest $request): Response|Application|ResponseFactory
    {
        $contributor = $this->registerService->registerContributor($request);
        session()->put('token', $contributor->only('token'));
        return response($contributor->only('user', 'role_data'));
    }
}
