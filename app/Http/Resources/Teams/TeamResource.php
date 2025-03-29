<?php

namespace App\Http\Resources\Teams;

use App\Http\Resources\Countries\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'budget' => Number::currency(is_numeric($this->budget) ? (float) $this->budget : 0),
            'value' => $this->whenAggregated(
                'players',
                'market_value',
                'sum',
                fn () => Number::currency(is_numeric($this->players_sum_market_value) ? (float) $this->players_sum_market_value : 0)
            ),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
