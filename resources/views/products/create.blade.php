@extends('layouts.app')

@section('content')

<div class="container">

<h2>Tambah Produk</h2>

<form action="{{ route('products.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Nama Produk</label>
<input type="text"
       name="product_name"
       class="form-control">
</div>

<div class="mb-3">
<label>Harga</label>
<input type="number"
       name="price"
       class="form-control">
</div>

<div class="mb-3">
<label>Stok</label>
<input type="number"
       name="stock"
       class="form-control">
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="description"
          class="form-control"></textarea>
</div>

<button type="submit"
        class="btn btn-success">
    Simpan
</button>

</form>

</div>

@endsection