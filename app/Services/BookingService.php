<?php

namespace App\Services;

use App\Contract\BookingServiceContract;
use App\Models\Booking;

class BookingService implements BookingServiceContract
{
    /**
     * Membuat booking baru
     */
    public function createBooking(
        int $userId,
        int $petId,
        int $serviceId,
        string $date,
        string $timeSlot
    ): array {

        $booking = Booking::create([
            'user_id'       => $userId,
            'pet_id'        => $petId,
            'service_id'    => $serviceId,
            'booking_code'  => 'BK-' . strtoupper(uniqid()),
            'booking_date'  => $date,
            'time_slot'     => $timeSlot,
            'status'        => 'pending',
            'total_price'   => 0,
            'notes'         => null,
        ]);

        return $booking->toArray();
    }

    /**
     * Mengambil detail booking
     */
    public function getBooking(int $bookingId): array
    {
        $booking = Booking::with([
            'user',
            'pet',
            'service',
            'payment'
        ])->find($bookingId);

        return $booking ? $booking->toArray() : [];
    }

    /**
     * Menampilkan daftar booking milik user
     */
    public function listBookings(int $userId, array $criteria = []): array
    {
        $query = Booking::where('user_id', $userId);

        if (!empty($criteria['status'])) {
            $query->where('status', $criteria['status']);
        }

        if (!empty($criteria['date'])) {
            $query->whereDate('booking_date', $criteria['date']);
        }

        return $query
            ->orderBy('booking_date', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Mengecek apakah jadwal tersedia
     */
    public function checkAvailability(
        int $serviceId,
        string $date,
        string $timeSlot
    ): bool {

        return !Booking::where('service_id', $serviceId)
            ->where('booking_date', $date)
            ->where('time_slot', $timeSlot)
            ->exists();
    }

    /**
     * Update status booking
     */
    public function updateBookingStatus(
        int $bookingId,
        string $status
    ): bool {

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return false;
        }

        $booking->status = $status;

        return $booking->save();
    }

    /**
     * Membatalkan booking
     */
    public function cancelBooking(int $bookingId): bool
    {
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return false;
        }

        $booking->status = 'cancelled';

        return $booking->save();
    }
}