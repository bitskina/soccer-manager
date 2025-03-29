<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;

class PlayerService
{
    /**
     * @return LengthAwarePaginator<Player>
     */
    public function getTeamPlayers(Team $team): LengthAwarePaginator
    {
        return $team->players()
            ->with('country.translation')
            ->latest()
            ->paginate();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Player $player, array $data): void
    {
        $player->update($data);
    }
}
