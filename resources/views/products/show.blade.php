@extends('layouts.app')

@section('content')

<div class="container">

<h2>Detail Produk</h2>

<p>
<strong>Nama:</strong>
{{ $product->product_name }}
</p>

<p>
<strong>Harga:</strong>
Rp {{ number_format($product->price) }}
</p>

<p>
<strong>Stok:</strong>
{{ $product->stock }}
</p>

<p>
<strong>Deskripsi:</strong>
{{ $product->description }}
</p>

</div>

@endsection