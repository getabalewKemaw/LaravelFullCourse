@extends('layouts.app')

@section('content')
    <h2>All Products</h2>

    @if($products->count())
        <ul>
            @foreach($products as $p)
                <li>
                    <a href="{{ route('products.show', $p) }}">{{ $p->name }}</a>
                    — ${{ number_format($p->price,2) }}
                    <form action="{{ route('products.destroy', $p) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')">Delete</button>
                    </form>
                    <a href="{{ route('products.edit', $p) }}">Edit</a>
                </li>
            @endforeach
        </ul>

        {{ $products->links() }}
    @else
        <p>No products yet. <a href="{{ route('products.create') }}">Create one</a>.</p>
    @endif
@endsection
