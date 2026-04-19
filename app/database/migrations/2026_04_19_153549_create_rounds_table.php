<?php

declare(strict_types=1);

use App\Models\Round;
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
        Schema::create(
            \App\Models\Round::TABLE_NAME,
            function (Blueprint $table) {
                $table->id();

                $table
                    ->bigInteger('game_id')
                    ->unsigned()
                    ->index()
                    ->comment('Идентификатор игры.');
                ;

                $table
                    ->integer('index')
                    ->unsigned()
                    ->comment('Номер раунда в игре.');
                ;

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Round::TABLE_NAME);
    }
};
