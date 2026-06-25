@extends('layouts.app')

@section('content')

<div class="container">

<h2>Tambah Layanan</h2>

<form action="{{ route('services.store') }}"
      method="POST">

@csrf

<div class="mb-3">
    <label>Nama Layanan</label>
    <input type="text"
           name="service_name"
           class="form-control">
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number"
           name="price"
           class="form-control">
</div>

<div class="mb-3">
    <label>Durasi</label>
    <input type="text"
           name="duration"
           class="form-control">
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description"
              class="form-control"></textarea>
</div>

<button class="btn btn-success">
    Simpan
</button>

</form>

</div>

@endsection