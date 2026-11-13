<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display the financial transaction ledger and summaries.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = $user->transactions()->with('category');

        // Date Range (default: Current Month)
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->endOfMonth()->toDateString());
        $query->whereBetween('transaction_date', [$from, $to]);

        // Type Filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Currency Filter
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Strict Financial Calculations separated by Currency
        $statsQuery = clone $query;
        $totalIncomeUsd = (float) (clone $statsQuery)->where('type', 'income')->where('currency', 'USD')->sum('amount');
        $totalIncomeKhr = (float) (clone $statsQuery)->where('type', 'income')->where('currency', 'KHR')->sum('amount');
        $totalExpenseUsd = (float) (clone $statsQuery)->where('type', 'expense')->where('currency', 'USD')->sum('amount');
        $totalExpenseKhr = (float) (clone $statsQuery)->where('type', 'expense')->where('currency', 'KHR')->sum('amount');

        $netUsd = $totalIncomeUsd - $totalExpenseUsd;
        $netKhr = $totalIncomeKhr - $totalExpenseKhr;

        $transactions = $query->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $categories = $user->categories()
            ->whereIn('type', ['income', 'expense'])
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('expenses.index', compact(
            'transactions',
            'categories',
            'from',
            'to',
            'totalIncomeUsd',
            'totalIncomeKhr',
            'totalExpenseUsd',
            'totalExpenseKhr',
            'netUsd',
            'netKhr'
        ));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(TransactionRequest $request): RedirectResponse
    {
        $request->user()->transactions()->create($request->validated());

        return redirect()->back()->with('success', 'Transaction recorded successfully.');
    }

    /**
     * Update the specified transaction.
     */
    public function update(TransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        $transaction->update($request->validated());

        return redirect()->back()->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
}
