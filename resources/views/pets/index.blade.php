@extends('layouts.app')

@section('page_title', 'Daftar Pets')

@section('content')
<div class="flex items-center justify-between">
    <p class="text-sm font-medium text-slate-500">Kelola informasi pasien hewan peliharaan Anda disini.</p>
    <a href="{{ route('pets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Pet
    </a>
</div>

<!-- Pets Table Card -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <th class="py-3 px-6">No</th>
                    <th class="py-3 px-6">Nama Pet</th>
                    <th class="py-3 px-6">Spesies / Ras</th>
                    <th class="py-3 px-6">Gender</th>
                    <th class="py-3 px-6">Umur / Berat</th>
                    <th class="py-3 px-6">Pemilik</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($pets as $pet)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="py-4 px-6 text-slate-400 font-bold">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">
                            <a href="{{ route('pets.show', $pet->id) }}" class="hover:text-indigo-600 flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    {{ substr($pet->name, 0, 1) }}
                                </div>
                                <span>{{ $pet->name }}</span>
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-slate-700">{{ $pet->species }}</span>
                            <span class="text-xs text-slate-400 block">{{ $pet->breed ?? 'Lokal/Campuran' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($pet->gender === 'Jantan')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">♂ Jantan</span>
                            @elseif($pet->gender === 'Betina')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-100">♀ Betina</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-700">{{ $pet->age ?? 0 }} Tahun</div>
                            <div class="text-xs text-slate-400">{{ $pet->weight ?? 0 }} Kg</div>
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-650">
                            {{ $pet->user->name ?? 'Tidak Ada Pemilik' }}
                        </td>
                        <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('pets.show', $pet->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                Detail
                            </a>
                            <a href="{{ route('pets.edit', $pet->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold border border-amber-200/50 transition">
                                Edit
                            </a>
                            <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pet ini?')">
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
                        <td colspan="7" class="py-12 text-center text-slate-400 font-medium">Belum ada data pet terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection