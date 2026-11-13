<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudySessionController extends Controller
{
    /**
     * Display the Study Planner and logged study sessions.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $subjects = $user->subjects()
            ->withCount('studySessions')
            ->orderBy('name')
            ->get();

        $query = $user->studySessions()->with('subject');

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $sessions = $query->orderByDesc('session_date')
            ->orderBy('start_time')
            ->paginate(15)
            ->withQueryString();

        $totalMinutes = (int) $user->studySessions()->where('status', 'completed')->sum('duration_minutes');
        $totalHours = round($totalMinutes / 60, 1);

        return view('study.index', compact('subjects', 'sessions', 'totalHours', 'totalMinutes'));
    }

    /**
     * Store a newly created study session.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id'   => ['required', 'exists:subjects,id'],
            'session_date' => ['required', 'date'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'status'       => ['required', 'in:planned,completed,skipped'],
            'notes'        => ['nullable', 'string'],
        ]);

        $request->user()->studySessions()->create($validated);

        return redirect()->back()->with('success', 'Study session logged successfully.');
    }

    /**
     * Update the specified study session.
     */
    public function update(Request $request, StudySession $studySession): RedirectResponse
    {
        abort_if($studySession->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'subject_id'   => ['required', 'exists:subjects,id'],
            'session_date' => ['required', 'date'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'status'       => ['required', 'in:planned,completed,skipped'],
            'notes'        => ['nullable', 'string'],
        ]);

        $studySession->update($validated);

        return redirect()->back()->with('success', 'Study session updated successfully.');
    }

    /**
     * Remove the specified study session.
     */
    public function destroy(Request $request, StudySession $studySession): RedirectResponse
    {
        abort_if($studySession->user_id !== $request->user()->id, 403);

        $studySession->delete();

        return redirect()->back()->with('success', 'Study session deleted successfully.');
    }
}
