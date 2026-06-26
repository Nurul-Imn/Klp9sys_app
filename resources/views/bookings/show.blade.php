@extends('layouts.app')

@section('content')

<h1>Detail Booking</h1>
<h2>Detail Booking</h2>

<p>Pet :
{{ $booking->pet->name }}</p>

<p>Service :
{{ $booking->service->service_name }}</p>

<p>Tanggal :
{{ $booking->booking_date }}</p>

<p>Status :
{{ $booking->status }}</p>

@endsection