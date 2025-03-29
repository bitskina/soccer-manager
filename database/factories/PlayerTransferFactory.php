<?php

namespace Database\Factories;

use App\Enums\PlayerTransferStatus;
use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerTransferFactory extends Factory
{
    protected $model = PlayerTransfer::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'player_id' => Player::factory(),
            'sell_price' => $this->faker->randomFloat(),
            'status' => $this->faker->randomElement(PlayerTransferStatus::cases()),
        ];
    }
}
