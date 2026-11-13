@php
    $navItems = [
        ['name' => 'dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard', 'label_km' => 'ផ្ទាំងគ្រប់គ្រង', 'label_en' => 'Dashboard'],
        ['name' => 'profile', 'route' => 'profile.index', 'icon' => 'user-circle', 'label_km' => 'ប្រវត្តិរូបផ្ទាល់ខ្លួន', 'label_en' => 'Personal Profile'],
        ['name' => 'schedule', 'route' => 'schedule.index', 'icon' => 'calendar-days', 'label_km' => 'កាលវិភាគប្រចាំថ្ងៃ', 'label_en' => 'Daily Schedule'],
        ['name' => 'tasks', 'route' => 'tasks.index', 'icon' => 'check-square', 'label_km' => 'កិច្ចការប្រចាំថ្ងៃ', 'label_en' => 'Daily Tasks'],
        ['name' => 'expenses', 'route' => 'expenses.index', 'icon' => 'wallet', 'label_km' => 'ចំណាយ & ចំណូល', 'label_en' => 'Daily Expenses'],
        ['name' => 'goals', 'route' => 'goals.index', 'icon' => 'target', 'label_km' => 'គោលដៅប្រចាំខែ', 'label_en' => 'Monthly Goals'],
        ['name' => 'study', 'route' => 'study.index', 'icon' => 'graduation-cap', 'label_km' => 'ផែនការសិក្សា', 'label_en' => 'Study Planner'],
        ['name' => 'work', 'route' => 'work.index', 'icon' => 'briefcase', 'label_km' => 'សកម្មភាពការងារ', 'label_en' => 'Work Activities'],
        ['name' => 'habits', 'route' => 'habits.index', 'icon' => 'flame', 'label_km' => 'តាមដានទម្លាប់', 'label_en' => 'Habit Tracker'],
        ['name' => 'skills', 'route' => 'skills.index', 'icon' => 'sparkles', 'label_km' => 'អភិវឌ្ឍន៍ជំនាញ', 'label_en' => 'Skills Development'],
        ['name' => 'notes', 'route' => 'notes.index', 'icon' => 'file-text', 'label_km' => 'កំណត់ត្រាផ្ទាល់ខ្លួន', 'label_en' => 'Personal Notes'],
        ['name' => 'reports', 'route' => 'reports.index', 'icon' => 'bar-chart-3', 'label_km' => 'របាយការណ៍ & ទិន្នន័យ', 'label_en' => 'Reports & Analytics'],
        ['name' => 'settings', 'route' => 'settings.index', 'icon' => 'settings', 'label_km' => 'ការកំណត់ប្រព័ន្ធ', 'label_en' => 'Settings'],
    ];
    $locale = app()->getLocale();
@endphp

<div class="flex flex-col h-full bg-white border-r border-slate-200">
    <!-- Brand Logo -->
    <div class="flex items-center gap-3 px-6 h-16 border-b border-slate-200">
        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-sm shadow-blue-500/20">
            MDL
        </div>
        <div>
            <span class="font-bold text-slate-900 tracking-tight text-base block leading-tight">My Daily Life</span>
            <span class="text-[11px] text-slate-500 font-medium block">ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ</span>
        </div>
    </div>

    <!-- Navigation Menu Items -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @foreach ($navItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) || request()->routeIs($item['name'] . '.*');
                $label = $locale === 'km' ? $item['label_km'] : $item['label_en'];
                $url = Route::has($item['route']) ? route($item['route']) : '#';
            @endphp
            <a href="{{ $url }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isActive ? 'bg-blue-50 text-blue-600 font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 {{ $isActive ? 'text-blue-600 stroke-[2.2]' : 'text-slate-500 stroke-[1.8]' }}"></i>
                <span class="truncate">{{ $label }}</span>
                @if ($isActive)
                    <span class="ml-auto w-1.5 h-4 bg-blue-600 rounded-full"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <!-- Quick User Footer -->
    <div class="p-3 border-t border-slate-200">
        <div class="flex items-center gap-3 p-2 rounded-lg bg-slate-50 border border-slate-100">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-900 truncate">{{ auth()->user()->name ?? 'My Account' }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email ?? 'user@example.test' }}</p>
            </div>
        </div>
    </div>
</div>
