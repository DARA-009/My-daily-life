@extends('layouts.app', ['title' => __('app.settings.title')])

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.settings.title') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('app.settings.subtitle') }}</p>
    </div>

    <!-- 1. System Preferences Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="sliders" class="w-5 h-5 text-blue-600"></i>
                <span>ចំណូលចិត្តប្រព័ន្ធ / General Preferences</span>
            </h2>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Interface Language -->
                <div>
                    <label for="locale" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.language') }}
                    </label>
                    <select name="locale" id="locale" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="km" @selected(old('locale', $settings->locale) === 'km')>🇰🇭 ភាសាខ្មែរ (Khmer - Noto Sans Khmer)</option>
                        <option value="en" @selected(old('locale', $settings->locale) === 'en')>🇬🇧 English (Inter)</option>
                    </select>
                </div>

                <!-- Default Currency -->
                <div>
                    <label for="default_currency" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.currency') }}
                    </label>
                    <select name="default_currency" id="default_currency" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="USD" @selected(old('default_currency', $settings->default_currency) === 'USD')>USD ($ - US Dollar)</option>
                        <option value="KHR" @selected(old('default_currency', $settings->default_currency) === 'KHR')>KHR (៛ - រៀលខ្មែរ)</option>
                    </select>
                </div>

                <!-- Timezone -->
                <div class="md:col-span-2">
                    <label for="timezone" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.timezone') }}
                    </label>
                    <select name="timezone" id="timezone" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Asia/Phnom_Penh" @selected(old('timezone', $settings->timezone) === 'Asia/Phnom_Penh')>Asia/Phnom Penh (GMT+7)</option>
                        <option value="Asia/Bangkok" @selected(old('timezone', $settings->timezone) === 'Asia/Bangkok')>Asia/Bangkok (GMT+7)</option>
                        <option value="Asia/Singapore" @selected(old('timezone', $settings->timezone) === 'Asia/Singapore')>Asia/Singapore (GMT+8)</option>
                        <option value="UTC" @selected(old('timezone', $settings->timezone) === 'UTC')>UTC (Universal Coordinated Time)</option>
                    </select>
                </div>

                <!-- Notification Checkboxes -->
                <div class="md:col-span-2 space-y-3 pt-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="notify_in_app" value="1"
                               @checked(old('notify_in_app', $settings->notify_in_app))
                               class="w-4 h-4 text-blue-600 rounded-md border-slate-300 focus:ring-blue-500">
                        <span class="text-sm font-medium text-slate-700">ទទួលការជូនដំណឹងក្នុងប្រព័ន្ធ (In-App Alerts)</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="notify_email" value="1"
                               @checked(old('notify_email', $settings->notify_email))
                               class="w-4 h-4 text-blue-600 rounded-md border-slate-300 focus:ring-blue-500">
                        <span class="text-sm font-medium text-slate-700">ទទួលសារសង្ខេបប្រចាំសប្តាហ៍តាមអ៊ីមែល (Weekly Email Summary)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-200">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>{{ __('app.actions.save') }}</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Security & Password Change Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-indigo-600"></i>
                <span>{{ __('app.settings.security') }}</span>
            </h2>
        </div>

        <form action="{{ route('settings.password') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4 max-w-md">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.current_password') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-rose-500 @enderror">
                    @error('current_password')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.new_password') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-rose-500 @enderror">
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ __('app.settings.confirm_password') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-200">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                    <i data-lucide="key" class="w-4 h-4"></i>
                    <span>ផ្លាស់ប្តូរពាក្យសម្ងាត់ / Update Password</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
