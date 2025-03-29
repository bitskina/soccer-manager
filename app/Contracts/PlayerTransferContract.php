<?php

namespace App\Contracts;

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
     *
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): void;

    public function buy(Team $team, PlayerTransfer $transfer): void;
}
