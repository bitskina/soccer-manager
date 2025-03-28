<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->success([
            'token' => $this->authService->login($request->string('email'), $request->string('password')),
        ]);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authService->logout($user);

        return response()->success();
    }
}
