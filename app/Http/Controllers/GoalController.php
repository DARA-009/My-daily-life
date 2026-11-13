<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use App\Models\Goal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoalController extends Controller
{
    /**
     * Display a listing of monthly goals.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $query = $user->goals()
            ->with('progressLogs')
            ->where('target_year', $year);

        if ($request->filled('month')) {
            $query->where('target_month', $month);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $goals = $query->orderBy('deadline')->get();

        $completedCount = $goals->where('status', 'completed')->count();
        $averageProgress = $goals->count() > 0 ? round($goals->avg('progress_percent')) : 0;

        return view('goals.index', compact('goals', 'year', 'month', 'completedCount', 'averageProgress'));
    }

    /**
     * Store a newly created monthly goal.
     */
    public function store(GoalRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (($data['progress_percent'] ?? 0) == 100) {
            $data['status'] = 'completed';
            $data['completed_at'] = now();
        }

        $request->user()->goals()->create($data);

        return redirect()->back()->with('success', 'Monthly goal created successfully.');
    }

    /**
     * Update the specified goal.
     */
    public function update(GoalRequest $request, Goal $goal): RedirectResponse
    {
        abort_if($goal->user_id !== $request->user()->id, 403);

        $data = $request->validated();
        if (($data['progress_percent'] ?? $goal->progress_percent) == 100 && $goal->status !== 'completed') {
            $data['status'] = 'completed';
            $data['completed_at'] = now();
        }

        $goal->update($data);

        return redirect()->back()->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified goal.
     */
    public function destroy(Request $request, Goal $goal): RedirectResponse
    {
        abort_if($goal->user_id !== $request->user()->id, 403);

        $goal->delete();

        return redirect()->back()->with('success', 'Goal deleted successfully.');
    }
}
