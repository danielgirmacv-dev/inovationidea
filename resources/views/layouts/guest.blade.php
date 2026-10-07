<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'EEC Innovative Idea Submission System' }} - Ethiopian Engineering Corporation</title>
    <meta name="description" content="Empowering every EEC employee to submit impactful engineering, operational, and digital innovations.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('eec-logo.png') }}">

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans text-slate-800 antialiased selection:bg-cyan-500 selection:text-white">
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <a href="{{ route('ideas.create') }}" class="flex items-center gap-3.5 group">
                    <div class="h-12 w-12 rounded-xl bg-white p-1 border border-slate-200 shadow-xs flex items-center justify-center overflow-hidden transition group-hover:shadow-md">
                        <img src="{{ asset('eec-logo.png') }}" alt="EEC Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-bold tracking-tight text-[#004B59]">EEC</span>
                            <span class="px-2 py-0.5 text-xs font-semibold uppercase tracking-wider rounded-full bg-cyan-100 text-[#004B59]">Innovation Hub</span>
                        </div>
                        <p class="text-xs text-slate-500 hidden sm:block">Ethiopian Engineering Corporation</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('ideas.create') }}" 
                       class="px-3.5 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('ideas.create') ? 'bg-[#004B59] text-white shadow-xs' : 'text-slate-700 hover:text-[#004B59] hover:bg-slate-100' }}">
                        Submit Idea
                    </a>
                    <a href="{{ route('ideas.track') }}" 
                       class="px-3.5 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('ideas.track') ? 'bg-[#004B59] text-white shadow-xs' : 'text-slate-700 hover:text-[#004B59] hover:bg-slate-100' }}">
                        Track Status
                    </a>

                    <div class="h-5 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-[#00A3C4] hover:bg-[#008ba8] rounded-lg shadow-xs transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-slate-600 hover:text-[#004B59] hover:bg-slate-100 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Staff Login</span>
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">
        <!-- Flash Alerts -->
        @if (session('success'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-6">
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 flex items-start gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-4xl mx-auto px-4 sm:px-6 pt-6">
                <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 flex items-start gap-3 shadow-xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-auto bg-white border-t border-slate-200 text-slate-500 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('eec-logo.png') }}" alt="EEC" class="h-7 w-auto object-contain grayscale opacity-70">
                <span>&copy; {{ date('Y') }} <strong>Ethiopian Engineering Corporation</strong>. Corporate Strategy & Innovation Office.</span>
            </div>
            <div class="flex items-center gap-6 text-xs">
                <a href="{{ route('ideas.track') }}" class="hover:text-[#004B59] transition">Track Submission</a>
                <span class="text-slate-300">•</span>
                <span class="text-slate-400">Head Office, Addis Ababa, Ethiopia</span>
            </div>
        </div>
    </footer>
</body>
</html>
