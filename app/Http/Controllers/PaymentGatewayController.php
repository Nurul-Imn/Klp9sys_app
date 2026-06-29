<?php

namespace App\Http\Controllers;

use App\Contract\PaymentGatewayContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    public function __construct(
        protected PaymentGatewayContract $paymentGateway
    ) {}

    /**
     * POST /api/payments
     * Membuat payment baru dari data checkout.
     */
    public function createPayment(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'string'],
            'amount'   => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'customer' => ['required', 'array'],
            'items'    => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data checkout tidak valid.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->paymentGateway->createPayment($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Payment berhasil dibuat.',
                'data'    => $result,
            ], 201);
        } catch (Exception $e) {
            Log::error('Gagal membuat payment.', [
                'error' => $e->getMessage(),
                'data'  => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat payment.',
            ], 500);
        }
    }

    /**
     * POST /api/payments/link
     * Generate payment link/redirect URL untuk checkout.
     */
    public function generatePaymentLink(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => ['required', 'string'],
            'amount'   => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'customer' => ['required', 'array'],
            'items'    => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data checkout tidak valid.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $paymentLink = $this->paymentGateway->generatePaymentLink($validator->validated());

            return response()->json([
                'success'     => true,
                'payment_url' => $paymentLink,
            ]);
        } catch (Exception $e) {
            Log::error('Gagal membuat payment link.', [
                'error' => $e->getMessage(),
                'data'  => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat payment link.',
            ], 500);
        }
    }

    /**
     * GET /api/payments/{transactionId}/verify
     * Verifikasi apakah transaksi berhasil dibayar.
     */
    public function verifyPayment(string $transactionId): JsonResponse
    {
        try {
            $isVerified = $this->paymentGateway->verifyPayment($transactionId);

            return response()->json([
                'success'        => true,
                'transaction_id' => $transactionId,
                'verified'       => $isVerified,
            ]);
        } catch (Exception $e) {
            Log::error('Gagal verifikasi payment.', [
                'transaction_id' => $transactionId,
                'error'          => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan verifikasi payment.',
            ], 500);
        }
    }

    /**
     * GET /api/payments/{transactionId}/status
     * Mengambil status terkini dari sebuah transaksi.
     */
    public function getPaymentStatus(string $transactionId): JsonResponse
    {
        try {
            $status = $this->paymentGateway->getPaymentStatus($transactionId);

            return response()->json([
                'success'        => true,
                'transaction_id' => $transactionId,
                'status'         => $status,
            ]);
        } catch (Exception $e) {
            Log::error('Gagal mengambil status payment.', [
                'transaction_id' => $transactionId,
                'error'          => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil status payment.',
            ], 500);
        }
    }

    /**
     * POST /api/payments/webhook
     * Menerima dan memproses notifikasi webhook dari payment gateway.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Webhook diterima dari payment gateway.', $payload);

        try {
            $handled = $this->paymentGateway->handleWebhook($payload);

            if (!$handled) {
                Log::warning('Webhook tidak berhasil diproses.', $payload);

                return response()->json([
                    'success' => false,
                    'message' => 'Webhook tidak dapat diproses.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Webhook berhasil diproses.',
            ]);
        } catch (Exception $e) {
            Log::error('Error saat memproses webhook.', [
                'error'   => $e->getMessage(),
                'payload' => $payload,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses webhook.',
            ], 500);
        }
    }
}
