<?php

namespace App\Models;

use App\Enums\PlayerTransferStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerTransfer extends Model
{
    protected $fillable = [
        'team_id',
        'player_id',
        'sell_price',
        'status',
    ];

    protected $casts = [
        'status' => PlayerTransferStatus::class,
    ];

    /**
     * @return BelongsTo<Team, $this>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsTo<Player, $this>
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Scope a query to only include active player transfers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\App\Models\PlayerTransfer>  $query
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\PlayerTransfer>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', PlayerTransferStatus::Active);
    }

    public function isActive(): bool
    {
        return $this->status === PlayerTransferStatus::Active;
    }
}
