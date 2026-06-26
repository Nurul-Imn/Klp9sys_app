@extends('layouts.app')

@section('page_title', 'Edit Layanan')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('services.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-6 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <form action="{{ route('services.update', $service->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Layanan <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name', $service->name) }}" placeholder="Contoh: Premium Pet Spa & Haircut" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="category" id="category"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="Grooming" {{ $service->category == 'Grooming' ? 'selected' : '' }}>Grooming</option>
                        <option value="Medical" {{ $service->category == 'Medical' ? 'selected' : '' }}>Medical (Kesehatan)</option>
                        <option value="Boarding" {{ $service->category == 'Boarding' ? 'selected' : '' }}>Boarding (Penitipan)</option>
                        <option value="Training" {{ $service->category == 'Training' ? 'selected' : '' }}>Training (Pelatihan)</option>
                        <option value="Lainnya" {{ $service->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Harga (Rupiah) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" id="price" required min="0" value="{{ old('price', $service->price) }}" placeholder="100000" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration_minutes" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Durasi (Menit) <span class="text-rose-500">*</span></label>
                    <input type="number" name="duration_minutes" id="duration_minutes" required min="1" value="{{ old('duration_minutes', $service->duration_minutes) }}" placeholder="60" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Status Checkbox -->
                <div class="flex items-center pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        <span class="ml-3 text-sm font-semibold text-slate-700">Layanan Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Layanan</label>
                <textarea name="description" id="description" rows="4" placeholder="Deskripsikan apa saja yang didapatkan oleh pet pada layanan ini..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">{{ old('description', $service->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('services.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-500/20 transition">
                    Perbarui Layanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection