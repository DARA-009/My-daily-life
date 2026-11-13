@extends('layouts.app', ['title' => __('app.skills.title')])

@section('content')
<div x-data="{ addSkillModal: false, logPracticeModal: false, activeSkill: null }" class="space-y-6">
    <!-- Header with Add Skill Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.skills.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.skills.subtitle') }}</p>
        </div>

        <button type="button" 
                @click="addSkillModal = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors self-start sm:self-auto">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('app.skills.add_skill') }}</span>
        </button>
    </div>

    <!-- Skills Cards Grid -->
    @if ($skills->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs py-16 text-center px-4">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                <i data-lucide="award" class="w-7 h-7"></i>
            </div>
            <h3 class="text-base font-semibold text-slate-800">{{ __('app.skills.empty') }}</h3>
            <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">កត់ត្រា និងពង្រឹងជំនាញសំខាន់ៗរបស់អ្នក ដូចជាភាសាបរទេស, ការសរសេរកូដ, ឬការទំនាក់ទំនង។</p>
            <button type="button" 
                    @click="addSkillModal = true"
                    class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.skills.add_skill') }}</span>
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($skills as $skill)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-5 flex flex-col justify-between hover:shadow-xs transition-shadow">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @if ($skill->category)
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md"
                                      style="background-color: {{ $skill->category->color ? $skill->category->color . '20' : '#E2E8F0' }}; color: {{ $skill->category->color ?? '#475569' }};">
                                    {{ $skill->category->name }}
                                </span>
                            @else
                                <span class="text-[11px] font-semibold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">General</span>
                            @endif

                            <div class="flex items-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="text-xs {{ $i <= $skill->current_level ? 'text-amber-500' : 'text-slate-200' }}">★</span>
                                @endfor
                            </div>
                        </div>

                        <h3 class="text-base font-bold text-slate-900">{{ $skill->name }}</h3>
                        @if ($skill->description)
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $skill->description }}</p>
                        @endif

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500">កម្រិតបច្ចុប្បន្ន: <strong class="text-slate-900">កម្រិត {{ $skill->current_level }}/5</strong></span>
                            <span class="text-slate-500">គោលដៅ: <strong class="text-blue-600">កម្រិត {{ $skill->target_level }}/5</strong></span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between gap-2 pt-4 mt-4 border-t border-slate-100">
                        <button type="button" 
                                @click="activeSkill = {{ json_encode(['id' => $skill->id, 'name' => $skill->name, 'level' => $skill->current_level]) }}; logPracticeModal = true"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                            <span>{{ __('app.skills.log_practice') }}</span>
                        </button>

                        <form action="{{ route('skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបជំនាញនេះមែនទេ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Add Skill Modal -->
    <div x-cloak x-show="addSkillModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addSkillModal = false" 
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.skills.add_skill') }}</h3>
                <button type="button" @click="addSkillModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('skills.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="skill_name" class="block text-xs font-semibold text-slate-700 mb-1">
                        ឈ្មោះជំនាញ / Skill Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="skill_name" required placeholder="ឧ. Vue.js, Public Speaking, Graphic Design..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="curr_lvl" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.skills.current_lvl') }} (1-5) <span class="text-rose-500">*</span>
                        </label>
                        <select name="current_level" id="curr_lvl" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="1">Level 1 (Beginner)</option>
                            <option value="2">Level 2 (Novice)</option>
                            <option value="3" selected>Level 3 (Intermediate)</option>
                            <option value="4">Level 4 (Advanced)</option>
                            <option value="5">Level 5 (Master)</option>
                        </select>
                    </div>

                    <div>
                        <label for="targ_lvl" class="block text-xs font-semibold text-slate-700 mb-1">
                            {{ __('app.skills.target_lvl') }} (1-5) <span class="text-rose-500">*</span>
                        </label>
                        <select name="target_level" id="targ_lvl" required
                                class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="2">Level 2</option>
                            <option value="3">Level 3</option>
                            <option value="4">Level 4</option>
                            <option value="5" selected>Level 5 (Master)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        ជំពូកជំនាញ / Category
                    </label>
                    <select name="category_id" id="category_id"
                            class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- {{ __('app.actions.all') }} --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="skill_desc" class="block text-xs font-semibold text-slate-700 mb-1">
                        បរិយាយ / Description
                    </label>
                    <textarea name="description" id="skill_desc" rows="2"
                              class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addSkillModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ __('app.actions.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl">
                        {{ __('app.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Log Practice Modal -->
    <div x-cloak x-show="logPracticeModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="logPracticeModal = false" 
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.skills.log_practice') }}</h3>
                <button type="button" @click="logPracticeModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="'/skills/' + (activeSkill ? activeSkill.id : '') + '/activities'" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="activity_date" value="{{ date('Y-m-d') }}">

                <div>
                    <span class="text-xs text-slate-400">ជំនាញ:</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-0.5" x-text="activeSkill ? activeSkill.name : ''"></h4>
                </div>

                <div>
                    <label for="prac_title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងការអនុវត្ត / Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="prac_title" required placeholder="ឧ. បានបង្កើត Mini Project, អានឯកសារបច្ចេកទេស..."
                           class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="duration_min" class="block text-xs font-semibold text-slate-700 mb-1">
                            រយៈពេលអនុវត្ត (នាទី)
                        </label>
                        <input type="number" min="1" name="duration_minutes" id="duration_min" value="60"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="level_after" class="block text-xs font-semibold text-slate-700 mb-1">
                            កម្រិតបន្ទាប់ពីហាត់ (1-5)
                        </label>
                        <input type="number" min="1" max="5" name="level_after" id="level_after"
                               :value="activeSkill ? activeSkill.level : 1"
                               class="w-full px-3.5 py-2 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="logPracticeModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
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
