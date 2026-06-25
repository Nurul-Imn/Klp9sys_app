@extends('layouts.app')

@section('content')

<div class="container">

<h2>Edit Layanan</h2>

<form action="{{ route('services.update',$service->id) }}"
      method="POST">

@csrf
@method('PUT')

<input type="text"
       name="service_name"
       value="{{ $service->service_name }}"
       class="form-control mb-3">

<input type="number"
       name="price"
       value="{{ $service->price }}"
       class="form-control mb-3">

<input type="text"
       name="duration"
       value="{{ $service->duration }}"
       class="form-control mb-3">

<textarea name="description"
          class="form-control mb-3">{{ $service->description }}</textarea>

<button class="btn btn-primary">
    Update
</button>

</form>

</div>

@endsection