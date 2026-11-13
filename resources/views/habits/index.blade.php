@extends('layouts.app', ['title' => __('app.habits.title')])

@section('content')
<div x-data="{ addHabitModal: false }" class="space-y-6">
    <!-- Header with Add Habit Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.habits.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.habits.subtitle') }}</p>
        </div>

        <button type="button" 
                @click="addHabitModal = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('app.habits.add_habit') }}</span>
        </button>
    </div>

    <!-- Habit 7-Day Matrix Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                <span>ចង្វាក់បំពេញទម្លាប់ ៧ ថ្ងៃចុងក្រោយ (7-Day Consistency)</span>
            </h2>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">
                {{ $habitsWithStreaks->count() }} ទម្លាប់
            </span>
        </div>

        @if ($habitsWithStreaks->isEmpty())
            <div class="py-16 text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="sparkles" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('app.habits.empty') }}</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">បង្កើតទម្លាប់វិជ្ជមានប្រចាំថ្ងៃ ដូចជាការផឹកទឹក ២ លីត្រ, អានសៀវភៅ, ឬធ្វើសមាធិ។</p>
                <button type="button" 
                        @click="addHabitModal = true"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>{{ __('app.habits.add_habit') }}</span>
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-semibold text-slate-500">
                            <th class="py-3 px-5 min-w-[200px]">ឈ្មោះទម្លាប់ / Habit</th>
                            <th class="py-3 px-3 text-center">Streak</th>
                            @foreach ($days as $dayStr)
                                @php $d = \Carbon\Carbon::parse($dayStr); @endphp
                                <th class="py-3 px-2 text-center {{ $d->isToday() ? 'text-blue-600 font-bold bg-blue-50/50' : '' }}">
                                    <div class="text-[10px] uppercase">{{ $d->format('D') }}</div>
                                    <div class="text-xs">{{ $d->format('d') }}</div>
                                </th>
                            @endforeach
                            <th class="py-3 px-4 text-right">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach ($habitsWithStreaks as $habit)
                            @php
                                $logMap = $habit->logs->pluck('log_date')->map(fn($ld) => $ld->format('Y-m-d'))->flip();
                            @endphp
                            <tr class="hover:bg-slate-50/75 transition-colors">
                                <!-- Habit Info -->
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-900">{{ $habit->name }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1.5">
                                        <span>{{ $habit->frequency === 'daily' ? 'រាល់ថ្ងៃ' : $habit->target_per_week . ' ថ្ងៃ/សប្តាហ៍' }}</span>
                                        @if ($habit->description)
                                            <span>&bull; {{ $habit->description }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Current Streak -->
                                <td class="py-4 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $habit->current_streak > 0 ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-400' }}">
                                        <span>🔥</span>
                                        <span>{{ $habit->current_streak }}</span>
                                    </span>
                                </td>

                                <!-- 7-Day Bubbles -->
                                @foreach ($days as $dayStr)
                                    @php
                                        $isCompleted = $logMap->has($dayStr);
                                        $isToday = \Carbon\Carbon::parse($dayStr)->isToday();
                                    @endphp
                                    <td class="py-4 px-2 text-center {{ $isToday ? 'bg-blue-50/30' : '' }}">
                                        <form action="{{ route('habits.toggle', $habit) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="log_date" value="{{ $dayStr }}">
                                            <button type="submit" 
                                                    class="w-8 h-8 rounded-full flex items-center justify-center transition-all transform active:scale-95 {{ $isCompleted ? 'bg-emerald-500 text-white shadow-xs' : 'border-2 border-slate-200 hover:border-slate-400 bg-white text-transparent' }}"
                                                    title="{{ $isCompleted ? 'Completed on ' . $dayStr : 'Mark Complete' }}">
                                                <i data-lucide="check" class="w-4 h-4 stroke-[3]"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endforeach

                                <!-- Actions -->
                                <td class="py-4 px-4 text-right">
                                    <form action="{{ route('habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបទម្លាប់នេះមែនទេ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Add Habit Modal -->
    <div x-cloak x-show="addHabitModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addHabitModal = false" 
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.habits.add_habit') }}</h3>
                <button type="button" @click="addHabitModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('habits.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="start_date" value="{{ date('Y-m-d') }}">

                <div>
                    <label for="habit_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        ឈ្មោះទម្លាប់ / Habit Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="habit_name" required placeholder="ឧ. ផឹកទឹក ២ លីត្រ, ហាត់យូហ្គា, អានសៀវភៅ..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="freq" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.habits.frequency') }} <span class="text-rose-500">*</span>
                        </label>
                        <select name="frequency" id="freq" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="daily">{{ __('app.habits.daily') }}</option>
                            <option value="weekly">{{ __('app.habits.weekly') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="target_per_week" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.habits.target_days') }}
                        </label>
                        <input type="number" min="1" max="7" name="target_per_week" id="target_per_week" value="7"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="habit_desc" class="block text-xs font-semibold text-slate-700 mb-1">
                        ការលើកទឹកចិត្ត / Why this habit matters
                    </label>
                    <textarea name="description" id="habit_desc" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addHabitModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
