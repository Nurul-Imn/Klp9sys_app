@extends('layouts.app')

@section('page_title', 'Status Transaksi & Pembayaran')

@section('content')
<div class="flex items-center justify-between">
    <p class="text-sm font-medium text-slate-500">Kelola riwayat tagihan dan verifikasi pembayaran manual dari customer.</p>
</div>

<!-- Payments Table Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <th class="py-3 px-6">ID Invoice</th>
                    <th class="py-3 px-6">Customer / Booking</th>
                    <th class="py-3 px-6">Metode</th>
                    <th class="py-3 px-6">Jumlah Tagihan</th>
                    <th class="py-3 px-6">Tanggal Bayar</th>
                    <th class="py-3 px-6">Status Bayar</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-800">INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
                            @if($payment->transaction_id)
                                <span class="text-[10px] font-mono text-slate-400 block">{{ $payment->transaction_id }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-semibold text-slate-800">{{ $payment->booking->user->name ?? '-' }}</div>
                            <a href="{{ route('bookings.show', $payment->booking_id) }}" class="text-xs text-indigo-600 hover:text-indigo-750 font-bold block mt-0.5">
                                Booking: {{ $payment->booking->booking_code ?? '-' }}
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-slate-700">{{ $payment->payment_method ?? 'Belum Ditentukan' }}</span>
                            @if($payment->gateway)
                                <span class="text-xs text-slate-400 block">{{ $payment->gateway }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-extrabold text-slate-900">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ $payment->paid_at ? $payment->paid_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($payment->payment_status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Paid</span>
                            @elseif($payment->payment_status === 'refunded')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">Refunded</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Unpaid</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('payments.show', $payment->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-105 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                Invoice
                            </a>
                            <a href="{{ route('payments.edit', $payment->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold border border-indigo-200/50 transition">
                                Konfirmasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 font-medium">Belum ada transaksi pembayaran terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection