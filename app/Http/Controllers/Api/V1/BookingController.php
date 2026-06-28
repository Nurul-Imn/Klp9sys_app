<?php

namespace App\Http\Controllers\Api\V1;

use App\Contract\BookingServiceContract;
use App\Exceptions\BookingUnavailableException;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    use ApiResponse;

    public function __construct(private BookingServiceContract $bookingService)
    {
    }

    /**
     * GET /api/v1/reservations
     * Customers see only their own bookings; admins see everything.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $scopeToUser = $user->isAdmin() ? null : $user;

        $bookings = $this->bookingService->listBookings($scopeToUser, $request->only(['status', 'date', 'per_page']));

        return $this->success(BookingResource::collection($bookings), 'Reservations retrieved successfully');
    }

    /**
     * POST /api/v1/reservations
     */
    public function store(BookingRequest $request)
    {
        try {
            $booking = $this->bookingService->createBooking($request->user(), $request->validated());
            $booking->load(['pet', 'service']);

            return $this->success([
                'reservation_id' => $booking->booking_code,
                'pet_name' => $booking->pet->name,
                'reservation_date' => $booking->booking_date->format('Y-m-d'),
                'total_price' => $booking->total_price,
                'payment_status' => 'pending',
            ], 'Reservation created successfully', 201);
        } catch (BookingUnavailableException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function show(Request $request, int $booking)
    {
        $reservation = $this->bookingService->getBooking($booking);
        $this->authorizeAccess($request, $reservation);

        return $this->success(new BookingResource($reservation), 'Reservation retrieved successfully');
    }

    /**
     * PATCH /api/v1/reservations/{booking}/status (admin only)
     */
    public function updateStatus(Request $request, int $booking)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'rejected', 'completed', 'cancelled'])],
        ]);

        $updated = $this->bookingService->updateBookingStatus($booking, $request->input('status'));

        return $this->success(new BookingResource($updated->load(['pet', 'service'])), 'Reservation status updated successfully');
    }

    /**
     * DELETE /api/v1/reservations/{booking}
     */
    public function cancel(Request $request, int $booking)
    {
        try {
            $cancelled = $this->bookingService->cancelBooking($booking, $request->user());

            return $this->success(new BookingResource($cancelled->load(['pet', 'service'])), 'Reservation cancelled successfully');
        } catch (AuthorizationException $e) {
            return $this->error($e->getMessage(), 403);
        } catch (BookingUnavailableException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    private function authorizeAccess(Request $request, \App\Models\Booking $booking): void
    {
        $user = $request->user();

        if (! $user->isAdmin() && $booking->user_id !== $user->id) {
            abort(403, 'You are not allowed to view this reservation.');
        }
    }
}
