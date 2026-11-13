@extends('layouts.app', ['title' => __('app.profile.title')])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.profile.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.profile.subtitle') }}</p>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <!-- Banner / Header Accent -->
        <div class="h-28 sm:h-36 bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 relative"></div>

        <div class="px-6 pb-6 pt-0 relative">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 -mt-12 sm:-mt-16 mb-6">
                <div class="flex items-end gap-4">
                    <div class="relative">
                        @if ($profile->photo_path)
                            <img src="{{ asset('storage/' . $profile->photo_path) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover ring-4 ring-white bg-slate-100 shadow-md">
                        @else
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold text-3xl flex items-center justify-center ring-4 ring-white shadow-md">
                                {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-1">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.name') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" required
                               value="{{ old('full_name', $profile->full_name ?? $user->name) }}"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('full_name') border-rose-500 @enderror">
                        @error('full_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read-Only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.email') }}
                        </label>
                        <input type="email" id="email" disabled value="{{ $user->email }}"
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.birthdate') }}
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                               value="{{ old('date_of_birth', optional($profile->date_of_birth)->format('Y-m-d')) }}"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-rose-500 @enderror">
                        @error('date_of_birth')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.gender') }}
                        </label>
                        <select name="gender" id="gender"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-rose-500 @enderror">
                            <option value="">-- {{ __('app.actions.all') }} --</option>
                            <option value="male" @selected(old('gender', $profile->gender) === 'male')>{{ __('app.profile.male') }}</option>
                            <option value="female" @selected(old('gender', $profile->gender) === 'female')>{{ __('app.profile.female') }}</option>
                            <option value="other" @selected(old('gender', $profile->gender) === 'other')>{{ __('app.profile.other') }}</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">
                            លេខទូរស័ព្ទ / Phone Number
                        </label>
                        <input type="tel" name="phone" id="phone"
                               value="{{ old('phone', $profile->phone) }}"
                               placeholder="+855 12 345 678"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Avatar Upload -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.avatar') }} (PNG, JPG, Max 2MB)
                        </label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-hidden">
                        @error('photo')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">
                            អាសយដ្ឋានបច្ចុប្បន្ន / Address
                        </label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $profile->address) }}"
                               placeholder="Phnom Penh, Cambodia"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('app.profile.bio') }}
                        </label>
                        <textarea name="bio" id="bio" rows="4"
                                  placeholder="Write a brief overview of your background, daily passions, or professional focus..."
                                  class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-200">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>{{ __('app.actions.save') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
