<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class BookController extends Controller
{
    // ✅ Get all books
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // ✅ Create a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|min:3',
            'author' => 'required|min:3',
            'year'   => 'required|integer|min:1900|max:2025',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book added successfully!',
            'data' => $book
        ], 201);
    }

    // ✅ Show one book
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json($book, 200);
    }

    // ✅ Update a book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title'  => 'sometimes|required|min:3',
            'author' => 'sometimes|required|min:3',
            'year'   => 'sometimes|required|integer|min:1900|max:2025',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully!',
            'data' => $book
        ]);
    }

    // ✅ Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully!']);
    }
}