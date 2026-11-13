@extends('layouts.app', ['title' => __('app.reports.title')])

@section('content')
<div class="space-y-6">
    <!-- Header with Date Filter & CSV Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.reports.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.reports.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('reports.export', ['from' => $from, 'to' => $to]) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>{{ __('app.actions.export') }}</span>
            </a>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-1.5 text-xs text-slate-600 font-medium">
                <span>ចាប់ពី:</span>
                <input type="date" name="from" value="{{ $from }}"
                       class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800">
            </div>

            <div class="flex items-center gap-1.5 text-xs text-slate-600 font-medium">
                <span>ដល់:</span>
                <input type="date" name="to" value="{{ $to }}"
                       class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800">
            </div>

            <button type="submit" 
                    class="px-4 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800">
                {{ __('app.actions.filter') }}
            </button>
        </form>
    </div>

    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Net Cash Flow -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">លំហូរសាច់ប្រាក់សុទ្ធ</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl font-bold {{ ($incomeUsd - $expenseUsd) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                ${{ number_format($incomeUsd - $expenseUsd, 2) }}
            </div>
            <div class="text-xs text-slate-400 mt-1">
                ចំណូល: ${{ number_format($incomeUsd, 2) }} &bull; ចំណាយ: ${{ number_format($expenseUsd, 2) }}
            </div>
        </div>

        <!-- 2. Task Completion Rate -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">អត្រាសម្រេចភារកិច្ច</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl font-bold text-blue-600">
                {{ $taskRate }}%
            </div>
            <div class="text-xs text-slate-400 mt-1">
                សម្រេច: {{ $tasksCompleted }} / {{ $tasksTotal }} ភារកិច្ច
            </div>
        </div>

        <!-- 3. Total Study Hours -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">ម៉ោងសិក្សាសរុប</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="book-open" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl font-bold text-indigo-600">
                {{ $studyHours }} <span class="text-sm font-medium text-slate-500">ម៉ោង</span>
            </div>
            <div class="text-xs text-slate-400 mt-1">
                ការស្រាវជ្រាវ & សិក្សាក្នុងចន្លោះកាលបរិច្ឆេទនេះ
            </div>
        </div>

        <!-- 4. Habits Check-ins -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">ការកត់ត្រាទម្លាប់</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="flame" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl sm:text-2xl font-bold text-amber-600">
                {{ $habitCheckins }} <span class="text-sm font-medium text-slate-500">លើក</span>
            </div>
            <div class="text-xs text-slate-400 mt-1">
                ភាពខ្ជាប់ខ្ជួននៃការអនុវត្តទម្លាប់ប្រចាំថ្ងៃ
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 1. Cash Flow Visualization -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-5 h-5 text-emerald-600"></i>
                    <span>{{ __('app.reports.cash_flow') }} (USD)</span>
                </h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="reportsCashFlowChart"></canvas>
            </div>
        </div>

        <!-- 2. Task Velocity & Completion Rate -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-blue-600"></i>
                    <span>{{ __('app.reports.task_stats') }}</span>
                </h3>
            </div>
            <div class="relative h-64 w-full flex items-center justify-center">
                <canvas id="reportsProductivityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart !== 'undefined') {
        // 1. Reports Cash Flow Chart
        const cashFlowCtx = document.getElementById('reportsCashFlowChart');
        if (cashFlowCtx) {
            new Chart(cashFlowCtx, {
                type: 'bar',
                data: {
                    labels: ['ចំណូល (Income)', 'ចំណាយ (Expense)'],
                    datasets: [{
                        label: 'Amount (USD)',
                        data: [{{ $incomeUsd }}, {{ $expenseUsd }}],
                        backgroundColor: ['rgba(16, 185, 129, 0.85)', 'rgba(239, 68, 68, 0.85)'],
                        borderRadius: 10,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) { return '$' + value; }
                            }
                        }
                    }
                }
            });
        }

        // 2. Reports Productivity Chart
        const prodCtx = document.getElementById('reportsProductivityChart');
        if (prodCtx) {
            const pendingTasks = Math.max(0, {{ $tasksTotal }} - {{ $tasksCompleted }});
            new Chart(prodCtx, {
                type: 'doughnut',
                data: {
                    labels: ['បានសម្រេច (Completed)', 'កំពុងរង់ចាំ (Pending)'],
                    datasets: [{
                        data: [{{ $tasksCompleted }}, pendingTasks || ({{ $tasksTotal }} === 0 ? 1 : 0)],
                        backgroundColor: ['#2563EB', '#E2E8F0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: "'Noto Sans Khmer', 'Inter', sans-serif" }
                            }
                        }
                    }
                }
            });
        }
    }
});
</script>
@endsection
