<?php

use App\Enums\PlayerPosition;
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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('country_id')->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('position', PlayerPosition::values());
            $table->unsignedTinyInteger('age');
            $table->decimal('market_value', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
