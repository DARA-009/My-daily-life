@extends('layouts.app', ['title' => __('app.expenses.title')])

@section('content')
<div x-data="{ addModalOpen: false, txnType: 'expense', txnCurrency: 'USD' }" class="space-y-6">
    <!-- Header with Add Transaction Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.expenses.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.expenses.subtitle') }}</p>
        </div>

        <button type="button" 
                @click="addModalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('app.expenses.add_txn') }}</span>
        </button>
    </div>

    <!-- Dual-Currency Summary Cards (USD & KHR) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- 1. Total Income -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="arrow-down-left" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.expenses.income') }}</span>
                <div class="flex flex-wrap items-baseline gap-2 mt-0.5">
                    <span class="text-xl sm:text-2xl font-bold text-emerald-600">${{ number_format($totalIncomeUsd, 2) }}</span>
                    <span class="text-xs font-semibold text-slate-400">/ ៛{{ number_format($totalIncomeKhr) }}</span>
                </div>
            </div>
        </div>

        <!-- 2. Total Expense -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <i data-lucide="arrow-up-right" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.expenses.expense') }}</span>
                <div class="flex flex-wrap items-baseline gap-2 mt-0.5">
                    <span class="text-xl sm:text-2xl font-bold text-rose-600">${{ number_format($totalExpenseUsd, 2) }}</span>
                    <span class="text-xs font-semibold text-slate-400">/ ៛{{ number_format($totalExpenseKhr) }}</span>
                </div>
            </div>
        </div>

        <!-- 3. Net Cash Flow -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $netUsd >= 0 ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center shrink-0">
                <i data-lucide="wallet" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div class="min-w-0">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.expenses.balance') }}</span>
                <div class="flex flex-wrap items-baseline gap-2 mt-0.5">
                    <span class="text-xl sm:text-2xl font-bold {{ $netUsd >= 0 ? 'text-blue-600' : 'text-amber-600' }}">${{ number_format($netUsd, 2) }}</span>
                    <span class="text-xs font-semibold text-slate-400">/ ៛{{ number_format($netKhr) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('expenses.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="flex items-center gap-1 text-xs text-slate-500">
                <span>ចាប់ពី:</span>
                <input type="date" name="from" value="{{ $from }}"
                       class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-800">
            </div>

            <div class="flex items-center gap-1 text-xs text-slate-500">
                <span>ដល់:</span>
                <input type="date" name="to" value="{{ $to }}"
                       class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-800">
            </div>

            <select name="type" onchange="this.form.submit()"
                    class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700">
                <option value="">-- ប្រភេទទាំងអស់ --</option>
                <option value="income" @selected(request('type') === 'income')>ចំណូល (Income)</option>
                <option value="expense" @selected(request('type') === 'expense')>ចំណាយ (Expense)</option>
            </select>

            <select name="currency" onchange="this.form.submit()"
                    class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-700">
                <option value="">-- រូបិយប័ណ្ណ --</option>
                <option value="USD" @selected(request('currency') === 'USD')>USD ($)</option>
                <option value="KHR" @selected(request('currency') === 'KHR')>KHR (៛)</option>
            </select>

            <button type="submit" 
                    class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800">
                {{ __('app.actions.filter') }}
            </button>
        </form>

        <a href="{{ route('reports.export', ['from' => $from, 'to' => $to]) }}" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
            <i data-lucide="download" class="w-3.5 h-3.5"></i>
            <span>{{ __('app.actions.export') }}</span>
        </a>
    </div>

    <!-- Transactions Ledger Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        @if ($transactions->isEmpty())
            <div class="py-16 text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="receipt" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('app.expenses.empty') }}</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">កត់ត្រាចំណូល និងចំណាយប្រចាំថ្ងៃ ដើម្បីគ្រប់គ្រងហិរញ្ញវត្ថុរបស់អ្នកឱ្យមានប្រសិទ្ធភាព។</p>
                <button type="button" 
                        @click="addModalOpen = true"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>{{ __('app.expenses.add_txn') }}</span>
                </button>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($transactions as $txn)
                    <div class="p-4 sm:p-5 flex items-center justify-between gap-4 hover:bg-slate-50/75 transition-colors">
                        <div class="flex items-center gap-3.5 min-w-0 flex-1">
                            <!-- Type Icon -->
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $txn->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                <i data-lucide="{{ $txn->type === 'income' ? 'arrow-down-left' : 'arrow-up-right' }}" class="w-5 h-5 stroke-[2]"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900">{{ $txn->description }}</h3>
                                    
                                    @if ($txn->category)
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-md" 
                                              style="background-color: {{ $txn->category->color ? $txn->category->color . '20' : '#E2E8F0' }}; color: {{ $txn->category->color ?? '#475569' }};">
                                            {{ $txn->category->name }}
                                        </span>
                                    @endif

                                    <span class="text-[11px] font-medium px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">
                                        {{ __('app.expenses.' . $txn->payment_method) }}
                                    </span>
                                </div>
                                <span class="text-xs text-slate-400 mt-0.5 block">{{ $txn->transaction_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Right: Amount & Delete -->
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="text-sm sm:text-base font-bold {{ $txn->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $txn->type === 'income' ? '+' : '-' }}{{ $txn->currency === 'USD' ? '$' : '៛' }}{{ number_format($txn->amount, $txn->currency === 'USD' ? 2 : 0) }}
                            </span>

                            <form action="{{ route('transactions.destroy', $txn) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបប្រតិបត្តិការនេះមែនទេ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="{{ __('app.actions.delete') }}">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($transactions->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $transactions->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Transaction Modal (Alpine.js) -->
    <div x-cloak x-show="addModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.expenses.add_txn') }}</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Type Selector Tabs (Income / Expense) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">{{ __('app.expenses.type') }}</label>
                    <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl">
                        <button type="button" @click="txnType = 'expense'"
                                :class="txnType === 'expense' ? 'bg-rose-600 text-white shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900'"
                                class="py-2 text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1.5">
                            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            <span>{{ __('app.expenses.expense') }}</span>
                        </button>
                        <button type="button" @click="txnType = 'income'"
                                :class="txnType === 'income' ? 'bg-emerald-600 text-white shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900'"
                                class="py-2 text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1.5">
                            <i data-lucide="arrow-down-left" class="w-4 h-4"></i>
                            <span>{{ __('app.expenses.income') }}</span>
                        </button>
                    </div>
                    <input type="hidden" name="type" :value="txnType">
                </div>

                <!-- Amount & Currency -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="col-span-2">
                        <label for="amount" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.expenses.amount') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" step="0.01" min="0.01" name="amount" id="amount" required
                               placeholder="0.00"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-base font-bold text-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="currency" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.expenses.currency') }}
                        </label>
                        <select name="currency" id="currency" x-model="txnCurrency"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-bold focus:ring-2 focus:ring-blue-500">
                            <option value="USD">USD ($)</option>
                            <option value="KHR">KHR (៛)</option>
                        </select>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        ជំពូកហិរញ្ញវត្ថុ / Category <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- ជ្រើសរើសជំពូក --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->type }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Method & Date -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="payment_method" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.expenses.payment_method') }}
                        </label>
                        <select name="payment_method" id="payment_method" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="cash">{{ __('app.expenses.cash') }}</option>
                            <option value="mobile_wallet">{{ __('app.expenses.mobile_wallet') }}</option>
                            <option value="bank">{{ __('app.expenses.bank') }}</option>
                            <option value="card">{{ __('app.expenses.card') }}</option>
                            <option value="other">{{ __('app.expenses.other') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="transaction_date" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.expenses.date') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" required value="{{ date('Y-m-d') }}"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="desc" class="block text-xs font-semibold text-slate-700 mb-1">
                        {{ __('app.expenses.desc') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="description" id="desc" required
                           placeholder="ឧ. បាយថ្ងៃត្រង់, ប្រាក់បៀវត្សរ៍, ទិញសាំង..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addModalOpen = false"
                            class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
