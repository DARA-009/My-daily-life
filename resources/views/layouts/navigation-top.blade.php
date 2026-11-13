@php
    $currentLocale = app()->getLocale();
    $targetLocale = $currentLocale === 'km' ? 'en' : 'km';
    $targetLabel = $currentLocale === 'km' ? '🇬🇧 English' : '🇰🇭 ខ្មែរ';
@endphp

<div class="h-16 px-4 lg:px-8 flex items-center justify-between gap-4">
    <!-- Left: Mobile Brand & Drawer Toggle -->
    <div class="flex items-center gap-3 lg:hidden">
        <button type="button" 
                @click="moreMenuOpen = true"
                class="p-2 -ml-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-hidden"
                aria-label="Open navigation menu">
            <i data-lucide="menu" class="w-6 h-6 stroke-[2]"></i>
        </button>
        <div class="flex items-center gap-2">
            <span class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs">MDL</span>
            <span class="font-bold text-slate-900 text-sm">My Daily Life</span>
        </div>
    </div>

    <!-- Desktop: Universal Quick Search Trigger -->
    <div class="hidden lg:flex items-center flex-1 max-w-md">
        <button type="button" 
                class="w-full flex items-center justify-between px-3.5 py-2 text-sm text-slate-400 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg transition-colors">
            <span class="flex items-center gap-2.5">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                <span>{{ $currentLocale === 'km' ? 'ស្វែងរកកិច្ចការ, កំណត់ត្រា, កាលវិភាគ...' : 'Search tasks, notes, schedule...' }}</span>
            </span>
            <kbd class="px-1.5 py-0.5 text-[11px] font-semibold text-slate-500 bg-white border border-slate-200 rounded-sm shadow-2xs">Ctrl K</kbd>
        </button>
    </div>

    <!-- Right Controls: Language Switcher, Notifications, User -->
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Language Switcher -->
        <a href="{{ route('locale.switch', $targetLocale) }}" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors"
           title="Switch language">
            <span>{{ $targetLabel }}</span>
        </a>

        <!-- Notification Bell -->
        <button type="button" 
                class="relative p-2 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors"
                aria-label="Notifications">
            <i data-lucide="bell" class="w-5 h-5 stroke-[1.8]"></i>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-blue-600 rounded-full ring-2 ring-white"></span>
        </button>

        <!-- User Profile Pill / Menu -->
        <a href="{{ route('profile.index') }}" 
           class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-full hover:bg-slate-100 transition-colors">
            <span class="hidden sm:block text-xs font-medium text-slate-700 text-right">
                <span class="block font-semibold text-slate-900">{{ auth()->user()->name ?? 'Dara' }}</span>
            </span>
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                {{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 1)) }}
            </div>
        </a>
    </div>
</div>
