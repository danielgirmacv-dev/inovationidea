<x-guest-layout title="Staff Login">
    <div class="py-16 bg-slate-50 min-h-[85vh] flex items-center justify-center">
        <div class="max-w-md w-full mx-auto px-4 sm:px-6">
            
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-10"
                 x-data="{ 
                     email: '{{ old('email', 'admin@eec.com.et') }}', 
                     password: 'password123',
                     quickLogin(em, pw) {
                         this.email = em;
                         this.password = pw;
                         this.$nextTick(() => { this.$refs.loginForm.submit(); });
                     }
                 }">
                <!-- Brand / Logo Header -->
                <div class="text-center mb-8">
                    <div class="h-16 w-16 mx-auto rounded-2xl bg-white p-2 border border-slate-200 shadow-xs flex items-center justify-center overflow-hidden mb-4">
                        <img src="{{ asset('eec-logo.png') }}" alt="EEC Logo" class="h-full w-full object-contain">
                    </div>
                    <h1 class="text-2xl font-bold text-[#004B59] tracking-tight">Staff Portal Login</h1>
                    <p class="text-xs text-slate-500 mt-1">Reviewers & Innovation Committee Sign In</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 rounded-xl bg-rose-50 border border-rose-200 p-4 text-xs text-rose-800">
                        <p class="font-semibold">{{ $errors->first() }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-xs text-emerald-800">
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                <form x-ref="loginForm" action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Corporate Email
                        </label>
                        <div class="mt-1.5">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   x-model="email"
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="username@eec.com.et"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 outline-hidden transition text-slate-900 text-sm">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Password
                            </label>
                        </div>
                        <div class="mt-1.5">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   x-model="password"
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#00A3C4] focus:ring-2 focus:ring-[#00A3C4]/30 outline-hidden transition text-slate-900 text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#004B59] focus:ring-[#00A3C4]" checked>
                            <span class="text-slate-600">Remember session</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl bg-[#004B59] hover:bg-[#003640] text-white font-bold text-sm shadow-md hover:shadow-lg transition">
                        Sign In to Portal
                    </button>
                </form>

                <!-- One-Click Demo Logins -->
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 text-center">One-Click Quick Login</p>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" 
                                @click="quickLogin('admin@eec.com.et', 'password123')"
                                class="flex flex-col items-start p-3 rounded-2xl border border-cyan-200 bg-cyan-50/60 hover:bg-cyan-100 hover:border-cyan-300 transition text-left group">
                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-[#004B59]">
                                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                                Login as Admin
                            </span>
                            <span class="text-[11px] text-slate-500 mt-1">Full management access</span>
                        </button>

                        <button type="button" 
                                @click="quickLogin('reviewer@eec.com.et', 'password123')"
                                class="flex flex-col items-start p-3 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-300 transition text-left group">
                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-slate-800">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                Login as Reviewer
                            </span>
                            <span class="text-[11px] text-slate-500 mt-1">Review & evaluate queue</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-guest-layout>
