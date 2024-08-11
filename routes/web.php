<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// if we use the cart feature, we can just create new table called cart and in the checkout view collect al data from cart and pass it to payment page
// or for guest we could use the session and pass it to payment page ...
// for our case i will assume that we can purchase just one product at a time
Route::get('/checkout/{product_id}', [PaymentController::class, 'show'])->name('checkout.show');
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');


Route::post('/process', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/lemonsqueezy/webhook', [PaymentController::class, 'handleWebhook'])->name('webhook');


