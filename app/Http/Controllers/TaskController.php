<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of daily tasks.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = $user->tasks()->with('category');

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority Filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Kind Filter (Personal, Work, Study)
        if ($request->filled('kind')) {
            $query->where('kind', $request->kind);
        }

        // Search Query
        if ($request->filled('q')) {
            $query->where('title', 'ilike', '%' . $request->q . '%');
        }

        $tasks = $query->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
            ->orderBy('due_date')
            ->paginate(15)
            ->withQueryString();

        $categories = $user->categories()
            ->where('type', 'task')
            ->orderBy('name')
            ->get();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Store a newly created task.
     */
    public function store(TaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($data['status'] === 'completed') {
            $data['completed_at'] = now();
            $data['progress_percent'] = 100;
        }

        $request->user()->tasks()->create($data);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * Update the specified task.
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $data = $request->validated();
        if ($data['status'] === 'completed' && $task->status !== 'completed') {
            $data['completed_at'] = now();
            $data['progress_percent'] = 100;
        } elseif ($data['status'] !== 'completed') {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    /**
     * Fast toggle completion state.
     */
    public function toggle(Request $request, Task $task): RedirectResponse
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $isCompleted = $task->status === 'completed';
        $task->update([
            'status'           => $isCompleted ? 'pending' : 'completed',
            'progress_percent' => $isCompleted ? 0 : 100,
            'completed_at'     => $isCompleted ? null : now(),
        ]);

        return redirect()->back()->with('success', 'Task status updated.');
    }
}
