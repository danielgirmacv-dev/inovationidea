<x-app-layout title="Idea Submissions Management">
    <x-slot:header>
        Idea Submissions Review Queue
    </x-slot:header>

    <div class="space-y-6" x-data="submissionsIndex()">

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- QUICK STATUS FILTER PILLS                                    --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="flex flex-wrap items-center gap-2">
            @php
                $statusMeta = [
                    ''                       => ['All', 'bg-slate-900 text-white', 'bg-slate-100 text-slate-600 hover:bg-slate-200 border border-slate-200'],
                    'Submitted'              => ['Submitted',        'bg-blue-600 text-white',   'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200'],
                    'Under Review'           => ['Under Review',     'bg-amber-500 text-white',  'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200'],
                    'Need More Information'  => ['Need More Info',   'bg-orange-500 text-white', 'bg-orange-50 text-orange-700 hover:bg-orange-100 border border-orange-200'],
                    'Approved'               => ['Approved',         'bg-emerald-600 text-white','bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200'],
                    'Rejected'               => ['Rejected',         'bg-rose-600 text-white',   'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200'],
                    'Implemented'            => ['Implemented',      'bg-teal-600 text-white',   'bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200'],
                ];
                $currentStatus = request('status', '');
            @endphp
            <span class="text-xs font-semibold text-slate-400 mr-1">Quick filter:</span>
            @foreach($statusMeta as $val => [$lbl, $active, $inactive])
                <a href="{{ route('admin.submissions.index', array_merge(request()->except('page'), ['status' => $val ?: null])) }}"
                   class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold transition
                          {{ $currentStatus === $val ? $active : $inactive }}">
                    {{ $lbl }}
                    @if ($val === $currentStatus)
                        <span class="ml-0.5 opacity-70">✓</span>
                    @endif
                </a>
            @endforeach

            <div class="ml-auto">
                <a href="{{ route('admin.submissions.export', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-800 transition hover:bg-emerald-100">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV ({{ $submissions->total() }})
                </a>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- ADVANCED FILTERS PANEL                                       --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs" x-data="{ showFilters: {{ count(array_filter(request()->only(['search','status','category','department','site','date_from','date_to']))) > 0 ? 'true' : 'false' }} }">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    <span class="text-sm font-semibold text-slate-700">Advanced Filters</span>
                    @if(count(array_filter(request()->only(['search','status','category','department','site','date_from','date_to']))) > 0)
                        <span class="rounded-full bg-[#004B59] px-2 py-0.5 text-[10px] font-bold text-white">
                            {{ count(array_filter(request()->only(['search','status','category','department','site','date_from','date_to']))) }} active
                        </span>
                    @endif
                </div>
                <button type="button" @click="showFilters = !showFilters"
                        class="flex items-center gap-1 text-xs font-semibold text-[#00A3C4] hover:underline">
                    <span x-text="showFilters ? 'Hide' : 'Show'"></span>
                    <svg class="h-3.5 w-3.5 transition-transform" :class="showFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>

            <div x-show="showFilters" x-collapse>
                <form method="GET" action="{{ route('admin.submissions.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {{-- Search --}}
                        <div class="sm:col-span-2 lg:col-span-2">
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Search Keywords</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Search by title, reference, problem, or submitter..."
                                       class="w-full rounded-xl border border-slate-300 py-2.5 pl-9 pr-4 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Status</label>
                            <select name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $st)
                                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Category</label>
                            <select name="category" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Department --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Department</label>
                            <select name="department" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Site --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Project Site</label>
                            <select name="site" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                <option value="">All Sites</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s }}" {{ request('site') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date From --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                        </div>

                        {{-- Date To --}}
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-xs text-slate-900 outline-none focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 border-t border-slate-100 pt-4">
                        <button type="submit" class="rounded-xl bg-[#004B59] px-5 py-2 text-xs font-semibold text-white shadow-xs transition hover:bg-[#003640]">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.submissions.index') }}" class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-200">
                            Reset All
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- SUBMISSIONS TABLE                                            --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xs">

            {{-- Table Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-slate-900">Submissions</h3>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-600">
                        {{ $submissions->total() }} total
                    </span>
                    @if($submissions->currentPage() > 1)
                        <span class="text-xs text-slate-400">Page {{ $submissions->currentPage() }} of {{ $submissions->lastPage() }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    Showing {{ $submissions->firstItem() ?? 0 }}–{{ $submissions->lastItem() ?? 0 }}
                </div>
            </div>

            {{-- Column Headers --}}
            <div class="hidden grid-cols-12 gap-3 border-b border-slate-200 bg-slate-50/80 px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 lg:grid">
                <div class="col-span-1">Ref #</div>
                <div class="col-span-4">Idea Title &amp; Categories</div>
                <div class="col-span-2">Submitter</div>
                <div class="col-span-2">Reviewer</div>
                <div class="col-span-1">Status</div>
                <div class="col-span-1">Date</div>
                <div class="col-span-1 text-right">Actions</div>
            </div>

            {{-- Rows --}}
            <div class="divide-y divide-slate-100">
                @forelse($submissions as $sub)
                    <div class="group grid grid-cols-1 items-start gap-3 px-6 py-4 transition hover:bg-slate-50/80 lg:grid-cols-12">

                        {{-- Reference --}}
                        <div class="lg:col-span-1">
                            <a href="{{ route('admin.submissions.show', $sub->id) }}"
                               class="font-mono text-xs font-bold text-[#004B59] hover:underline">
                                {{ $sub->reference_number }}
                            </a>
                        </div>

                        {{-- Title & Categories --}}
                        <div class="min-w-0 lg:col-span-4">
                            <a href="{{ route('admin.submissions.show', $sub->id) }}"
                               class="block break-words text-sm font-bold leading-snug text-slate-900 hover:text-[#00A3C4]">
                                {{ $sub->title }}
                            </a>
                            <div class="mt-1.5 flex flex-wrap gap-1">
                                @foreach($sub->categories as $c)
                                    <span class="inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold bg-cyan-50 text-[#004B59] border border-cyan-100">{{ $c->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Submitter --}}
                        <div class="min-w-0 lg:col-span-2">
                            <p class="break-words text-xs font-semibold text-slate-800">{{ $sub->submitter_name }}</p>
                            <p class="break-words text-[11px] text-slate-400">{{ $sub->submitter_department ?? 'General' }}</p>
                            @if($sub->submitter_site)
                                <p class="break-words text-[10px] text-slate-300">{{ $sub->submitter_site }}</p>
                            @endif
                        </div>

                        {{-- Reviewer --}}
                        <div class="min-w-0 lg:col-span-2">
                            @if($sub->assignedReviewer)
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-700">
                                    <span class="h-2 w-2 shrink-0 rounded-full bg-cyan-500"></span>
                                    <span class="break-words">{{ $sub->assignedReviewer->name }}</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-600 border border-rose-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    Unassigned
                                </span>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="lg:col-span-1">
                            <x-badge :status="$sub->status" />
                        </div>

                        {{-- Date --}}
                        <div class="lg:col-span-1">
                            <span class="text-xs text-slate-400">{{ $sub->submission_date->format('M d, Y') }}</span>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-2 lg:col-span-1">
                            <a href="{{ route('admin.submissions.show', $sub->id) }}"
                               class="inline-flex items-center rounded-lg bg-[#004B59] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#003640]">
                                Review
                            </a>
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.submissions.destroy', $sub->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this submission? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="rounded-lg p-1.5 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600"
                                            title="Delete submission">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="py-16 text-center text-slate-400">
                        <svg class="mx-auto mb-3 h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="font-semibold text-slate-700">No matching submissions found.</p>
                        <p class="mt-1 text-xs text-slate-400">Try relaxing your search terms or filter criteria.</p>
                        <a href="{{ route('admin.submissions.index') }}"
                           class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                            Clear all filters
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($submissions->hasPages())
                <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>

    </div>

    <script>
        function submissionsIndex() { return {}; }
    </script>
</x-app-layout>
