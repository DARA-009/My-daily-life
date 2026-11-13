<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'My Daily Life') : config('app.name', 'My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ)') }}</title>

    <!-- PWA & Mobile Web App Meta Tags (iPhone 14 Pro Max Home Screen) -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.svg') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Daily Life">
    <meta name="theme-color" content="#2563EB">

    <!-- Google Fonts: Inter & Noto Sans Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine cloak utility -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full text-slate-900 antialiased overflow-x-hidden selection:bg-blue-500 selection:text-white"
      x-data="{ moreMenuOpen: false }">

    <div class="min-h-screen-dvh flex flex-col lg:flex-row">
        <!-- 1. Desktop Fixed Sidebar (13 Modules) -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 z-30">
            @include('layouts.navigation-sidebar')
        </aside>

        <!-- 2. Main Container (with offset on desktop for fixed sidebar) -->
        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            <!-- Top Bar Navigation with iOS Safe Area Top -->
            <header class="sticky top-0 z-20 bg-white/95 backdrop-blur-md border-b border-slate-200 pt-safe">
                @include('layouts.navigation-top')
            </header>

            <!-- Main Page Dynamic Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto pb-24 lg:pb-8">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-rose-500 hover:text-rose-700">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @endif
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>

        <!-- 3. Mobile Safari Sticky Bottom Navigation (iPhone 14 Pro Max 5 Tabs) -->
        <nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 pb-safe">
            @include('layouts.navigation-bottom-mobile')
        </nav>

        <!-- 4. Mobile Slide-over Drawer ("More" Menu) -->
        @include('layouts.mobile-more-menu')
    </div>
</body>
</html>
