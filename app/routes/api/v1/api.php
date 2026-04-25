<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/* Загаданные слова */
Route::post('words', \App\Http\Controllers\Word\CreateWordController::class);
/* Игра */
Route::post('games/{word}', \App\Http\Controllers\Game\CreateGameController::class);
