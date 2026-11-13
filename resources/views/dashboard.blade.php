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
                {{ $locale === 'km' ? 'ផ្ទាំងគ្រប់គ្រង' : 'Dashboard' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ $locale === 'km' ? 'ទិដ្ឋភាពទូទៅនៃជីវិតប្រចាំថ្ងៃ, ភារកិច្ច និងហិរញ្ញវត្ថុរបស់អ្នក' : 'Overview of your daily schedule, tasks, and finances' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" 
                    class="inline-flex items-center gap-2 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ $locale === 'km' ? 'បន្ថែមសកម្មភាព' : 'Quick Action' }}</span>
            </button>
        </div>
    </div>

    <!-- 1. KPI Statistics Ribbon (6 Metric Cards) -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
        <!-- Today's Tasks -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'កិច្ចការថ្ងៃនេះ' : "Today's Tasks" }}</span>
                <i data-lucide="check-square" class="w-4 h-4 text-blue-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">8 / 12</div>
            <div class="text-[11px] text-emerald-600 font-medium mt-1">67% {{ $locale === 'km' ? 'បានបញ្ចប់' : 'done' }}</div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'បញ្ចប់សរុប' : 'Completed' }}</span>
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">24</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">{{ $locale === 'km' ? 'សប្តាហ៍នេះ' : 'this week' }}</div>
        </div>

        <!-- Today's Expenses -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'ចំណាយថ្ងៃនេះ' : "Today's Expenses" }}</span>
                <i data-lucide="arrow-down-right" class="w-4 h-4 text-rose-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">$18.50</div>
            <div class="text-[11px] text-slate-500 font-medium mt-1">25,000 ៛</div>
        </div>

        <!-- Monthly Income -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'ចំណូលខែនេះ' : 'Monthly Income' }}</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-emerald-600"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">$850.00</div>
            <div class="text-[11px] text-emerald-600 font-medium mt-1">+12% vs last mo</div>
        </div>

        <!-- Monthly Goals -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'គោលដៅខែនេះ' : 'Monthly Goals' }}</span>
                <i data-lucide="target" class="w-4 h-4 text-amber-500"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">4 / 5</div>
            <div class="text-[11px] text-amber-600 font-medium mt-1">75% {{ $locale === 'km' ? 'វឌ្ឍនភាព' : 'progress' }}</div>
        </div>

        <!-- Habit Streak -->
        <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 mb-2">
                <span class="text-xs font-medium">{{ $locale === 'km' ? 'ទម្លាប់ជាប់ៗគ្នា' : 'Habit Streak' }}</span>
                <i data-lucide="flame" class="w-4 h-4 text-orange-500"></i>
            </div>
            <div class="text-xl font-bold text-slate-900">7 {{ $locale === 'km' ? 'ថ្ងៃ' : 'Days' }}</div>
            <div class="text-[11px] text-orange-600 font-medium mt-1">🔥 {{ $locale === 'km' ? 'កំពុងបន្ត' : 'Active streak' }}</div>
        </div>
    </div>

    <!-- 2. Charts Section (Cash Flow & Task Completion) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Cash Flow Chart (Income vs Expense) -->
        <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">
                        {{ $locale === 'km' ? 'ចំណូល vs ចំណាយ (ប្រចាំខែ)' : 'Monthly Cash Flow (Income vs Expense)' }}
                    </h2>
                    <p class="text-xs text-slate-500">{{ $locale === 'km' ? 'គិតជារូបិយប័ណ្ណ USD & KHR' : 'Displayed in USD & KHR equivalent' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-semibold">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> {{ $locale === 'km' ? 'ចំណូល' : 'Income' }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs text-rose-600 font-semibold ml-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> {{ $locale === 'km' ? 'ចំណាយ' : 'Expense' }}
                    </span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Task Completion Distribution Chart -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col">
            <div class="mb-4">
                <h2 class="text-base font-semibold text-slate-900">
                    {{ $locale === 'km' ? 'ស្ថានភាពកិច្ចការថ្ងៃនេះ' : "Today's Task Status" }}
                </h2>
                <p class="text-xs text-slate-500">{{ $locale === 'km' ? 'ការបែងចែកកិច្ចការតាមស្ថានភាព' : 'Task distribution by status' }}</p>
            </div>
            <div class="flex-1 flex items-center justify-center h-52">
                <canvas id="taskStatusChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center text-xs">
                <div>
                    <span class="block font-bold text-emerald-600">8</span>
                    <span class="text-slate-500 text-[11px]">{{ $locale === 'km' ? 'រួចរាល់' : 'Done' }}</span>
                </div>
                <div>
                    <span class="block font-bold text-blue-600">3</span>
                    <span class="text-slate-500 text-[11px]">{{ $locale === 'km' ? 'កំពុងធ្វើ' : 'Ongoing' }}</span>
                </div>
                <div>
                    <span class="block font-bold text-slate-500">1</span>
                    <span class="text-slate-500 text-[11px]">{{ $locale === 'km' ? 'នៅសល់' : 'Pending' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Bottom Dual Columns: Today's Schedule & Priority Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule Timeline -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-blue-600"></i>
                    <span>{{ $locale === 'km' ? 'កាលវិភាគថ្ងៃនេះ' : "Today's Schedule" }}</span>
                </h2>
                <a href="{{ route('schedule.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                    {{ $locale === 'km' ? 'មើលទាំងអស់' : 'View all' }} &rarr;
                </a>
            </div>
            <div class="space-y-3">
                <div class="flex items-start gap-3 p-3 rounded-lg bg-blue-50/60 border border-blue-100">
                    <span class="text-xs font-bold text-blue-700 w-16 pt-0.5">08:00 - 09:30</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">Computer Science & Algorithms</p>
                        <p class="text-xs text-slate-500">Study Session &bull; University Library</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-700">Done</span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-700 w-16 pt-0.5">10:00 - 12:00</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">Laravel Backend Feature API</p>
                        <p class="text-xs text-slate-500">Work Activity &bull; Remote</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-100 text-blue-700">In Progress</span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-700 w-16 pt-0.5">17:00 - 18:00</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">Evening Jogging & Exercise</p>
                        <p class="text-xs text-slate-500">Habit & Health</p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-600">Planned</span>
                </div>
            </div>
        </div>

        <!-- Priority Tasks & Recent Transactions -->
        <div class="space-y-6">
            <!-- Upcoming Priority Tasks -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-amber-500"></i>
                        <span>{{ $locale === 'km' ? 'កិច្ចការអាទិភាពខ្ពស់' : 'Priority Tasks' }}</span>
                    </h2>
                    <a href="{{ route('tasks.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                        {{ $locale === 'km' ? 'មើលទាំងអស់' : 'View all' }} &rarr;
                    </a>
                </div>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 border border-slate-100 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm font-medium text-slate-500 line-through flex-1">Complete Chapter 4 Database Assignment</span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600">Urgent</span>
                    </label>
                    <label class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 border border-slate-100 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm font-medium text-slate-800 flex-1">Review Graphic Design Wireframes in Figma</span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600">High</span>
                    </label>
                    <label class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 border border-slate-100 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-sm font-medium text-slate-800 flex-1">Weekly Personal Expense Reconciliation</span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600">Medium</span>
                    </label>
                </div>
            </div>

            <!-- Recent Transactions Mini Card -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                        <i data-lucide="receipt" class="w-4 h-4 text-emerald-600"></i>
                        <span>{{ $locale === 'km' ? 'ប្រតិបត្តិការហិរញ្ញវត្ថុថ្មីៗ' : 'Recent Transactions' }}</span>
                    </h2>
                    <a href="{{ route('expenses.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                        {{ $locale === 'km' ? 'មើលទាំងអស់' : 'View all' }} &rarr;
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    <div class="py-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold">-$</div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Lunch with university friends</p>
                                <p class="text-[11px] text-slate-400">Food & Dining &bull; ABA Bank</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-rose-600">- $4.50</span>
                    </div>

                    <div class="py-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold">-៛</div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Motorcycle Gasoline Refill</p>
                                <p class="text-[11px] text-slate-400">Transport &bull; Cash</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-rose-600">- 15,000 ៛</span>
                    </div>

                    <div class="py-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">+$</div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Freelance Graphic Design Project</p>
                                <p class="text-[11px] text-slate-400">Freelance Income &bull; Wing</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-emerald-600">+ $150.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Initialization Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Cash Flow Chart (Income vs Expense)
    const ctxCashFlow = document.getElementById('cashFlowChart');
    if (ctxCashFlow && window.Chart) {
        new Chart(ctxCashFlow, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: '{{ $locale === "km" ? "ចំណូល" : "Income" }} ($)',
                        data: [250, 400, 150, 50],
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                    },
                    {
                        label: '{{ $locale === "km" ? "ចំណាយ" : "Expense" }} ($)',
                        data: [95, 140, 80, 45],
                        backgroundColor: '#f43f5e',
                        borderRadius: 6,
                    }
                ]
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
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

    // 2. Task Status Doughnut Chart
    const ctxTask = document.getElementById('taskStatusChart');
    if (ctxTask && window.Chart) {
        new Chart(ctxTask, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending'],
                datasets: [{
                    data: [8, 3, 1],
                    backgroundColor: ['#10b981', '#3b82f6', '#94a3b8'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>
@endsection
