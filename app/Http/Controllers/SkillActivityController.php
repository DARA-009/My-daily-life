<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SkillActivityController extends Controller
{
    /**
     * Store a practice activity or milestone for a skill.
     */
    public function store(Request $request, Skill $skill): RedirectResponse
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'activity_date'    => ['required', 'date'],
            'description'      => ['nullable', 'string'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'level_after'      => ['nullable', 'integer', 'between:1,5'],
        ]);

        $skill->activities()->create($validated);

        if (!empty($validated['level_after']) && $validated['level_after'] > $skill->current_level) {
            $skill->update(['current_level' => $validated['level_after']]);
        }

        return redirect()->back()->with('success', 'Skill practice session logged.');
    }
}
