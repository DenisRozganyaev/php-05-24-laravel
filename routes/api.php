<?php

use Illuminate\Support\Facades\Route;

Route::post('auth', \App\Http\Controllers\Api\AuthController::class)
    ->name('auth');

Route::prefix('v1')->name('v1.')->middleware('auth:sanctum')->group(function () {
    require_once __DIR__ . '/versions/v1.php';
});
