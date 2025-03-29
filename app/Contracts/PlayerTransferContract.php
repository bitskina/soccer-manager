<?php

namespace App\Contracts;

use App\Data\CreatePlayerTransferData;
use App\Models\PlayerTransfer;
use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlayerTransferContract
{
    /**
     * @return LengthAwarePaginator<PlayerTransfer>
     */
    public function paginate(): LengthAwarePaginator;

    /**
     * Store a player transfer.
     */
    public function store(CreatePlayerTransferData $data): void;

    public function buy(Team $team, PlayerTransfer $transfer): void;
}
