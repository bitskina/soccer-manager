<?php

namespace App\Services;

use App\Data\PlayerData;
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

    public function update(Player $player, PlayerData $data): void
    {
        $player->update($data->toArray());
    }
}
