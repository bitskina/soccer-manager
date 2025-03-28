<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;

class TeamService
{
    public function getUserTeam(User $user): Team
    {
        return $user->team()
            ->with('country.translation')
            ->withSum('players', 'market_value')
            ->sole();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Team $team, array $data): void
    {
        $team->update($data);
    }
}
