<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::apiResource('pets', PetController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('payments', PaymentController::class);
