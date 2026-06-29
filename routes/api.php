<?php

use App\Http\Controllers\PaymentGatewayController;
use Illuminate\Support\Facades\Route;

// Payment Gateway API (webhook endpoint tidak perlu auth karena dipanggil oleh gateway)
Route::prefix('v1')->group(function () {
    // Webhook — exclude dari CSRF (sudah exclude di bootstrap/app.php)
    Route::post('/payments/webhook', [PaymentGatewayController::class, 'handleWebhook'])
        ->name('api.payments.webhook');

    // Endpoint payment lainnya (bisa ditambahkan auth middleware jika perlu)
    Route::post('/payments', [PaymentGatewayController::class, 'createPayment'])
        ->name('api.payments.create');

    Route::post('/payments/link', [PaymentGatewayController::class, 'generatePaymentLink'])
        ->name('api.payments.link');

    Route::get('/payments/{transactionId}/verify', [PaymentGatewayController::class, 'verifyPayment'])
        ->name('api.payments.verify');

    Route::get('/payments/{transactionId}/status', [PaymentGatewayController::class, 'getPaymentStatus'])
        ->name('api.payments.status');
});
