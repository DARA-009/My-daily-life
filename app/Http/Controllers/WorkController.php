<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkController extends Controller
{
    /**
     * Display the focused Work Activities & Projects workspace.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // 1. Work Tasks
        $workTasks = $user->tasks()
            ->where('kind', 'work')
            ->orderBy('due_date')
            ->get();

        $completedCount = $workTasks->where('status', 'completed')->count();
        $pendingCount = $workTasks->where('status', '!=', 'completed')->count();

        // 2. Work Schedule Activities
        $todayWorkActivities = $user->activities()
            ->whereDate('activity_date', now()->toDateString())
            ->whereHas('category', fn($q) => $q->where('name', 'ilike', '%work%'))
            ->orderBy('start_time')
            ->get();

        return view('work.index', compact('workTasks', 'completedCount', 'pendingCount', 'todayWorkActivities'));
    }
}
