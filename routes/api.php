<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('user/team', [TeamController::class, 'show']);
    Route::patch('user/team', [TeamController::class, 'update']);
});
