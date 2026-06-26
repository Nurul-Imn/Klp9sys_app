@extends('layouts.app')

@section('content')

<div class="container">

<h2>Edit Produk</h2>

<form action="{{ route('products.update',$product->id) }}"
      method="POST">

@csrf
@method('PUT')

<input type="text"
       name="product_name"
       value="{{ $product->product_name }}"
       class="form-control mb-3">

<input type="number"
       name="price"
       value="{{ $product->price }}"
       class="form-control mb-3">

<input type="number"
       name="stock"
       value="{{ $product->stock }}"
       class="form-control mb-3">

<textarea name="description"
          class="form-control mb-3">
{{ $product->description }}
</textarea>

<button class="btn btn-primary">
Update
</button>

</form>

</div>

@endsection