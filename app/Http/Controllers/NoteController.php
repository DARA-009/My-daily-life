<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    /**
     * Display personal notes with pinned items and full-text search.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = $user->notes()->with('category');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'ilike', "%{$q}%")
                    ->orWhere('body', 'ilike', "%{$q}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $pinnedNotes = (clone $query)->where('is_pinned', true)->orderByDesc('updated_at')->get();
        $notes = $query->where('is_pinned', false)->orderByDesc('updated_at')->paginate(12)->withQueryString();

        $categories = $user->categories()->where('type', 'note')->orderBy('name')->get();

        return view('notes.index', compact('pinnedNotes', 'notes', 'categories'));
    }

    /**
     * Store a newly created note.
     */
    public function store(NoteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_pinned'] = $request->boolean('is_pinned');

        $request->user()->notes()->create($data);

        return redirect()->back()->with('success', 'Note saved successfully.');
    }

    /**
     * Update the specified note.
     */
    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        abort_if($note->user_id !== $request->user()->id, 403);

        $data = $request->validated();
        $data['is_pinned'] = $request->boolean('is_pinned');

        $note->update($data);

        return redirect()->back()->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified note.
     */
    public function destroy(Request $request, Note $note): RedirectResponse
    {
        abort_if($note->user_id !== $request->user()->id, 403);

        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully.');
    }

    /**
     * Fast toggle pin state.
     */
    public function togglePin(Request $request, Note $note): RedirectResponse
    {
        abort_if($note->user_id !== $request->user()->id, 403);

        $note->update(['is_pinned' => !$note->is_pinned]);

        return redirect()->back()->with('success', $note->is_pinned ? 'Note pinned.' : 'Note unpinned.');
    }
}
