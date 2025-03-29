<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferHistory extends Model
{
    protected $fillable = [
        'buyer_team_id',
        'seller_team_id',
        'player_id',
        'market_price',
        'price_after_transfer',
        'sell_price',
    ];
}
