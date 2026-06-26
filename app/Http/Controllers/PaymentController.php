<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking.user')->latest()->get();
        return view('payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('booking.user')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $validated = $request->validate([
            'payment_status' => 'required|in:paid,unpaid,refunded',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'gateway' => 'nullable|string|max:255',
        ]);

        $payment->payment_status = $validated['payment_status'];
        $payment->payment_method = $validated['payment_method'];
        $payment->transaction_id = $validated['transaction_id'];
        $payment->gateway = $validated['gateway'];

        if ($validated['payment_status'] === 'paid') {
            $payment->status = 'success';
            $payment->paid_at = now();
            // Automatically confirm the booking if paid
            if ($payment->booking) {
                $payment->booking->status = 'confirmed';
                $payment->booking->save();
            }
        } else {
            $payment->status = 'pending';
            $payment->paid_at = null;
        }

        $payment->save();

        return redirect()->route('payments.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}