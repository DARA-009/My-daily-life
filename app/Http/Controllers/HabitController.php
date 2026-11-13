<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HabitController extends Controller
{
    /**
     * Display the Habit Tracker with weekly matrices and streak calculations.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $habits = $user->habits()->with('logs')->get();

        // Calculate past 7 days for the bubble check-in grid
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = now()->subDays($i)->toDateString();
        }

        // Calculate current streak and best streak for each habit
        $habitsWithStreaks = $habits->map(function ($habit) {
            $logDates = $habit->logs->pluck('log_date')->map(fn($d) => $d->format('Y-m-d'))->flip();

            // Calculate current streak
            $currentStreak = 0;
            $checkDate = now();
            // Allow check-in today or continue from yesterday
            if (!$logDates->has($checkDate->toDateString())) {
                $checkDate = $checkDate->copy()->subDay();
            }

            while ($logDates->has($checkDate->toDateString())) {
                $currentStreak++;
                $checkDate->subDay();
            }

            $habit->current_streak = $currentStreak;
            return $habit;
        });

        return view('habits.index', compact('habitsWithStreaks', 'days'));
    }

    /**
     * Store a newly created habit.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:150'],
            'description'     => ['nullable', 'string'],
            'frequency'       => ['required', 'in:daily,weekly'],
            'target_per_week' => ['required', 'integer', 'between:1,7'],
            'start_date'      => ['required', 'date'],
        ]);

        if ($validated['frequency'] === 'daily') {
            $validated['target_per_week'] = 7;
        }

        $request->user()->habits()->create($validated);

        return redirect()->back()->with('success', 'Habit created successfully.');
    }

    /**
     * Update the specified habit.
     */
    public function update(Request $request, Habit $habit): RedirectResponse
    {
        abort_if($habit->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:150'],
            'description'     => ['nullable', 'string'],
            'frequency'       => ['required', 'in:daily,weekly'],
            'target_per_week' => ['required', 'integer', 'between:1,7'],
            'start_date'      => ['required', 'date'],
        ]);

        if ($validated['frequency'] === 'daily') {
            $validated['target_per_week'] = 7;
        }

        $habit->update($validated);

        return redirect()->back()->with('success', 'Habit updated successfully.');
    }

    /**
     * Remove the specified habit.
     */
    public function destroy(Request $request, Habit $habit): RedirectResponse
    {
        abort_if($habit->user_id !== $request->user()->id, 403);

        $habit->delete();

        return redirect()->back()->with('success', 'Habit deleted successfully.');
    }
}
