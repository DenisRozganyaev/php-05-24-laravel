<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/account', [App\Http\Controllers\Account\HomeController::class, 'index'])->middleware(['auth'])->name('home');

Route::resource('products', \App\Http\Controllers\ProductsController::class)->only(['show', 'index']);

Route::name('cart.')->prefix('cart')->group(function() {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::delete('/', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::put('{product}/count', [\App\Http\Controllers\CartController::class, 'count'])->name('count');
});

// site.com/admin
Route::name('admin.')->prefix('admin')->middleware('role:admin|moderator')->group(function() {
    Route::get('/', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductsController::class)->except(['show']);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoriesController::class)->except(['show']);
});

Route::name('ajax.')->prefix('ajax')->group(function() {
    Route::group(['auth', 'role:admin|moderator'], function() {
        Route::post('products/{product}/images', \App\Http\Controllers\Ajax\Products\UploadImages::class)->name('product.images.upload');
        Route::delete('images/{image}', \App\Http\Controllers\Ajax\RemoveImageController::class)->name('image.remove');
    });
});

