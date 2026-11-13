<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GoalProgressLogController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HabitLogController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SkillActivityController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WorkController;
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

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Personal Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.password');

    // Daily Schedule (Activities)
    Route::get('/schedule', [ActivityController::class, 'index'])->name('schedule.index');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    Route::patch('/activities/{activity}/toggle', [ActivityController::class, 'toggle'])->name('activities.toggle');

    // Daily Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    // Work Activities
    Route::get('/work', [WorkController::class, 'index'])->name('work.index');

    // Daily Expenses & Income (Transactions)
    Route::get('/expenses', [TransactionController::class, 'index'])->name('expenses.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Monthly Goals
    Route::get('/goals', [GoalController::class, 'index'])->name('goals.index');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/goals/{goal}/progress', [GoalProgressLogController::class, 'store'])->name('goals.progress.store');

    // Study Planner
    Route::get('/study', [StudySessionController::class, 'index'])->name('study.index');
    Route::post('/study-sessions', [StudySessionController::class, 'store'])->name('study-sessions.store');
    Route::put('/study-sessions/{studySession}', [StudySessionController::class, 'update'])->name('study-sessions.update');
    Route::delete('/study-sessions/{studySession}', [StudySessionController::class, 'destroy'])->name('study-sessions.destroy');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    // Habits Tracker
    Route::get('/habits', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::put('/habits/{habit}', [HabitController::class, 'update'])->name('habits.update');
    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])->name('habits.destroy');
    Route::post('/habits/{habit}/toggle', [HabitLogController::class, 'toggle'])->name('habits.toggle');

    // Skills Development
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
    Route::post('/skills/{skill}/activities', [SkillActivityController::class, 'store'])->name('skills.activities.store');

    // Personal Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');

    // Reports & Analytics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-transactions', [ReportController::class, 'exportTransactionsCsv'])->name('reports.export.transactions');
});
