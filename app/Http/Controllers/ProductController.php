<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /products
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // GET /products/create
    public function create()
    {
        return view('products.create');
    }

    // POST /products
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($data);

        return redirect()->route('products.show', $product)->with('success', 'Product created.');
    }

    // GET /products/{product}
    public function show(Product $product)
    {
        // load reviews (newest first) for display
        $product->load(['reviews' => function($q){ $q->latest(); }]);
        return view('products.show', compact('product'));
    }

    // GET /products/{product}/edit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // PUT/PATCH /products/{product}
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($data);

        return redirect()->route('products.show', $product)->with('success', 'Product updated.');
    }

    // DELETE /products/{product}
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
