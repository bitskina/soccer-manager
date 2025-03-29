<?php

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
        Schema::create('transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_team_id')->constrained('teams')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('seller_team_id')->constrained('teams')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('player_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->decimal('market_price', 15);
            $table->decimal('price_after_transfer', 15);
            $table->decimal('sell_price', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_histories');
    }
};
