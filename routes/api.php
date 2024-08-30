<?php

use Illuminate\Support\Facades\Route;

Route::post('auth', \App\Http\Controllers\Api\AuthController::class)
    ->name('auth');
