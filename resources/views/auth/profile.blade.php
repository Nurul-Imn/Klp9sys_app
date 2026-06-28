@extends('layouts.app')

@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200/60 flex items-center space-x-3">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Profile Card --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
        <h2 class="text-base font-bold text-slate-800 mb-5">Informasi Akun</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $profile['name']) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile['email']) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile['phone'] ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role</label>
                    <input type="text" value="{{ ucfirst($profile['role'] ?? 'customer') }}" disabled
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-500 bg-slate-50 text-sm">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <p class="text-xs font-semibold text-slate-500 mb-3 uppercase tracking-wider">Ganti Password <span class="font-normal normal-case">(kosongkan jika tidak ingin ganti)</span></p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                            placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition"
                            placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-indigo-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Pets Card --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-bold text-slate-800">Hewan Peliharaan Saya</h2>
            <a href="{{ route('pets.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-indigo-500/20">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pet
            </a>
        </div>

        @if (empty($pets))
            <div class="text-center py-10 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138..." />
                </svg>
                <p class="text-sm">Belum ada hewan peliharaan yang didaftarkan.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($pets as $pet)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $pet['name'] }}</p>
                            <p class="text-xs text-slate-500">{{ $pet['species'] }}{{ !empty($pet['breed']) ? ' · ' . $pet['breed'] : '' }}</p>
                        </div>
                        <a href="{{ route('pets.edit', $pet['id']) }}"
                            class="text-xs text-indigo-600 font-semibold hover:text-indigo-700 transition">
                            Edit
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
