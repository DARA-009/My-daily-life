@extends('layouts.guest')

@php
    $locale = app()->getLocale();
@endphp

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-xs">
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
            {{ $locale === 'km' ? 'បង្កើតគណនីថ្មី' : 'Create Account' }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            {{ $locale === 'km' ? 'ចាប់ផ្តើមរៀបចំ និងគ្រប់គ្រងជីវិតប្រចាំថ្ងៃរបស់អ្នក' : 'Start organizing your daily life, finances, and habits' }}
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

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                {{ $locale === 'km' ? 'ឈ្មោះពេញ' : 'Full Name' }}
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Dara Chhoeun"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

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
                   autocomplete="username"
                   placeholder="name@example.com"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                {{ $locale === 'km' ? 'ពាក្យសម្ងាត់' : 'Password' }}
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                {{ $locale === 'km' ? 'បញ្ជាក់ពាក្យសម្ងាត់' : 'Confirm Password' }}
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-hidden transition-all placeholder:text-slate-400">
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-xs shadow-blue-600/20 transition-all focus:ring-2 focus:ring-blue-600/30">
            {{ $locale === 'km' ? 'ចុះឈ្មោះបង្កើតគណនី' : 'Create Account' }}
        </button>

        <!-- Login Link -->
        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            {{ $locale === 'km' ? 'មានគណនីរួចហើយមែនទេ?' : 'Already have an account?' }}
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline ml-1">
                {{ $locale === 'km' ? 'ចូលគណនី' : 'Sign In' }}
            </a>
        </div>
    </form>
</div>
@endsection
