@php
    $locale = app()->getLocale();
    $mobileTabs = [
        ['name' => 'dashboard', 'route' => 'dashboard', 'icon' => 'home', 'label_km' => 'ទំព័រដើម', 'label_en' => 'Home'],
        ['name' => 'schedule', 'route' => 'schedule.index', 'icon' => 'calendar-days', 'label_km' => 'កាលវិភាគ', 'label_en' => 'Schedule'],
        ['name' => 'expenses', 'route' => 'expenses.index', 'icon' => 'wallet', 'label_km' => 'ចំណាយ', 'label_en' => 'Expenses'],
        ['name' => 'goals', 'route' => 'goals.index', 'icon' => 'target', 'label_km' => 'គោលដៅ', 'label_en' => 'Goals'],
        ['name' => 'profile', 'route' => 'profile.index', 'icon' => 'user-circle', 'label_km' => 'ប្រវត្តិរូប', 'label_en' => 'Profile'],
    ];
@endphp

<div class="h-16 px-2 grid grid-cols-5 items-center">
    @foreach ($mobileTabs as $tab)
        @php
            $isActive = request()->routeIs($tab['route']) || request()->routeIs($tab['name'] . '.*');
            $label = $locale === 'km' ? $tab['label_km'] : $tab['label_en'];
            $url = Route::has($tab['route']) ? route($tab['route']) : '#';
        @endphp
        <a href="{{ $url }}" 
           class="flex flex-col items-center justify-center py-1 rounded-lg transition-colors {{ $isActive ? 'text-blue-600 font-semibold' : 'text-slate-500 hover:text-slate-900 font-medium' }}">
            <i data-lucide="{{ $tab['icon'] }}" class="w-5 h-5 {{ $isActive ? 'stroke-[2.2]' : 'stroke-[1.8]' }}"></i>
            <span class="text-[11px] mt-0.5 leading-none truncate max-w-[70px]">{{ $label }}</span>
        </a>
    @endforeach
</div>
