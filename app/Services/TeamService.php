<?php

namespace App\Services;

use App\Data\TeamData;
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

    public function update(Team $team, TeamData $data): void
    {
        $team->update($data->toArray());
    }
}
