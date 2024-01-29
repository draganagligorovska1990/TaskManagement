<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');

        $tasks = Task::where('user_id', auth()->user()->id);

        if ($status && $status != "all") {
            $tasks = $tasks->where('status', $status);
        }

        if ($date_from && $date_from != 'null') {
            $tasks = $tasks->where('due_date', '>=', $date_from);
        }

        if ($date_to && $date_to != 'null') {
            $tasks = $tasks->where('due_date', '<=', $date_to);
        }

        $tasks = $tasks->orderBy('updated_at', 'desc');
        $tasks = $tasks->get();

        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        return Inertia::render('Details', ['task' => $task, 'comments' => $task->comments]);
    }

    public function create()
    {
        return Inertia::render('Task');
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        Task::create([
            'user_id' => auth()->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date']
        ]);

        return response(['success' => true]);
    }

    public function edit(Task $task)
    {
        return Inertia::render('Task', ['task' => $task]);
    }

    public function update(StoreTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->status = $validated['status'];
        $task->due_date = $validated['due_date'];

        $task->save();

        return response(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('task');
    }
}

