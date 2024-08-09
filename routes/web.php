<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/checkout', function () {
    return Inertia::render('Payment/CheckoutPage');
});
