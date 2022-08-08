<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {}

    public function login(LoginRequest $request): Response|Application|ResponseFactory
    {
        return response($this->authService->login($request));
    }

    public function logout(Request $request): Response|Application|ResponseFactory
    {
        return response($this->authService->logout($request));
    }

    public function getUserByToken(Request $request): Response|Application|ResponseFactory
    {
        return response($this->authService->getUserByToken());
    }
}
