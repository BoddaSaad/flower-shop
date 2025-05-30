<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('products')->controller(ProductController::class)->name('products.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('{product:slug}', 'show')->name('show');
});

Route::prefix('checkout')->controller(CheckoutController::class)->name('checkout.')->group(function () {
    Route::post('webhook', 'webhook')->name('webhook');
});


Route::view('cart', 'cart.cart')->name('cart');
Route::middleware(['auth'])->group(function () {

    Route::view('dashboard', 'profile')->name('dashboard');
    Route::get('orders', function() {
        if(request('success') === "true") {
            (new \App\Services\CartService())->clear();
        }

        $orders = auth()->user()->orders()->with('items.product.media', 'items.gifts')->latest()->paginate();

        return view('orders', compact('orders'));
    })->name('orders');
});

require __DIR__.'/auth.php';
