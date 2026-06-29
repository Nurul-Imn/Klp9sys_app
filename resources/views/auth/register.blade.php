<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PetCare System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center bg-gradient-to-b from-indigo-50/80 via-white to-slate-50 p-4">

    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-violet-200/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-violet-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl text-slate-900 tracking-wide">PetCare</h1>
                    <span class="text-[10px] text-slate-400 font-medium tracking-wide">MANAGEMENT SYSTEM</span>
                </div>
            </a>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Buat Akun</h2>
            <p class="text-sm text-slate-500 mb-6">Daftar untuk mulai menggunakan PetCare</p>

            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200/60">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                        placeholder="email@example.com">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                        placeholder="08xxxxxxxxxx">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                        placeholder="Ulangi password">
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-violet-500 to-indigo-600 text-white font-semibold rounded-xl shadow-md shadow-indigo-500/20 hover:from-violet-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all duration-200 text-sm mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
