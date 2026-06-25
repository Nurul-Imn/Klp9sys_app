@extends('layouts.app')

@section('content')

<h2>Data Pet</h2>

<a href="{{ route('pets.create') }}"
   class="btn btn-primary mb-3">

   Tambah Pet

</a>

<table class="table table-bordered">

    <thead>

        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Ras</th>
            <th>Umur</th>
            <th>Aksi</th>
        </tr>

    </thead>

    <tbody>

    @foreach($pets as $pet)

    <tr>

        <td>{{ $loop->iteration }}</td>
        <td>{{ $pet->name }}</td>
        <td>{{ $pet->species }}</td>
        <td>{{ $pet->breed }}</td>
        <td>{{ $pet->age }}</td>

        <td>

            <a href="{{ route('pets.show',$pet->id) }}"
               class="btn btn-info btn-sm">

               Detail

            </a>

            <a href="{{ route('pets.edit',$pet->id) }}"
               class="btn btn-warning btn-sm">

               Edit

            </a>

        </td>

    </tr>

    @endforeach

    </tbody>

</table>

@endsection