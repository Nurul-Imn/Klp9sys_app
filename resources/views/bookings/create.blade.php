@extends('layouts.app')

@section('content')

<h2>Tambah Booking</h2>

<form action="{{ route('bookings.store') }}" method="POST">

    @csrf

    <div class="mb-3">
        <label>Pilih Pet</label>

        <select name="pet_id" class="form-control">

            @foreach($pets as $pet)

            <option value="{{ $pet->id }}">
                {{ $pet->name }}
            </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Pilih Service</label>

        <select name="service_id" class="form-control">

            @foreach($services as $service)

            <option value="{{ $service->id }}">
                {{ $service->service_name }}
            </option>

            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal Booking</label>

        <input type="date"
               name="booking_date"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Jam Booking</label>

        <input type="time"
               name="booking_time"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Catatan</label>

        <textarea name="notes"
                  class="form-control">
        </textarea>
    </div>

    <button type="submit"
            class="btn btn-success">

        Simpan
    </button>

</form>

@endsection