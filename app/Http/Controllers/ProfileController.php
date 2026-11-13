<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the personal profile page.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile ?? $user->profile()->create(['full_name' => $user->name]);

        return view('profile.index', compact('user', 'profile'));
    }

    /**
     * Update the user profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->profile ?? $user->profile()->create(['full_name' => $user->name]);

        $validated = $request->validate([
            'full_name'     => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'address'       => ['nullable', 'string'],
            'bio'           => ['nullable', 'string'],
            'photo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($profile->photo_path && Storage::disk('public')->exists($profile->photo_path)) {
                Storage::disk('public')->delete($profile->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update(['name' => $validated['full_name']]);
        $profile->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
