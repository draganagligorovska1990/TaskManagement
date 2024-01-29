<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        return Inertia::render('Details', ['task' => $task]);
    }

    public function create()
    {
        return Inertia::render('Task');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|max:1000',
            'status' => 'required|string|max:255',
            'dueDate' => 'required|date|date_format:Y-m-d H:i:s'
        ]);

        Task::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->dueDate
        ]);

        return response(['success' => true]);
    }

    public function edit(Task $task)
    {
        return Inertia::render('Task', ['task' => $task]);
    }

    public function update()
    {

    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('task');
    }
}

