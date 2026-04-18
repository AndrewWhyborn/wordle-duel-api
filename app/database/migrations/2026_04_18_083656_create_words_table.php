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
            App\Models\Word::TABLE_NAME,
            function (Blueprint $table) {
                $table->id();

                $table
                    ->string('url')
                    ->comment('URL.')
                ;

                $table
                    ->string('target')
                    ->comment('Загаданное слово.')
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
        Schema::dropIfExists(App\Models\Word::TABLE_NAME);
    }
};
