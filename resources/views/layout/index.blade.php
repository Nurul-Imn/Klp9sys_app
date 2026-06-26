@extends('layout.app')

@section('content')
<h2>Data Pets</h2>

<a href="/pets/create" class="btn btn-primary mb-2">Tambah</a>

<table class="table table-bordered">
<tr>
    <th>Nama</th>
    <th>Jenis</th>
    <th>Aksi</th>
</tr>

@foreach($pets as $pet)
<tr>
    <td>{{ $pet->name }}</td>
    <td>{{ $pet->species }}</td>
    <td>
        <a href="/pets/{{ $pet->id }}/edit" class="btn btn-warning">Edit</a>

        <form action="/pets/{{ $pet->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus</button>
        </form>
    </td>
</tr>
@endforeach

</table>
@endsection