<?php

namespace App\Services;

use App\Contracts\PlayerTransferContract;
use App\Data\TransferData;
use App\Enums\PlayerTransferStatus;
use App\Exceptions\BusinessLogicException;
use App\Jobs\PlayerTransferred;
use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PlayerTransferService implements PlayerTransferContract
{
    public function paginate(): LengthAwarePaginator
    {
        return PlayerTransfer::query()
            ->active()
            ->with([
                'team',
                'player.country' => fn ($query) => $query->withTranslation(),
            ])
            ->paginate();
    }

    public function store(array $data): void
    {
        PlayerTransfer::create($data);
    }

    /**
     * @throws \App\Exceptions\BusinessLogicException
     * @throws \Throwable
     */
    public function buy(Team $team, PlayerTransfer $transfer): void
    {
        DB::transaction(function () use ($team, $transfer) {
            $transfer = $transfer->lockForUpdate()->findOrFail($transfer->id);
            $buyerTeam = $team->lockForUpdate()->findOrFail($team->id);
            $sellerTeam = Team::lockForUpdate()->findOrFail($transfer->team_id);
            $player = Player::lockForUpdate()->findOrFail($transfer->player_id);

            $this->validateTransfer($transfer, $buyerTeam);

            $this->completeTransfer(new TransferData(
                transfer: $transfer,
                player: $player,
                buyerTeam: $buyerTeam,
                sellerTeam: $sellerTeam,
            ));
        }, 3);
    }

    /**
     * @throws \App\Exceptions\BusinessLogicException
     */
    private function validateTransfer(PlayerTransfer $transfer, Team $buyerTeam): void
    {
        if (! $transfer->isActive()) {
            throw new BusinessLogicException(__('exception.transfer_inactive'));
        }

        if ($transfer->team_id === $buyerTeam->id) {
            throw new BusinessLogicException(__('exception.cannot_buy_own_player'));
        }

        if ($buyerTeam->budget <= $transfer->sell_price) {
            throw new BusinessLogicException(__('exception.insufficient_budget'));
        }
    }

    private function completeTransfer(TransferData $data): void
    {
        $data->player->team()->associate($data->buyerTeam);
        $data->player->save();
        $data->transfer->update(['status' => PlayerTransferStatus::Completed]);
        $data->buyerTeam->decrement('budget', $data->transfer->sell_price);
        $data->sellerTeam->increment('budget', $data->transfer->sell_price);

        PlayerTransferred::dispatch($data);
    }
}
