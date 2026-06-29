<?php

namespace App\Http\Controllers\Api\V1;

use App\Contract\BookingServiceContract;
use App\Contract\PaymentGatewayContract;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentChargeRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private PaymentGatewayContract $paymentGateway,
        private BookingServiceContract $bookingService,
    ) {
    }

    /**
     * POST /api/v1/payments/charge
     */
    public function charge(PaymentChargeRequest $request)
    {
        $booking = $this->bookingService->getBooking($request->validated('booking_id'));

        if (! $request->user()->isAdmin() && $booking->user_id !== $request->user()->id) {
            return $this->error('You are not allowed to pay for this reservation.', 403);
        }

        try {
            $result = $this->paymentGateway->createPayment($booking);

            return $this->success([
                'snap_token' => $result['snap_token'],
                'redirect_url' => $result['redirect_url'],
            ], 'Payment token generated successfully');
        } catch (\Throwable $e) {
            report($e);

            return $this->error('Midtrans API Connection Error.', 500);
        }
    }

    /**
     * POST /api/v1/payments/webhook
     * Public endpoint called directly by Midtrans; protected by signature
     * verification instead of Sanctum auth.
     */
    public function webhook(Request $request)
    {
        try {
            $this->paymentGateway->handleWebhook($request->all());

            return $this->success(null, 'Payment status updated to success');
        } catch (\InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 400);
        } catch (\Throwable $e) {
            report($e);

            return $this->error('Failed to process payment notification.', 400);
        }
    }
}
