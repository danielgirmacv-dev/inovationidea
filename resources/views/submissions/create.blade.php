<x-guest-layout title="Submit Innovative Idea">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50/30 to-slate-100 py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- ══════════════════════════════════ --}}
            {{-- HERO HEADER                        --}}
            {{-- ══════════════════════════════════ --}}
            <div class="mb-8 text-center">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-white px-3 py-1 text-xs font-semibold text-[#004B59] shadow-xs">
                    <svg class="h-4 w-4 text-[#00A3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    EEC Corporation-Wide Innovation Portal
                </div>
                <h1 class="text-3xl font-black tracking-tight text-[#004B59] sm:text-4xl">
                    Innovative Idea Submission Form
                </h1>
                <p class="mx-auto mt-2.5 max-w-2xl text-sm text-slate-600">
                    Transforming Ethiopian engineering excellence. Share your ideas to improve processes,
                    reduce costs, enhance safety, or launch new capabilities across EEC.
                </p>
            </div>

            {{-- ══════════════════════════════════ --}}
            {{-- GLOBAL VALIDATION ERRORS           --}}
            {{-- ══════════════════════════════════ --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-xs">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-rose-900">Please correct the following errors:</h3>
                            <ul class="mt-2 list-inside list-disc space-y-1 text-xs text-rose-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ══════════════════════════════════ --}}
            {{-- MULTI-STEP FORM WRAPPER            --}}
            {{-- ══════════════════════════════════ --}}
            <div
                x-data="ideaForm()"
                x-init="init()"
                class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl"
            >
                {{-- ── STEP PROGRESS HEADER ── --}}
                <div class="bg-gradient-to-r from-[#002830] via-[#004B59] to-[#006472] px-6 py-6 text-white sm:px-10">
                    {{-- Progress Bar --}}
                    <div class="mb-5 h-1.5 w-full overflow-hidden rounded-full bg-white/20">
                        <div class="h-full rounded-full bg-[#00A3C4] transition-all duration-500"
                             :style="`width: ${((step - 1) / 2) * 100}%`"></div>
                    </div>

                    {{-- Step Tabs --}}
                    <div class="flex items-center justify-between">
                        {{-- Step 1 --}}
                        <button type="button" @click="goToStep(1)" class="flex items-center gap-3 text-left focus:outline-none group">
                            <div :class="step === 1 ? 'bg-[#00A3C4] ring-4 ring-cyan-400/30' : (step > 1 ? 'bg-emerald-500 ring-4 ring-emerald-400/20' : 'bg-white/20')"
                                 class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold transition">
                                <template x-if="step > 1">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="step === 1">
                                    <span>1</span>
                                </template>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-cyan-300">Step 1</p>
                                <p class="text-sm font-bold text-white">Contact Info</p>
                            </div>
                        </button>

                        <div class="mx-4 h-px flex-1 bg-white/20"></div>

                        {{-- Step 2 --}}
                        <button type="button" @click="goToStep(2)" class="flex items-center gap-3 text-left focus:outline-none group">
                            <div :class="step === 2 ? 'bg-[#00A3C4] ring-4 ring-cyan-400/30' : (step > 2 ? 'bg-emerald-500 ring-4 ring-emerald-400/20' : 'bg-white/20')"
                                 class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold transition">
                                <template x-if="step > 2">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="step <= 2">
                                    <span>2</span>
                                </template>
                            </div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-cyan-300">Step 2</p>
                                <p class="text-sm font-bold text-white">Idea Details</p>
                            </div>
                        </button>

                        <div class="mx-4 h-px flex-1 bg-white/20"></div>

                        {{-- Step 3 --}}
                        <button type="button" @click="goToStep(3)" class="flex items-center gap-3 text-left focus:outline-none group">
                            <div :class="step === 3 ? 'bg-[#00A3C4] ring-4 ring-cyan-400/30' : 'bg-white/20'"
                                 class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold transition">3</div>
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-cyan-300">Step 3</p>
                                <p class="text-sm font-bold text-white">Materials &amp; Submit</p>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- ── FORM ── --}}
                <form action="{{ route('ideas.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-10">
                    @csrf

                    {{-- ════════════════════════════════ --}}
                    {{-- STEP 1 — CONTACT INFORMATION    --}}
                    {{-- ════════════════════════════════ --}}
                    <div x-show="step === 1"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">

                        <div class="border-b border-slate-200 pb-4">
                            <h2 class="text-lg font-bold text-[#004B59]">1. Contact Information</h2>
                            <p class="mt-1 text-xs text-slate-500">Provide accurate contact details so the innovation evaluation committee can follow up with you.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            {{-- Full Name --}}
                            <div class="sm:col-span-2">
                                <label for="submitter_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="submitter_name" id="submitter_name"
                                       value="{{ old('submitter_name', auth()->user()?->name) }}"
                                       required placeholder="e.g., Abebe Bikila"
                                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('submitter_name') border-rose-400 @enderror">
                                @error('submitter_name')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Job Title --}}
                            <div>
                                <label for="submitter_job_title" class="mb-1.5 block text-sm font-semibold text-slate-700">Job Title</label>
                                <input type="text" name="submitter_job_title" id="submitter_job_title"
                                       value="{{ old('submitter_job_title', auth()->user()?->job_title) }}"
                                       placeholder="e.g., Senior Resident Engineer"
                                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                @error('submitter_job_title')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="submitter_phone" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                    Phone Number(s) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="submitter_phone" id="submitter_phone"
                                       value="{{ old('submitter_phone', auth()->user()?->phone) }}"
                                       required placeholder="+251 91 123 4567"
                                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('submitter_phone') border-rose-400 @enderror">
                                @error('submitter_phone')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div>
                                <label for="submitter_department" class="mb-1.5 block text-sm font-semibold text-slate-700">Department</label>
                                <select name="submitter_department" id="submitter_department"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                    <option value="">— Select Department —</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ old('submitter_department', auth()->user()?->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                    @endforeach
                                </select>
                                @error('submitter_department')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Site --}}
                            <div>
                                <label for="submitter_site" class="mb-1.5 block text-sm font-semibold text-slate-700">Site / Operational Location</label>
                                <select name="submitter_site" id="submitter_site"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                    <option value="">— Select Site / Branch —</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site }}" {{ old('submitter_site', auth()->user()?->site) === $site ? 'selected' : '' }}>{{ $site }}</option>
                                    @endforeach
                                </select>
                                @error('submitter_site')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-2">
                                <label for="submitter_email" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                    Email Address <span class="text-xs font-normal text-slate-400">(Optional — for automated status updates)</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="email" name="submitter_email" id="submitter_email"
                                           value="{{ old('submitter_email', auth()->user()?->email) }}"
                                           placeholder="yourname@eec.com.et"
                                           class="w-full rounded-xl border border-slate-300 py-3 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                                </div>
                                @error('submitter_email')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Step 1 Controls --}}
                        <div class="flex justify-end border-t border-slate-200 pt-6">
                            <button type="button" @click="validateStep1()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#004B59] px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:bg-[#003640] hover:shadow-lg">
                                Continue to Idea Details
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- ════════════════════════════════ --}}
                    {{-- STEP 2 — IDEA DESCRIPTION       --}}
                    {{-- ════════════════════════════════ --}}
                    <div x-show="step === 2"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">

                        <div class="border-b border-slate-200 pb-4">
                            <h2 class="text-lg font-bold text-[#004B59]">2. Innovative Idea Description</h2>
                            <p class="mt-1 text-xs text-slate-500">Clearly describe your concept, the problem it solves, and how EEC will gain strategic, technical, or financial value.</p>
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="title" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Idea Title <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   value="{{ old('title') }}" required
                                   placeholder="Give your idea a clear, concise headline..."
                                   class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('title') border-rose-400 @enderror">
                            @error('title')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categories --}}
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label class="block text-sm font-semibold text-slate-700">
                                    Categories <span class="text-rose-500">*</span>
                                    <span class="ml-1 text-xs font-normal text-slate-400">(Choose up to 3)</span>
                                </label>
                                <span :class="selectedCategories.length === 3 ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600'"
                                      class="rounded-full px-2 py-0.5 text-xs font-bold">
                                    <span x-text="selectedCategories.length"></span> / 3 Selected
                                </span>
                            </div>
                            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($categories as $cat)
                                    @php $isOther = strtolower($cat->name) === 'other'; @endphp
                                    <label @click.prevent="toggleCategory({{ $cat->id }})"
                                           :class="isCategorySelected({{ $cat->id }})
                                               ? 'bg-[#004B59] text-white border-[#004B59] shadow-sm'
                                               : (selectedCategories.length >= 3
                                                   ? 'cursor-not-allowed opacity-50 bg-slate-50 border-slate-200 text-slate-400'
                                                   : 'cursor-pointer bg-white hover:bg-slate-50 border-slate-300 text-slate-700')"
                                           class="flex cursor-pointer select-none items-center gap-3 rounded-xl border p-3 transition">
                                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                               {{ $isOther ? 'data-category-other' : '' }}
                                               :checked="isCategorySelected({{ $cat->id }})" class="hidden">
                                        <div :class="isCategorySelected({{ $cat->id }}) ? 'bg-white/20' : 'bg-slate-100'"
                                             class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md">
                                            <svg x-show="isCategorySelected({{ $cat->id }})" class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            <span x-show="!isCategorySelected({{ $cat->id }})" class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        </div>
                                        <span class="text-xs font-medium leading-tight">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                            {{-- Custom category if "Other" is chosen --}}
                            <div x-show="hasOtherCategory" x-transition class="mt-3">
                                <label for="custom_category" class="mb-1 block text-xs font-semibold text-slate-600">Specify the "Other" Category:</label>
                                <input type="text" name="custom_category" id="custom_category"
                                       value="{{ old('custom_category') }}"
                                       placeholder="Enter your custom innovation category..."
                                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="description" class="block text-sm font-semibold text-slate-700">
                                    Brief Description <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-xs" :class="charCounts.desc < 50 ? 'text-rose-500 font-semibold' : 'text-slate-400'">
                                    <span x-text="charCounts.desc"></span> chars (min 50)
                                </span>
                            </div>
                            <textarea name="description" id="description" rows="4" required
                                      @input="charCounts.desc = $el.value.length"
                                      placeholder="Provide an overview of the concept and how it functions..."
                                      class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-relaxed text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('description') border-rose-400 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Problem Addressed --}}
                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="problem_addressed" class="block text-sm font-semibold text-slate-700">
                                    Problem Specifically Addressed <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-xs" :class="charCounts.problem < 30 ? 'text-rose-500 font-semibold' : 'text-slate-400'">
                                    <span x-text="charCounts.problem"></span> chars (min 30)
                                </span>
                            </div>
                            <textarea name="problem_addressed" id="problem_addressed" rows="3" required
                                      @input="charCounts.problem = $el.value.length"
                                      placeholder="What inefficiency, hazard, technical limitation, or cost driver currently exists?"
                                      class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-relaxed text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('problem_addressed') border-rose-400 @enderror">{{ old('problem_addressed') }}</textarea>
                            @error('problem_addressed')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Company Benefits --}}
                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="company_benefits" class="block text-sm font-semibold text-slate-700">
                                    How the Idea Will Benefit EEC <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-xs" :class="charCounts.benefits < 30 ? 'text-rose-500 font-semibold' : 'text-slate-400'">
                                    <span x-text="charCounts.benefits"></span> chars (min 30)
                                </span>
                            </div>
                            <textarea name="company_benefits" id="company_benefits" rows="3" required
                                      @input="charCounts.benefits = $el.value.length"
                                      placeholder="Quantify the upside where possible (e.g., saves 20 hours/month, reduces fuel costs by 15%, eliminates rework)..."
                                      class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-relaxed text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('company_benefits') border-rose-400 @enderror">{{ old('company_benefits') }}</textarea>
                            @error('company_benefits')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Risks / Challenges --}}
                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="risks_challenges" class="block text-sm font-semibold text-slate-700">
                                    Potential Risks, Roadblocks, or Dependencies <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-xs" :class="charCounts.risks < 20 ? 'text-rose-500 font-semibold' : 'text-slate-400'">
                                    <span x-text="charCounts.risks"></span> chars (min 20)
                                </span>
                            </div>
                            <textarea name="risks_challenges" id="risks_challenges" rows="2" required
                                      @input="charCounts.risks = $el.value.length"
                                      placeholder="What could impede execution? (e.g., budget allocation, specialized software licenses, regulatory approval)..."
                                      class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-relaxed text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('risks_challenges') border-rose-400 @enderror">{{ old('risks_challenges') }}</textarea>
                            @error('risks_challenges')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Step 2 Controls --}}
                        <div class="flex items-center justify-between border-t border-slate-200 pt-6">
                            <button type="button" @click="step = 1; scrollTop()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Back
                            </button>
                            <button type="button" @click="validateStep2()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#004B59] px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:bg-[#003640] hover:shadow-lg">
                                Continue to Supporting Materials
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- ════════════════════════════════ --}}
                    {{-- STEP 3 — MATERIALS & SUBMIT     --}}
                    {{-- ════════════════════════════════ --}}
                    <div x-show="step === 3"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-6">

                        <div class="border-b border-slate-200 pb-4">
                            <h2 class="text-lg font-bold text-[#004B59]">3. Supporting Materials &amp; Final Submission</h2>
                            <p class="mt-1 text-xs text-slate-500">Optionally attach documents, diagrams, or links that support your proposal. Then review and submit.</p>
                        </div>

                        {{-- Drag-and-Drop File Upload --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Supporting Documents
                                <span class="text-xs font-normal text-slate-400">(Optional — max 5 files, 10 MB each)</span>
                            </label>
                            <div
                                x-data="fileDropzone()"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-[#00A3C4] bg-cyan-50' : 'border-slate-300 bg-slate-50 hover:border-[#00A3C4] hover:bg-slate-50'"
                                class="relative cursor-pointer rounded-2xl border-2 border-dashed p-8 text-center transition-all duration-200"
                                @click="$refs.fileInput.click()"
                            >
                                <div class="pointer-events-none">
                                    <svg :class="isDragging ? 'text-[#00A3C4]' : 'text-slate-300'"
                                         class="mx-auto mb-3 h-10 w-10 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-slate-700">
                                        <span :class="isDragging ? 'text-[#00A3C4]' : ''">Drop files here</span>
                                        or <span class="text-[#00A3C4]">browse</span>
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400">PDF, DOCX, XLSX, PNG, JPG, ZIP accepted</p>
                                </div>

                                <input type="file" name="attachments[]" multiple id="attachments"
                                       x-ref="fileInput"
                                       @change="handleFiles($event.target.files)"
                                       class="hidden"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif,.webp,.zip">
                            </div>

                            {{-- File List Preview --}}
                            <div x-data="fileDropzone()" class="hidden"><!-- alpine scope bridge --></div>
                            <div id="fileList" class="mt-3 space-y-2"></div>

                            @error('attachments')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                            @error('attachments.*')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Supporting Links --}}
                        <div>
                            <label for="supporting_links" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Web Links / Cloud Drives / References
                                <span class="text-xs font-normal text-slate-400">(Optional)</span>
                            </label>
                            <textarea name="supporting_links" id="supporting_links" rows="3"
                                      placeholder="Paste relevant external links (one per line): https://..."
                                      class="w-full rounded-xl border border-slate-300 px-4 py-3 font-mono text-xs text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30">{{ old('supporting_links') }}</textarea>
                        </div>

                        {{-- Submission Date --}}
                        <div class="w-full sm:w-1/2">
                            <label for="submission_date" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Date of Submission <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="submission_date" id="submission_date"
                                   value="{{ old('submission_date', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}" required
                                   class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 @error('submission_date') border-rose-400 @enderror">
                            @error('submission_date')
                                <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Summary Review Panel --}}
                        <div class="rounded-2xl border border-cyan-200 bg-gradient-to-br from-cyan-50 to-white p-5 text-xs space-y-2">
                            <p class="font-bold text-[#004B59] text-sm mb-3">✅ Pre-Submission Review</p>
                            <div class="flex justify-between py-1 border-b border-cyan-100">
                                <span class="text-slate-500">Name:</span>
                                <span class="font-semibold text-slate-800" x-text="document.getElementById('submitter_name')?.value || '—'"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-cyan-100">
                                <span class="text-slate-500">Phone:</span>
                                <span class="font-semibold text-slate-800" x-text="document.getElementById('submitter_phone')?.value || '—'"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-cyan-100">
                                <span class="text-slate-500">Idea Title:</span>
                                <span class="font-semibold text-slate-800 text-right max-w-[220px] truncate" x-text="document.getElementById('title')?.value || '—'"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Categories:</span>
                                <span class="font-semibold text-slate-800" x-text="selectedCategories.length + ' selected'"></span>
                            </div>
                        </div>

                        {{-- Declaration --}}
                        <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <input type="checkbox" id="declaration" required
                                   class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#004B59] focus:ring-[#00A3C4]">
                            <label for="declaration" class="text-xs text-slate-600 leading-relaxed">
                                I confirm that the information provided is accurate to the best of my knowledge and that this idea is my original contribution or one I am authorized to share with EEC. I understand that the evaluation committee's decision is final.
                            </label>
                        </div>

                        {{-- Step 3 Controls --}}
                        <div class="flex items-center justify-between border-t border-slate-200 pt-6">
                            <button type="button" @click="step = 2; scrollTop()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Back to Idea Details
                            </button>

                            <button type="submit" id="submitBtn"
                                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#004B59] to-[#006472] px-9 py-3.5 text-sm font-black text-white shadow-lg transition hover:from-[#003640] hover:shadow-xl active:scale-[0.98]">
                                <svg class="h-5 w-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Submit Innovative Idea
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            {{-- Bottom Tracking Quick Link --}}
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500">
                    Already submitted an idea?
                    <a href="{{ route('ideas.track') }}" class="font-semibold text-[#00A3C4] hover:text-[#004B59] hover:underline">
                        Track its review status here →
                    </a>
                </p>
            </div>

        </div>
    </div>

    <script>
        function ideaForm() {
            return {
                step: {{ $errors->hasAny(['title','description','categories','problem_addressed','company_benefits','risks_challenges','submission_date']) ? 2 : ($errors->hasAny(['attachments','supporting_links']) ? 3 : 1) }},
                selectedCategories: {{ json_encode(array_map('intval', (array) old('categories', []))) }},
                hasOtherCategory: false,
                charCounts: {
                    desc:     '{{ addslashes(old('description', '')) }}'.length,
                    problem:  '{{ addslashes(old('problem_addressed', '')) }}'.length,
                    benefits: '{{ addslashes(old('company_benefits', '')) }}'.length,
                    risks:    '{{ addslashes(old('risks_challenges', '')) }}'.length,
                },
                init() {
                    this.checkOther();
                },
                toggleCategory(id) {
                    const idx = this.selectedCategories.indexOf(id);
                    if (idx > -1) {
                        this.selectedCategories.splice(idx, 1);
                    } else if (this.selectedCategories.length < 3) {
                        this.selectedCategories.push(id);
                    }
                    this.checkOther();
                },
                isCategorySelected(id) {
                    return this.selectedCategories.includes(id);
                },
                checkOther() {
                    const otherEl = document.querySelector('[data-category-other]');
                    if (otherEl) {
                        this.hasOtherCategory = this.selectedCategories.includes(parseInt(otherEl.value));
                    }
                },
                goToStep(target) {
                    if (target < this.step) { this.step = target; this.scrollTop(); }
                },
                scrollTop() {
                    window.scrollTo({ top: 80, behavior: 'smooth' });
                },
                validateStep1() {
                    const name  = document.getElementById('submitter_name').value.trim();
                    const phone = document.getElementById('submitter_phone').value.trim();
                    if (!name)  { alert('Please enter your Full Name.');      document.getElementById('submitter_name').focus(); return; }
                    if (!phone) { alert('Please enter your Phone Number.');   document.getElementById('submitter_phone').focus(); return; }
                    this.step = 2;
                    this.scrollTop();
                },
                validateStep2() {
                    const title = document.getElementById('title').value.trim();
                    const desc  = document.getElementById('description').value.trim();
                    const prob  = document.getElementById('problem_addressed').value.trim();
                    const ben   = document.getElementById('company_benefits').value.trim();
                    const risk  = document.getElementById('risks_challenges').value.trim();
                    if (!title)             { alert('Please enter an idea title.');              document.getElementById('title').focus(); return; }
                    if (desc.length  < 50)  { alert('Description must be at least 50 characters.'); document.getElementById('description').focus(); return; }
                    if (this.selectedCategories.length === 0) { alert('Please select at least one category.'); return; }
                    if (prob.length  < 30)  { alert('Problem statement must be at least 30 characters.'); document.getElementById('problem_addressed').focus(); return; }
                    if (ben.length   < 30)  { alert('Benefits must be at least 30 characters.'); document.getElementById('company_benefits').focus(); return; }
                    if (risk.length  < 20)  { alert('Risks field must be at least 20 characters.'); document.getElementById('risks_challenges').focus(); return; }
                    this.step = 3;
                    this.scrollTop();
                },
            };
        }

        function fileDropzone() {
            return {
                isDragging: false,
                files: [],
                handleDrop(event) {
                    this.isDragging = false;
                    this.handleFiles(event.dataTransfer.files);
                },
                handleFiles(fileList) {
                    const list = document.getElementById('fileList');
                    list.innerHTML = '';
                    Array.from(fileList).slice(0, 5).forEach(file => {
                        const div = document.createElement('div');
                        div.className = 'flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs';
                        div.innerHTML = `
                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span class="flex-1 font-medium text-slate-700 truncate">${file.name}</span>
                            <span class="text-slate-400">${(file.size / 1024).toFixed(1)} KB</span>
                        `;
                        list.appendChild(div);
                    });
                }
            };
        }
    </script>
</x-guest-layout>
