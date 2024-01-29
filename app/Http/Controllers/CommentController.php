<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Task;
use Inertia\Inertia;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(Task $task)
    {
        return Inertia::render('Comment', ['task' => $task]);
    }

    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();

        Comment::create([
            'task_id' => $validated['task_id'],
            'comment' => $validated['comment']
        ]);

        return response(['success' => true]);
    }
}
