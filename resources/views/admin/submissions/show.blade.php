<x-app-layout title="Review Idea: {{ $submission->reference_number }}">
    <x-slot:header>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.submissions.index') }}" class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <span class="font-mono text-sm font-bold">{{ $submission->reference_number }}</span>
        </div>
    </x-slot:header>

    <div class="space-y-6">

        {{-- ═══════════════════════════════════ --}}
        {{-- GRADIENT HEADER BANNER             --}}
        {{-- ═══════════════════════════════════ --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002830] via-[#004B59] to-[#005e6e] p-6 shadow-lg text-white sm:p-8">
            <div class="pointer-events-none absolute -right-12 -top-12 h-48 w-48 rounded-full bg-white/5 blur-2xl"></div>
            <div class="relative z-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="font-mono text-2xl font-black tracking-wider text-white">{{ $submission->reference_number }}</span>
                    <x-badge :status="$submission->status" />
                    <span class="inline-flex items-center gap-1 rounded-full bg-white/10 px-2.5 py-1 text-xs text-cyan-200">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Submitted {{ $submission->submission_date->format('M d, Y') }}
                    </span>
                    @if($submission->assignedReviewer)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 text-xs text-cyan-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-cyan-400"></span>
                            Reviewer: {{ $submission->assignedReviewer->name }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/20 px-2.5 py-1 text-xs text-rose-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                            No reviewer assigned
                        </span>
                    @endif
                </div>

            <!-- Quick Workflow Transitions -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Assign Reviewer Modal Trigger -->
                @can('assignReviewer', $submission)
                    <div x-data="{ open: false }">
                        <button @click="open = true" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            <span>{{ $submission->assignedReviewer ? 'Reassign Reviewer' : 'Assign Reviewer' }}</span>
                        </button>

                        <!-- Assignment Modal -->
                        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                            <div @click.away="open = false" class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-200">
                                <h3 class="text-base font-bold text-slate-900 mb-2">Assign Technical Reviewer</h3>
                                <p class="text-xs text-slate-500 mb-4">Select an engineer or panel member to evaluate this idea.</p>
                                
                                <form action="{{ route('admin.submissions.assign-reviewer', $submission->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <select name="reviewer_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 bg-white">
                                            <option value="">-- Remove Assignment --</option>
                                            @foreach ($reviewers as $rev)
                                                <option value="{{ $rev->id }}" {{ $submission->assigned_reviewer_id === $rev->id ? 'selected' : '' }}>
                                                    {{ $rev->name }} ({{ $rev->job_title ?? $rev->department ?? 'Reviewer' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="open = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-semibold bg-[#004B59] text-white hover:bg-[#003640]">Save Assignment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan

                <!-- Update Status Modal Trigger -->
                @can('updateStatus', $submission)
                    <div x-data="{ open: false, selectedStatus: '{{ $submission->status }}' }">
                        <button @click="open = true" 
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#00A3C4] hover:bg-[#008ba8] text-white text-xs font-bold shadow-xs transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Change Status</span>
                        </button>

                        <!-- Status Modal -->
                        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                            <div @click.away="open = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200">
                                <h3 class="text-lg font-bold text-slate-900 mb-1">Update Submission Lifecycle Status</h3>
                                <p class="text-xs text-slate-500 mb-4">Set the decision or progression state and provide remarks for the lifecycle log.</p>
                                
                                <form action="{{ route('admin.submissions.update-status', $submission->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">New Status</label>
                                        <select name="status" x-model="selectedStatus" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-900 bg-white">
                                            @foreach ($statuses as $st)
                                                <option value="{{ $st }}">{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                            Evaluation Remarks / Decision Notes
                                        </label>
                                        <textarea name="remarks" rows="3" required placeholder="Explain the rationale for this status update..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 outline-hidden focus:ring-2 focus:ring-[#00A3C4]"></textarea>
                                    </div>

                                    <div class="flex justify-end gap-2 pt-2">
                                        <button type="button" @click="open = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-[#004B59] text-white hover:bg-[#003640] shadow-sm">Confirm Transition</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
        {{-- End gradient banner --}}
        </div>

        {{-- 2 Column Layout: Details Left, Meta/Timeline Right --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Details (Left 2 Columns) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Core Concept Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 leading-tight">{{ $submission->title }}</h2>
                        
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach ($submission->categories as $c)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-cyan-50 text-[#004B59] border border-cyan-200">
                                    {{ $c->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 space-y-5">
                        <!-- Brief Description -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Description of Idea</h4>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-sm text-slate-800 leading-relaxed whitespace-pre-line [overflow-wrap:anywhere]">
                                {{ $submission->description }}
                            </div>
                        </div>

                        <!-- Problem Addressed -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-rose-500 mb-2">Problem Specifically Addressed</h4>
                            <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-100 text-sm text-slate-800 leading-relaxed whitespace-pre-line [overflow-wrap:anywhere]">
                                {{ $submission->problem_addressed }}
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2">Benefits to EEC</h4>
                            <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 text-sm text-slate-800 leading-relaxed whitespace-pre-line [overflow-wrap:anywhere]">
                                {{ $submission->company_benefits }}
                            </div>
                        </div>

                        <!-- Risks / Challenges -->
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-2">Risks, Roadblocks & Dependencies</h4>
                            <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-100 text-sm text-slate-800 leading-relaxed whitespace-pre-line [overflow-wrap:anywhere]">
                                {{ $submission->risks_challenges }}
                            </div>
                        </div>
                    </div>

                    <!-- Supporting Links -->
                    @if (!empty($submission->supporting_links))
                        <div class="border-t border-slate-100 pt-5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Supporting Reference Links</h4>
                            <ul class="space-y-1 text-xs">
                                @foreach ($submission->supporting_links as $link)
                                    <li>
                                        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-[#00A3C4] hover:underline font-mono inline-flex items-start gap-1 [overflow-wrap:anywhere] min-w-0 w-full">
                                            <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            <span class="[overflow-wrap:anywhere] min-w-0">{{ $link }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Attachments -->
                    @if ($submission->attachments->isNotEmpty())
                        <div class="border-t border-slate-100 pt-5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Uploaded Attachments ({{ $submission->attachments->count() }})</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($submission->attachments as $att)
                                    <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="h-9 w-9 rounded-xl bg-cyan-100 text-[#004B59] flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ pathinfo($att->file_name, PATHINFO_EXTENSION) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-semibold text-slate-800 truncate">{{ $att->file_name }}</p>
                                                <p class="text-[11px] text-slate-400">{{ number_format($att->file_size / 1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" class="p-2 text-slate-500 hover:text-[#004B59] rounded-lg hover:bg-slate-200/60 transition" title="Download">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Discussion & Comments Section -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h3 class="text-base font-bold text-slate-900">Reviewer Notes & Feedback</h3>
                        <span class="text-xs text-slate-400">{{ $submission->comments->count() }} entries</span>
                    </div>

                    <!-- Add Comment Form -->
                    @can('addComment', $submission)
                        <form action="{{ route('admin.submissions.add-comment', $submission->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <textarea name="comment" rows="3" required placeholder="Add technical comments, evaluation memos, or public feedback..." class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 outline-hidden text-xs text-slate-900"></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer select-none text-xs text-slate-600">
                                    <input type="checkbox" name="is_internal" value="1" class="rounded border-slate-300 text-[#004B59] focus:ring-[#00A3C4]" checked>
                                    <span>Internal Only (Hidden from submitter tracking page)</span>
                                </label>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-[#004B59] hover:bg-[#003640] text-white font-semibold text-xs shadow-xs transition">
                                    Post Note
                                </button>
                            </div>
                        </form>
                    @endcan

                    <!-- Comment List -->
                    <div class="space-y-3 pt-2">
                        @forelse ($submission->comments as $c)
                            <div class="p-4 rounded-2xl border {{ $c->is_internal ? 'bg-amber-50/40 border-amber-200/60' : 'bg-slate-50 border-slate-200/80' }} text-xs">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900">{{ $c->user->name }}</span>
                                        @if ($c->is_internal)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">Internal</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">Public Feedback</span>
                                        @endif
                                    </div>
                                    <span class="text-slate-400 text-[11px]">{{ $c->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $c->comment }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-4">No comments or notes posted yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Column: Submitter Meta & History Timeline -->
            <div class="space-y-6">
                
                <!-- Submitter Info Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Submitter Profile</h3>
                    
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="h-12 w-12 rounded-2xl bg-[#004B59] text-white font-bold text-base flex items-center justify-center uppercase shrink-0">
                            {{ substr($submission->submitter_name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-slate-900 text-sm truncate">{{ $submission->submitter_name }}</h4>
                            <p class="text-xs text-slate-500 truncate">{{ $submission->submitter_job_title ?? 'Employee' }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Department:</span>
                            <span class="font-semibold text-slate-800 text-right">{{ $submission->submitter_department ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Project Site:</span>
                            <span class="font-semibold text-slate-800 text-right">{{ $submission->submitter_site ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Phone:</span>
                            <a href="tel:{{ $submission->submitter_phone }}" class="font-semibold text-[#00A3C4] hover:underline">{{ $submission->submitter_phone }}</a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Email:</span>
                            @if ($submission->submitter_email)
                                <a href="mailto:{{ $submission->submitter_email }}" class="font-semibold text-[#00A3C4] hover:underline truncate max-w-[160px]">{{ $submission->submitter_email }}</a>
                            @else
                                <span class="text-slate-400 italic">Not provided</span>
                            @endif
                        </div>
                    </div>

                    @if ($submission->assignedReviewer)
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Assigned Evaluator</span>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                                <span class="text-xs font-bold text-slate-800">{{ $submission->assignedReviewer->name }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Lifecycle History Timeline -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Lifecycle History</h3>
                    
                    <div class="flow-root mt-2">
                        <ul role="list" class="-mb-6">
                            @forelse ($submission->statusHistory as $hist)
                                <li>
                                    <div class="relative pb-6">
                                        @if (!$loop->last)
                                            <span class="absolute top-4 left-3.5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-7 w-7 rounded-full bg-cyan-100 text-[#004B59] flex items-center justify-center ring-4 ring-white text-[11px] font-bold">
                                                    ✓
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-2 pt-0.5">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800">
                                                        {{ $hist->to_status }}
                                                    </p>
                                                    @if ($hist->remarks)
                                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $hist->remarks }}</p>
                                                    @endif
                                                    <p class="text-[10px] text-slate-400 mt-1">by {{ $hist->user?->name ?? 'System' }}</p>
                                                </div>
                                                <div class="whitespace-nowrap text-right text-[10px] text-slate-400">
                                                    {{ $hist->created_at->format('M d') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-slate-400 italic">No transition history.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
