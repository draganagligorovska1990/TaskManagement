<?php

namespace App\Http\Controllers;

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
            'description' => 'string|nullable|max:1000',
            'status' => 'required|string|max:255',
            'due_date' => 'required|date|date_format:Y-m-d H:i:s'
        ]);

        Task::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date
        ]);

        return response(['success' => true]);
    }

    public function edit(Task $task)
    {
        return Inertia::render('Task', ['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|nullable|max:1000',
            'status' => 'required|string|max:255',
            'due_date' => 'required|date|date_format:Y-m-d H:i:s'
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->due_date = $request->due_date;

        $task->save();

        return response(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('task');
    }
}

