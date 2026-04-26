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
        Schema::create(
            \App\Models\Letter::TABLE_NAME,
            function (Blueprint $table) {
                $table->id();

                $table
                    ->bigInteger('round_id')
                    ->unsigned()
                    ->index()
                    ->comment('Идентификатор раунда.');
                ;

                $table
                    ->integer('index')
                    ->unsigned()
                    ->comment('Буква.');
                ;

                $table
                    ->string('value')
                    ->comment('Буква.');
                ;

                $table
                    ->string('status')
                    ->comment('Статус буквы');
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
        Schema::dropIfExists(\App\Models\Letter::TABLE_NAME);
    }
};
