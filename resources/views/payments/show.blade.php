@extends('layouts.app')

@section('page_title', 'Invoice Pembayaran')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('payments.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Transaksi
        </a>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Invoice
        </button>
    </div>

    <!-- Invoice Card Container -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-md p-8 md:p-12 space-y-8 relative overflow-hidden" id="invoice">
        <!-- Accent bar -->
        <div class="absolute top-0 left-0 right-0 h-2.5 bg-gradient-to-r from-indigo-500 to-violet-650"></div>
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <h3 class="text-xl font-bold text-slate-900">PetCare System</h3>
                <p class="text-xs text-slate-400 font-medium">Sistem Perawatan & Klinik Hewan Premium</p>
            </div>
            <div class="text-left md:text-right">
                <h4 class="text-base font-extrabold text-slate-800">INVOICE TAGIHAN</h4>
                <p class="text-sm font-bold text-indigo-650 mt-0.5">INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <hr class="border-slate-100">

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
            <div>
                <span class="text-slate-400 font-bold text-[10px] uppercase tracking-wider block mb-2.5">Ditagih Kepada:</span>
                <p class="font-bold text-slate-805 text-base">{{ $payment->booking->user->name ?? '-' }}</p>
                <p class="text-slate-500 mt-1">{{ $payment->booking->user->email ?? '-' }}</p>
                <p class="text-slate-500">{{ $payment->booking->user->phone ?? '-' }}</p>
            </div>
            <div>
                <span class="text-slate-400 font-bold text-[10px] uppercase tracking-wider block mb-2.5">Detail Transaksi:</span>
                <table class="w-full text-left space-y-1 text-xs">
                    <tr>
                        <td class="text-slate-450 pr-4 py-0.5">Tanggal Invoice:</td>
                        <td class="font-bold text-slate-700">{{ $payment->created_at->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-slate-450 pr-4 py-0.5">Kode Booking:</td>
                        <td class="font-bold text-slate-700">{{ $payment->booking->booking_code ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-slate-450 pr-4 py-0.5">Status Pembayaran:</td>
                        <td>
                            @if($payment->payment_status === 'paid')
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded border border-emerald-100">Lunas</span>
                            @else
                                <span class="px-2 py-0.5 bg-rose-50 text-rose-700 font-bold rounded border border-rose-100">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Invoice Table -->
        <div class="border border-slate-100 rounded-xl overflow-hidden mt-8">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 font-bold text-slate-500 border-b border-slate-100">
                        <th class="py-3.5 px-6">Nama Layanan / Deskripsi</th>
                        <th class="py-3.5 px-6 text-center">Durasi</th>
                        <th class="py-3.5 px-6 text-right">Harga Pasien ({{ $payment->booking->pet->name ?? 'Pet' }})</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-5 px-6">
                            <span class="font-bold text-slate-800">{{ $payment->booking->service->name ?? 'Layanan Pet Care' }}</span>
                            <span class="text-xs text-slate-400 block mt-1">Grooming & perawatan khusus peliharaan</span>
                        </td>
                        <td class="py-5 px-6 text-center text-slate-600 font-medium">
                            {{ $payment->booking->service->duration_minutes ?? '-' }} Menit
                        </td>
                        <td class="py-5 px-6 text-right font-bold text-slate-800">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Total summary block -->
        <div class="flex justify-end pt-4">
            <div class="w-full md:w-80 text-sm space-y-2.5">
                <div class="flex justify-between">
                    <span class="text-slate-450 font-medium">Subtotal:</span>
                    <span class="font-bold text-slate-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-450 font-medium">Pajak (0%):</span>
                    <span class="font-bold text-slate-700">Rp 0</span>
                </div>
                <hr class="border-slate-100">
                <div class="flex justify-between text-base">
                    <span class="font-bold text-slate-850">Total Bayar:</span>
                    <span class="font-extrabold text-indigo-650 text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        <!-- Footer terms -->
        <div class="text-center text-xs text-slate-400 space-y-1">
            <p>Terima kasih atas kepercayaan Anda mempercayakan hewan kesayangan kepada PetCare.</p>
            <p>Jika ada pertanyaan terkait tagihan ini, silakan hubungi Customer Service kami.</p>
        </div>
    </div>
</div>
@endsection