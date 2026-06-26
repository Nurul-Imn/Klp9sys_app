<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $bookings = Booking::all();

    return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'pet_id' => 'required|exists:pets,id',
        'service_id' => 'required|exists:services,id',
        'booking_date' => 'required|date|after_or_equal:today',
        'booking_time' => 'required',
        'status' => 'required|in:pending,approved,completed,cancelled'
    ]);

    Booking::create([
        'user_id' => $request->user_id,
        'pet_id' => $request->pet_id,
        'service_id' => $request->service_id,
        'booking_date' => $request->booking_date,
        'booking_time' => $request->booking_time,
        'status' => $request->status,
        'notes' => $request->notes
    ]);

    return redirect()->back()
        ->with('success', 'Booking berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $booking = Booking::findOrFail($id);

    return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $booking = Booking::findOrFail($id);

    $request->validate([
        'booking_date' => 'required|date',
        'booking_time' => 'required',
        'status' => 'required|in:pending,approved,completed,cancelled'
    ]);

    $booking->update([
        'booking_date' => $request->booking_date,
        'booking_time' => $request->booking_time,
        'status' => $request->status,
        'notes' => $request->notes
    ]);

    return redirect()->back()
        ->with('success', 'Booking berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $booking = Booking::findOrFail($id);

    $booking->delete();

    return redirect()->back()
        ->with('success', 'Booking berhasil dihapus');
    }
}
