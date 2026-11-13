<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    /**
     * Display the Skills Development dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $skills = $user->skills()
            ->with(['category', 'activities' => fn($q) => $q->orderByDesc('activity_date')])
            ->orderBy('name')
            ->get();

        $categories = $user->categories()
            ->where('type', 'skill')
            ->orderBy('name')
            ->get();

        return view('skills.index', compact('skills', 'categories'));
    }

    /**
     * Store a newly created skill.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:150'],
            'description'   => ['nullable', 'string'],
            'current_level' => ['required', 'integer', 'between:1,5'],
            'target_level'  => ['required', 'integer', 'between:1,5'],
        ]);

        $request->user()->skills()->create($validated);

        return redirect()->back()->with('success', 'Skill registered successfully.');
    }

    /**
     * Update the specified skill.
     */
    public function update(Request $request, Skill $skill): RedirectResponse
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'category_id'   => ['nullable', 'exists:categories,id'],
            'name'          => ['required', 'string', 'max:150'],
            'description'   => ['nullable', 'string'],
            'current_level' => ['required', 'integer', 'between:1,5'],
            'target_level'  => ['required', 'integer', 'between:1,5'],
        ]);

        $skill->update($validated);

        return redirect()->back()->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified skill.
     */
    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        $skill->delete();

        return redirect()->back()->with('success', 'Skill removed successfully.');
    }
}
