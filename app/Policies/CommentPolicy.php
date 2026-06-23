<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function create(User $user, \App\Models\Task $task): bool
    {
        return $user->hasRole('admin')
            || ($user->can('comentar') && (
                $task->project->owner_id === $user->id
                || $task->project->members->contains($user->id)
            ));
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin') || $comment->user_id === $user->id;
    }
}