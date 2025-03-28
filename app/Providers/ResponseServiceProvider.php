<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function (?array $data = null): JsonResponse {
            $response = [
                'success' => true,
            ];

            if (! is_null($data)) {
                $response['data'] = $data;
            }

            return Response::json($response);
        });

        Response::macro('error', function (string $message, int $status = 400): JsonResponse {
            return Response::json([
                'success' => false,
                'errorMessage' => $message,
            ], $status);
        });
    }
}
