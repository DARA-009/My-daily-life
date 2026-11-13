@extends('layouts.app', ['title' => __('app.notes.title')])

@section('content')
<div x-data="{ addNoteModal: false }" class="space-y-6">
    <!-- Header with Search & Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">{{ __('app.notes.title') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('app.notes.subtitle') }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <form action="{{ route('notes.index') }}" method="GET" class="relative">
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="{{ __('app.actions.search') }}"
                       class="w-48 sm:w-64 pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
            </form>

            <button type="button" 
                    @click="addNoteModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-xs transition-colors shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>{{ __('app.notes.add_note') }}</span>
            </button>
        </div>
    </div>

    <!-- Pinned Notes Section -->
    @if ($pinnedNotes->isNotEmpty())
        <div>
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="pin" class="w-4 h-4 text-amber-500 fill-amber-500"></i>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('app.notes.pinned') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($pinnedNotes as $note)
                    <div class="bg-amber-50/50 rounded-2xl border-2 border-amber-200/80 p-5 shadow-2xs flex flex-col justify-between relative group hover:shadow-xs transition-shadow">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $note->title }}</h3>
                                <form action="{{ route('notes.pin', $note) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-amber-600 hover:text-amber-800 p-1" title="{{ __('app.notes.unpin') }}">
                                        <i data-lucide="pin-off" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">{{ $note->body }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-amber-100 flex items-center justify-between text-[11px] text-slate-400">
                            <span>{{ $note->updated_at->diffForHumans() }}</span>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបកំណត់ត្រានេះមែនទេ?');">
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
        </div>
    @endif

    <!-- All Other Notes (Masonry Grid) -->
    <div>
        @if ($pinnedNotes->isNotEmpty())
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">{{ __('app.notes.others') }}</h2>
        @endif

        @if ($notes->isEmpty() && $pinnedNotes->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs py-16 text-center px-4">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i data-lucide="file-text" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-800">{{ __('app.notes.empty') }}</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">កត់ត្រាគំនិតល្អៗ សេចក្តីព្រាង ឬកំណត់ហេតុប្រជុំរបស់អ្នកនៅទីនេះ។</p>
                <button type="button" 
                        @click="addNoteModal = true"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>{{ __('app.notes.add_note') }}</span>
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($notes as $note)
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs flex flex-col justify-between relative hover:shadow-xs transition-shadow">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $note->title }}</h3>
                                <form action="{{ route('notes.pin', $note) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-slate-400 hover:text-amber-500 p-1" title="{{ __('app.notes.pin') }}">
                                        <i data-lucide="pin" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-xs text-slate-600 whitespace-pre-line line-clamp-6 leading-relaxed">{{ $note->body }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                            <span>{{ $note->updated_at->diffForHumans() }}</span>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបកំណត់ត្រានេះមែនទេ?');">
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

            @if ($notes->hasPages())
                <div class="pt-4">
                    {{ $notes->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Create Note Modal -->
    <div x-cloak x-show="addNoteModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="addNoteModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full border border-slate-200 shadow-xl overflow-hidden animate-in fade-in zoom-in duration-150">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">{{ __('app.notes.add_note') }}</h3>
                <button type="button" @click="addNoteModal = false" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('notes.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="note_title" class="block text-xs font-semibold text-slate-700 mb-1">
                        ចំណងជើងកំណត់ត្រា / Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="note_title" required placeholder="ឧ. គំនិតសម្រាប់គម្រោងថ្មី, សេចក្តីព្រាង..."
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1">
                        ជំពូក / Category
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
                    <label for="note_body" class="block text-xs font-semibold text-slate-700 mb-1">
                        ខ្លឹមសារកំណត់ត្រា / Content & Notes
                    </label>
                    <textarea name="body" id="note_body" rows="6" placeholder="សរសេរគំនិតរបស់អ្នកនៅទីនេះ..."
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="pt-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1"
                               class="w-4 h-4 text-amber-500 rounded-md border-slate-300 focus:ring-amber-500">
                        <span class="text-xs font-medium text-slate-700">ខ្ទាស់កំណត់ត្រានេះនៅខាងលើគេ (Pin to top)</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="addNoteModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
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
