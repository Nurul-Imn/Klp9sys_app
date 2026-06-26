@extends('layouts.app')

@section('content')

<h1>Halaman Booking</h1>

<h2>Daftar Booking</h2>

<a href="{{ route('bookings.create') }}" class="btn btn-primary">
    Tambah Booking
</a>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Pet</th>
            <th>Service</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $booking->pet->name }}</td>
            <td>{{ $booking->service->service_name }}</td>
            <td>{{ $booking->booking_date }}</td>
            <td>{{ $booking->status }}</td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection