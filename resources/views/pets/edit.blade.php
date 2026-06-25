@extends('layouts.app')

@section('content')

<h2>Edit Pet</h2>

<form action="{{ route('pets.update',$pet->id) }}"
      method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama</label>

<input type="text"
       name="name"
       value="{{ $pet->name }}"
       class="form-control">

</div>

<div class="mb-3">

<label>Jenis</label>

<input type="text"
       name="species"
       value="{{ $pet->species }}"
       class="form-control">

</div>

<div class="mb-3">

<label>Ras</label>

<input type="text"
       name="breed"
       value="{{ $pet->breed }}"
       class="form-control">

</div>

<div class="mb-3">

<label>Umur</label>

<input type="number"
       name="age"
       value="{{ $pet->age }}"
       class="form-control">

</div>

<button class="btn btn-primary">

Update

</button>

</form>

@endsection