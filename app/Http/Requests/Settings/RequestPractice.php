<?php

namespace App\Http\Requests\Settings;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestPractice
{
    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->input('title'))]);

        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required|min:50',
        ]);

        $post = Post::create($data);

        return response()->json($post, 201);
    }
}

  