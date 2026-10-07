<x-guest-layout title="Idea Submitted Successfully">
    <div class="flex min-h-[90vh] items-center justify-center bg-gradient-to-br from-slate-50 via-emerald-50/30 to-cyan-50/30 py-16">
        <div class="mx-auto w-full max-w-2xl px-4 sm:px-6">

            <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-2xl">
                {{-- Top gradient accent --}}
                <div class="h-2.5 w-full bg-gradient-to-r from-[#004B59] via-[#00A3C4] to-emerald-400"></div>

                {{-- Decorative background circles --}}
                <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-emerald-100/30 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-cyan-100/30 blur-2xl"></div>

                <div class="relative px-8 py-12 text-center sm:px-14">

                    {{-- Animated success icon --}}
                    <div class="relative mx-auto mb-6 flex h-24 w-24 items-center justify-center">
                        {{-- Ping rings --}}
                        <div class="absolute inset-0 animate-ping rounded-full bg-emerald-200 opacity-30" style="animation-duration:2s"></div>
                        <div class="absolute inset-2 animate-ping rounded-full bg-emerald-300 opacity-20" style="animation-duration:2.5s"></div>
                        <div class="relative flex h-20 w-20 items-center justify-center rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-emerald-100 shadow-lg">
                            <svg class="h-10 w-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Badge + Heading --}}
                    <span class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Submission Successfully Received
                    </span>

                    <h1 class="mt-2 text-3xl font-black tracking-tight text-[#004B59]">
                        Thank You, {{ $submission->submitter_name }}!
                    </h1>

                    <p class="mx-auto mt-3 max-w-lg text-sm leading-relaxed text-slate-600">
                        Your innovative idea has been securely registered in the EEC innovation database
                        and forwarded to the evaluation committee for review.
                    </p>

                    {{-- Reference Card --}}
                    <div class="mx-auto mt-8 max-w-md rounded-2xl border border-slate-200/80 bg-gradient-to-br from-slate-50 to-white p-6" x-data="{ copied: false }">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Your Tracking Reference Number</p>
                        <div class="mt-2 flex items-center justify-center gap-3">
                            <span class="font-mono text-2xl font-black tracking-widest text-[#004B59] sm:text-3xl">
                                {{ $submission->reference_number }}
                            </span>
                            <button type="button"
                                    @click="navigator.clipboard.writeText('{{ $submission->reference_number }}'); copied = true; setTimeout(() => copied = false, 2500)"
                                    class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-200/60 hover:text-[#00A3C4]"
                                    title="Copy Reference Number">
                                <svg x-show="!copied" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <svg x-show="copied" x-cloak class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <p x-show="copied" x-cloak class="mt-1 text-xs font-semibold text-emerald-600">Copied to clipboard!</p>
                        <p class="mt-2 text-xs text-slate-400">Keep this reference handy to check your submission's review status.</p>
                    </div>

                    {{-- Submission Summary --}}
                    <div class="mx-auto mt-8 max-w-md space-y-0 divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-white text-left text-xs">
                        <div class="flex items-start justify-between gap-3 px-4 py-3">
                            <span class="font-medium text-slate-500 shrink-0">Idea Title</span>
                            <span class="font-semibold text-slate-900 text-right">{{ $submission->title }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-3 px-4 py-3">
                            <span class="font-medium text-slate-500 shrink-0">Categories</span>
                            <div class="flex flex-wrap justify-end gap-1">
                                @foreach($submission->categories as $c)
                                    <span class="rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700">{{ $c->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <span class="font-medium text-slate-500">Submitted By</span>
                            <span class="font-semibold text-slate-900">{{ $submission->submitter_name }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <span class="font-medium text-slate-500">Current Status</span>
                            <x-badge :status="$submission->status" />
                        </div>
                        <div class="flex items-center justify-between gap-3 px-4 py-3">
                            <span class="font-medium text-slate-500">Submitted On</span>
                            <span class="font-semibold text-slate-900">{{ $submission->submission_date->format('d F Y') }}</span>
                        </div>
                    </div>

                    {{-- What Happens Next --}}
                    <div class="mx-auto mt-8 max-w-md rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-left">
                        <p class="mb-3 text-xs font-bold uppercase tracking-wider text-blue-800">What Happens Next?</p>
                        <div class="space-y-2.5">
                            @foreach([
                                ['Assigned to a Technical Reviewer', 'Your idea will be assigned to a qualified evaluator within 5 business days.'],
                                ['Under Review', 'The committee evaluates feasibility, cost-benefit, and strategic alignment.'],
                                ['Decision Notification', 'You will be notified of the outcome. Track status using your reference number.'],
                            ] as $i => [$title, $desc])
                                <div class="flex items-start gap-3">
                                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-200 text-[10px] font-black text-blue-800">{{ $i + 1 }}</span>
                                    <div>
                                        <p class="text-xs font-semibold text-blue-900">{{ $title }}</p>
                                        <p class="text-[11px] text-blue-700">{{ $desc }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <a href="{{ route('ideas.track', ['ref' => $submission->reference_number]) }}"
                           class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#00A3C4] px-6 py-3 text-sm font-bold text-white shadow-md transition hover:bg-[#008ba8] sm:w-auto">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            Track This Submission
                        </a>
                        <a href="{{ route('ideas.create') }}"
                           class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200 sm:w-auto">
                            Submit Another Idea
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
