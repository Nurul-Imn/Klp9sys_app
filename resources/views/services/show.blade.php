@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detail Layanan</h2>

<div class="card">

<div class="card-body">

<h4>{{ $service->service_name }}</h4>

<p>
Harga :
Rp {{ number_format($service->price) }}
</p>

<p>
Durasi :
{{ $service->duration }}
</p>

<p>
{{ $service->description }}
</p>

</div>

</div>

</div>

@endsection