<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerTransferController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserHasTeam;

Route::middleware('guest')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware(EnsureUserHasTeam::class)->group(function () {
        Route::get('user/team', [TeamController::class, 'show']);
        Route::patch('user/team', [TeamController::class, 'update']);

        Route::resource('players', PlayerController::class)
            ->only(['index', 'update']);

        Route::prefix('player-transfers')->group(function () {
            Route::get('/', [PlayerTransferController::class, 'index']);
            Route::post('/', [PlayerTransferController::class, 'store']);
            Route::post('/{playerTransfer}/buy', [PlayerTransferController::class, 'buy']);
        });
    });
});
