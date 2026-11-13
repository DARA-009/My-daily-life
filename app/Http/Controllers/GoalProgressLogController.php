<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoalProgressLogController extends Controller
{
    /**
     * Store a progress history update for a goal.
     */
    public function store(Request $request, Goal $goal): RedirectResponse
    {
        abort_if($goal->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'progress_percent' => ['required', 'integer', 'between:0,100'],
            'note'             => ['nullable', 'string'],
            'logged_on'        => ['required', 'date'],
        ]);

        $goal->progressLogs()->create($validated);

        // Update current goal progress and completion status
        $goal->progress_percent = $validated['progress_percent'];
        if ($goal->progress_percent == 100) {
            $goal->status = 'completed';
            $goal->completed_at = now();
        } else {
            $goal->status = 'in_progress';
            $goal->completed_at = null;
        }
        $goal->save();

        return redirect()->back()->with('success', 'Goal progress updated successfully.');
    }
}
