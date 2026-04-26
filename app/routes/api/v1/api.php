<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/* Загаданные слова */
Route::post('words', \App\Http\Controllers\Word\CreateWordController::class);
/* Игра */
Route::get('games/{word}', \App\Http\Controllers\Game\GetGameController::class);
Route::post('games/{word}', \App\Http\Controllers\Game\CreateGameController::class);
/* Раунд */
Route::post('rounds/{game}', \App\Http\Controllers\Round\CreateRoundController::class);
