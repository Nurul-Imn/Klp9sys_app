@extends('layouts.app')

@section('page_title', 'Dashboard Ringkasan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stat Card 1: Pets -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center space-x-4 shadow-sm hover:shadow-md transition-all duration-200">
        <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Hewan</span>
            <span class="text-2xl font-extrabold text-slate-800">{{ $totalPets }}</span>
        </div>
    </div>

    <!-- Stat Card 2: Bookings -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center space-x-4 shadow-sm hover:shadow-md transition-all duration-200">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Booking</span>
            <span class="text-2xl font-extrabold text-slate-800">{{ $totalBookings }}</span>
        </div>
    </div>

    <!-- Stat Card 3: Products / Active Services -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center space-x-4 shadow-sm hover:shadow-md transition-all duration-200">
        <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Produk & Layanan</span>
            <span class="text-2xl font-extrabold text-slate-800">{{ $totalProducts + $totalServices }}</span>
        </div>
    </div>

    <!-- Stat Card 4: Total Revenue -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center space-x-4 shadow-sm hover:shadow-md transition-all duration-200">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pendapatan Bersih</span>
            <span class="text-xl font-extrabold text-slate-850">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden lg:col-span-2">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-850 text-base">Booking Terbaru</h3>
            <a href="{{ route('bookings.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 px-6">Kode</th>
                        <th class="py-3 px-6">Pet</th>
                        <th class="py-3 px-6">Layanan</th>
                        <th class="py-3 px-6">Tanggal & Slot</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-semibold text-slate-900">{{ $booking->booking_code }}</td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-slate-800">{{ $booking->pet->name ?? '-' }}</div>
                                <div class="text-xs text-slate-450">{{ $booking->pet->species ?? '' }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">{{ $booking->service->name ?? '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="text-slate-700 font-medium">{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-slate-450">{{ $booking->time_slot }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($booking->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-250">Terkonfirmasi</span>
                                @elseif($booking->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-250">Menunggu</span>
                                @elseif($booking->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-250">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-250">Batal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada data booking terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Registered Pets -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-850 text-base">Pet Baru Masuk</h3>
            <a href="{{ route('pets.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
        </div>
        <div class="p-6 divide-y divide-slate-100">
            @forelse($recentPets as $pet)
                <div class="py-4.5 first:pt-0 last:pb-0 flex items-center justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-violet-500 to-indigo-500 flex items-center justify-center text-white font-extrabold text-sm shadow-sm shadow-indigo-200">
                            {{ substr($pet->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">{{ $pet->name }}</h4>
                            <span class="text-xs text-slate-400 font-medium">{{ $pet->species }} • {{ $pet->breed ?? 'Lokal' }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold text-slate-400 block">Pemilik</span>
                        <span class="text-xs font-bold text-slate-700">{{ $pet->user->name ?? 'Anonim' }}</span>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-400 font-medium text-sm">Belum ada pet terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection