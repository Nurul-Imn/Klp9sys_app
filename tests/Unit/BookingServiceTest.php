<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit tests untuk BookingService.
 */
class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BookingService $bookingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookingService = new BookingService();
    }

    // ─── Helper ──────────────────────────────────────────────────

    /** Membuat Service tanpa menggunakan factory (factory punya kolom 'daily_slot_capacity' yang tidak ada di migration). */
    private function createService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'name'             => 'Grooming Test',
            'category'         => 'grooming',
            'price'            => 100000,
            'duration_minutes' => 60,
            'description'      => 'Test service',
            'is_active'        => true,
        ], $overrides));
    }

    private function createUserAndPet(): array
    {
        $user = User::factory()->create();
        $pet  = Pet::create([
            'user_id' => $user->id,
            'name'    => 'Buddy',
            'species' => 'Anjing',
        ]);
        return [$user, $pet];
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE BOOKING
    // ──────────────────────────────────────────────────────────────

    /** createBooking() membuat record booking di database. */
    public function test_create_booking_creates_booking_record(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService();

        $result = $this->bookingService->createBooking(
            $user->id,
            $pet->id,
            $service->id,
            '2026-12-01',
            '09:00'
        );

        $this->assertIsArray($result);
        $this->assertDatabaseHas('bookings', [
            'user_id'    => $user->id,
            'pet_id'     => $pet->id,
            'service_id' => $service->id,
            'status'     => 'pending',
        ]);
    }

    /** createBooking() otomatis membuat payment record dengan status unpaid. */
    public function test_create_booking_auto_creates_payment_record(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService(['price' => 150000]);

        $result = $this->bookingService->createBooking(
            $user->id, $pet->id, $service->id, '2026-12-01', '10:00'
        );

        $booking = Booking::find($result['id']);
        $this->assertNotNull($booking->payment);
        $this->assertEquals('unpaid', $booking->payment->payment_status);
        $this->assertEquals(150000, $booking->payment->amount);
    }

    /** total_price booking harus sama dengan harga service. */
    public function test_create_booking_sets_total_price_from_service(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService(['price' => 75000]);

        $result = $this->bookingService->createBooking(
            $user->id, $pet->id, $service->id, '2026-12-01', '11:00'
        );

        $this->assertEquals(75000, $result['total_price']);
    }

    /** booking_code harus diawali dengan 'BK-'. */
    public function test_create_booking_generates_booking_code_with_bk_prefix(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService();

        $result = $this->bookingService->createBooking(
            $user->id, $pet->id, $service->id, '2026-12-01', '09:00'
        );

        $this->assertStringStartsWith('BK-', $result['booking_code']);
    }

    /** status booking baru harus 'pending'. */
    public function test_create_booking_has_pending_status(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService();

        $result = $this->bookingService->createBooking(
            $user->id, $pet->id, $service->id, '2026-12-02', '14:00'
        );

        $this->assertEquals('pending', $result['status']);
    }

    // ──────────────────────────────────────────────────────────────
    //  GET BOOKING
    // ──────────────────────────────────────────────────────────────

    /** getBooking() mengembalikan data booking beserta relasi. */
    public function test_get_booking_returns_booking_with_relations(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $service = $this->createService();

        $created = $this->bookingService->createBooking(
            $user->id, $pet->id, $service->id, '2026-12-03', '09:00'
        );

        $result = $this->bookingService->getBooking($created['id']);

        $this->assertIsArray($result);
        $this->assertEquals($created['id'], $result['id']);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('pet', $result);
        $this->assertArrayHasKey('service', $result);
    }

    /** getBooking() melempar exception untuk ID yang tidak ada. */
    public function test_get_booking_throws_exception_for_nonexistent_id(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->bookingService->getBooking(99999);
    }

    // ──────────────────────────────────────────────────────────────
    //  LIST BOOKINGS
    // ──────────────────────────────────────────────────────────────

    /** listBookings() hanya mengembalikan booking milik user yang diminta. */
    public function test_list_bookings_returns_only_user_bookings(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $petA  = Pet::create(['user_id' => $userA->id, 'name' => 'PetA', 'species' => 'Kucing']);
        $petB  = Pet::create(['user_id' => $userB->id, 'name' => 'PetB', 'species' => 'Anjing']);
        $svc   = $this->createService();

        $this->bookingService->createBooking($userA->id, $petA->id, $svc->id, '2026-12-04', '09:00');
        $this->bookingService->createBooking($userA->id, $petA->id, $svc->id, '2026-12-05', '10:00');
        $this->bookingService->createBooking($userB->id, $petB->id, $svc->id, '2026-12-06', '11:00');

        $resultA = $this->bookingService->listBookings($userA->id);
        $resultB = $this->bookingService->listBookings($userB->id);

        $this->assertCount(2, $resultA);
        $this->assertCount(1, $resultB);
    }

    /** listBookings() bisa difilter berdasarkan status. */
    public function test_list_bookings_filters_by_status(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $svc = $this->createService();

        $b1 = $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-04', '09:00');
        $b2 = $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-05', '10:00');

        // Cancel b1
        $this->bookingService->cancelBooking($b1['id']);

        $pending   = $this->bookingService->listBookings($user->id, ['status' => 'pending']);
        $cancelled = $this->bookingService->listBookings($user->id, ['status' => 'cancelled']);

        $this->assertCount(1, $pending);
        $this->assertCount(1, $cancelled);
    }

    // ──────────────────────────────────────────────────────────────
    //  CHECK AVAILABILITY
    // ──────────────────────────────────────────────────────────────

    /** checkAvailability() mengembalikan true jika slot masih tersedia. */
    public function test_check_availability_returns_true_when_slot_available(): void
    {
        $svc = $this->createService();

        $result = $this->bookingService->checkAvailability($svc->id, '2026-12-10', '09:00');

        $this->assertTrue($result);
    }

    /** checkAvailability() mengembalikan false setelah 3 booking aktif (max concurrent = 3). */
    public function test_check_availability_returns_false_when_slot_full(): void
    {
        $svc = $this->createService();

        // Buat 3 booking aktif di slot yang sama
        for ($i = 0; $i < 3; $i++) {
            [$user, $pet] = $this->createUserAndPet();
            $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-11', '09:00');
        }

        $result = $this->bookingService->checkAvailability($svc->id, '2026-12-11', '09:00');

        $this->assertFalse($result);
    }

    /** checkAvailability() tidak menghitung booking yang sudah dibatalkan. */
    public function test_check_availability_excludes_cancelled_bookings(): void
    {
        $svc = $this->createService();

        // Buat 3 booking lalu cancel semuanya
        $ids = [];
        for ($i = 0; $i < 3; $i++) {
            [$user, $pet] = $this->createUserAndPet();
            $b = $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-12', '09:00');
            $ids[] = $b['id'];
        }
        foreach ($ids as $id) {
            $this->bookingService->cancelBooking($id);
        }

        // Slot harus tersedia lagi karena semua booking dibatalkan
        $result = $this->bookingService->checkAvailability($svc->id, '2026-12-12', '09:00');

        $this->assertTrue($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE BOOKING STATUS
    // ──────────────────────────────────────────────────────────────

    /** updateBookingStatus() mengubah status booking. */
    public function test_update_booking_status_changes_status(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $svc = $this->createService();

        $booking = $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-13', '09:00');

        $result = $this->bookingService->updateBookingStatus($booking['id'], 'confirmed');

        $this->assertTrue($result);
        $this->assertDatabaseHas('bookings', ['id' => $booking['id'], 'status' => 'confirmed']);
    }

    /** updateBookingStatus() mengembalikan false untuk booking yang tidak ada. */
    public function test_update_booking_status_returns_false_for_nonexistent(): void
    {
        $result = $this->bookingService->updateBookingStatus(99999, 'confirmed');

        $this->assertFalse($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  CANCEL BOOKING
    // ──────────────────────────────────────────────────────────────

    /** cancelBooking() mengubah status menjadi 'cancelled'. */
    public function test_cancel_booking_sets_status_to_cancelled(): void
    {
        [$user, $pet] = $this->createUserAndPet();
        $svc = $this->createService();

        $booking = $this->bookingService->createBooking($user->id, $pet->id, $svc->id, '2026-12-14', '09:00');

        $result = $this->bookingService->cancelBooking($booking['id']);

        $this->assertTrue($result);
        $this->assertDatabaseHas('bookings', ['id' => $booking['id'], 'status' => 'cancelled']);
    }

    /** cancelBooking() mengembalikan false untuk booking yang tidak ada. */
    public function test_cancel_booking_returns_false_for_nonexistent(): void
    {
        $result = $this->bookingService->cancelBooking(99999);

        $this->assertFalse($result);
    }
}
