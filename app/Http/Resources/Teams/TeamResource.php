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
            'name' => $this->name,
            'value' => $this->whenAggregated('players', 'market_value', 'sum', fn () => Number::currency($this->players_sum_market_value)),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
