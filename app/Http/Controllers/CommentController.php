<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('create', [Comment::class, $task]);

        $task->comments()->create([
            'cuerpo'  => $request->cuerpo,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comentario agregado.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comentario eliminado.');
    }
}