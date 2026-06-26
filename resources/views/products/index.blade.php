@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Daftar Produk</h2>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
        Tambah Produk
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($products as $product)

        <tr>
            <td>{{ $product->product_name }}</td>
            <td>Rp {{ number_format($product->price) }}</td>
            <td>{{ $product->stock }}</td>

            <td>

                <a href="{{ route('products.show',$product->id) }}"
                    class="btn btn-info">
                    Detail
                </a>

                <a href="{{ route('products.edit',$product->id) }}"
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