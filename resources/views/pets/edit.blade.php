@extends('layouts.app')

@section('page_title', 'Edit Data Pet')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('pets.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-6 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <form action="{{ route('pets.update', $pet->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Peliharaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $pet->name) }}" placeholder="Contoh: Milo" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Owner -->
                <div>
                    <label for="user_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pemilik (User)</label>
                    <select name="user_id" id="user_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Pemilik (Opsional) --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $pet->user_id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Species -->
                <div>
                    <label for="species" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis / Spesies <span class="text-rose-500">*</span></label>
                    <select name="species" id="species" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="Kucing" {{ $pet->species == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                        <option value="Anjing" {{ $pet->species == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                        <option value="Burung" {{ $pet->species == 'Burung' ? 'selected' : '' }}>Burung</option>
                        <option value="Kelinci" {{ $pet->species == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                        <option value="Lainnya" {{ $pet->species == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Breed -->
                <div>
                    <label for="breed" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Ras / Breed</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed', $pet->breed) }}" placeholder="Contoh: Persia, Golden Retriever" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Gender --</option>
                        <option value="Jantan" {{ $pet->gender == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="Betina" {{ $pet->gender == 'Betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Umur (Tahun)</label>
                    <input type="number" name="age" id="age" min="0" value="{{ old('age', $pet->age) }}" placeholder="0" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Weight -->
                <div>
                    <label for="weight" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Berat (Kg)</label>
                    <input type="number" name="weight" id="weight" step="0.01" min="0" value="{{ old('weight', $pet->weight) }}" placeholder="0.0" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Tambahan (Alergi/Penyakit)</label>
                <textarea name="notes" id="notes" rows="4" placeholder="Tuliskan catatan medis atau kebiasaan khusus disini..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">{{ old('notes', $pet->notes) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('pets.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-500/20 transition">
                    Perbarui Peliharaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection