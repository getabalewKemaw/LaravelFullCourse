@extends('layouts.app')

@section('content')
    <h2>{{ $product->name }}</h2>
    <p>{{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ number_format($product->price,2) }}</p>

    <hr>
    <h3>Reviews</h3>
    <a href="{{ route('products.reviews.create', $product) }}">Add Review</a>

    @if($product->reviews->count())
        <ul>
            @foreach($product->reviews as $r)
                <li>
                    <strong>{{ $r->user_name }}</strong> ({{ $r->rating }}/5) —
                    {{ $r->comment }}
                    <form action="{{ route('products.reviews.destroy', [$product, $r]) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete review?')">Delete</button>
                    </form>
                    <a href="{{ route('products.reviews.edit', [$product,$r]) }}">Edit</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No reviews yet.</p>
    @endif
@endsection
