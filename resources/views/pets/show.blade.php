@extends('layouts.app')

@section('page_title', 'Detail Pet - ' . $pet->name)

@section('content')
<div class="space-y-6">
    <a href="{{ route('pets.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pet Profile Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-white text-3xl font-extrabold shadow-md mb-4">
                {{ substr($pet->name, 0, 1) }}
            </div>
            <h3 class="text-xl font-bold text-slate-900">{{ $pet->name }}</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-750 border border-indigo-100/60 mt-1">
                {{ $pet->species }}
            </span>

            <div class="w-full mt-6 space-y-4 border-t border-slate-100 pt-6 text-left">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400 font-medium">Ras / Breed:</span>
                    <span class="font-bold text-slate-800">{{ $pet->breed ?? 'Lokal' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400 font-medium">Gender:</span>
                    <span class="font-bold text-slate-800">{{ $pet->gender ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400 font-medium">Umur:</span>
                    <span class="font-bold text-slate-800">{{ $pet->age ?? 0 }} Tahun</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400 font-medium">Berat Badan:</span>
                    <span class="font-bold text-slate-800">{{ $pet->weight ?? 0 }} Kg</span>
                </div>
            </div>
        </div>

        <!-- Owner & Medical Notes -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Owner details -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <h4 class="font-bold text-slate-900 text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 text-slate-450 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Pemilik
                </h4>
                @if($pet->user)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-slate-400 block font-medium">Nama Pemilik</span>
                            <span class="font-bold text-slate-800">{{ $pet->user->name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">E-mail</span>
                            <span class="font-semibold text-slate-800">{{ $pet->user->email }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Telepon / HP</span>
                            <span class="font-bold text-slate-800">{{ $pet->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-450 italic">Tidak ada informasi pemilik untuk peliharaan ini.</p>
                @endif
            </div>

            <!-- Notes -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <h4 class="font-bold text-slate-900 text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 text-slate-450 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Catatan Medis & Keterangan Peliharaan
                </h4>
                <p class="text-slate-700 bg-slate-50 border border-slate-100 rounded-xl p-4 text-sm leading-relaxed min-h-24">
                    {{ $pet->notes ?? 'Tidak ada catatan khusus untuk hewan peliharaan ini.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Booking History Card -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h4 class="font-bold text-slate-900 text-base">Riwayat Booking</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 px-6">Kode Booking</th>
                        <th class="py-3 px-6">Layanan</th>
                        <th class="py-3 px-6">Tanggal & Slot</th>
                        <th class="py-3 px-6">Total Harga</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($pet->bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="hover:text-indigo-650">{{ $booking->booking_code }}</a>
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-semibold">{{ $booking->service->name ?? '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-slate-800">{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-slate-400">{{ $booking->time_slot }}</div>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @if($booking->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Confirmed</span>
                                @elseif($booking->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                @elseif($booking->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada riwayat booking untuk peliharaan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection