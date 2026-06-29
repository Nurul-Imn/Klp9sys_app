<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use App\Services\PaymentGatewayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit tests untuk PaymentGatewayService.
 */
class PaymentGatewayServiceTest extends TestCase
{
    use RefreshDatabase;

    private PaymentGatewayService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = new PaymentGatewayService();
    }

    // ─── Helpers ─────────────────────────────────────────────────

    private function createService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'name'             => 'Test Grooming',
            'category'         => 'grooming',
            'price'            => 100000,
            'duration_minutes' => 60,
            'is_active'        => true,
        ], $overrides));
    }

    private function createBookingWithPayment(int $price = 100000): array
    {
        $user    = User::factory()->create();
        $pet     = Pet::create(['user_id' => $user->id, 'name' => 'Buddy', 'species' => 'Anjing']);
        $service = $this->createService(['price' => $price]);

        $booking = Booking::create([
            'user_id'      => $user->id,
            'pet_id'       => $pet->id,
            'service_id'   => $service->id,
            'booking_code' => 'BK-TEST01',
            'booking_date' => '2026-12-15',
            'time_slot'    => '09:00',
            'status'       => 'pending',
            'total_price'  => $price,
        ]);

        $payment = Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $price,
            'currency'       => 'IDR',
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'gateway'        => 'Manual',
        ]);

        return [$booking, $payment, $user];
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE PAYMENT
    // ──────────────────────────────────────────────────────────────

    /** createPayment() membuat atau memperbarui payment record. */
    public function test_create_payment_creates_payment_record(): void
    {
        [$booking] = $this->createBookingWithPayment();

        $checkoutData = [
            'order_id' => $booking->id,
            'amount'   => 150000,
            'currency' => 'IDR',
            'customer' => ['payment_method' => 'Transfer'],
        ];

        $result = $this->paymentService->createPayment($checkoutData);

        $this->assertIsArray($result);
        $this->assertEquals($booking->id, $result['booking_id']);
        $this->assertEquals(150000, $result['amount']);
    }

    /** createPayment() menghasilkan transaction_id yang diawali 'TX-'. */
    public function test_create_payment_generates_transaction_id_with_tx_prefix(): void
    {
        [$booking] = $this->createBookingWithPayment();

        $result = $this->paymentService->createPayment([
            'order_id' => $booking->id,
            'amount'   => 100000,
            'currency' => 'IDR',
            'customer' => [],
        ]);

        $this->assertStringStartsWith('TX-', $result['transaction_id']);
    }

    /** createPayment() menyimpan payment_status sebagai 'unpaid'. */
    public function test_create_payment_sets_payment_status_to_unpaid(): void
    {
        [$booking] = $this->createBookingWithPayment();

        $result = $this->paymentService->createPayment([
            'order_id' => $booking->id,
            'amount'   => 100000,
            'currency' => 'IDR',
            'customer' => [],
        ]);

        $this->assertEquals('unpaid', $result['payment_status']);
    }

    // ──────────────────────────────────────────────────────────────
    //  GENERATE PAYMENT LINK
    // ──────────────────────────────────────────────────────────────

    /** generatePaymentLink() mengembalikan URL yang valid. */
    public function test_generate_payment_link_returns_valid_url(): void
    {
        $checkoutData = [
            'order_id' => 1,
            'amount'   => 100000,
        ];

        $link = $this->paymentService->generatePaymentLink($checkoutData);

        $this->assertIsString($link);
        $this->assertStringContainsString('/payments/checkout/', $link);
    }

    /** generatePaymentLink() menghasilkan URL yang berbeda untuk data berbeda. */
    public function test_generate_payment_link_returns_unique_url_per_order(): void
    {
        $link1 = $this->paymentService->generatePaymentLink(['order_id' => 1, 'amount' => 100000]);
        $link2 = $this->paymentService->generatePaymentLink(['order_id' => 2, 'amount' => 200000]);

        $this->assertNotEquals($link1, $link2);
    }

    // ──────────────────────────────────────────────────────────────
    //  VERIFY PAYMENT
    // ──────────────────────────────────────────────────────────────

    /** verifyPayment() mengembalikan false untuk transaction_id yang tidak ada. */
    public function test_verify_payment_returns_false_for_nonexistent_transaction(): void
    {
        $result = $this->paymentService->verifyPayment('TX-TIDAK-ADA');

        $this->assertFalse($result);
    }

    /** verifyPayment() mengembalikan false jika payment masih unpaid. */
    public function test_verify_payment_returns_false_when_not_paid(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-BELUMBAYAR', 'payment_status' => 'unpaid']);

        $result = $this->paymentService->verifyPayment('TX-BELUMBAYAR');

        $this->assertFalse($result);
    }

    /** verifyPayment() mengembalikan true jika payment sudah paid. */
    public function test_verify_payment_returns_true_when_paid(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-SUDAYBAYAR', 'payment_status' => 'paid']);

        $result = $this->paymentService->verifyPayment('TX-SUDAYBAYAR');

        $this->assertTrue($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  HANDLE WEBHOOK
    // ──────────────────────────────────────────────────────────────

    /** handleWebhook() mengembalikan false jika tidak ada transaction_id. */
    public function test_handle_webhook_returns_false_for_empty_payload(): void
    {
        $result = $this->paymentService->handleWebhook([]);

        $this->assertFalse($result);
    }

    /** handleWebhook() mengupdate status payment menjadi paid saat settlement. */
    public function test_handle_webhook_updates_payment_to_paid_on_settlement(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-WEBHOOK01']);

        $result = $this->paymentService->handleWebhook([
            'transaction_id'     => 'TX-WEBHOOK01',
            'transaction_status' => 'settlement',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('payments', [
            'transaction_id' => 'TX-WEBHOOK01',
            'payment_status' => 'paid',
        ]);
    }

    /** handleWebhook() mengupdate status booking menjadi confirmed saat payment berhasil. */
    public function test_handle_webhook_updates_booking_to_confirmed_on_payment_success(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-CONFIRMED01']);

        $this->paymentService->handleWebhook([
            'transaction_id'     => 'TX-CONFIRMED01',
            'transaction_status' => 'paid',
        ]);

        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'confirmed']);
    }

    /** handleWebhook() mengupdate status payment menjadi failed saat cancel. */
    public function test_handle_webhook_updates_payment_to_failed_on_cancel(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-CANCEL01']);

        $result = $this->paymentService->handleWebhook([
            'transaction_id'     => 'TX-CANCEL01',
            'transaction_status' => 'cancel',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('payments', [
            'transaction_id' => 'TX-CANCEL01',
            'payment_status' => 'failed',
        ]);
    }

    /** handleWebhook() mengupdate booking menjadi cancelled saat payment gagal. */
    public function test_handle_webhook_updates_booking_to_cancelled_on_payment_failure(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-DENIED01']);

        $this->paymentService->handleWebhook([
            'transaction_id'     => 'TX-DENIED01',
            'transaction_status' => 'deny',
        ]);

        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'cancelled']);
    }

    /** handleWebhook() mengembalikan false jika transaction_id tidak ditemukan. */
    public function test_handle_webhook_returns_false_for_unknown_transaction(): void
    {
        $result = $this->paymentService->handleWebhook([
            'transaction_id'     => 'TX-UNKNOWN99',
            'transaction_status' => 'settlement',
        ]);

        $this->assertFalse($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  GET PAYMENT STATUS
    // ──────────────────────────────────────────────────────────────

    /** getPaymentStatus() mengembalikan 'not_found' untuk transaction_id yang tidak ada. */
    public function test_get_payment_status_returns_not_found_for_unknown(): void
    {
        $result = $this->paymentService->getPaymentStatus('TX-TIDAKADA');

        $this->assertEquals('not_found', $result);
    }

    /** getPaymentStatus() mengembalikan status payment yang benar. */
    public function test_get_payment_status_returns_correct_status(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-STATUS01', 'payment_status' => 'unpaid']);

        $result = $this->paymentService->getPaymentStatus('TX-STATUS01');

        $this->assertEquals('unpaid', $result);
    }

    /** getPaymentStatus() mengembalikan 'paid' setelah pembayaran berhasil. */
    public function test_get_payment_status_returns_paid_after_payment(): void
    {
        [$booking, $payment] = $this->createBookingWithPayment();
        $payment->update(['transaction_id' => 'TX-PAID01', 'payment_status' => 'paid']);

        $result = $this->paymentService->getPaymentStatus('TX-PAID01');

        $this->assertEquals('paid', $result);
    }
}
