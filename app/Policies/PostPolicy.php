<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id
            || $user->hasPermission('posts.update');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id
            || $user->hasPermission('posts.delete');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('posts.create');
    }
}