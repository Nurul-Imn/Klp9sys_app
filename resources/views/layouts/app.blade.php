<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care System - Premium Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col md:flex-row overflow-hidden text-slate-800">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 text-slate-100 flex flex-col shrink-0 border-r border-slate-800 shadow-xl z-20">
        <!-- Logo & Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-violet-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-base leading-none text-white tracking-wide">PetCare</h1>
                    <span class="text-[10px] text-slate-400 font-medium">MANAGEMENT SYSTEM</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Menu Utama</span>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('dashboard*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                Dashboard
            </a>

            <!-- Pets -->
            <a href="{{ route('pets.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('pets*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                Pets
            </a>

            <!-- Services -->
            <a href="{{ route('services.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('services*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Services
            </a>

            <!-- Bookings -->
            <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('bookings*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Bookings
            </a>

            <!-- Products -->
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('products*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Products
            </a>

            <!-- Payments -->
            <a href="{{ route('payments.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('payments*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Payments
            </a>
        </nav>

        <!-- User Profile (Bottom) -->
        <div id="user-profile" class="p-4 border-t border-slate-800 bg-slate-950">
            <div id="user-authenticated" class="hidden flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center font-bold text-white shadow-md shrink-0" id="user-avatar">A</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate" id="user-name">User</p>
                    <span class="text-[11px] text-slate-500 font-medium capitalize" id="user-role">Administrator</span>
                </div>
                <button id="logout-btn" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-400 hover:bg-slate-800 transition" title="Keluar">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>
            <a id="user-guest" href="{{ route('login') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-slate-200 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-400 group-hover:text-white transition">Masuk</p>
                    <span class="text-[11px] text-slate-600 font-medium">Belum login</span>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Top bar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Sistem Manajemen</span>
                <h2 class="text-lg font-bold text-slate-800 leading-tight">@yield('page_title', 'Pet Care Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-500 font-medium">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-1 p-8 space-y-6">
            
            <!-- Toast Flash Messages -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-center space-x-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60 flex flex-col space-y-1 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold">Ada beberapa kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside pl-8 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        (function() {
            var token = localStorage.getItem('auth_token');
            var userEl = document.getElementById('user-authenticated');
            var guestEl = document.getElementById('user-guest');
            var nameEl = document.getElementById('user-name');
            var roleEl = document.getElementById('user-role');
            var avatarEl = document.getElementById('user-avatar');
            var logoutBtn = document.getElementById('logout-btn');

            function updateUI() {
                if (token) {
                    userEl.classList.remove('hidden');
                    guestEl.classList.add('hidden');
                    try {
                        var user = JSON.parse(localStorage.getItem('user') || '{}');
                        nameEl.textContent = user.name || 'User';
                        roleEl.textContent = user.role || 'customer';
                        avatarEl.textContent = (user.name || 'A').charAt(0).toUpperCase();
                    } catch (e) {
                        nameEl.textContent = 'User';
                        roleEl.textContent = 'customer';
                    }
                } else {
                    userEl.classList.add('hidden');
                    guestEl.classList.remove('hidden');
                }
            }

            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                });
            }

            updateUI();
        })();
    </script>
</body>
</html>