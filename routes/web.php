<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('calculate', [CalculatorController::class, 'calculate'])
    ->name('calculate');
