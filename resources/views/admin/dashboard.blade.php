<x-app-layout title="Executive Innovation Dashboard">
    <x-slot:header>
        Executive Innovation Dashboard
    </x-slot:header>

    <div class="space-y-7" x-data="dashboardPage()">

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- WELCOME BANNER                                               --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#002830] via-[#004B59] to-[#006b7a] shadow-xl text-white">
            {{-- decorative blobs --}}
            <div class="pointer-events-none absolute -top-16 -right-16 h-64 w-64 rounded-full bg-white/5 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-12 left-0 h-48 w-48 rounded-full bg-[#00A3C4]/10 blur-2xl"></div>
            <div class="pointer-events-none absolute top-4 right-1/3 h-32 w-32 rounded-full bg-cyan-400/5 blur-xl"></div>

            <div class="relative z-10 flex flex-col gap-6 p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-cyan-200 backdrop-blur">
                        {{-- live pulse dot --}}
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-cyan-300"></span>
                        </span>
                        Ethiopian Engineering Corporation &bull; Innovation Operations
                    </div>
                    <h2 class="text-2xl font-black tracking-tight sm:text-3xl">
                        Welcome back, {{ auth()->user()->name }}
                    </h2>
                    <p class="mt-1 max-w-xl text-sm text-cyan-100">
                        Monitor, evaluate, and advance innovative engineering solutions submitted across all EEC directorates and project sites.
                    </p>
                    <p class="mt-2 text-xs text-cyan-300/70">{{ now()->format('l, d F Y \a\t H:i') }}</p>
                </div>
                <div class="flex shrink-0 flex-wrap items-center gap-3">
                    <a href="{{ route('admin.submissions.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-xs font-bold text-[#004B59] shadow-md transition hover:bg-slate-100">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Review Queue
                        @if($kpi['submitted'] + $kpi['under_review'] > 0)
                            <span class="rounded-full bg-[#004B59] px-2 py-0.5 text-[10px] font-black text-white">
                                {{ $kpi['submitted'] + $kpi['under_review'] }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.submissions.export') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/20">
                        <svg class="h-4 w-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export CSV
                    </a>
                    <a href="{{ route('ideas.create') }}" target="_blank"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/20">
                        <svg class="h-4 w-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Public Form
                    </a>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- KPI ROW 1 — 4 CARDS (total, submitted, under review, need info) --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <x-kpi-card
                title="Total Submissions"
                value="{{ $kpi['total'] }}"
                color="teal"
                trend="All logged concepts"
                icon='<svg class="w-6 h-6 text-[#004B59]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' />

            <x-kpi-card
                title="Newly Submitted"
                value="{{ $kpi['submitted'] }}"
                color="blue"
                trend="Awaiting triage"
                icon='<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>' />

            <x-kpi-card
                title="Under Review"
                value="{{ $kpi['under_review'] }}"
                color="amber"
                trend="Active committee triage"
                icon='<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />

            <x-kpi-card
                title="Need More Info"
                value="{{ $kpi['need_info'] }}"
                color="orange"
                trend="Awaiting submitter response"
                icon='<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- KPI ROW 2 — 3 CARDS (approved, rejected, implemented)       --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <x-kpi-card
                title="Approved &amp; Piloting"
                value="{{ $kpi['approved'] }}"
                color="cyan"
                trend="Funding / pilot sanctioned"
                icon='<svg class="w-6 h-6 text-[#00A3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />

            <x-kpi-card
                title="Implemented"
                value="{{ $kpi['implemented'] }}"
                color="emerald"
                trend="Operational across EEC"
                icon='<svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>' />

            <x-kpi-card
                title="Rejected"
                value="{{ $kpi['rejected'] }}"
                color="rose"
                trend="Not approved this cycle"
                icon='<svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- CHART ROW 1: Status Donut + Monthly Trend                   --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Status Doughnut --}}
            <div class="flex flex-col rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-bold tracking-tight text-slate-900">Status Breakdown</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Lifecycle distribution</p>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-xs font-semibold text-emerald-700">
                            {{ $kpi['total'] > 0 ? round((($kpi['approved'] + $kpi['implemented']) / $kpi['total']) * 100) : 0 }}% Success Rate
                        </span>
                        <span class="text-[10px] text-slate-400">Approved + Implemented</span>
                    </div>
                </div>
                <div class="relative mt-4 h-56">
                    <canvas id="statusChart"></canvas>
                </div>
                {{-- legend summary --}}
                <div class="mt-4 grid grid-cols-2 gap-1.5 border-t border-slate-100 pt-4">
                    @foreach([
                        ['Submitted','bg-blue-500',$kpi['submitted']],
                        ['Under Review','bg-amber-400',$kpi['under_review']],
                        ['Need Info','bg-orange-400',$kpi['need_info']],
                        ['Approved','bg-emerald-500',$kpi['approved']],
                        ['Rejected','bg-rose-500',$kpi['rejected']],
                        ['Implemented','bg-[#00A3C4]',$kpi['implemented']],
                    ] as [$lbl,$dot,$cnt])
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-600">
                            <span class="h-2 w-2 shrink-0 rounded-full {{ $dot }}"></span>
                            {{ $lbl }}: <strong class="text-slate-800">{{ $cnt }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Monthly Trend --}}
            <div class="flex flex-col rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs lg:col-span-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-bold tracking-tight text-slate-900">Submission Volume &amp; Trend</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Monthly idea submission velocity — {{ now()->year }}</p>
                    </div>
                    <span class="rounded-lg border border-cyan-100 bg-cyan-50 px-2.5 py-1 text-xs font-semibold text-[#00A3C4]">
                        {{ now()->format('Y') }}
                    </span>
                </div>
                <div class="relative mt-4 flex-1" style="min-height:220px">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- CHART ROW 2: Categories Bar + Department Table               --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            {{-- Categories Bar --}}
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs">
                <h3 class="text-sm font-bold tracking-tight text-slate-900">Ideas by Innovation Category</h3>
                <p class="mt-0.5 text-xs text-slate-500">Strategic focus areas targeted by employees</p>
                <div class="relative mt-4" style="height:260px">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            {{-- Department Engagement --}}
            <div class="flex flex-col rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-bold tracking-tight text-slate-900">Top Contributing Departments</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Participation in corporate innovation</p>
                    </div>
                    <a href="{{ route('admin.submissions.index') }}" class="text-xs font-semibold text-[#00A3C4] hover:underline">
                        View All →
                    </a>
                </div>
                <div class="mt-4 flex-1 space-y-2.5">
                    @forelse($byDepartment->take(7) as $dept)
                        @php $pct = $kpi['total'] > 0 ? round(($dept->count / $kpi['total']) * 100, 1) : 0; @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-700 truncate max-w-[200px]">{{ $dept->submitter_department ?? 'Unspecified' }}</span>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="font-bold text-[#004B59]">{{ $dept->count }}</span>
                                    <span class="text-slate-400">{{ $pct }}%</span>
                                </div>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-[#004B59] to-[#00A3C4] transition-all duration-700"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-xs text-slate-400 italic">No departmental data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════ --}}
        {{-- RECENT SUBMISSIONS TABLE                                     --}}
        {{-- ══════════════════════════════════════════════════════════════ --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xs">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h3 class="text-sm font-bold tracking-tight text-slate-900">Recent Submissions</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Latest concepts awaiting action or review updates</p>
                </div>
                <a href="{{ route('admin.submissions.index') }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                    View All
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="border-b border-slate-200/80 bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="py-3 pl-6 pr-3">Reference</th>
                            <th class="py-3 px-3">Idea Title</th>
                            <th class="py-3 px-3">Submitter</th>
                            <th class="py-3 px-3">Department</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3">Date</th>
                            <th class="py-3 pl-3 pr-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentSubmissions as $sub)
                            <tr class="group transition hover:bg-slate-50/80">
                                <td class="py-3.5 pl-6 pr-3">
                                    <a href="{{ route('admin.submissions.show', $sub->id) }}"
                                       class="font-mono text-xs font-bold text-[#004B59] hover:underline">
                                        {{ $sub->reference_number }}
                                    </a>
                                </td>
                                <td class="max-w-xs py-3.5 px-3">
                                    <a href="{{ route('admin.submissions.show', $sub->id) }}"
                                       class="block truncate font-semibold text-slate-900 hover:text-[#00A3C4]">
                                        {{ $sub->title }}
                                    </a>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach($sub->categories->take(2) as $c)
                                            <span class="inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold bg-cyan-50 text-[#004B59] border border-cyan-100">{{ $c->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap font-medium text-slate-700">{{ $sub->submitter_name }}</td>
                                <td class="py-3.5 px-3 whitespace-nowrap text-slate-400">{{ $sub->submitter_department ?? '—' }}</td>
                                <td class="py-3.5 px-3 whitespace-nowrap">
                                    <x-badge :status="$sub->status" />
                                </td>
                                <td class="py-3.5 px-3 whitespace-nowrap text-slate-400">{{ $sub->created_at->format('M d, Y') }}</td>
                                <td class="py-3.5 pl-3 pr-6 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.submissions.show', $sub->id) }}"
                                       class="inline-flex items-center gap-1 rounded-lg bg-[#00A3C4]/10 px-3 py-1.5 text-xs font-semibold text-[#00A3C4] transition hover:bg-[#00A3C4] hover:text-white">
                                        Review
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-slate-400">
                                    <svg class="mx-auto mb-3 h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    No submissions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CHART.JS INITIALIZATION                                      --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <script>
        function dashboardPage() { return {}; }

        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = 'Inter, ui-sans-serif, system-ui';

            // ── 1. Status Doughnut ──
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                const statusLabels = {!! json_encode($byStatus->keys()) !!};
                const statusData   = {!! json_encode($byStatus->values()) !!};
                const colorMap = {
                    'Submitted':            '#3B82F6',
                    'Under Review':         '#F59E0B',
                    'Need More Information': '#F97316',
                    'Approved':             '#10B981',
                    'Rejected':             '#EF4444',
                    'Implemented':          '#00A3C4',
                };
                new window.Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: statusLabels.map(l => colorMap[l] || '#94A3B8'),
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${ctx.parsed} submissions`
                                }
                            }
                        },
                        cutout: '72%',
                        animation: { animateRotate: true, duration: 900 }
                    }
                });
            }

            // ── 2. Monthly Trend (area line) ──
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                const trendLabels = {!! json_encode($monthlyTrend->keys()) !!};
                const trendData   = {!! json_encode($monthlyTrend->values()) !!};
                new window.Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [{
                            label: 'Submissions',
                            data: trendData,
                            borderColor: '#00A3C4',
                            backgroundColor: (ctx) => {
                                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 220);
                                gradient.addColorStop(0,   'rgba(0,163,196,0.25)');
                                gradient.addColorStop(1,   'rgba(0,163,196,0)');
                                return gradient;
                            },
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#004B59',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                titleFont: { size: 11 },
                                bodyFont: { size: 12, weight: 'bold' },
                                padding: 10,
                                cornerRadius: 10,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0, font: { size: 10 } },
                                grid: { color: '#f1f5f9' }
                            },
                            x: {
                                ticks: { font: { size: 10 } },
                                grid: { display: false }
                            }
                        },
                        animation: { duration: 800, easing: 'easeInOutQuart' }
                    }
                });
            }

            // ── 3. Category Horizontal Bar ──
            const catCtx = document.getElementById('categoryChart');
            if (catCtx) {
                const catLabels = {!! json_encode($byCategory->pluck('name')) !!};
                const catData   = {!! json_encode($byCategory->pluck('submissions_count')) !!};
                const palette   = ['#004B59','#006b7a','#00A3C4','#0e9f9f','#1da89e','#34c0b0','#64d6c4','#94e8da'];
                new window.Chart(catCtx, {
                    type: 'bar',
                    data: {
                        labels: catLabels,
                        datasets: [{
                            data: catData,
                            backgroundColor: catLabels.map((_, i) => palette[i % palette.length]),
                            borderRadius: 6,
                            maxBarThickness: 26,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: { label: ctx => ` ${ctx.parsed.x} ideas` }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { precision: 0, font: { size: 10 } },
                                grid: { color: '#f1f5f9' }
                            },
                            y: {
                                ticks: { font: { size: 10 } },
                                grid: { display: false }
                            }
                        },
                        animation: { duration: 700 }
                    }
                });
            }
        });
    </script>
</x-app-layout>
