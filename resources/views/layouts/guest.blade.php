<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'My Daily Life') : config('app.name', 'My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ)') }}</title>

    <!-- Google Fonts: Inter & Noto Sans Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-slate-900 antialiased overflow-x-hidden selection:bg-blue-500 selection:text-white flex flex-col justify-between min-h-screen-dvh">
    @php
        $currentLocale = app()->getLocale();
        $targetLocale = $currentLocale === 'km' ? 'en' : 'km';
        $targetLabel = $currentLocale === 'km' ? '🇬🇧 English' : '🇰🇭 ខ្មែរ';
    @endphp

    <!-- Top Language Switcher Bar -->
    <header class="w-full max-w-md mx-auto px-6 pt-safe pt-4 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">MDL</span>
            <span class="font-bold text-slate-900 text-sm">My Daily Life</span>
        </a>

        <a href="{{ route('locale.switch', $targetLocale) }}" 
           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg shadow-2xs transition-colors">
            <span>{{ $targetLabel }}</span>
        </a>
    </header>

    <!-- Center Card Canvas -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-md">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-md mx-auto px-6 pb-safe pb-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ). All rights reserved.
    </footer>
</body>
</html>
