<?php

namespace App\Jobs;

use App\Enums\PlayerPosition;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class GenerateUserTeam implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @throws \Throwable
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $team = Team::factory()->for($this->user)->create();

            $positions = [
                PlayerPosition::GoalKeeper->value => 3,
                PlayerPosition::Defender->value => 6,
                PlayerPosition::MidFielder->value => 6,
                PlayerPosition::Striker->value => 5,
            ];

            foreach ($positions as $position => $count) {
                Player::factory()
                    ->count($count)
                    ->for($team)
                    ->create([
                        'position' => $position,
                    ]);
            }
        });
    }
}
