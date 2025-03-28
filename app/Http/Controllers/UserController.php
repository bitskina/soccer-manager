<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function register(StoreUserRequest $request): Response
    {
        $this->userService->store($request->validated());

        return response()->noContent(status: 201);
    }
}
