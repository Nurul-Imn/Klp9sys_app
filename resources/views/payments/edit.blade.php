@extends('layouts.app')

@section('page_title', 'Konfirmasi Pembayaran INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('payments.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-6 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <div class="mb-6 p-4 bg-slate-50 border border-slate-100 rounded-xl text-sm">
            <div class="flex justify-between py-1">
                <span class="text-slate-450">Pelanggan:</span>
                <span class="font-bold text-slate-800">{{ $payment->booking->user->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-slate-455">Total Tagihan:</span>
                <span class="font-extrabold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-slate-450">Layanan:</span>
                <span class="font-semibold text-indigo-650">{{ $payment->booking->service->name ?? '-' }}</span>
            </div>
        </div>

        <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Status -->
                <div>
                    <label for="payment_status" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Pembayaran <span class="text-rose-500">*</span></label>
                    <select name="payment_status" id="payment_status" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="unpaid" {{ $payment->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid (Belum Lunas)</option>
                        <option value="paid" {{ $payment->payment_status === 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                        <option value="refunded" {{ $payment->payment_status === 'refunded' ? 'selected' : '' }}>Refunded (Pengembalian Dana)</option>
                    </select>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method', $payment->payment_method) }}" placeholder="Contoh: Transfer Bank BCA, Cash, Gopay" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Transaction ID -->
                <div>
                    <label for="transaction_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ID Transaksi / Referensi</label>
                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}" placeholder="Contoh: TX-827391943" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Gateway -->
                <div>
                    <label for="gateway" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pintu Pembayaran / Gateway</label>
                    <input type="text" name="gateway" id="gateway" value="{{ old('gateway', $payment->gateway) }}" placeholder="Contoh: Midtrans, Manual Transfer, Kasir" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('payments.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-500/20 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
