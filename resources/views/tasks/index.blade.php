@extends('layouts.app', ['title' => __('app.tasks.title')])

@section('content')
<div x-data="{ addModalOpen: false }" class="space-y-6">
    <!-- Header with Kind Tabs & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.tasks.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.tasks.subtitle') }}</p>
        </div>

        <button type="button" 
                @click="addModalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('app.tasks.add_task') }}</span>
        </button>
    </div>

    <!-- Filter Bar: Kind Tabs, Priority Filters, Search -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <!-- Kind Tabs -->
        <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl overflow-x-auto text-xs font-semibold">
            @php $currentKind = request('kind'); @endphp
            <a href="{{ route('tasks.index', request()->except('kind', 'page')) }}" 
               class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($currentKind) ? 'bg-white text-blue-600 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                {{ __('app.actions.all') }}
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['kind' => 'personal'])) }}" 
               class="px-3.5 py-1.5 rounded-lg transition-colors {{ $currentKind === 'personal' ? 'bg-white text-blue-600 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                {{ __('app.tasks.kind_personal') }}
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['kind' => 'work'])) }}" 
               class="px-3.5 py-1.5 rounded-lg transition-colors {{ $currentKind === 'work' ? 'bg-white text-blue-600 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                {{ __('app.tasks.kind_work') }}
            </a>
            <a href="{{ route('tasks.index', array_merge(request()->except('page'), ['kind' => 'study'])) }}" 
               class="px-3.5 py-1.5 rounded-lg transition-colors {{ $currentKind === 'study' ? 'bg-white text-blue-600 shadow-2xs font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                {{ __('app.tasks.kind_study') }}
            </a>
        </div>

        <!-- Search & Priority Filters -->
        <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center gap-2">
            @if (request('kind'))
                <input type="hidden" name="kind" value="{{ request('kind') }}">
            @endif

            <select name="priority" onchange="this.form.submit()"
                    class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:ring-2 focus:ring-blue-500">
                <option value="">-- អាទិភាពទាំងអស់ --</option>
                <option value="high" @selected(request('priority') === 'high')>🔥 {{ __('app.priority.high') }}</option>
                <option value="medium" @selected(request('priority') === 'medium')>⚡ {{ __('app.priority.medium') }}</option>
                <option value="low" @selected(request('priority') === 'low')>🌱 {{ __('app.priority.low') }}</option>
            </select>

            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:ring-2 focus:ring-blue-500">
                <option value="">-- ស្ថានភាព --</option>
                <option value="pending" @selected(request('status') === 'pending')>{{ __('app.status.pending') }}</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>{{ __('app.status.in_progress') }}</option>
                <option value="completed" @selected(request('status') === 'completed')>{{ __('app.status.completed') }}</option>
            </select>
        </form>
    </div>

    <!-- Tasks List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        @if ($tasks->isEmpty())
            <div class="py-16 text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="check-square" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('app.tasks.empty') }}</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">បង្កើតភារកិច្ចថ្មីដើម្បីរៀបចំការងារឱ្យកាន់តែមានរបៀបរៀបរយ។</p>
                <button type="button" 
                        @click="addModalOpen = true"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>{{ __('app.tasks.add_task') }}</span>
                </button>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($tasks as $task)
                    <div class="p-4 sm:p-5 flex items-start sm:items-center justify-between gap-4 hover:bg-slate-50/75 transition-colors">
                        <!-- Left: Status Checkbox & Content -->
                        <div class="flex items-start sm:items-center gap-3.5 min-w-0 flex-1">
                            <!-- Toggle Button -->
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="shrink-0 pt-0.5 sm:pt-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-6 h-6 rounded-lg border flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 hover:border-blue-500 bg-white' }}"
                                        title="{{ $task->status === 'completed' ? 'Mark Pending' : 'Mark Completed' }}">
                                    @if ($task->status === 'completed')
                                        <i data-lucide="check" class="w-4 h-4 stroke-[3]"></i>
                                    @endif
                                </button>
                            </form>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900 {{ $task->status === 'completed' ? 'line-through text-slate-400' : '' }}">
                                        {{ $task->title }}
                                    </h3>

                                    <!-- Priority Badge -->
                                    @if ($task->priority === 'high')
                                        <span class="text-[11px] font-bold px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-md">
                                            🔥 ខ្ពស់
                                        </span>
                                    @elseif ($task->priority === 'medium')
                                        <span class="text-[11px] font-medium px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md">
                                            ⚡ មធ្យម
                                        </span>
                                    @else
                                        <span class="text-[11px] font-medium px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">
                                            🌱 ទាប
                                        </span>
                                    @endif

                                    <!-- Kind Badge -->
                                    <span class="text-[11px] font-medium px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md">
                                        {{ __('app.tasks.kind_' . $task->kind) }}
                                    </span>

                                    <!-- Category Badge -->
                                    @if ($task->category)
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-md" 
                                              style="background-color: {{ $task->category->color ? $task->category->color . '20' : '#E2E8F0' }}; color: {{ $task->category->color ?? '#475569' }};">
                                            {{ $task->category->name }}
                                        </span>
                                    @endif
                                </div>

                                @if ($task->description)
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $task->description }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Due Date & Delete -->
                        <div class="flex items-center gap-3 shrink-0">
                            @if ($task->due_date)
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-700' }}">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        <span>{{ $task->due_date->format('d M Y') }}</span>
                                    </span>
                                </div>
                            @endif

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបភារកិច្ចនេះមែនទេ?');">
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

            <!-- Pagination -->
            @if ($tasks->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Task Modal (Alpine.js) -->
    <div x-cloak x-show="addModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.tasks.add_task') }}</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងភារកិច្ច / Task Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           placeholder="ឧ. បញ្ចប់របាយការណ៍ប្រចាំខែ, ទិញសៀវភៅ..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Kind & Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kind" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.tasks.kind') }} <span class="text-rose-500">*</span>
                        </label>
                        <select name="kind" id="kind" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="personal">{{ __('app.tasks.kind_personal') }}</option>
                            <option value="work">{{ __('app.tasks.kind_work') }}</option>
                            <option value="study">{{ __('app.tasks.kind_study') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-xs font-semibold text-slate-700 mb-1">
                            អាទិភាព / Priority <span class="text-rose-500">*</span>
                        </label>
                        <select name="priority" id="priority" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="medium">{{ __('app.priority.medium') }}</option>
                            <option value="high">{{ __('app.priority.high') }}</option>
                            <option value="low">{{ __('app.priority.low') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Due Date & Category -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.tasks.due_date') }}
                        </label>
                        <input type="date" name="due_date" id="due_date"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1">
                            ជំពូក / Category
                        </label>
                        <select name="category_id" id="category_id"
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">-- {{ __('app.actions.all') }} --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
