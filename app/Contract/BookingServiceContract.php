<?php

namespace App\Contract;

interface BookingServiceContract
{
    public function createBooking(int $userId, int $petId, int $serviceId, string $date, string $timeSlot): array;

    public function getBooking(int $bookingId): array;

    public function listBookings(int $userId, array $criteria = []): array;

    public function checkAvailability(int $serviceId, string $date, string $timeSlot): bool;

    public function updateBookingStatus(int $bookingId, string $status): bool;

    public function cancelBooking(int $bookingId): bool;
}
