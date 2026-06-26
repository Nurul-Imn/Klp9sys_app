@extends('layouts.app')

@section('content')

<h2>Data Pembayaran</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Total</th>
    <th>Metode</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

@foreach($payments as $payment)

<tr>
    <td>{{ $payment->id }}</td>
    <td>{{ $payment->amount }}</td>
    <td>{{ $payment->payment_method }}</td>
    <td>{{ $payment->payment_status }}</td>

    <td>
        <a href="/payments/{{ $payment->id }}">
            Detail
        </a>
    </td>
</tr>

@endforeach

</table>

@endsection