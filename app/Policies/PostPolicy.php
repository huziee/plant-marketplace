<?php

namespace App\Policies;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAuthor();
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->status === PostStatus::PUBLISHED) {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($user->isEditor() || $user->isAdmin()) {
            return true;
        }

        return $user->id === $post->author_id;
    }

    public function create(User $user): bool
    {
        return $user->isAuthor();
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        return $user->id === $post->author_id && in_array($post->status, [PostStatus::DRAFT, PostStatus::REVIEW], true);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function publish(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }
}
