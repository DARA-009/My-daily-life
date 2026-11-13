@extends('layouts.app', ['title' => __('app.study.title')])

@section('content')
<div x-data="{ addSubjectModal: false, logSessionModal: false }" class="space-y-6">
    <!-- Header with Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.study.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.study.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" 
                    @click="addSubjectModal = true"
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl shadow-2xs transition-colors">
                <i data-lucide="book-plus" class="w-4 h-4 text-blue-600"></i>
                <span>{{ __('app.study.add_subject') }}</span>
            </button>

            <button type="button" 
                    @click="logSessionModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.study.log_session') }}</span>
            </button>
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- 1. Total Study Hours -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.study.total_hours') }}</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $totalHours }} <span class="text-sm font-medium text-slate-500">ម៉ោង ({{ $totalMinutes }} នាទី)</span></p>
            </div>
        </div>

        <!-- 2. Subjects Count -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="book-open" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.study.subjects') }}</span>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $subjects->count() }}</p>
            </div>
        </div>

        <!-- 3. Study Sessions Count -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="graduation-cap" class="w-6 h-6 stroke-[2]"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('app.study.sessions') }}</span>
                <p class="text-2xl font-bold text-emerald-600 mt-0.5">{{ $sessions->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Subjects Cards Grid -->
    <div>
        <h2 class="text-base font-bold text-slate-900 mb-3 flex items-center gap-2">
            <i data-lucide="layers" class="w-4 h-4 text-blue-600"></i>
            <span>{{ __('app.study.subjects') }}</span>
        </h2>

        @if ($subjects->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center">
                <p class="text-xs text-slate-400">មិនទាន់មានមុខវិជ្ជាណាមួយត្រូវបានបន្ថែមនៅឡើយទេ។ ចុច "បន្ថែមមុខវិជ្ជាថ្មី" ដើម្បីចាប់ផ្តើម។</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($subjects as $subject)
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                    {{ mb_substr($subject->name, 0, 1) }}
                                </span>
                                <span class="text-[11px] font-semibold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">
                                    {{ $subject->study_sessions_count }} វគ្គ
                                </span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900">{{ $subject->name }}</h3>
                            @if ($subject->learning_target)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $subject->learning_target }}</p>
                            @endif
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">គោលដៅ: {{ $subject->target_hours ? $subject->target_hours . 'h' : 'គ្មាន' }}</span>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមុខវិជ្ជានេះមែនទេ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 p-1">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Recent Sessions History -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="history" class="w-5 h-5 text-indigo-600"></i>
                <span>{{ __('app.study.sessions') }}</span>
            </h2>
        </div>

        @if ($sessions->isEmpty())
            <div class="py-12 text-center px-4">
                <i data-lucide="clock" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                <p class="text-xs text-slate-400">{{ __('app.study.empty') }}</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($sessions as $session)
                    <div class="p-4 sm:p-5 flex items-center justify-between gap-4 hover:bg-slate-50/75 transition-colors">
                        <div class="flex items-center gap-3.5 min-w-0 flex-1">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="book-open" class="w-5 h-5"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-slate-900">{{ $session->subject->name ?? 'Subject' }}</h3>
                                    @if ($session->topic)
                                        <span class="text-xs text-slate-500">— {{ $session->topic }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-slate-400 mt-0.5 block">
                                    {{ $session->session_date->format('d M Y') }} &bull; {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span class="text-xs sm:text-sm font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">
                                {{ $session->duration_minutes }} នាទី
                            </span>

                            <form action="{{ route('study-sessions.destroy', $session) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបកំណត់ត្រានេះមែនទេ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($sessions->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $sessions->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Add Subject Modal -->
    <div x-cloak x-show="addSubjectModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addSubjectModal = false" 
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.study.add_subject') }}</h3>
                <button type="button" @click="addSubjectModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('subjects.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="sub_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        ឈ្មោះមុខវិជ្ជា / Subject Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="sub_name" required placeholder="ឧ. PHP/Laravel, English IELTS, AI Research..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="target_hours" class="block text-xs font-semibold text-slate-700 mb-1">
                        ម៉ោងគោលដៅ (Target Hours)
                    </label>
                    <input type="number" step="0.5" name="target_hours" id="target_hours" placeholder="50"
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="learning_target" class="block text-xs font-semibold text-slate-700 mb-1">
                        គោលបំណងនៃការរៀន / Objectives
                    </label>
                    <textarea name="learning_target" id="learning_target" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addSubjectModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Log Study Session Modal -->
    <div x-cloak x-show="logSessionModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="logSessionModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.study.log_session') }}</h3>
                <button type="button" @click="logSessionModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('study-sessions.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="sess_subject" class="block text-xs font-semibold text-slate-700 mb-1">
                        មុខវិជ្ជា / Subject <span class="text-rose-500">*</span>
                    </label>
                    <select name="subject_id" id="sess_subject" required
                            class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="sess_date" class="block text-xs font-semibold text-slate-700 mb-1">កាលបរិច្ឆេទ</label>
                        <input type="date" name="session_date" id="sess_date" required value="{{ date('Y-m-d') }}"
                               class="w-full px-2.5 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="sess_start" class="block text-xs font-semibold text-slate-700 mb-1">ម៉ោងចាប់ផ្តើម</label>
                        <input type="time" name="start_time" id="sess_start" required value="14:00"
                               class="w-full px-2.5 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="sess_end" class="block text-xs font-semibold text-slate-700 mb-1">ម៉ោងបញ្ចប់</label>
                        <input type="time" name="end_time" id="sess_end" required value="15:30"
                               class="w-full px-2.5 py-2 bg-white border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="sess_topic" class="block text-xs font-semibold text-slate-700 mb-1">
                        ប្រធានបទដែលបានរៀន / Topic
                    </label>
                    <input type="text" name="topic" id="sess_topic" placeholder="ឧ. Eloquent Relationships, KaTeX Formula..."
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="sess_notes" class="block text-xs font-semibold text-slate-700 mb-1">កំណត់ត្រាបន្ថែម / Notes</label>
                    <textarea name="notes" id="sess_notes" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="logSessionModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
