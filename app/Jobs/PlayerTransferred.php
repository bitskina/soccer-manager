<?php

namespace App\Jobs;

use App\Data\TransferData;
use App\Models\TransferHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class PlayerTransferred implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private TransferData $data)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @throws \Random\RandomException|\Throwable
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $currentPrice = $this->data->player->market_value;
            $this->data->player->increment('market_value', $currentPrice * random_int(10, 100) / 100);

            TransferHistory::create([
                'buyer_team_id' => $this->data->buyerTeam->id,
                'seller_team_id' => $this->data->sellerTeam->id,
                'player_id' => $this->data->player->id,
                'market_price' => $currentPrice,
                'price_after_transfer' => $this->data->player->market_value,
                'sell_price' => $this->data->transfer->sell_price,
            ]);
        });
    }
}
