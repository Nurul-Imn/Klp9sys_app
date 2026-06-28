<?php

use App\Http\Controllers\Api\V1\BookingController as ApiBookingController;
use App\Http\Controllers\Api\V1\PaymentController as ApiPaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/reservations', [ApiBookingController::class, 'index']);
        Route::post('/reservations', [ApiBookingController::class, 'store']);
        Route::get('/reservations/{booking}', [ApiBookingController::class, 'show']);
        Route::patch('/reservations/{booking}/status', [ApiBookingController::class, 'updateStatus']);
        Route::delete('/reservations/{booking}', [ApiBookingController::class, 'cancel']);
    });

    Route::post('/payments/webhook', [ApiPaymentController::class, 'webhook'])
        ->name('api.payments.webhook');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/payments/charge', [ApiPaymentController::class, 'charge']);
    });
});
