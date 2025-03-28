<?php

namespace Database\Factories;

use App\Enums\PlayerPosition;
use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'country_id' => Country::inRandomOrder()->value('id'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'position' => $this->faker->randomElement(PlayerPosition::cases()),
            'age' => $this->faker->numberBetween(18, 40),
            'market_value' => config('player.default_market_value'),
        ];
    }
}
