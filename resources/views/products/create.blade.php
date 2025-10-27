@extends('layouts.app')

@section('content')
    <h2>Create Product</h2>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div>
            <label>Name</label><br>
            <input name="name" value="{{ old('name') }}">
            @error('name') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Description</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <label>Price</label><br>
            <input name="price" value="{{ old('price') }}">
            @error('price') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <button>Create</button>
    </form>
@endsection
