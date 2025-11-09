<?php

namespace App\Policies;

use App\Models\PostGech;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(?User $user)
    {
        return Response::allow(); // Everyone can view posts
    }

    public function view(?User $user, PostGech $post)
    {
        return Response::allow();
    }

    public function create(User $user)
    {
        return $user->isVerified()
            ? Response::allow()
            : Response::deny('Only verified users can create posts.');
    }

    public function update(User $user, PostGech $post)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this post.');
    }

    public function delete(User $user, PostGech $post)
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You cannot delete this post.');
    }
}
