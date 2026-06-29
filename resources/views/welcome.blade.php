<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Sistem Manajemen Klinik & Perawatan Hewan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col justify-between overflow-x-hidden text-slate-800">

    <!-- Top Navigation Bar -->
    <header class="bg-transparent absolute top-0 left-0 right-0 z-30">
        <div class="max-w-7xl mx-auto px-6 md:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-violet-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <h1 class="font-extrabold text-lg text-slate-900 tracking-wide">PetCare</h1>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}" class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold shadow-sm transition duration-150">
                    Masuk
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md transition duration-150">
                    Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-28 bg-gradient-to-b from-indigo-50/80 via-white to-slate-50 overflow-hidden flex-1 flex items-center">
        <!-- Floating shapes -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-200/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-violet-200/40 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Intro -->
                <div class="lg:col-span-7 space-y-6 text-left">
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        ✨ Sistem Manajemen Hewan Premium
                    </span>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        Kesehatan & Perawatan Terbaik untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-650">Hewan Kesayangan</span>
                    </h2>
                    <p class="text-slate-500 text-base md:text-lg leading-relaxed max-w-2xl">
                        Kelola data pasien peliharaan, jadwalkan booking grooming atau pemeriksaan medis secara efisien, serta catat transaksi tagihan pembayaran Anda dalam satu aplikasi terintegrasi.
                    </p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-7 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-base font-bold shadow-lg shadow-indigo-600/20 hover:shadow-xl transition-all duration-200">
                            Masuk Ke Aplikasi
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center px-7 py-3.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-base font-bold transition">
                            Lihat Fitur Utama
                        </a>
                    </div>
                </div>

                <!-- Features Cards Summary -->
                <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 hover:translate-y-[-4px] transition duration-200">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                            🐾
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Data Pets</h3>
                        <p class="text-slate-400 text-xs leading-relaxed">Catat data klinis pasien, riwayat alergi, dan info pemilik.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 mt-4 hover:translate-y-[-4px] transition duration-200">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            📅
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Reservasi</h3>
                        <p class="text-slate-400 text-xs leading-relaxed">Booking perawatan & pemeriksaan dengan waktu presisi.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 hover:translate-y-[-4px] transition duration-200">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                            💼
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Katalog</h3>
                        <p class="text-slate-400 text-xs leading-relaxed">Kelola harga paket perawatan & stok produk medis.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-3 mt-4 hover:translate-y-[-4px] transition duration-200">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            💳
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">Billing</h3>
                        <p class="text-slate-400 text-xs leading-relaxed">Invoice otomatis & validasi pembayaran digital/manual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="h-16 bg-white border-t border-slate-100 shrink-0">
        <div class="max-w-7xl mx-auto px-6 md:px-8 h-full flex items-center justify-between text-xs text-slate-400 font-medium">
            <span>&copy; {{ date('Y') }} PetCare Management System. All rights reserved.</span>
            <span>Made with ❤️ for Pet Lovers</span>
        </div>
    </footer>

</body>
</html>
