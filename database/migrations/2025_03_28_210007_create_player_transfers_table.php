<?php

use App\Enums\PlayerTransferStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('player_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('sell_price', 10);
            $table->enum('status', PlayerTransferStatus::values())
                ->default(PlayerTransferStatus::Active);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_transfers');
    }
};
