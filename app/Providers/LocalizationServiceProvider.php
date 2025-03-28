<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
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
    public function boot(Request $request): void
    {
        $locale = $request->header('X-Accept-Language');

        if (filled($locale) && in_array($locale, (array) config('translatable.locales'))) {
            app()->setLocale($locale);
        }
    }
}
