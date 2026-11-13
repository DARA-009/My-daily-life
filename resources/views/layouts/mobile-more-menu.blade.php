@php
    $locale = app()->getLocale();
    $extraModules = [
        ['name' => 'tasks', 'route' => 'tasks.index', 'icon' => 'check-square', 'label_km' => 'កិច្ចការប្រចាំថ្ងៃ', 'label_en' => 'Daily Tasks', 'desc_km' => 'គ្រប់គ្រងភារកិច្ច & អាទិភាព', 'desc_en' => 'Manage tasks and priorities'],
        ['name' => 'study', 'route' => 'study.index', 'icon' => 'graduation-cap', 'label_km' => 'ផែនការសិក្សា', 'label_en' => 'Study Planner', 'desc_km' => 'មុខវិជ្ជា & ម៉ោងសិក្សា', 'desc_en' => 'Courses and study sessions'],
        ['name' => 'work', 'route' => 'work.index', 'icon' => 'briefcase', 'label_km' => 'សកម្មភាពការងារ', 'label_en' => 'Work Activities', 'desc_km' => 'គម្រោងការងារ & Deadline', 'desc_en' => 'Projects and deadlines'],
        ['name' => 'habits', 'route' => 'habits.index', 'icon' => 'flame', 'label_km' => 'តាមដានទម្លាប់', 'label_en' => 'Habit Tracker', 'desc_km' => 'រក្សាទម្លាប់ល្អជារៀងរាល់ថ្ងៃ', 'desc_en' => 'Build daily and weekly routines'],
        ['name' => 'skills', 'route' => 'skills.index', 'icon' => 'sparkles', 'label_km' => 'អភិវឌ្ឍន៍ជំនាញ', 'label_en' => 'Skills Development', 'desc_km' => 'Design, English, Code, etc.', 'desc_en' => 'Design, English, Code, etc.'],
        ['name' => 'notes', 'route' => 'notes.index', 'icon' => 'file-text', 'label_km' => 'កំណត់ត្រាផ្ទាល់ខ្លួន', 'label_en' => 'Personal Notes', 'desc_km' => 'គំនិត & សេចក្តីព្រាងសំខាន់ៗ', 'desc_en' => 'Quick ideas and documents'],
        ['name' => 'reports', 'route' => 'reports.index', 'icon' => 'bar-chart-3', 'label_km' => 'របាយការណ៍ & ទិន្នន័យ', 'label_en' => 'Reports & Analytics', 'desc_km' => 'ស្ថិតិផលិតភាព & ហិរញ្ញវត្ថុ', 'desc_en' => 'Productivity and finance stats'],
        ['name' => 'settings', 'route' => 'settings.index', 'icon' => 'settings', 'label_km' => 'ការកំណត់ប្រព័ន្ធ', 'label_en' => 'Settings', 'desc_km' => 'ភាសា, រូបិយប័ណ្ណ, សុវត្ថិភាព', 'desc_en' => 'Locale, currency, security'],
    ];
@endphp

<!-- Mobile Slide-over Drawer -->
<div x-show="moreMenuOpen" 
     x-cloak
     class="relative z-50 lg:hidden" 
     aria-labelledby="slide-over-title" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Backdrop overlay -->
    <div x-show="moreMenuOpen"
         x-transition:enter="ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="moreMenuOpen = false"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
                <div x-show="moreMenuOpen"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="pointer-events-auto w-screen max-w-xs bg-white shadow-xl flex flex-col">
                    
                    <!-- Drawer Header with Safe Area Top -->
                    <div class="p-4 border-b border-slate-200 flex items-center justify-between pt-safe bg-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-xs">MDL</span>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900" id="slide-over-title">
                                    {{ $locale === 'km' ? 'ម៉ឺនុយទាំងអស់' : 'All Modules' }}
                                </h2>
                                <p class="text-[11px] text-slate-500">My Daily Life</p>
                            </div>
                        </div>
                        <button type="button" 
                                @click="moreMenuOpen = false"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Drawer Navigation Links -->
                    <div class="flex-1 overflow-y-auto p-3 space-y-1">
                        @foreach ($extraModules as $mod)
                            @php
                                $isActive = request()->routeIs($mod['route']) || request()->routeIs($mod['name'] . '.*');
                                $label = $locale === 'km' ? $mod['label_km'] : $mod['label_en'];
                                $desc = $locale === 'km' ? $mod['desc_km'] : $mod['desc_en'];
                                $url = Route::has($mod['route']) ? route($mod['route']) : '#';
                            @endphp
                            <a href="{{ $url }}"
                               @click="moreMenuOpen = false"
                               class="flex items-center gap-3 p-2.5 rounded-lg transition-colors {{ $isActive ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                                <div class="w-9 h-9 rounded-lg {{ $isActive ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $mod['icon'] }}" class="w-5 h-5"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium leading-tight truncate">{{ $label }}</p>
                                    <p class="text-[11px] text-slate-400 leading-tight truncate mt-0.5">{{ $desc }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Drawer Footer with Safe Area Bottom -->
                    <div class="p-4 border-t border-slate-200 pb-safe bg-slate-50">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span>Version 1.0.0</span>
                            <span>PHP 8.5 &bull; Laravel 13</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
