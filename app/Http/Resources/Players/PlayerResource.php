<?php

namespace App\Http\Resources\Players;

use App\Http\Resources\Countries\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PlayerResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'market_value' => Number::currency(is_numeric($this->market_value) ? (float) $this->market_value : 0),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
