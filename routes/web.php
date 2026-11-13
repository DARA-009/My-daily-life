<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Universal Language Switcher
Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['km', 'en'])) {
        Session::put('locale', $lang);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('locale.switch');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

// Authenticated Application Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Application Modules
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
});
