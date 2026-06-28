<?php

namespace App\Http\Controllers;

use App\Contract\BookingServiceContract;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        protected BookingServiceContract $bookingService
    ) {}

    // -------------------------------------------------------------------------
    // Index — list all bookings (admin view, no userId filter)
    // -------------------------------------------------------------------------
    public function index()
    {
        // Admin sees all: bypass listBookings(userId) and query directly via model
        // This keeps the contract lean while the admin view still works.
        $bookings = \App\Models\Booking::with(['user', 'pet', 'service'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    // -------------------------------------------------------------------------
    // Create form
    // -------------------------------------------------------------------------
    public function create()
    {
        $users    = User::all();
        $pets     = Pet::all();
        $services = Service::where('is_active', true)->get();
        return view('bookings.create', compact('users', 'pets', 'services'));
    }

    // -------------------------------------------------------------------------
    // Store — delegate heavy logic to service
    // -------------------------------------------------------------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'pet_id'       => 'required|exists:pets,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'time_slot'    => 'required|string|max:255',
            'notes'        => 'nullable|string',
        ]);

        // Optional: check slot availability before creating
        $available = $this->bookingService->checkAvailability(
            (int) $validated['service_id'],
            $validated['booking_date'],
            $validated['time_slot']
        );

        if (!$available) {
            return back()
                ->withInput()
                ->withErrors(['time_slot' => 'Slot waktu ini sudah dipesan. Silakan pilih waktu lain.']);
        }

        $this->bookingService->createBooking(
            userId:    (int) $validated['user_id'],
            petId:     (int) $validated['pet_id'],
            serviceId: (int) $validated['service_id'],
            date:      $validated['booking_date'],
            timeSlot:  $validated['time_slot']
        );

        // notes is handled separately since the contract keeps it minimal;
        // update it on the freshly-created booking if provided
        if (!empty($validated['notes'])) {
            $booking = \App\Models\Booking::where('user_id', $validated['user_id'])
                ->latest()
                ->first();
            if ($booking) {
                $booking->notes = $validated['notes'];
                $booking->save();
            }
        }

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------
    public function show(string $id)
    {
        $bookingData = $this->bookingService->getBooking((int) $id);

        // Views still expect an Eloquent model instance — reload it
        $booking = \App\Models\Booking::with(['user', 'pet', 'service', 'payment'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    // -------------------------------------------------------------------------
    // Edit form
    // -------------------------------------------------------------------------
    public function edit(string $id)
    {
        $booking  = \App\Models\Booking::findOrFail($id);
        $users    = User::all();
        $pets     = Pet::where('user_id', $booking->user_id)->get();

        if ($pets->isEmpty()) {
            $pets = Pet::all();
        }

        $services = Service::where('is_active', true)->get();
        return view('bookings.edit', compact('booking', 'users', 'pets', 'services'));
    }

    // -------------------------------------------------------------------------
    // Update
    // -------------------------------------------------------------------------
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'pet_id'       => 'required|exists:pets,id',
            'service_id'   => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'time_slot'    => 'required|string|max:255',
            'status'       => 'required|in:pending,confirmed,completed,cancelled',
            'notes'        => 'nullable|string',
        ]);

        $booking = \App\Models\Booking::findOrFail($id);
        $service = Service::findOrFail($validated['service_id']);

        // Update fields not covered by the contract
        $booking->user_id      = $validated['user_id'];
        $booking->pet_id       = $validated['pet_id'];
        $booking->service_id   = $validated['service_id'];
        $booking->booking_date = $validated['booking_date'];
        $booking->time_slot    = $validated['time_slot'];
        $booking->total_price  = $service->price;
        $booking->notes        = $validated['notes'];
        $booking->save();

        // Status change is delegated to service so business rules (e.g. void payment) run
        $this->bookingService->updateBookingStatus((int) $id, $validated['status']);

        // Sync payment amount if still unpaid
        $payment = $booking->fresh()->payment;
        if ($payment && $payment->payment_status === 'unpaid') {
            $payment->amount = $service->price;
            $payment->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil diperbarui!');
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------
    public function destroy(string $id)
    {
        // Cancel first (runs business rules), then delete
        $this->bookingService->cancelBooking((int) $id);
        \App\Models\Booking::findOrFail($id)->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}