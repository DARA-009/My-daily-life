<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Locale Switcher
Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['km', 'en'])) {
        Session::put('locale', $lang);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('locale.switch');

// Dashboard Route (Default)
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Placeholder module routes for navigation
Route::get('/profile', fn() => view('dashboard'))->name('profile.index');
Route::get('/schedule', fn() => view('dashboard'))->name('schedule.index');
Route::get('/tasks', fn() => view('dashboard'))->name('tasks.index');
Route::get('/expenses', fn() => view('dashboard'))->name('expenses.index');
Route::get('/goals', fn() => view('dashboard'))->name('goals.index');
Route::get('/study', fn() => view('dashboard'))->name('study.index');
Route::get('/work', fn() => view('dashboard'))->name('work.index');
Route::get('/habits', fn() => view('dashboard'))->name('habits.index');
Route::get('/skills', fn() => view('dashboard'))->name('skills.index');
Route::get('/notes', fn() => view('dashboard'))->name('notes.index');
Route::get('/reports', fn() => view('dashboard'))->name('reports.index');
Route::get('/settings', fn() => view('dashboard'))->name('settings.index');
