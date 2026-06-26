<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;

Route::resource('pets', PetController::class);
Route::resource('bookings', BookingController::class);
Route::resource('services', ServiceController::class);
Route::resource('products', ProductController::class);
Route::resource('payments', PaymentController::class);

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index']);