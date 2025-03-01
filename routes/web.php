<?php

use App\Http\Controllers\BottleCollectorController;
use Illuminate\Support\Facades\Route;

Route::get('/bottle-collector', function () {
    return view('bottle_collector');
});

Route::post('/calculate-earnings', [BottleCollectorController::class, 'calculateEarnings'])->name('calculate.earnings');
