<?php

namespace App\Providers;

use App\Contracts\PlayerTransferContract;
use App\Models\Player;
use App\Models\User;
use App\Services\PlayerTransferService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerTransferContract::class, PlayerTransferService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-player', function (User $user, Player $player): bool {
            return $user->team?->id === $player->team_id;
        });
    }
}
