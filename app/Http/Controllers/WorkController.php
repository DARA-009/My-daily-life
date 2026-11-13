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
        $date = $request->query('date', now()->toDateString());

        // 1. Work Tasks / Deliverables
        $deliverables = $user->tasks()
            ->where('kind', 'work')
            ->orderBy('due_date')
            ->get();

        $completedCount = $deliverables->where('status', 'completed')->count();
        $pendingCount = $deliverables->where('status', '!=', 'completed')->count();

        // 2. Work Schedule Activities
        $workActivities = $user->activities()
            ->whereDate('activity_date', $date)
            ->whereHas('category', function ($sub) {
                $sub->where('name', 'ilike', '%work%')
                    ->orWhere('name', 'ilike', '%ការងារ%')
                    ->orWhere('type', 'work');
            })
            ->orderBy('start_time')
            ->get();

        $totalMinutes = (int) $workActivities->sum('duration_minutes');
        $totalHours = round($totalMinutes / 60, 1);

        $workTasks = $deliverables;
        $todayWorkActivities = $workActivities;

        $workCategory = $user->categories()
            ->where('type', 'activity')
            ->where(function ($q) {
                $q->where('name', 'ilike', '%work%')
                  ->orWhere('name', 'ilike', '%ការងារ%');
            })->first();

        return view('work.index', compact(
            'deliverables',
            'workTasks',
            'workActivities',
            'todayWorkActivities',
            'completedCount',
            'pendingCount',
            'totalHours',
            'totalMinutes',
            'workCategory',
            'date'
        ));
    }
}
