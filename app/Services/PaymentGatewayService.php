<?php

namespace App\Services;

use App\Contract\PaymentGatewayContract;

class PaymentGatewayService implements PaymentGatewayContract
{
    /**
     * Membuat data pembayaran
     */
    public function createPayment(array $checkoutData): array
    {
        return [
            'transaction_id' => 'TRX-' . strtoupper(uniqid()),
            'amount' => $checkoutData['amount'] ?? 0,
            'status' => 'pending',
            'payment_link' => $this->generatePaymentLink($checkoutData),
            'created_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Generate link pembayaran
     */
    public function generatePaymentLink(array $checkoutData): string
    {
        $transactionId = 'TRX-' . strtoupper(uniqid());

        return url('/payment/' . $transactionId);
    }

    /**
     * Verifikasi pembayaran
     */
    public function verifyPayment(string $transactionId): bool
    {
        // Simulasi verifikasi pembayaran
        return true;
    }

    /**
     * Menangani webhook dari payment gateway
     */
    public function handleWebhook(array $payload): bool
    {
        if (empty($payload)) {
            return false;
        }

        // Tempat untuk memproses data webhook
        return true;
    }

    /**
     * Mengambil status pembayaran
     */
    public function getPaymentStatus(string $transactionId): string
    {
        // Simulasi status pembayaran
        return 'paid';
    }
}