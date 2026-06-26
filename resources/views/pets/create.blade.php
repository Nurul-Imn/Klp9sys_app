@extends('layouts.app')

@section('content')

<h2>Tambah Pet</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pets.store') }}"
      method="POST">

@csrf

<div class="mb-3">

<label>Nama Hewan</label>

<input type="text"
       name="name"
       class="form-control"> @error('name') is-invalid @enderror"
        value="{{ old('name') }}">

    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>

<div class="mb-3">

<label>Jenis Hewan</label>

<input type="text"
       name="species"
       class="form-control">

</div>

<div class="mb-3">

<label>Ras</label>

<input type="text"
       name="breed"
       class="form-control">

</div>

<div class="mb-3">

<label>Umur</label>

<input type="number"
       name="age"
       class="form-control">

</div>

<button type="submit"
        class="btn btn-success">

Simpan

</button>

</form>

@endsection