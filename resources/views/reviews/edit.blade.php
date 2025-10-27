@extends('layouts.app')

@section('content')
    <h2>Edit Review for: {{ $product->name }}</h2>

    <form action="{{ route('products.reviews.update', [$product,$review]) }}" method="POST">
        @csrf @method('PUT')
        <div>
            <label>Your name</label><br>
            <input name="user_name" value="{{ old('user_name', $review->user_name) }}">
            @error('user_name') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Rating (1-5)</label><br>
            <input name="rating" value="{{ old('rating', $review->rating) }}">
            @error('rating') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Comment</label><br>
            <textarea name="comment">{{ old('comment', $review->comment) }}</textarea>
            @error('comment') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <button>Save review</button>
    </form>
@endsection

