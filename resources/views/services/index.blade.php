@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Daftar Layanan</h2>

    <a href="{{ route('services.create') }}"
       class="btn btn-primary mb-3">
       Tambah Layanan
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Layanan</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($services as $service)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $service->service_name }}</td>
                <td>Rp {{ number_format($service->price) }}</td>
                <td>{{ $service->duration }}</td>

                <td>

                    <a href="{{ route('services.show',$service->id) }}"
                       class="btn btn-info">
                       Detail
                    </a>

                    <a href="{{ route('services.edit',$service->id) }}"
                       class="btn btn-warning">
                       Edit
                    </a>

                </td>
            </tr>

        @endforeach

        </tbody>
    </table>

</div>

@endsection