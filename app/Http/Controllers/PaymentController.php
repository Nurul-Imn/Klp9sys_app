<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of all payments (admin view).
     */
    public function index()
    {
        $payments = Payment::with(['booking.user', 'booking.service'])
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

    /**
     * Display the specified payment / invoice.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['booking.user', 'booking.pet', 'booking.service'])
            ->findOrFail($id);

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a payment (manual update by admin).
     */
    public function edit(string $id)
    {
        $payment = Payment::with(['booking.user', 'booking.service'])->findOrFail($id);

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update payment status manually (admin confirms manual transfer, etc.).
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid,failed,refunded',
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'gateway'        => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        $payment->payment_status = $validated['payment_status'];
        $payment->payment_method = $validated['payment_method'] ?? $payment->payment_method;
        $payment->transaction_id = $validated['transaction_id'] ?? $payment->transaction_id;
        $payment->gateway        = $validated['gateway'] ?? $payment->gateway;

        if ($validated['payment_status'] === 'paid') {
            $payment->status  = 'success';
            $payment->paid_at = now();
            // Update booking status to confirmed when paid
            $payment->booking()->update(['status' => 'confirmed']);
        } elseif ($validated['payment_status'] === 'failed') {
            $payment->status = 'failed';
        }

        $payment->save();

        return redirect()
            ->route('payments.show', $payment->id)
            ->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified payment record.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Data pembayaran berhasil dihapus!');
    }
}
