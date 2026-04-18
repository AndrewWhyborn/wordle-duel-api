<?php

declare(strict_types=1);

use App\Http\Controllers\Word\CreateWordController;
use Illuminate\Support\Facades\Route;

Route::post('words', CreateWordController::class);
