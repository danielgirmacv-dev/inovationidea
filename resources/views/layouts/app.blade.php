<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Portal' }} - EEC Innovation Hub</title>
    <link rel="icon" type="image/png" href="{{ asset('eec-logo.png') }}">

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-cloak 
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-[#003640] text-white flex flex-col transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-xl">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-white p-1 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('eec-logo.png') }}" alt="EEC Logo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <div class="font-bold text-base tracking-tight text-white flex items-center gap-2">
                            <span>EEC</span>
                            <span class="text-[10px] px-1.5 py-0.5 font-semibold uppercase bg-cyan-400/20 text-cyan-300 rounded border border-cyan-400/30">Admin</span>
                        </div>
                        <p class="text-[11px] text-slate-300 truncate max-w-[150px]">Innovation Portal</p>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-cyan-300/70">Overview</div>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#00A3C4] text-white shadow-sm font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard & Analytics</span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-cyan-300/70">Submissions</div>

                <a href="{{ route('admin.submissions.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.submissions.*') ? 'bg-[#00A3C4] text-white shadow-sm font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Idea Submissions</span>
                    </div>
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-cyan-300/70">Administration</div>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#00A3C4] text-white shadow-sm font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>Categories</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-[#00A3C4] text-white shadow-sm font-semibold' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Users & Reviewers</span>
                    </a>
                @endif

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-cyan-300/70">Public Portal</div>

                <a href="{{ route('ideas.create') }}" target="_blank"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-200 hover:bg-white/10 hover:text-white transition">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>View Public Form</span>
                </a>
            </div>

            <!-- Current User Info & Logout -->
            <div class="p-4 border-t border-white/10 bg-black/20">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="h-10 w-10 rounded-full {{ auth()->user()->role === 'admin' ? 'bg-[#00A3C4]' : 'bg-amber-600' }} text-white font-bold flex items-center justify-center shrink-0 shadow-xs uppercase">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ auth()->user()->role === 'admin' ? 'bg-cyan-400/20 text-cyan-300 border border-cyan-400/30' : 'bg-amber-400/20 text-amber-300 border border-amber-400/30' }}">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Sign Out" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs text-slate-300 hover:text-rose-300 rounded-lg hover:bg-white/10 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span class="hidden xl:inline text-[11px] font-semibold">Exit</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white border-b border-slate-200 h-20 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('ideas.create') }}" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 text-xs font-semibold text-[#004B59] bg-cyan-50 border border-cyan-200 rounded-lg hover:bg-cyan-100 transition">
                        <svg class="w-4 h-4 text-[#00A3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>New Submission</span>
                    </a>

                    <!-- User Status Chip & Quick Logout -->
                    <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                        <div class="hidden md:flex flex-col items-end text-right">
                            <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider {{ auth()->user()->role === 'admin' ? 'text-[#00A3C4]' : 'text-amber-600' }}">
                                Role: {{ auth()->user()->role }}
                            </span>
                        </div>
                        <a href="{{ route('logout') }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 transition"
                           title="Sign out of current account">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
                <!-- Notifications/Flashes -->
                @if (session('success'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 flex items-start gap-3 shadow-xs">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="text-sm font-medium">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 flex items-start gap-3 shadow-xs">
                        <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div class="text-sm font-medium">{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-rose-800 shadow-xs">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-rose-900 mb-1">Please correct the following errors:</h4>
                                <ul class="list-disc list-inside text-xs space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
