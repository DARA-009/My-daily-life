@extends('layouts.app', ['title' => __('app.schedule.title')])

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, activeActivity: null }" class="space-y-6">
    <!-- Header with Date Navigator & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.schedule.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.schedule.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <!-- Date Navigator -->
            <div class="inline-flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-2xs">
                <a href="{{ route('schedule.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" 
                   class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors"
                   title="Previous Day">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>

                <input type="date" value="{{ $date }}"
                       onchange="window.location.href = '{{ route('schedule.index') }}?date=' + this.value"
                       class="text-xs font-semibold text-slate-800 border-0 bg-transparent px-2 py-1 focus:ring-0 cursor-pointer">

                <a href="{{ route('schedule.index', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" 
                   class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors"
                   title="Next Day">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>

            <button type="button" 
                    @click="addModalOpen = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.schedule.add_activity') }}</span>
            </button>
        </div>
    </div>

    <!-- Activities Timeline / List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                <h2 class="text-base font-bold text-slate-900">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                </h2>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg">
                {{ $activities->count() }} {{ $activities->count() === 1 ? 'សកម្មភាព' : 'សកម្មភាព' }}
            </span>
        </div>

        @if ($activities->isEmpty())
            <div class="py-16 text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="calendar-plus" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('app.schedule.empty') }}</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">រៀបចំកាលវិភាគដើម្បីបង្កើនប្រសិទ្ធភាពការងារ និងតុល្យភាពជីវិតរបស់អ្នក។</p>
                <button type="button" 
                        @click="addModalOpen = true"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>{{ __('app.schedule.add_activity') }}</span>
                </button>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($activities as $activity)
                    <div class="p-4 sm:p-5 flex items-start sm:items-center justify-between gap-4 hover:bg-slate-50/75 transition-colors">
                        <!-- Left: Status Check & Info -->
                        <div class="flex items-start sm:items-center gap-3.5 min-w-0 flex-1">
                            <!-- Toggle Button -->
                            <form action="{{ route('activities.toggle', $activity) }}" method="POST" class="shrink-0 pt-0.5 sm:pt-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-6 h-6 rounded-lg border flex items-center justify-center transition-colors {{ $activity->status === 'done' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 hover:border-blue-500 bg-white' }}"
                                        title="{{ $activity->status === 'done' ? 'Mark Planned' : 'Mark Done' }}">
                                    @if ($activity->status === 'done')
                                        <i data-lucide="check" class="w-4 h-4 stroke-[3]"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900 {{ $activity->status === 'done' ? 'line-through text-slate-400' : '' }}">
                                        {{ $activity->title }}
                                    </h3>

                                    @php
                                        $isWork = $activity->category && (str_contains(strtolower($activity->category->name), 'work') || str_contains($activity->category->name, 'ការងារ') || $activity->category->type === 'work');
                                    @endphp
                                    @if ($isWork)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-md border border-indigo-200">
                                            <i data-lucide="briefcase" class="w-3 h-3"></i>
                                            <span>{{ __('app.modules.work') }}</span>
                                        </span>
                                    @endif

                                    @if ($activity->category)
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-md" 
                                              style="background-color: {{ $activity->category->color ? $activity->category->color . '20' : '#E2E8F0' }}; color: {{ $activity->category->color ?? '#475569' }};">
                                            {{ $activity->category->name }}
                                        </span>
                                    @endif
                                </div>

                                @if ($activity->description)
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $activity->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Time Slot & Actions -->
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="text-right">
                                <span class="inline-block text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">
                                    {{ \Carbon\Carbon::parse($activity->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }}
                                </span>
                                @if ($activity->duration_minutes)
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $activity->duration_minutes }} នាទី</p>
                                @endif
                            </div>

                            <!-- Delete Action -->
                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបសកម្មភាពនេះមែនទេ?');">
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
        @endif
    </div>

    <!-- Create Activity Modal (Alpine.js) -->
    <div x-cloak x-show="addModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.schedule.add_activity') }}</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('activities.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="activity_date" value="{{ $date }}">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងសកម្មភាព / Activity Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           placeholder="ឧ. ហាត់ប្រាណពេលព្រឹក, ប្រជុំគម្រោង..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Times: Start & End -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-xs font-semibold text-slate-700 mb-1">
                            ម៉ោងចាប់ផ្តើម / Start Time <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time" required value="08:00"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_time" class="block text-xs font-semibold text-slate-700 mb-1">
                            ម៉ោងបញ្ចប់ / End Time <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time" required value="09:00"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        {{ __('app.schedule.category') }}
                    </label>
                    <select name="category_id" id="category_id"
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- {{ __('app.actions.all') }} --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>



                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-semibold text-slate-700 mb-1">
                        បរិយាយលម្អិត / Description
                    </label>
                    <textarea name="description" id="description" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
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
