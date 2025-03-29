<?php

namespace App\Data;

class CreatePlayerTransferData extends AbstractLaravelData
{
    public function __construct(
        public int $teamId,
        public int $playerId,
        public float $sellPrice,
    ) {}
}
