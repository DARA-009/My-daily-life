@extends('layouts.app', ['title' => __('app.goals.title')])

@section('content')
<div x-data="{ addGoalModal: false, logProgressModal: false, activeGoal: null }" class="space-y-6">
    <!-- Header with Add Goal Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.goals.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.goals.subtitle') }}</p>
        </div>

        <button type="button" 
                @click="addGoalModal = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('app.goals.add_goal') }}</span>
        </button>
    </div>

    <!-- KPI Progress Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- 1. Total Goals -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="target" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">គោលដៅសរុប</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $goals->count() }}</p>
            </div>
        </div>

        <!-- 2. Completed Goals -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle-2" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.goals.completed') }}</span>
                <p class="text-2xl font-bold text-emerald-600 mt-0.5">{{ $completedCount }}</p>
            </div>
        </div>

        <!-- 3. Average Progress -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="trending-up" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.goals.avg_progress') }}</span>
                <p class="text-2xl font-bold text-indigo-600 mt-0.5">{{ $averageProgress }}%</p>
            </div>
        </div>
    </div>

    <!-- Goals Grid -->
    @if ($goals->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs py-16 text-center px-4">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                <i data-lucide="compass" class="w-7 h-7"></i>
            </div>
            <h3 class="text-base font-semibold text-slate-800">{{ __('app.goals.empty') }}</h3>
            <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">កំណត់គោលដៅប្រចាំខែច្បាស់លាស់ ដើម្បីតាមដានភាពរីកចម្រើននៃជីវិត និងអាជីពរបស់អ្នក។</p>
            <button type="button" 
                    @click="addGoalModal = true"
                    class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.goals.add_goal') }}</span>
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($goals as $goal)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-5 flex flex-col justify-between hover:shadow-xs transition-shadow">
                    <div>
                        <!-- Header: Priority & Status -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @if ($goal->priority === 'high')
                                <span class="text-[11px] font-bold px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-md">🔥 អាទិភាពខ្ពស់</span>
                            @elseif ($goal->priority === 'medium')
                                <span class="text-[11px] font-medium px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md">⚡ មធ្យម</span>
                            @else
                                <span class="text-[11px] font-medium px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">🌱 ទាប</span>
                            @endif

                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md {{ $goal->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                {{ __('app.status.' . $goal->status) }}
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="text-base font-bold text-slate-900 line-clamp-1">{{ $goal->title }}</h3>
                        @if ($goal->description)
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $goal->description }}</p>
                        @endif

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-500">វឌ្ឍនភាព</span>
                                <span class="text-blue-600 font-bold">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r {{ $goal->progress_percent == 100 ? 'from-emerald-500 to-teal-500' : 'from-blue-600 to-indigo-600' }} rounded-full transition-all duration-300"
                                     style="width: {{ $goal->progress_percent }}%;"></div>
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="mt-4 flex items-center gap-1.5 text-xs text-slate-500">
                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                            <span>ផុតកំណត់: {{ $goal->deadline->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between gap-2 pt-4 mt-4 border-t border-slate-100">
                        <button type="button" 
                                @click="activeGoal = {{ json_encode(['id' => $goal->id, 'title' => $goal->title, 'progress' => $goal->progress_percent]) }}; logProgressModal = true"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                            <span>{{ __('app.goals.log_progress') }}</span>
                        </button>

                        <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបគោលដៅនេះមែនទេ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="{{ __('app.actions.delete') }}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Create Goal Modal (Alpine.js) -->
    <div x-cloak x-show="addGoalModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addGoalModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.goals.add_goal') }}</h3>
                <button type="button" @click="addGoalModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('goals.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Title -->
                <div>
                    <label for="goal_title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងគោលដៅ / Goal Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="goal_title" required
                           placeholder="ឧ. អានសៀវភៅឱ្យបាន ២ ក្បាល, សន្សំប្រាក់ $500..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Priority & Deadline -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="goal_priority" class="block text-xs font-semibold text-slate-700 mb-1">
                            អាទិភាព / Priority
                        </label>
                        <select name="priority" id="goal_priority" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="high">{{ __('app.priority.high') }}</option>
                            <option value="medium" selected>{{ __('app.priority.medium') }}</option>
                            <option value="low">{{ __('app.priority.low') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="goal_deadline" class="block text-xs font-semibold text-slate-700 mb-1">
                            កាលបរិច្ឆេទផុតកំណត់ / Deadline <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="deadline" id="goal_deadline" required value="{{ now()->endOfMonth()->toDateString() }}"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="goal_desc" class="block text-xs font-semibold text-slate-700 mb-1">
                        បរិយាយយុទ្ធសាស្ត្រ / Strategy & Details
                    </label>
                    <textarea name="description" id="goal_desc" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addGoalModal = false"
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

    <!-- Log Goal Progress Modal (Alpine.js) -->
    <div x-cloak x-show="logProgressModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="logProgressModal = false" 
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.goals.log_progress') }}</h3>
                <button type="button" @click="logProgressModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'/goals/' + (activeGoal ? activeGoal.id : '') + '/progress'" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="logged_on" value="{{ date('Y-m-d') }}">

                <div>
                    <span class="text-xs text-slate-400">គោលដៅ:</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-0.5" x-text="activeGoal ? activeGoal.title : ''"></h4>
                </div>

                <!-- Progress Percent Slider / Input -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="progress_percent" class="block text-xs font-semibold text-slate-700">
                            វឌ្ឍនភាពថ្មី (0 - 100%) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs font-bold text-blue-600" x-text="(activeGoal ? activeGoal.progress : 0) + '%'"></span>
                    </div>
                    <input type="range" min="0" max="100" step="5" name="progress_percent" id="progress_percent"
                           x-model="activeGoal.progress"
                           class="w-full accent-blue-600 cursor-pointer">
                </div>

                <!-- Note -->
                <div>
                    <label for="prog_note" class="block text-xs font-semibold text-slate-700 mb-1">
                        កំណត់សម្គាល់វឌ្ឍនភាព / Milestone Note
                    </label>
                    <input type="text" name="note" id="prog_note"
                           placeholder="ឧ. បានអានចប់ជំពូកទី ៣..."
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="logProgressModal = false"
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
