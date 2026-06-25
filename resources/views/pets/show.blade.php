@extends('layouts.app')

@section('content')

<h2>Detail Pet</h2>

<div class="card">

<div class="card-body">

<p>
Nama :
{{ $pet->name }}
</p>

<p>
Jenis :
{{ $pet->species }}
</p>

<p>
Ras :
{{ $pet->breed }}
</p>

<p>
Umur :
{{ $pet->age }}
</p>

</div>

</div>

@endsection