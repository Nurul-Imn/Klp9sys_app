<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'pet', 'service'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $pets = Pet::all();
        $services = Service::where('is_active', true)->get();
        return view('bookings.create', compact('users', 'pets', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        $booking = new Booking();
        $booking->user_id = $validated['user_id'];
        $booking->pet_id = $validated['pet_id'];
        $booking->service_id = $validated['service_id'];
        $booking->booking_code = 'BK-' . strtoupper(Str::random(6));
        $booking->booking_date = $validated['booking_date'];
        $booking->time_slot = $validated['time_slot'];
        $booking->status = 'pending';
        $booking->total_price = $service->price;
        $booking->notes = $validated['notes'];
        $booking->save();

        // Create an accompanying pending payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'currency' => 'IDR',
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function show(string $id)
    {
        $booking = Booking::with(['user', 'pet', 'service', 'payment'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);
        $users = User::all();
        $pets = Pet::where('user_id', $booking->user_id)->get();
        if ($pets->isEmpty()) {
            $pets = Pet::all();
        }
        $services = Service::where('is_active', true)->get();
        return view('bookings.edit', compact('booking', 'users', 'pets', 'services'));
    }

    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'time_slot' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        $booking->user_id = $validated['user_id'];
        $booking->pet_id = $validated['pet_id'];
        $booking->service_id = $validated['service_id'];
        $booking->booking_date = $validated['booking_date'];
        $booking->time_slot = $validated['time_slot'];
        $booking->status = $validated['status'];
        $booking->total_price = $service->price;
        $booking->notes = $validated['notes'];
        $booking->save();

        // Update payment amount if it exists and is unpaid
        $payment = $booking->payment;
        if ($payment && $payment->payment_status === 'unpaid') {
            $payment->amount = $booking->total_price;
            $payment->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}