<x-guest-layout title="Track Submission Status">
    <div class="min-h-[90vh] bg-gradient-to-br from-slate-50 via-cyan-50/20 to-slate-100 py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-white px-3 py-1 text-xs font-semibold text-[#004B59] shadow-xs">
                    <svg class="h-4 w-4 text-[#00A3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Public Status Portal
                </div>
                <h1 class="text-3xl font-black tracking-tight text-[#004B59]">
                    Track Your Innovative Idea
                </h1>
                <p class="mx-auto mt-2 max-w-xl text-sm text-slate-600">
                    Enter your reference number (e.g.,
                    <code class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-slate-800">EEC-IDEA-2026-00001</code>)
                    to see real-time committee review progress.
                </p>
            </div>

            {{-- Search Box --}}
            <div class="mb-8 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-md">
                <form action="{{ route('ideas.track') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </div>
                        <input type="text" name="ref" value="{{ request('ref') }}" required
                               placeholder="EEC-IDEA-YEAR-XXXXX"
                               class="w-full rounded-xl border border-slate-300 py-3 pl-11 pr-4 font-mono text-sm uppercase text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                    </div>
                    <button type="submit"
                            class="shrink-0 rounded-xl bg-[#004B59] px-7 py-3 text-sm font-semibold text-white shadow-xs transition hover:bg-[#003640]">
                        Check Status
                    </button>
                </form>
            </div>

            {{-- Result Section --}}
            @if(request()->filled('ref'))
                @if($submission)

                    {{-- STATUS STEPPER --}}
                    @php
                        $allStatuses = ['Submitted', 'Under Review', 'Need More Information', 'Approved', 'Implemented'];
                        $currentIdx = array_search($submission->status, $allStatuses);
                        if ($submission->status === 'Rejected') {
                            $currentIdx = -1; // special case
                        }
                    @endphp
                    <div class="mb-6 overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl">
                        {{-- Top Banner --}}
                        <div class="bg-gradient-to-r from-[#004B59] to-[#006472] px-6 py-6 text-white sm:px-8">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-mono text-xs uppercase tracking-wider text-cyan-200">Reference Number</p>
                                    <h2 class="mt-0.5 font-mono text-2xl font-bold tracking-tight">{{ $submission->reference_number }}</h2>
                                </div>
                                <x-badge :status="$submission->status" />
                            </div>
                        </div>

                        {{-- Status Stepper --}}
                        @if($submission->status !== 'Rejected')
                            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5 sm:px-8">
                                <p class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400">Review Progress</p>
                                <div class="relative flex items-start justify-between">
                                    {{-- Connector line --}}
                                    <div class="absolute left-0 right-0 top-4 h-0.5 bg-slate-200" style="z-index:0"></div>
                                    <div class="absolute left-0 top-4 h-0.5 bg-[#00A3C4] transition-all duration-700 ease-in-out" style="width: {{ $currentIdx >= 0 ? ($currentIdx / (count($allStatuses) - 1)) * 100 : 0 }}%; z-index:0"></div>

                                    @foreach($allStatuses as $idx => $st)
                                        <div class="relative z-10 flex flex-col items-center" style="width: {{ 100 / count($allStatuses) }}%">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full border-2 transition-all duration-300
                                                {{ $idx <= $currentIdx ? 'border-[#00A3C4] bg-[#00A3C4] text-white shadow-md' : 'border-slate-300 bg-white text-slate-400' }}">
                                                @if($idx < $currentIdx)
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                @elseif($idx === $currentIdx)
                                                    <span class="h-2 w-2 rounded-full bg-white"></span>
                                                @else
                                                    <span class="text-[10px] font-bold">{{ $idx + 1 }}</span>
                                                @endif
                                            </div>
                                            <p class="mt-1.5 text-center text-[10px] font-semibold leading-tight {{ $idx <= $currentIdx ? 'text-[#004B59]' : 'text-slate-400' }}">
                                                {{ $st }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="border-b border-rose-200 bg-rose-50 px-6 py-4 sm:px-8">
                                <div class="flex items-center gap-3 text-rose-700">
                                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-sm font-semibold">This submission was not approved in the current review cycle.</p>
                                </div>
                            </div>
                        @endif

                        {{-- Idea Details --}}
                        <div class="space-y-6 p-6 sm:p-8">
                            <div>
                                <h3 class="text-xl font-bold leading-snug text-slate-900">{{ $submission->title }}</h3>
                                <p class="mt-1 text-xs text-slate-500">
                                    Submitted by <strong class="text-slate-700">{{ $submission->submitter_name }}</strong>
                                    on {{ $submission->submission_date->format('F d, Y') }}
                                </p>
                            </div>

                            {{-- Categories --}}
                            <div>
                                <h4 class="mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Categories</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($submission->categories as $cat)
                                        <span class="rounded-lg border border-slate-200 bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700">
                                <p class="mb-1 text-xs font-bold text-slate-500">Concept Summary:</p>
                                {{ $submission->description }}
                            </div>

                            {{-- Committee Feedback --}}
                            @if($submission->rejection_reason)
                                <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                                    <p class="mb-1 font-bold">Evaluation Committee Feedback:</p>
                                    {{ $submission->rejection_reason }}
                                </div>
                            @elseif($submission->approval_notes)
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                                    <p class="mb-1 font-bold">Committee Endorsement Notes:</p>
                                    {{ $submission->approval_notes }}
                                </div>
                            @endif

                            {{-- Lifecycle History Timeline --}}
                            <div class="border-t border-slate-200 pt-6">
                                <h4 class="mb-4 text-[11px] font-bold uppercase tracking-wider text-slate-400">Lifecycle Timeline</h4>
                                <div class="flow-root">
                                    <ul role="list" class="-mb-8">
                                        @forelse($submission->statusHistory as $history)
                                            <li>
                                                <div class="relative pb-8">
                                                    @if(!$loop->last)
                                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                                    @endif
                                                    <div class="relative flex space-x-3">
                                                        <div>
                                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-cyan-100 text-[#004B59] ring-8 ring-white text-xs font-bold">
                                                                ✓
                                                            </span>
                                                        </div>
                                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                            <div>
                                                                <p class="text-sm font-semibold text-slate-800">
                                                                    Status changed to
                                                                    <span class="text-[#004B59]">{{ $history->to_status }}</span>
                                                                </p>
                                                                @if($history->remarks)
                                                                    <p class="mt-0.5 text-xs text-slate-500">{{ $history->remarks }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="shrink-0 text-right text-xs text-slate-400">
                                                                <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('M d, Y') }}</time>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-xs italic text-slate-400">No status transitions recorded yet.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            {{-- Public Comments --}}
                            @if($submission->publicComments->isNotEmpty())
                                <div class="border-t border-slate-200 pt-6">
                                    <h4 class="mb-4 text-[11px] font-bold uppercase tracking-wider text-slate-400">Official Feedback &amp; Messages</h4>
                                    <div class="space-y-3">
                                        @foreach($submission->publicComments as $comment)
                                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-700">
                                                <div class="mb-1 flex items-center justify-between">
                                                    <span class="font-bold text-slate-900">{{ $comment->user?->name ?? 'EEC Innovation Committee' }}</span>
                                                    <span class="text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p>{{ $comment->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Track Another button --}}
                            <div class="border-t border-slate-200 pt-6 text-center">
                                <a href="{{ route('ideas.track') }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                    ← Track a Different Submission
                                </a>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- Not Found --}}
                    <div class="rounded-2xl border border-rose-200 bg-white p-10 text-center shadow-xs">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-rose-50 text-rose-500">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Reference Number Not Found</h3>
                        <p class="mx-auto mt-1 max-w-sm text-xs text-slate-500">
                            No submission matched <strong>{{ request('ref') }}</strong>.
                            Please double-check your reference format (e.g., <code class="font-mono">EEC-IDEA-2026-00001</code>)
                            or contact the Corporate Innovation Office.
                        </p>
                    </div>
                @endif
            @else
                {{-- Prompt state (no ref entered yet) --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-10 text-center shadow-xs">
                    <svg class="mx-auto mb-4 h-14 w-14 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <h3 class="text-base font-semibold text-slate-700">Enter your reference number above</h3>
                    <p class="mt-1 text-xs text-slate-400">Your reference number was shown on the confirmation page after you submitted your idea.</p>
                </div>
            @endif

        </div>
    </div>
</x-guest-layout>
