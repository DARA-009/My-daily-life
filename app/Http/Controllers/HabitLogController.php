<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HabitLogController extends Controller
{
    /**
     * Fast toggle a habit check-in for a given date.
     */
    public function toggle(Request $request, Habit $habit): RedirectResponse
    {
        abort_if($habit->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'log_date' => ['required', 'date'],
            'note'     => ['nullable', 'string', 'max:255'],
        ]);

        $existingLog = $habit->logs()->whereDate('log_date', $validated['log_date'])->first();

        if ($existingLog) {
            $existingLog->delete();
            $message = 'Habit check-in removed.';
        } else {
            $habit->logs()->create($validated);
            $message = 'Habit completed!';
        }

        return redirect()->back()->with('success', $message);
    }
}
