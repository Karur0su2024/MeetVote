<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CommentPolicy
{
    // Kontrola zda může uživatel odstranit komentář
    public function delete(?User $user, Comment $comment): bool
    {
        if (Gate::allows('isAdmin', $comment->poll)) {
            return true;
        }

        if ($user) {
            return $comment->user_id === $user->id;
        }

        return false;

    }
}
