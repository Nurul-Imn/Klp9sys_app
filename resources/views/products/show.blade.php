@extends('layouts.app')

@section('page_title', 'Detail Produk')

@section('content')
<div class="max-w-3xl space-y-6">
    <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm space-y-6">
        <div class="flex justify-between items-start">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-2">
                    {{ $product->category ?? 'Umum' }}
                </span>
                <h3 class="text-2xl font-bold text-slate-900">{{ $product->name }}</h3>
            </div>
            <div>
                @if($product->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Ditampilkan</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">Diarsipkan</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-y border-slate-100 py-6">
            <div>
                <span class="text-slate-400 block text-xs font-bold uppercase tracking-wider mb-1">Ketersediaan Stok</span>
                <span class="text-lg font-bold text-slate-850 flex items-center">
                    @if($product->stock > 0)
                        <svg class="w-5 h-5 mr-2 text-emerald-550" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tersedia ({{ $product->stock }} item)
                    @else
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Habis / Kosong
                    @endif
                </span>
            </div>
            <div>
                <span class="text-slate-400 block text-xs font-bold uppercase tracking-wider mb-1">Harga Satuan</span>
                <span class="text-2xl font-extrabold text-slate-900">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div>
            <h4 class="text-slate-900 font-bold text-sm mb-2">Deskripsi Detail Produk</h4>
            <p class="text-slate-650 text-sm leading-relaxed whitespace-pre-line bg-slate-50 rounded-xl p-5 border border-slate-100">
                {{ $product->description ?? 'Tidak ada deskripsi detail.' }}
            </p>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('products.edit', $product->id) }}" class="px-5 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl text-sm font-semibold border border-amber-200/50 transition">
                Edit Produk
            </a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-sm font-semibold border border-rose-200/50 transition">
                    Hapus Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection