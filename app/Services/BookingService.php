<?php

namespace App\Services;

use App\Contract\BookingServiceContract;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Support\Str;

class BookingService implements BookingServiceContract
{
    /**
     * Create a new booking and an associated unpaid payment record.
     */
    public function createBooking(
        int $userId,
        int $petId,
        int $serviceId,
        string $date,
        string $timeSlot
    ): array {
        $service = Service::findOrFail($serviceId);

        $booking = Booking::create([
            'user_id'      => $userId,
            'pet_id'       => $petId,
            'service_id'   => $serviceId,
            'booking_code' => 'BK-' . strtoupper(Str::random(6)),
            'booking_date' => $date,
            'time_slot'    => $timeSlot,
            'status'       => 'pending',
            'total_price'  => $service->price,
        ]);

        // Auto-create an unpaid payment record for every new booking
        Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $service->price,
            'currency'       => 'IDR',
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'gateway'        => 'Manual Transfer',
        ]);

        return $booking->toArray();
    }

    /**
     * Get a single booking with its relations.
     */
    public function getBooking(int $bookingId): array
    {
        $booking = Booking::with(['user', 'pet', 'service', 'payment'])
            ->findOrFail($bookingId);

        return $booking->toArray();
    }

    /**
     * List bookings for a user, with optional filter criteria.
     */
    public function listBookings(int $userId, array $criteria = []): array
    {
        $query = Booking::with(['pet', 'service', 'payment'])
            ->where('user_id', $userId);

        if (!empty($criteria['status'])) {
            $query->where('status', $criteria['status']);
        }

        if (!empty($criteria['date'])) {
            $query->whereDate('booking_date', $criteria['date']);
        }

        return $query->latest()->get()->toArray();
    }

    /**
     * Check whether a time slot is available for a given service and date.
     * Currently allows max 3 concurrent bookings per slot.
     */
    public function checkAvailability(int $serviceId, string $date, string $timeSlot): bool
    {
        $count = Booking::where('service_id', $serviceId)
            ->whereDate('booking_date', $date)
            ->where('time_slot', $timeSlot)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        return $count < 3;
    }

    /**
     * Update the status of a booking.
     */
    public function updateBookingStatus(int $bookingId, string $status): bool
    {
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return false;
        }

        $booking->status = $status;
        return $booking->save();
    }

    /**
     * Cancel a booking (set status to cancelled).
     */
    public function cancelBooking(int $bookingId): bool
    {
        return $this->updateBookingStatus($bookingId, 'cancelled');
    }
}
