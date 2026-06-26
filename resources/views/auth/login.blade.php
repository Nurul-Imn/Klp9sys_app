<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PetCare System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
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
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Selamat Datang</h2>
            <p class="text-sm text-slate-500 mb-6">Masuk ke akun Anda untuk melanjutkan</p>

            <div id="error-message" role="alert" class="hidden p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60 flex items-center space-x-3 shadow-sm">
                <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span id="error-text" class="font-medium"></span>
            </div>

            <form id="login-form" class="space-y-5">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 placeholder:text-slate-300">
                </div>
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="Masukkan password"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 placeholder:text-slate-300">
                </div>
                <button type="submit" id="login-btn"
                        class="w-full px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-xl text-sm font-bold shadow-md shadow-indigo-500/20 hover:shadow-lg transition-all duration-150 flex items-center justify-center disabled:opacity-60 disabled:cursor-not-allowed">
                    <span id="btn-text">Masuk</span>
                    <svg id="btn-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-400">
                Belum punya akun?
                <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Hubungi Admin</a>
            </p>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('login-form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const btn = document.getElementById('login-btn');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            const errorMsg = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = emailInput.value.trim();
                const password = passwordInput.value;

                if (!email || !password) {
                    showError('Harap isi email dan password.');
                    return;
                }

                errorMsg.classList.add('hidden');
                setLoading(true);

                try {
                    const response = await fetch('/api/v1/auth/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ email, password }),
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Email atau password salah.');
                    }

                    localStorage.setItem('auth_token', result.data.token);
                    localStorage.setItem('user', JSON.stringify(result.data.user));
                    window.location.href = '/dashboard';
                } catch (error) {
                    showError(error.message);
                } finally {
                    setLoading(false);
                }
            });

            function setLoading(loading) {
                btn.disabled = loading;
                if (loading) {
                    btnText.textContent = 'Memproses...';
                    spinner.classList.remove('hidden');
                } else {
                    btnText.textContent = 'Masuk';
                    spinner.classList.add('hidden');
                }
            }

            function showError(message) {
                errorText.textContent = message;
                errorMsg.classList.remove('hidden');
            }
        })();
    </script>

</body>
</html>
