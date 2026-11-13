@extends('layouts.app', ['title' => __('app.work.title')])

@section('content')
<div x-data="{ addWorkModal: false }" class="space-y-6">
    <!-- Header with Date Navigator & Add Work Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.work.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.work.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <!-- Date Navigator -->
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-2xs">
                <a href="{{ route('work.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" 
                   class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors"
                   title="Previous Day">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>

                <input type="date" value="{{ $date }}"
                       onchange="window.location.href = '{{ route('work.index') }}?date=' + this.value"
                       class="text-xs font-semibold text-slate-800 border-0 bg-transparent px-2 py-1 focus:ring-0 cursor-pointer">

                <a href="{{ route('work.index', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" 
                   class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors"
                   title="Next Day">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <button type="button" 
                    @click="addWorkModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>បន្ថែមការងារ / Log Work</span>
            </button>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- 1. Total Hours Logged -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.work.hours_logged') }}</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $totalHours }} <span class="text-sm font-medium text-slate-500">ម៉ោង</span></p>
            </div>
        </div>

        <!-- 2. Work Activities Count -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="activity" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.work.activities') }}</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $workActivities->count() }} <span class="text-sm font-medium text-slate-500">កំណត់ត្រា</span></p>
            </div>
        </div>

        <!-- 3. Deliverables Count -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.work.deliverables') }}</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $deliverables->where('status', 'completed')->count() }} / {{ $deliverables->count() }}</p>
            </div>
        </div>
    </div>

    <!-- 2 Column Layout: Work Activities & Deliverables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 1. Work Activities Timeline -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="briefcase" class="w-5 h-5 text-indigo-600"></i>
                    <span>{{ __('app.work.activities') }}</span>
                </h2>
                <span class="text-xs font-semibold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </span>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @if ($workActivities->isEmpty())
                    <div class="py-12 text-center px-4">
                        <i data-lucide="calendar" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-xs text-slate-400">{{ __('app.work.empty') }}</p>
                    </div>
                @else
                    @foreach ($workActivities as $activity)
                        <div class="p-4 flex items-center justify-between gap-3 hover:bg-slate-50/75 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <form action="{{ route('activities.toggle', $activity) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-5 h-5 rounded border flex items-center justify-center transition-colors {{ $activity->status === 'done' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 bg-white' }}">
                                        @if ($activity->status === 'done')
                                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                        @endif
                                    </button>
                                </form>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold text-slate-900 {{ $activity->status === 'done' ? 'line-through text-slate-400' : '' }}">
                                        {{ $activity->title }}
                                    </h3>
                                    <span class="text-[11px] text-slate-500">
                                        {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }}
                                        ({{ $activity->duration_minutes }} នាទី)
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- 2. Work Deliverables / Tasks -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="check-square" class="w-5 h-5 text-emerald-600"></i>
                    <span>{{ __('app.work.deliverables') }}</span>
                </h2>
                <a href="{{ route('tasks.index', ['kind' => 'work']) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    {{ __('app.actions.view_all') }} &rarr;
                </a>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @if ($deliverables->isEmpty())
                    <div class="py-12 text-center px-4">
                        <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-xs text-slate-400">មិនមានភារកិច្ចការងារដែលត្រូវបំពេញទេ។</p>
                    </div>
                @else
                    @foreach ($deliverables as $task)
                        <div class="p-4 flex items-center justify-between gap-3 hover:bg-slate-50/75 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-5 h-5 rounded border flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 bg-white' }}">
                                        @if ($task->status === 'completed')
                                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                                        @endif
                                    </button>
                                </form>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold text-slate-900 {{ $task->status === 'completed' ? 'line-through text-slate-400' : '' }}">
                                        {{ $task->title }}
                                    </h3>
                                    @if ($task->due_date)
                                        <span class="text-[11px] text-slate-500">កាលបរិច្ឆេទ: {{ $task->due_date->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Log Work Modal -->
    <div x-cloak x-show="addWorkModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addWorkModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">កត់ត្រាការងារថ្មី / Log Work Activity</h3>
                <button type="button" @click="addWorkModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('activities.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="activity_date" value="{{ $date }}">
                <input type="hidden" name="category_id" value="{{ $workCategory?->id }}">

                <div>
                    <label for="work_title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងការងារ / Work Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="work_title" required
                           placeholder="ឧ. សរសេរកូដមុខងារថ្មី, ប្រជុំអតិថិជន..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="work_start" class="block text-xs font-semibold text-slate-700 mb-1">
                            ម៉ោងចាប់ផ្តើម <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="start_time" id="work_start" required value="09:00"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="work_end" class="block text-xs font-semibold text-slate-700 mb-1">
                            ម៉ោងបញ្ចប់ <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="end_time" id="work_end" required value="12:00"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label for="work_desc" class="block text-xs font-semibold text-slate-700 mb-1">
                        បរិយាយការងារ / Notes
                    </label>
                    <textarea name="description" id="work_desc" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addWorkModal = false"
                            class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
