@extends('layouts.app')

@section('content')

<h2>Detail Pembayaran</h2>

<p>ID : {{ $payment->id }}</p>

<p>Total : Rp {{ $payment->amount }}</p>

<p>Metode : {{ $payment->payment_method }}</p>

<p>Status : {{ $payment->payment_status }}</p>

<a href="/payments">
    Kembali
</a>

@endsection