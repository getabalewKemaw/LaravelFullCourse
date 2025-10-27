<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // GET /products/{product}/reviews
    public function index(Product $product)
    {
        $reviews = $product->reviews()->latest()->paginate(10);
        return view('reviews.index', compact('product','reviews'));
    }

    // GET /products/{product}/reviews/create
    public function create(Product $product)
    {
        return view('reviews.create', compact('product'));
    }

    // POST /products/{product}/reviews
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $product->reviews()->create($data);

        return redirect()->route('products.show', $product)->with('success', 'Review added.');
    }

    // GET /products/{product}/reviews/{review}
    public function show(Product $product, Review $review)
    {
        // scoped() ensures $review belongs to $product
        return view('reviews.show', compact('product','review'));
    }

    // GET /products/{product}/reviews/{review}/edit
    public function edit(Product $product, Review $review)
    {
        return view('reviews.edit', compact('product','review'));
    }

    // PUT/PATCH /products/{product}/reviews/{review}
    public function update(Request $request, Product $product, Review $review)
    {
        $data = $request->validate([
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($data);

        return redirect()->route('products.show', $product)->with('success', 'Review updated.');
    }

    // DELETE /products/{product}/reviews/{review}
    public function destroy(Product $product, Review $review)
    {
        $review->delete();
        return redirect()->route('products.show', $product)->with('success', 'Review deleted.');
    }
}
