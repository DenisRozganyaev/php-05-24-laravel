<?php

use App\Http\Controllers\Pages\ThankYouController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('test', function() {

});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('products', \App\Http\Controllers\ProductsController::class)->only(['show', 'index']);
Route::get('checkout', \App\Http\Controllers\CheckoutController::class)->name('checkout');
Route::get('orders/{vendorOrderId}/thank-you', ThankYouController::class)->name('thankyou');

Route::middleware(['auth'])->group(function() {
    Route::post('wishlist/{product}', [\App\Http\Controllers\WishListController::class, 'add'])->name('wishlist.add');
    Route::delete('wishlist/{product}', [\App\Http\Controllers\WishListController::class, 'remove'])->name('wishlist.remove');


    Route::name('account.')->prefix('account')->group(function() {
        Route::get('/', [App\Http\Controllers\Account\HomeController::class, 'index'])->name('home');
        Route::get('wishlist', App\Http\Controllers\Account\WishListController::class)->name('wishlist');
    });

    Route::get('invoices/{order}', \App\Http\Controllers\InvoicesController::class)->name('invoice');
});

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

    Route::prefix('paypal')->name('paypal.')->group(function() {
       Route::post('order', [\App\Http\Controllers\Ajax\Payments\PaypalController::class, 'create'])->name('order.create');
       Route::post('order/{vendorOrderId}/capture', [\App\Http\Controllers\Ajax\Payments\PaypalController::class, 'capture'])->name('order.capture');
    });
});

