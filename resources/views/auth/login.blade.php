@extends('layouts.guest')

@php
    $locale = app()->getLocale();
@endphp

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs">
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
            {{ $locale === 'km' ? 'ចូលប្រើប្រាស់គណនី' : 'Welcome Back' }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            {{ $locale === 'km' ? 'សូមបញ្ចូលអ៊ីមែល និងពាក្យសម្ងាត់របស់អ្នកដើម្បីបន្ត' : 'Sign in to access your personal dashboard' }}
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                {{ $locale === 'km' ? 'អាសយដ្ឋានអ៊ីមែល' : 'Email Address' }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="name@example.com"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-700">
                    {{ $locale === 'km' ? 'ពាក្យសម្ងាត់' : 'Password' }}
                </label>
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center gap-2 cursor-pointer">
                <input id="remember" 
                       type="checkbox" 
                       name="remember"
                       class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                <span class="text-xs text-slate-600 select-none">
                    {{ $locale === 'km' ? 'ចងចាំខ្ញុំ' : 'Remember me' }}
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-xs shadow-blue-600/20 transition-all focus:ring-2 focus:ring-blue-600/30">
            {{ $locale === 'km' ? 'ចូលគណនី' : 'Sign In' }}
        </button>

        <!-- Register Link -->
        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            {{ $locale === 'km' ? 'មិនទាន់មានគណនីមែនទេ?' : "Don't have an account?" }}
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline ml-1">
                {{ $locale === 'km' ? 'ចុះឈ្មោះនៅទីនេះ' : 'Create account' }}
            </a>
        </div>
    </form>
</div>
@endsection
