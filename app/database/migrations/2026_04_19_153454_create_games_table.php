<?php

declare(strict_types=1);

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
            \App\Models\Game::TABLE_NAME,
            function (Blueprint $table) {
                $table->id();

                $table
                    ->bigInteger('word_id')
                    ->unsigned()
                    ->index()
                    ->comment('Идентификатор загаданного слова.');
                ;

                $table
                    ->string('ip')
                    ->index()
                    ->comment('IP игрока.');
                ;

                $table
                    ->string('status')
                    ->comment('Статус игры.');
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
        Schema::dropIfExists(\App\Models\Game::TABLE_NAME);
    }
};
