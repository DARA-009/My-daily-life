<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Store a newly created academic subject.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:150'],
            'description'     => ['nullable', 'string'],
            'learning_target' => ['nullable', 'string'],
            'target_hours'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $request->user()->subjects()->create($validated);

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    /**
     * Update the specified subject.
     */
    public function update(Request $request, Subject $subject): RedirectResponse
    {
        abort_if($subject->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:150'],
            'description'     => ['nullable', 'string'],
            'learning_target' => ['nullable', 'string'],
            'target_hours'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $subject->update($validated);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified subject.
     */
    public function destroy(Request $request, Subject $subject): RedirectResponse
    {
        abort_if($subject->user_id !== $request->user()->id, 403);

        $subject->delete();

        return redirect()->back()->with('success', 'Subject removed successfully.');
    }
}
