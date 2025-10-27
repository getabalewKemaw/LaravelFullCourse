@extends('layouts.app')

@section('content')
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf @method('PUT')
        <div>
            <label>Name</label><br>
            <input name="name" value="{{ old('name', $product->name) }}">
            @error('name') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Description</label><br>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label>Price</label><br>
            <input name="price" value="{{ old('price', $product->price) }}">
            @error('price') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <button>Save</button>
    </form>
@endsection
