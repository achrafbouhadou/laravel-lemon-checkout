<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/checkout', function () {
    return Inertia::render('Payment/CheckoutPage');
});
// if we use the cart feature, we can just create new table called cart and in the checkout view collect al data from cart and pass it to payment page
// or for guest we could use the session and pass it to payment page ...
// for our case i will assume that we can purchase just one product at a time
Route::get('/checkout/{product_id}', [PaymentController::class, 'show'])->name('checkout.show');

Route::post('/process', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/lemonsqueezy/webhook', [PaymentController::class, 'handleWebhook'])->name('webhook');


