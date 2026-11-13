<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings management view.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $settings = $user->settings ?? $user->settings()->create([
            'locale' => 'km',
            'default_currency' => 'USD',
            'timezone' => 'Asia/Phnom Penh',
        ]);

        return view('settings.index', compact('user', 'settings'));
    }

    /**
     * Update user application preferences.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $settings = $user->settings;

        $validated = $request->validate([
            'locale'           => ['required', 'in:km,en'],
            'default_currency' => ['required', 'in:USD,KHR'],
            'timezone'         => ['required', 'string', 'max:64'],
            'notify_in_app'    => ['nullable', 'boolean'],
            'notify_email'     => ['nullable', 'boolean'],
        ]);

        $validated['notify_in_app'] = $request->boolean('notify_in_app');
        $validated['notify_email'] = $request->boolean('notify_email');

        $settings->update($validated);
        Session::put('locale', $validated['locale']);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }

    /**
     * Update the user password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('settings.index')->with('success', 'Password changed successfully.');
    }
}
