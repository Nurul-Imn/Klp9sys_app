<?php

namespace App\Services;

use App\Contract\PaymentGatewayContract;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Str;

/**
 * PaymentGatewayService
 *
 * Implementasi manual (simulasi) payment gateway.
 * Bisa diganti dengan integrasi Midtrans/Xendit di masa mendatang
 * hanya dengan mengganti binding di AppServiceProvider.
 */
class PaymentGatewayService implements PaymentGatewayContract
{
    /**
     * Create a payment record for the given checkout data.
     * Expects: order_id (booking_id), amount, currency, customer, items
     */
    public function createPayment(array $checkoutData): array
    {
        $booking = Booking::findOrFail($checkoutData['order_id']);

        $payment = Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'transaction_id' => 'TX-' . strtoupper(Str::random(10)),
                'gateway'        => 'Manual',
                'amount'         => (int) $checkoutData['amount'],
                'currency'       => $checkoutData['currency'] ?? 'IDR',
                'payment_method' => $checkoutData['customer']['payment_method'] ?? 'Transfer',
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'payload'        => $checkoutData,
            ]
        );

        return $payment->toArray();
    }

    /**
     * Generate a payment link (simulated).
     */
    public function generatePaymentLink(array $checkoutData): string
    {
        // In production: call Midtrans/Xendit API and return the real URL.
        $token = base64_encode(json_encode([
            'order_id' => $checkoutData['order_id'],
            'amount'   => $checkoutData['amount'],
            'ts'       => now()->timestamp,
        ]));

        return url('/payments/checkout/' . $token);
    }

    /**
     * Verify whether a transaction has been paid.
     */
    public function verifyPayment(string $transactionId): bool
    {
        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return false;
        }

        return $payment->payment_status === 'paid';
    }

    /**
     * Handle an incoming webhook payload.
     * Updates the payment and booking status accordingly.
     */
    public function handleWebhook(array $payload): bool
    {
        $transactionId = $payload['transaction_id'] ?? $payload['order_id'] ?? null;

        if (!$transactionId) {
            return false;
        }

        $payment = Payment::where('transaction_id', $transactionId)
            ->orWhereHas('booking', fn($q) => $q->where('id', $transactionId))
            ->first();

        if (!$payment) {
            return false;
        }

        $status = strtolower($payload['transaction_status'] ?? $payload['status'] ?? 'pending');

        $paymentStatus = match ($status) {
            'settlement', 'capture', 'success', 'paid' => 'paid',
            'cancel', 'deny', 'expire'                 => 'failed',
            default                                    => 'unpaid',
        };

        $payment->update([
            'status'         => $status,
            'payment_status' => $paymentStatus,
            'paid_at'        => $paymentStatus === 'paid' ? now() : null,
            'payload'        => $payload,
        ]);

        // Also update booking status
        if ($paymentStatus === 'paid') {
            $payment->booking()->update(['status' => 'confirmed']);
        } elseif ($paymentStatus === 'failed') {
            $payment->booking()->update(['status' => 'cancelled']);
        }

        return true;
    }

    /**
     * Get the current payment status string for a transaction.
     */
    public function getPaymentStatus(string $transactionId): string
    {
        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return 'not_found';
        }

        return $payment->payment_status;
    }
}
