@extends('layouts.app')

@section('page_title', 'Buat Booking Baru')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 mb-6 transition">
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User (Customer) -->
                <div>
                    <label for="user_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Customer / Pemilik <span class="text-rose-500">*</span></label>
                    <select name="user_id" id="user_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Customer --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pet -->
                <div>
                    <label for="pet_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Hewan Peliharaan <span class="text-rose-500">*</span></label>
                    <select name="pet_id" id="pet_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Pet --</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" data-owner="{{ $pet->user_id }}">{{ $pet->name }} ({{ $pet->species }} - {{ $pet->breed ?? 'Lokal' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Service -->
                <div>
                    <label for="service_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Layanan Perawatan <span class="text-rose-500">*</span></label>
                    <select name="service_id" id="service_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Booking Date -->
                <div>
                    <label for="booking_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Booking <span class="text-rose-500">*</span></label>
                    <input type="date" name="booking_date" id="booking_date" required min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Time Slot -->
                <div>
                    <label for="time_slot" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Waktu / Jam Slot <span class="text-rose-500">*</span></label>
                    <select name="time_slot" id="time_slot" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">-- Pilih Jam --</option>
                        <option value="09:00 - 10:00">Pagi (09:00 - 10:00)</option>
                        <option value="10:00 - 11:00">Pagi (10:00 - 11:00)</option>
                        <option value="11:00 - 12:00">Siang (11:00 - 12:00)</option>
                        <option value="13:00 - 14:00">Siang (13:00 - 14:00)</option>
                        <option value="14:00 - 15:00">Sore (14:00 - 15:00)</option>
                        <option value="15:00 - 16:00">Sore (15:00 - 16:00)</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Keluhan / Catatan Tambahan</label>
                <textarea name="notes" id="notes" rows="4" placeholder="Tuliskan keluhan atau permintaan khusus untuk pet Anda selama perawatan..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('bookings.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-indigo-500/20 transition">
                    Konfirmasi & Buat Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ownerSelect = document.getElementById('user_id');
        const petSelect = document.getElementById('pet_id');
        const allPets = Array.from(petSelect.options).slice(1);

        ownerSelect.addEventListener('change', function() {
            const selectedOwnerId = this.value;
            
            // Clear current options
            petSelect.innerHTML = '<option value="">-- Pilih Pet --</option>';
            
            if (selectedOwnerId) {
                // Filter pets belonging to this owner
                const filtered = allPets.filter(opt => opt.getAttribute('data-owner') == selectedOwnerId);
                filtered.forEach(opt => petSelect.appendChild(opt.cloneNode(true)));
            } else {
                // Show all if no owner selected
                allPets.forEach(opt => petSelect.appendChild(opt.cloneNode(true)));
            }
        });
    });
</script>
@endsection