<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterContributorRequest;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Services\RegisterService;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $registerService)
    {}

    public function registerOrganization(RegisterOrganizationRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response($this->registerService->registerOrganization($request));
    }

    public function registerContributor(RegisterContributorRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response($this->registerService->registerContributor($request));
    }
}
