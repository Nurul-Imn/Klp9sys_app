@extends('layouts.app')

@section('page_title', 'Katalog Layanan')

@section('content')
<div class="flex items-center justify-between">
    <p class="text-sm font-medium text-slate-500">Daftar layanan perawatan hewan peliharaan yang tersedia.</p>
    <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Layanan
    </a>
</div>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($services as $service)
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-start">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ $service->category ?? 'Umum' }}
                    </span>
                    @if($service->is_active)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Aktif</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">Nonaktif</span>
                    @endif
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 text-lg hover:text-indigo-650">
                        <a href="{{ route('services.show', $service->id) }}">{{ $service->name }}</a>
                    </h3>
                    <p class="text-slate-500 text-sm mt-1.5 leading-relaxed line-clamp-2">
                        {{ $service->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <div class="flex justify-between items-center pt-2 text-sm border-t border-slate-50">
                    <div class="flex items-center text-slate-455">
                        <svg class="w-4.5 h-4.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ $service->duration_minutes }} Menit</span>
                    </div>
                    <div class="font-extrabold text-slate-900 text-base">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Footer actions -->
            <div class="bg-slate-50/80 px-6 py-3 border-t border-slate-100 flex items-center justify-end space-x-2">
                <a href="{{ route('services.edit', $service->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold border border-amber-250/20 transition">
                    Edit
                </a>
                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold border border-rose-250/20 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-slate-400 font-medium">Belum ada layanan terdaftar.</div>
    @endforelse
</div>
@endsection