<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display consolidated reports and analytics.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->endOfMonth()->toDateString());

        // 1. Finance Stats
        $incomeUsd = (float) $user->transactions()
            ->where('type', 'income')
            ->where('currency', 'USD')
            ->whereBetween('transaction_date', [$from, $to])
            ->sum('amount');

        $incomeKhr = (float) $user->transactions()
            ->where('type', 'income')
            ->where('currency', 'KHR')
            ->whereBetween('transaction_date', [$from, $to])
            ->sum('amount');

        $expenseUsd = (float) $user->transactions()
            ->where('type', 'expense')
            ->where('currency', 'USD')
            ->whereBetween('transaction_date', [$from, $to])
            ->sum('amount');

        $expenseKhr = (float) $user->transactions()
            ->where('type', 'expense')
            ->where('currency', 'KHR')
            ->whereBetween('transaction_date', [$from, $to])
            ->sum('amount');

        // 2. Task Productivity Stats
        $tasksTotal = $user->tasks()->whereBetween('created_at', [$from, $to])->count();
        $tasksCompleted = $user->tasks()->where('status', 'completed')->whereBetween('completed_at', [$from, $to])->count();
        $taskRate = $tasksTotal > 0 ? round(($tasksCompleted / $tasksTotal) * 100) : 0;

        // 3. Study Hours Stats
        $studyMinutes = (int) $user->studySessions()->where('status', 'completed')->whereBetween('session_date', [$from, $to])->sum('duration_minutes');
        $studyHours = round($studyMinutes / 60, 1);

        // 4. Habits Log Count
        $habitCheckins = $user->habits()->withCount(['logs' => fn($q) => $q->whereBetween('log_date', [$from, $to])])->get()->sum('logs_count');

        return view('reports.index', compact(
            'from',
            'to',
            'incomeUsd',
            'incomeKhr',
            'expenseUsd',
            'expenseKhr',
            'tasksTotal',
            'tasksCompleted',
            'taskRate',
            'studyHours',
            'habitCheckins'
        ));
    }

    /**
     * Export transaction reports to CSV with UTF-8 BOM for Khmer text compatibility.
     */
    public function exportTransactionsCsv(Request $request): StreamedResponse
    {
        $user = $request->user();
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->endOfMonth()->toDateString());

        $transactions = $user->transactions()
            ->with('category')
            ->whereBetween('transaction_date', [$from, $to])
            ->orderBy('transaction_date')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"transactions-{$from}-to-{$to}.csv\"",
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel Khmer font compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['ID', 'Date', 'Type', 'Category', 'Amount', 'Currency', 'Payment Method', 'Description', 'Notes']);

            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t->id,
                    $t->transaction_date->format('Y-m-d'),
                    $t->type,
                    $t->category?->name ?? 'Uncategorized',
                    $t->amount,
                    $t->currency,
                    $t->payment_method,
                    $t->description,
                    $t->notes,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
