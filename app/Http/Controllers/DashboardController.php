<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Render the main application dashboard with aggregated statistics.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        // 1. Task Statistics
        $todayTasksTotal = $user->tasks()->whereDate('due_date', $today)->count();
        $todayTasksCompleted = $user->tasks()->whereDate('due_date', $today)->where('status', 'completed')->count();
        $completedThisWeek = $user->tasks()->where('status', 'completed')->whereBetween('completed_at', [$startOfWeek, $endOfWeek])->count();
        $taskRate = $todayTasksTotal > 0 ? round(($todayTasksCompleted / $todayTasksTotal) * 100) : 0;

        // 2. Financial Statistics (Dual Currency USD & KHR)
        $todayExpensesUsd = (float) $user->transactions()
            ->where('type', 'expense')
            ->where('currency', 'USD')
            ->whereDate('transaction_date', $today)
            ->sum('amount');

        $todayExpensesKhr = (float) $user->transactions()
            ->where('type', 'expense')
            ->where('currency', 'KHR')
            ->whereDate('transaction_date', $today)
            ->sum('amount');

        $monthIncomeUsd = (float) $user->transactions()
            ->where('type', 'income')
            ->where('currency', 'USD')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthIncomeKhr = (float) $user->transactions()
            ->where('type', 'income')
            ->where('currency', 'KHR')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Monthly Goals
        $currentGoals = $user->goals()
            ->where('target_year', now()->year)
            ->where('target_month', now()->month)
            ->get();

        $goalsTotal = $currentGoals->count();
        $goalsCompleted = $currentGoals->where('status', 'completed')->count();
        $goalsProgress = $goalsTotal > 0 ? round($currentGoals->avg('progress_percent')) : 0;

        // 4. Habits Streak Summary
        $activeHabitsCount = $user->habits()->count();

        // 5. Activity Timeline for Today
        $todaySchedule = $user->activities()
            ->with('category')
            ->whereDate('activity_date', $today)
            ->orderBy('start_time')
            ->get();

        // 6. Upcoming Priority Tasks
        $priorityTasks = $user->tasks()
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // 7. Recent Transactions
        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'todayTasksTotal',
            'todayTasksCompleted',
            'completedThisWeek',
            'taskRate',
            'todayExpensesUsd',
            'todayExpensesKhr',
            'monthIncomeUsd',
            'monthIncomeKhr',
            'goalsTotal',
            'goalsCompleted',
            'goalsProgress',
            'activeHabitsCount',
            'todaySchedule',
            'priorityTasks',
            'recentTransactions'
        ));
    }
}
