<?php

namespace App\Http\Controllers;

use App\Models\Post1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Post1Controller extends Controller
{
      // Fetch all posts with caching
    public function index()
    {
        $posts = Cache::remember('posts', 60, function () {
            return Post1::all();
        });

        return response()->json($posts);
    }

    // Create a new post and clear cache
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post1::create($validated);

        Cache::forget('post1s'); // remove old cache

        return response()->json(['message' => 'Post created', 'post' => $post], 201);
    }
}
