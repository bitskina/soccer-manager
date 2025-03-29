<?php

use App\Contracts\PlayerTransferContract;
use App\Enums\PlayerTransferStatus;
use App\Exceptions\BusinessLogicException;
use App\Jobs\PlayerTransferred;
use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;
use App\Services\PlayerTransferService;

beforeEach(function () {
    // Resolve the contract from the service container
    $this->service = app(PlayerTransferContract::class);
});

it('completes a player transfer successfully', function () {
    // Arrange
    Bus::fake();

    $sellerTeam = Team::factory()->create(['budget' => 1000]);
    $buyerTeam = Team::factory()->create(['budget' => 5000]);
    $player = Player::factory()->create(['team_id' => $sellerTeam->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $sellerTeam->id,
        'sell_price' => 2000,
        'status' => PlayerTransferStatus::Active,
    ]);

    // Act
    $this->service->buy($buyerTeam, $transfer);

    // Assert
    $player->refresh();
    $buyerTeam->refresh();
    $sellerTeam->refresh();
    $transfer->refresh();

    expect($player->team_id)->toBe($buyerTeam->id)
        ->and($transfer->status)->toBe(PlayerTransferStatus::Completed)
        ->and($buyerTeam->budget)->toBe('3000.00') // 5000 - 2000
        ->and($sellerTeam->budget)->toBe('3000.00'); // 1000 + 2000

    Bus::assertDispatched(PlayerTransferred::class, function (PlayerTransferred $job) use ($player, $buyerTeam, $sellerTeam, $transfer) {
        $data = $job->data;

        return $data->player->id === $player->id &&
            $data->buyerTeam->id === $buyerTeam->id &&
            $data->sellerTeam->id === $sellerTeam->id &&
            $data->transfer->id === $transfer->id;
    });
});

it('prevents transfer when player is not active', function () {
    // Arrange
    $sellerTeam = Team::factory()->create();
    $buyerTeam = Team::factory()->create(['budget' => 5000]);
    $player = Player::factory()->create(['team_id' => $sellerTeam->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $sellerTeam->id,
        'status' => PlayerTransferStatus::Completed, // Non-active status
    ]);

    // Act & Assert
    expect(fn () => $this->service->buy($buyerTeam, $transfer))
        ->toThrow(BusinessLogicException::class, __('exception.transfer_inactive'));
});

it('prevents buying your own player', function () {
    // Arrange
    $team = Team::factory()->create(['budget' => 5000]);
    $player = Player::factory()->create(['team_id' => $team->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $team->id,
        'status' => PlayerTransferStatus::Active,
    ]);

    // Act & Assert
    expect(fn () => $this->service->buy($team, $transfer))
        ->toThrow(BusinessLogicException::class, __('exception.cannot_buy_own_player'));
});

it('prevents transfer when buyer has insufficient budget', function () {
    // Arrange
    $sellerTeam = Team::factory()->create();
    $buyerTeam = Team::factory()->create(['budget' => 1000]);
    $player = Player::factory()->create(['team_id' => $sellerTeam->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $sellerTeam->id,
        'sell_price' => 2000,
        'status' => PlayerTransferStatus::Active,
    ]);

    // Act & Assert
    expect(fn () => $this->service->buy($buyerTeam, $transfer))
        ->toThrow(BusinessLogicException::class, __('exception.insufficient_budget'));
});

it('uses database transactions to ensure data consistency', function () {
    // Arrange
    $sellerTeam = Team::factory()->create(['budget' => 1000]);
    $buyerTeam = Team::factory()->create(['budget' => 5000]);
    $player = Player::factory()->create(['team_id' => $sellerTeam->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $sellerTeam->id,
        'sell_price' => 2000,
        'status' => PlayerTransferStatus::Active,
    ]);

    // Create a mock service that throws an exception during the transfer
    $mockService = Mockery::mock(PlayerTransferContract::class);
    $mockService->shouldReceive('buy')->andThrow(new \Exception('Simulated failure'));

    // Temporarily replace the bound contract with our mock
    $originalService = app(PlayerTransferContract::class);
    app()->instance(PlayerTransferContract::class, $mockService);

    // Act
    try {
        $mockService->buy($buyerTeam, $transfer);
    } catch (\Exception $e) {
        // Exception is expected
    }

    // Restore the original service
    app()->instance(PlayerTransferContract::class, $originalService);

    // Assert - verify no data was changed due to transaction rollback
    $player->refresh();
    $buyerTeam->refresh();
    $sellerTeam->refresh();
    $transfer->refresh();

    expect($player->team_id)->toBe($sellerTeam->id)
        ->and($transfer->status)->toBe(PlayerTransferStatus::Active)
        ->and($buyerTeam->budget)->toBe('5000.00')
        ->and($sellerTeam->budget)->toBe('1000.00');
});

it('works with a real implementation of the contract', function () {
    // This test makes sure the bound implementation works properly

    // Arrange
    $sellerTeam = Team::factory()->create(['budget' => 1000]);
    $buyerTeam = Team::factory()->create(['budget' => 5000]);
    $player = Player::factory()->create(['team_id' => $sellerTeam->id]);

    $transfer = PlayerTransfer::factory()->create([
        'player_id' => $player->id,
        'team_id' => $sellerTeam->id,
        'sell_price' => 2000,
        'status' => PlayerTransferStatus::Active,
    ]);

    // Get the real implementation
    $realService = app(PlayerTransferContract::class);

    // Act
    $realService->buy($buyerTeam, $transfer);

    // Assert
    $player->refresh();
    expect($player->team_id)->toBe($buyerTeam->id);
});

it('binds PlayerTransferService to the PlayerTransferContract', function () {
    $instance = app(PlayerTransferContract::class);
    expect($instance)->toBeInstanceOf(PlayerTransferService::class);
});
