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
