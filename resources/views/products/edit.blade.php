@extends('layouts.app')

<<<<<<< HEAD
@section('page_title', 'Edit Produk')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-6 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <h2 class="text-lg font-bold text-slate-900 mb-6">Edit Produk</h2>

        @php $prod = is_array($product) ? (object)$product : $product; @endphp

        <form action="{{ route('products.update', $prod->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $prod->name) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="category" id="category"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        @foreach(['Makanan Kucing','Makanan Anjing','Aksesoris & Perawatan','Mainan','Obat & Vitamin'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $prod->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Harga (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" id="price" required min="0" value="{{ old('price', $prod->price) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Stok</label>
                    <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $prod->stock ?? 0) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $prod->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 text-indigo-600 border-slate-300 rounded">
                    <label for="is_active" class="text-sm font-semibold text-slate-700">Aktif / Tersedia</label>
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 resize-none">{{ old('description', $prod->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2 border-t border-slate-100">
                <a href="{{ route('products.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
=======
@section('content')

<div class="container">

<h2>Edit Produk</h2>

<form action="{{ route('products.update',$product->id) }}"
      method="POST">

@csrf
@method('PUT')

<input type="text"
       name="product_name"
       value="{{ $product->product_name }}"
       class="form-control mb-3">

<input type="number"
       name="price"
       value="{{ $product->price }}"
       class="form-control mb-3">

<input type="number"
       name="stock"
       value="{{ $product->stock }}"
       class="form-control mb-3">

<textarea name="description"
          class="form-control mb-3">
{{ $product->description }}
</textarea>

<button class="btn btn-primary">
Update
</button>

</form>

</div>

@endsection
>>>>>>> 36494942b4e1901ebea6344515955376fda8ecbf
