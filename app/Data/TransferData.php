<?php

namespace App\Data;

use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;

class TransferData extends AbstractLaravelData
{
    public function __construct(
        public PlayerTransfer $transfer,
        public Player $player,
        public Team $buyerTeam,
        public Team $sellerTeam,
    ) {}
}
