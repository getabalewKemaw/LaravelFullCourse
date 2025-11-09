<?php


namespace App\Http\Controllers;

use App\Models\PostGech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostGechController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PostGech::class);
        return response()->json(PostGech::all());
    }

    public function show(PostGech $post)
    {
        $this->authorize('view', $post);
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $this->authorize('create', PostGech::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        $post = PostGech::create([
            'title'   => $validated['title'],
            'body'    => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($post, 201);
    }

    public function update(Request $request, PostGech $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'body'  => 'sometimes|string',
        ]);

        $post->update($validated);
        return response()->json(['message' => 'PostGech updated successfully']);
    }

    public function destroy(PostGech $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(['message' => 'PostGech deleted successfully']);
    }

    // Demonstrate Gate usage outside of Policy
    public function manage()
    {
        if (Gate::allows('manage-posts')) {
            return response()->json(['message' => 'Admin or moderator can manage posts']);
        }
        return response()->json(['message' => 'Access denied'], 403);
    }
}
