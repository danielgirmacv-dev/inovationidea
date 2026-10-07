@props(['status'])

@php
    $statusClasses = [
        'Submitted' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-600/10',
        'Under Review' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/10',
        'Need More Information' => 'bg-orange-50 text-orange-700 border-orange-200 ring-orange-600/10',
        'Approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/10',
        'Rejected' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-600/10',
        'Implemented' => 'bg-teal-50 text-teal-800 border-teal-200 ring-teal-600/10',
    ];

    $dotClasses = [
        'Submitted' => 'bg-blue-500',
        'Under Review' => 'bg-amber-500',
        'Need More Information' => 'bg-orange-500',
        'Approved' => 'bg-emerald-500',
        'Rejected' => 'bg-rose-500',
        'Implemented' => 'bg-teal-500',
    ];

    $currentClass = $statusClasses[$status] ?? 'bg-slate-50 text-slate-700 border-slate-200 ring-slate-600/10';
    $dotClass = $dotClasses[$status] ?? 'bg-slate-400';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {$currentClass}"]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
    <span>{{ $status }}</span>
</span>
