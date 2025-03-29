<?php

namespace App\Http\Resources\PlayerTransfers;

use App\Http\Resources\Players\PlayerResource;
use App\Http\Resources\Teams\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PlayerTransferResource extends JsonResource
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
            'player' => PlayerResource::make($this->whenLoaded('player')),
            'team' => TeamResource::make($this->whenLoaded('team')),
            'sell_price' => Number::currency(is_numeric($this->sell_price) ? (float) $this->sell_price : 0),
            'has_budget' => $request->user()?->getBudget() >= $this->sell_price,

        ];
    }
}
