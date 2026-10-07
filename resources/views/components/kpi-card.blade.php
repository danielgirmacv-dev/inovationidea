@props(['title', 'value', 'icon' => null, 'trend' => null, 'color' => 'teal', 'change' => null, 'changeType' => 'neutral'])

@php
    $colorClasses = [
        'teal'    => 'bg-teal-50 text-[#004B59] border-teal-100',
        'cyan'    => 'bg-cyan-50 text-[#00A3C4] border-cyan-100',
        'amber'   => 'bg-amber-50 text-amber-600 border-amber-100',
        'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'rose'    => 'bg-rose-50 text-rose-600 border-rose-100',
        'blue'    => 'bg-blue-50 text-blue-600 border-blue-100',
        'orange'  => 'bg-orange-50 text-orange-600 border-orange-100',
        'violet'  => 'bg-violet-50 text-violet-600 border-violet-100',
    ];
    $borderAccent = [
        'teal'    => 'border-t-[#004B59]',
        'cyan'    => 'border-t-[#00A3C4]',
        'amber'   => 'border-t-amber-500',
        'emerald' => 'border-t-emerald-500',
        'rose'    => 'border-t-rose-500',
        'blue'    => 'border-t-blue-500',
        'orange'  => 'border-t-orange-500',
        'violet'  => 'border-t-violet-500',
    ];
    $iconBg = $colorClasses[$color] ?? $colorClasses['teal'];
    $accentBorder = $borderAccent[$color] ?? $borderAccent['teal'];
    $changeColor = match($changeType) {
        'up'   => 'text-emerald-600 bg-emerald-50',
        'down' => 'text-rose-600 bg-rose-50',
        default => 'text-slate-500 bg-slate-100',
    };
@endphp

<div class="bg-white rounded-2xl border border-slate-200/80 border-t-2 {{ $accentBorder }} p-5 shadow-xs hover:shadow-md transition-all duration-200 group">
    <div class="flex items-start justify-between">
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">{{ $title }}</p>
            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight tabular-nums">{{ $value }}</h3>
        </div>
        @if ($icon)
            <div class="h-12 w-12 rounded-xl flex items-center justify-center border {{ $iconBg }} shrink-0 group-hover:scale-110 transition-transform duration-200">
                {!! $icon !!}
            </div>
        @endif
    </div>
    <div class="mt-3 flex items-center justify-between">
        @if ($trend)
            <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                <span>{{ $trend }}</span>
            </div>
        @endif
        @if ($change)
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold {{ $changeColor }}">
                @if ($changeType === 'up')
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"/></svg>
                @elseif ($changeType === 'down')
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                @endif
                {{ $change }}
            </span>
        @endif
    </div>
</div>
