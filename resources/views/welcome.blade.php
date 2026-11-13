<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ __('app.name') }} — {{ __('app.tagline') }}</title>

    <!-- Google Fonts: Inter & Noto Sans Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Noto+Sans+Khmer:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-slate-100 antialiased bg-slate-900 selection:bg-blue-500 selection:text-white flex flex-col justify-between">
    <!-- Background Glow Accents -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl"></div>
    </div>

    <!-- Navigation Header -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-base shadow-lg shadow-blue-500/25">
                MDL
            </span>
            <div>
                <span class="font-extrabold text-white text-lg tracking-tight block leading-tight">My Daily Life</span>
                <span class="text-xs text-slate-400 font-medium block">ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ</span>
            </div>
        </div>

        <!-- Language Switcher & Auth Links -->
        <div class="flex items-center gap-3">
            @php
                $curr = app()->getLocale();
                $target = $curr === 'km' ? 'en' : 'km';
                $label = $curr === 'km' ? '🇬🇧 English' : '🇰🇭 ខ្មែរ';
            @endphp
            <a href="{{ route('locale.switch', $target) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors">
                {{ $label }}
            </a>

            @auth
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-md transition-colors">
                    {{ __('app.modules.dashboard') }} &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-300 hover:text-white transition-colors">
                    ចូលប្រើ / Log In
                </a>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-600/25 transition-colors">
                    ចុះឈ្មោះ / Register
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="relative z-10 flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 flex flex-col items-center text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            <span>ប្រព័ន្ធគ្រប់គ្រងជីវិតផ្ទាល់ខ្លួនកម្រិតវិជ្ជាជីវៈ &bull; Full-Stack Productivity</span>
        </div>

        <!-- Headline -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white max-w-4xl leading-tight sm:leading-tight">
            រៀបចំជីវិត ពេលវេលា និងហិរញ្ញវត្ថុរបស់អ្នក <br class="hidden sm:inline">
            <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-emerald-400 bg-clip-text text-transparent">
                ឱ្យកាន់តែមានតុល្យភាព និងប្រសិទ្ធភាពខ្ពស់
            </span>
        </h1>

        <!-- Subtitle -->
        <p class="mt-6 text-sm sm:text-base lg:text-lg text-slate-400 max-w-2xl leading-relaxed">
            <strong>My Daily Life</strong> ផ្តល់ជូននូវឧបករណ៍គ្រប់គ្រងទូលំទូលាយចំនួន <strong>១២ ម៉ូឌុល</strong> រួមមាន កាលវិភាគប្រចាំថ្ងៃ, ភារកិច្ចតាមអាទិភាព, ចំណូល-ចំណាយទ្វេរូបិយប័ណ្ណ (USD & KHR), ការតាមដានទម្លាប់ ៧ ថ្ងៃ, ផែនការសិក្សា, និងរបាយការណ៍ស្ថិតិលម្អិត។
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-3.5 w-full sm:w-auto">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl shadow-xl shadow-blue-600/30 transition-all transform active:scale-95 text-sm sm:text-base">
                    <span>ចូលទៅកាន់ផ្ទាំងគ្រប់គ្រង (Dashboard)</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl shadow-xl shadow-blue-600/30 transition-all transform active:scale-95 text-sm sm:text-base">
                    <span>ចាប់ផ្តើមប្រើប្រាស់ឥឡូវនេះ (Get Started Free)</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-800/80 hover:bg-slate-800 text-slate-300 font-semibold rounded-2xl border border-slate-700 transition-colors text-sm sm:text-base">
                    <span>ចូលគណនី (Sign In)</span>
                </a>
            @endauth
        </div>

        <!-- 12 Modules Feature Grid -->
        <div class="mt-20 w-full text-left">
            <h2 class="text-xl sm:text-2xl font-bold text-white text-center mb-8">
                ម៉ូឌុលគ្រប់គ្រងជីវិតទាំង ១២ (All 12 Core Modules)
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- 1. Schedule -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-3">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">កាលវិភាគប្រចាំថ្ងៃ (Daily Schedule)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">រៀបចំកាលវិភាគ ម៉ោងចាប់ផ្តើម-បញ្ចប់ និងគណនារយៈពេលស្វ័យប្រវត្ត។</p>
                </div>

                <!-- 2. Tasks -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-3">
                        <i data-lucide="check-square" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">ភារកិច្ច & អាទិភាព (Daily Tasks)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">បែងចែកកិច្ចការតាមអាទិភាព ខ្ពស់ មធ្យម ទាប និងតាមដាន Deadline។</p>
                </div>

                <!-- 3. Expenses -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-3">
                        <i data-lucide="wallet" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">ហិរញ្ញវត្ថុទ្វេរូបិយប័ណ្ណ (USD & KHR)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">កត់ត្រាចំណូល-ចំណាយជាប្រាក់ដុល្លារ និងរៀលខ្មែរ ដោយភាពសុក្រឹតខ្ពស់។</p>
                </div>

                <!-- 4. Habits -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-3">
                        <i data-lucide="flame" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">តាមដានទម្លាប់ ៧ ថ្ងៃ (Habit Tracker)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">តារាង check-in រង្វង់ ៧ ថ្ងៃចុងក្រោយ និងប្រព័ន្ធរាប់ streak ជាប់ៗគ្នា។</p>
                </div>

                <!-- 5. Goals -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center mb-3">
                        <i data-lucide="target" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">គោលដៅប្រចាំខែ (Monthly Goals)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">កំណត់គោលដៅយុទ្ធសាស្ត្រ និងកត់ត្រាវឌ្ឍនភាពតាមដំណាក់កាល។</p>
                </div>

                <!-- 6. Study -->
                <div class="p-5 rounded-2xl bg-slate-800/50 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center mb-3">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">ផែនការសិក្សា (Study Planner)</h3>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">គ្រប់គ្រងមុខវិជ្ជា និងកត់ត្រាម៉ោងស្រាវជ្រាវរៀនសូត្រជាក់ស្តែង។</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
        <div>
            &copy; {{ date('Y') }} <strong>My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ)</strong>. All rights reserved.
        </div>
        <div class="flex items-center gap-4">
            <a href="https://github.com/DARA-009/My-daily-life" target="_blank" class="hover:text-slate-300 transition-colors flex items-center gap-1.5">
                <i data-lucide="github" class="w-4 h-4"></i>
                <span>GitHub Repository</span>
            </a>
        </div>
    </footer>
</body>
</html>
