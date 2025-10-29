<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Show all posts with generated URLs.
     */
    public function index(Request $request)
    {
        $posts = Post::all(['id', 'title', 'body']);

        $posts->transform(function ($post) {
            // Named route URL
            $post->url = route('posts.show', ['post' => $post->id]);

            // Example with query parameters
            $post->search_url = url()->query("/api/posts/{$post->id}", ['utm_source' => 'newsletter']);

            // Example action URL
            $post->action_url = action([self::class, 'show'], ['post' => $post->id]);

            return $post;
        });

        return response()->json([
            'message' => 'All posts with URLs generated successfully',
            'current_url' => url()->current(),
            'full_url' => url()->full(),
            'data' => $posts
        ]);
    }

    /**
     * Show a single post with its share link.
     */
    public function show(Post $post)
    {
        $shareLink = route('posts.show', ['post' => $post->id, 'utm_source' => 'email']);

        return response()->json([
            'post' => $post,
            'share_link' => $shareLink,
            'previous_url' => url()->previous() ?? 'N/A'
        ]);
    }

    /**
     * Generate a public share link with query parameters.
     */
    public function share(Post $post)
    {
        $url = url()->query("/api/posts/{$post->id}", [
            'ref' => 'social',
            'campaign' => 'OctoberLaunch'
        ]);

        return response()->json([
            'message' => 'Share link generated successfully',
            'share_url' => $url
        ]);
    }

    /**
     * Generate a temporary signed unsubscribe link for a user.
     */
    public function sendUnsubscribeLink(User $user)
    {
        $link = URL::temporarySignedRoute(
            'unsubscribe',
            now()->addMinutes(5),
            ['user' => $user->id]
        );

        // In a real app, you’d email this link.
        return response()->json([
            'message' => 'Temporary unsubscribe link created',
            'expires_in' => '5 minutes',
            'unsubscribe_link' => $link
        ]);
    }

    /**
     * Handle unsubscribe requests (validate signature).
     */
    public function unsubscribe(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            return response()->json([
                'error' => 'Invalid or expired unsubscribe link'
            ], 401);
        }

        // Example logic — mark user as unsubscribed
        $user->update(['subscribed' => false]);

        return response()->json([
            'message' => 'User unsubscribed successfully',
            'user_id' => $user->id,
            'unsubscribed_at' => now(),
            'current_url' => url()->current(),
        ]);
    }
}
