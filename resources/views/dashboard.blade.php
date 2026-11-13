@extends('layouts.app')

@php
    $locale = app()->getLocale();
@endphp

@section('content')
<div class="space-y-6">
    <!-- Top Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                {{ __('app.modules.dashboard') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ $locale === 'km' ? 'ទិដ្ឋភាពទូទៅនៃជីវិតប្រចាំថ្ងៃ, ភារកិច្ច និងហិរញ្ញវត្ថុរបស់អ្នក' : 'Overview of your daily schedule, tasks, and finances' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('schedule.index') }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.schedule.add_activity') }}</span>
            </a>
        </div>
    </div>

    <!-- 1. KPI Statistics Ribbon (6 Metric Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
        <!-- Today's Tasks -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'កិច្ចការថ្ងៃនេះ' : "Today's Tasks" }}</span>
                <i data-lucide="check-square" class="w-4 h-4 text-blue-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">{{ $todayTasksCompleted }} / {{ $todayTasksTotal }}</div>
            <div class="text-[11px] text-emerald-600 font-medium mt-1">{{ $taskRate }}% {{ __('app.status.completed') }}</div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'បញ្ចប់សរុប' : 'Completed' }}</span>
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">{{ $completedThisWeek }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">{{ $locale === 'km' ? 'សប្តាហ៍នេះ' : 'this week' }}</div>
        </div>

        <!-- Today's Expenses -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ __('app.expenses.expense') }}</span>
                <i data-lucide="arrow-down-right" class="w-4 h-4 text-rose-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">${{ number_format($todayExpensesUsd, 2) }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">៛{{ number_format($todayExpensesKhr) }}</div>
        </div>

        <!-- Monthly Income -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ __('app.expenses.income') }}</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-emerald-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">${{ number_format($monthIncomeUsd, 2) }}</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">៛{{ number_format($monthIncomeKhr) }}</div>
        </div>

        <!-- Monthly Goals -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ __('app.goals.title') }}</span>
                <i data-lucide="target" class="w-4 h-4 text-amber-500"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">{{ $goalsCompleted }} / {{ $goalsTotal }}</div>
            <div class="text-[11px] text-amber-600 font-medium mt-1">{{ $goalsProgress }}% {{ __('app.goals.avg_progress') }}</div>
        </div>

        <!-- Active Habits -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ __('app.habits.title') }}</span>
                <i data-lucide="flame" class="w-4 h-4 text-orange-500"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">{{ $activeHabitsCount }}</div>
            <div class="text-[11px] text-orange-600 font-medium mt-1">🔥 {{ __('app.status.active') }}</div>
        </div>
    </div>

    <!-- 2. Charts Section (Cash Flow & Task Completion) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Cash Flow Chart -->
        <div class="lg:col-span-2 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">
                        {{ $locale === 'km' ? 'ចំណូល vs ចំណាយ (ប្រចាំខែ)' : 'Monthly Cash Flow (Income vs Expense)' }}
                    </h2>
                    <p class="text-xs text-slate-500">{{ $locale === 'km' ? 'គិតជារូបិយប័ណ្ណ USD & KHR' : 'Displayed in USD & KHR equivalent' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> {{ __('app.expenses.income') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-rose-600 font-semibold">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> {{ __('app.expenses.expense') }}
                    </span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Task Completion Distribution Chart -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-900">
                    {{ $locale === 'km' ? 'ស្ថានភាពកិច្ចការថ្ងៃនេះ' : "Today's Task Status" }}
                </h2>
                <p class="text-xs text-slate-500">{{ $locale === 'km' ? 'ការបែងចែកកិច្ចការតាមស្ថានភាព' : 'Task distribution by status' }}</p>
            </div>
            <div class="flex-1 flex items-center justify-center h-52">
                <canvas id="taskStatusChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-100 text-center text-xs">
                <div>
                    <span class="block font-bold text-emerald-600">{{ $todayTasksCompleted }}</span>
                    <span class="text-slate-500 text-[11px]">{{ __('app.status.completed') }}</span>
                </div>
                <div>
                    <span class="block font-bold text-slate-500">{{ max(0, $todayTasksTotal - $todayTasksCompleted) }}</span>
                    <span class="text-slate-500 text-[11px]">{{ __('app.status.pending') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Bottom Dual Columns: Today's Schedule & Priority Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule Timeline -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-blue-600"></i>
                    <span>{{ __('app.schedule.title') }}</span>
                </h2>
                <a href="{{ route('schedule.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                    {{ __('app.actions.view_all') }} &rarr;
                </a>
            </div>

            @if ($todaySchedule->isEmpty())
                <div class="py-12 text-center text-xs text-slate-400">
                    <i data-lucide="calendar" class="w-7 h-7 mx-auto mb-2 text-slate-300"></i>
                    {{ __('app.schedule.empty') }}
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($todaySchedule->take(4) as $activity)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs font-bold text-blue-700 w-24 pt-0.5">
                                {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-900 truncate {{ $activity->status === 'done' ? 'line-through text-slate-400' : '' }}">
                                    {{ $activity->title }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $activity->category->name ?? 'General' }}</p>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $activity->status === 'done' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                {{ __('app.status.' . $activity->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Priority Tasks -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                    <span>{{ __('app.tasks.title') }}</span>
                </h2>
                <a href="{{ route('tasks.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                    {{ __('app.actions.view_all') }} &rarr;
                </a>
            </div>

            @if ($priorityTasks->isEmpty())
                <div class="py-12 text-center text-xs text-slate-400">
                    <i data-lucide="check-circle" class="w-7 h-7 mx-auto mb-2 text-slate-300"></i>
                    {{ __('app.tasks.empty') }}
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($priorityTasks as $task)
                        <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-5 h-5 rounded border border-slate-300 bg-white hover:border-blue-500 flex items-center justify-center transition-colors">
                                    </button>
                                </form>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $task->title }}</p>
                                    <span class="text-[11px] text-slate-500">
                                        {{ $task->due_date ? $task->due_date->format('d M Y') : 'No due date' }} &bull; {{ __('app.tasks.kind_' . $task->kind) }}
                                    </span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $task->priority === 'high' ? 'bg-rose-100 text-rose-700' : ($task->priority === 'medium' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }}">
                                {{ $task->priority }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart !== 'undefined') {
        // 1. Dashboard Cash Flow Chart
        const cashFlowCtx = document.getElementById('cashFlowChart');
        if (cashFlowCtx) {
            new Chart(cashFlowCtx, {
                type: 'bar',
                data: {
                    labels: ['ចរន្តខែនេះ (Current Month)'],
                    datasets: [
                        {
                            label: '{{ __("app.expenses.income") }} ($)',
                            data: [{{ $monthIncomeUsd }}],
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderRadius: 8
                        },
                        {
                            label: '{{ __("app.expenses.expense") }} ($)',
                            data: [{{ $todayExpensesUsd }}],
                            backgroundColor: 'rgba(239, 68, 68, 0.85)',
                            borderRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(val) { return '$' + val; }
                            }
                        }
                    }
                }
            });
        }

        // 2. Task Completion Doughnut
        const taskCtx = document.getElementById('taskStatusChart');
        if (taskCtx) {
            new Chart(taskCtx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("app.status.completed") }}', '{{ __("app.status.pending") }}'],
                    datasets: [{
                        data: [{{ $todayTasksCompleted }}, {{ max(0, $todayTasksTotal - $todayTasksCompleted) }} || ({{ $todayTasksTotal }} === 0 ? 1 : 0)],
                        backgroundColor: ['#10B981', '#E2E8F0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    }
});
</script>
@endsection
