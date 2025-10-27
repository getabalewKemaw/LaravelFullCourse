@extends('layouts.app')

@section('content')
    <h2>Add Review for: {{ $product->name }}</h2>

    <form action="{{ route('products.reviews.store', $product) }}" method="POST">
        @csrf
        <div>
            <label>Your name</label><br>
            <input name="user_name" value="{{ old('user_name') }}">
            @error('user_name') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Rating (1-5)</label><br>
            <input name="rating" value="{{ old('rating', 5) }}">
            @error('rating') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Comment</label><br>
            <textarea name="comment">{{ old('comment') }}</textarea>
            @error('comment') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <button>Add Review</button>
    </form>
@endsection
