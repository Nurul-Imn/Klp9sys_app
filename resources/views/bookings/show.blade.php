@extends('layouts.app')

@section('page_title', 'Detail Booking ' . $booking->booking_code)

@section('content')
<div class="space-y-6">
    <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Booking details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-slate-400 block text-xs font-bold uppercase tracking-wider">Kode Reservasi</span>
                        <span class="text-xl font-bold text-slate-900">{{ $booking->booking_code }}</span>
                    </div>
                    <div>
                        @if($booking->status === 'confirmed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmed (Terkonfirmasi)</span>
                        @elseif($booking->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Pending (Menunggu)</span>
                        @elseif($booking->status === 'completed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Completed (Selesai)</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Cancelled (Batal)</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-slate-100 pt-6 text-sm">
                    <div>
                        <span class="text-slate-400 block font-medium">Tanggal Booking</span>
                        <span class="font-bold text-slate-800">{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Slot Waktu</span>
                        <span class="font-bold text-slate-800">{{ $booking->time_slot }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Total Harga Layanan</span>
                        <span class="font-extrabold text-slate-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <span class="text-slate-400 block text-xs font-bold uppercase tracking-wider mb-2">Layanan yang Dipesan</span>
                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $booking->service->name ?? '-' }}</h4>
                            <p class="text-xs text-slate-450 mt-0.5">Kategori: {{ $booking->service->category ?? 'Umum' }}</p>
                        </div>
                        <span class="text-xs font-bold text-slate-500">{{ $booking->service->duration_minutes ?? 0 }} Menit</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <span class="text-slate-400 block text-xs font-bold uppercase tracking-wider mb-2">Keluhan / Catatan Medis</span>
                    <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line min-h-16">
                        {{ $booking->notes ?? 'Tidak ada catatan keluhan.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar profiles and payment -->
        <div class="space-y-6">
            <!-- Patient / Pet Profile -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-900 text-sm border-b border-slate-50 pb-3">Informasi Pasien (Pet)</h4>
                @if($booking->pet)
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-650 flex items-center justify-center font-bold text-sm">
                            {{ substr($booking->pet->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-800 text-sm">
                                <a href="{{ route('pets.show', $booking->pet->id) }}" class="hover:text-indigo-650">{{ $booking->pet->name }}</a>
                            </h5>
                            <p class="text-xs text-slate-400">{{ $booking->pet->species }} • {{ $booking->pet->breed ?? 'Lokal' }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-450 italic">Data pet tidak ditemukan.</p>
                @endif
            </div>

            <!-- Customer / Owner Profile -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-900 text-sm border-b border-slate-50 pb-3">Pemilik (Customer)</h4>
                @if($booking->user)
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">Nama:</span>
                            <span class="font-bold text-slate-850">{{ $booking->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">Email:</span>
                            <span class="font-semibold text-slate-800">{{ $booking->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">HP/Telepon:</span>
                            <span class="font-bold text-slate-800">{{ $booking->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-450 italic">Data customer tidak ditemukan.</p>
                @endif
            </div>

            <!-- Payment Status -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                <h4 class="font-bold text-slate-900 text-sm border-b border-slate-50 pb-3">Informasi Pembayaran</h4>
                @if($booking->payment)
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">Metode:</span>
                            <span class="font-bold text-slate-850">{{ $booking->payment->payment_method ?? 'Belum ditentukan' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">ID Transaksi:</span>
                            <span class="font-mono text-slate-700">{{ $booking->payment->transaction_id ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-medium">Status Pembayaran:</span>
                            @if($booking->payment->payment_status === 'paid')
                                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-100">Paid (Lunas)</span>
                            @elseif($booking->payment->payment_status === 'refunded')
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">Refunded</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-rose-50 text-rose-700 font-bold border border-rose-100">Unpaid (Belum Lunas)</span>
                            @endif
                        </div>
                        @if($booking->payment->payment_status === 'unpaid')
                            <div class="pt-2">
                                <a href="{{ route('payments.edit', $booking->payment->id) }}" class="w-full text-center inline-block px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold rounded-xl border border-indigo-200/50 transition">
                                    Konfirmasi Pembayaran
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-xs text-slate-450 italic">Invoice pembayaran tidak dibuat.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection