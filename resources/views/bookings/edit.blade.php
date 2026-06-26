@extends('layouts.app')

@section('content')

<h1>Edit Booking</h1>
<h2>Tambah Booking</h2>

<form action="{{ route('bookings.update',$booking->id) }}"
      method="POST">

@csrf
@method('PUT')

    <div class="mb-3">
        <label>Pilih Pet</label>

        <select name="pet_id" class="form-control">

            @foreach($pets as $pet)

            <option value="{{ $pet->id }}"
                {{ $booking->pet_id == $pet->id ? 'selected' : '' }}>
                
                {{ $pet->name }}
            </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Pilih Service</label>

        <select name="service_id" class="form-control">

            @foreach($services as $service)

            <option value="{{ $service->id }}"
                {{ $booking->service_id == $service->id ? 'selected' : '' }}>

                {{ $service->service_name }}

            </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal Booking</label>

        <input type="date"
               name="booking_date"
               class="form-control"
               value="{{ $booking->booking_date }}">
    </div>

    <div class="mb-3">
        <label>Jam Booking</label>

        <input type="time"
               name="booking_time"
               class="form-control"
               value="{{ $booking->booking_time }}">
    </div>

    <div class="mb-3">
        <label>Catatan</label>

        <textarea name="notes"
                  class="form-control">{{ $booking->notes }}</textarea>
    </div>

    <button type="submit"
            class="btn btn-success">

        Simpan
    </button>

</form>

@endsection