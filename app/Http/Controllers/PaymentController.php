<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function store(Request $request)
    {
       $request->validate([
    'booking_id' => 'required|exists:bookings,id',
    'transaction_id' => 'required|string|max:100',
    'gateway' => 'required|string|max:50',
    'amount' => 'required|integer|min:0',
    'currency' => 'required|string|max:10',
    'payment_method' => 'required|string|max:50',
    'status' => 'required|in:pending,paid,failed',
        ]);

        Payment::create([
    'booking_id' => $request->booking_id,
    'transaction_id' => $request->transaction_id,
    'gateway' => $request->gateway,
    'amount' => $request->amount,
    'currency' => $request->currency,
    'payment_method' => $request->payment_method,
    'status' => $request->status,
        ]);

        return redirect()->back()
            ->with('success', 'Pembayaran berhasil ditambahkan');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Payment $payment)
    {
    $request->validate([
        'booking_id' => 'required|exists:bookings,id',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'required|in:cash,transfer,ewallet',
        'payment_status' => 'required|in:pending,paid',
    ]);

    $payment->update([
        'booking_id' => $request->booking_id,
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'status' => $request->status,
    ]);

    return redirect()->back()
        ->with('success', 'Pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
