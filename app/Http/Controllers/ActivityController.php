<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Display the daily schedule & activity calendar.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $date = $request->query('date', now()->toDateString());

        $activities = $user->activities()
            ->with('category')
            ->whereDate('activity_date', $date)
            ->orderBy('start_time')
            ->get();

        $categories = $user->categories()
            ->where('type', 'activity')
            ->orderBy('name')
            ->get();

        return view('schedule.index', compact('activities', 'categories', 'date'));
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(ActivityRequest $request): RedirectResponse
    {
        $request->user()->activities()->create($request->validated());

        return redirect()->back()->with('success', 'Activity scheduled successfully.');
    }

    /**
     * Update the specified activity.
     */
    public function update(ActivityRequest $request, Activity $activity): RedirectResponse
    {
        abort_if($activity->user_id !== $request->user()->id, 403);

        $activity->update($request->validated());

        return redirect()->back()->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified activity.
     */
    public function destroy(Request $request, Activity $activity): RedirectResponse
    {
        abort_if($activity->user_id !== $request->user()->id, 403);

        $activity->delete();

        return redirect()->back()->with('success', 'Activity removed successfully.');
    }

    /**
     * Toggle activity status (planned <-> done).
     */
    public function toggle(Request $request, Activity $activity): RedirectResponse
    {
        abort_if($activity->user_id !== $request->user()->id, 403);

        $newStatus = $activity->status === 'done' ? 'planned' : 'done';
        $activity->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Activity status updated.');
    }
}
