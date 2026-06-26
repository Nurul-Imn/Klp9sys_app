@extends('layouts.app')

@section('page_title', 'Data Bookings')

@section('content')
<div class="flex items-center justify-between">
    <p class="text-sm font-medium text-slate-500">Daftar reservasi layanan perawatan hewan oleh customer.</p>
    <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Buat Booking
    </a>
</div>

<!-- Bookings Table Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <th class="py-3 px-6">Kode Booking</th>
                    <th class="py-3 px-6">Pemilik & Pet</th>
                    <th class="py-3 px-6">Layanan</th>
                    <th class="py-3 px-6">Tanggal & Waktu</th>
                    <th class="py-3 px-6">Total Biaya</th>
                    <th class="py-3 px-6">Status Booking</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6 font-bold text-slate-900">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="hover:text-indigo-600">
                                {{ $booking->booking_code }}
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-semibold text-slate-800">{{ $booking->pet->name ?? '-' }}</div>
                            <span class="text-xs text-slate-400 font-medium">Pemilik: {{ $booking->user->name ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6 font-medium text-slate-700">
                            {{ $booking->service->name ?? '-' }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-800">{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</div>
                            <span class="text-xs text-slate-400 font-medium">{{ $booking->time_slot }}</span>
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-950">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($booking->status === 'confirmed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Confirmed</span>
                            @elseif($booking->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Pending</span>
                            @elseif($booking->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">Completed</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">Cancelled</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-105 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                Detail
                            </a>
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold border border-amber-200/50 transition">
                                Edit
                            </a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data booking ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold border border-rose-200/50 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 font-medium">Belum ada riwayat booking terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection