<x-app-layout title="User & Reviewer Management">
    <x-slot:header>
        Users & Technical Reviewers
    </x-slot:header>

    <div class="space-y-6" x-data="{ addModalOpen: false }">
        
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500">Manage administrator and reviewer access to the innovation review portal.</p>
            </div>
            <button @click="addModalOpen = true" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#004B59] hover:bg-[#003640] text-white font-semibold text-xs shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>Add Staff User</span>
            </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">Name & Email</th>
                        <th class="py-3.5 px-6">Role</th>
                        <th class="py-3.5 px-6">Department & Site</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $u)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-[#004B59] text-white font-bold flex items-center justify-center uppercase shrink-0 shadow-xs">
                                        {{ substr($u->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $u->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $u->email }}</p>
                                        @if($u->job_title)
                                            <p class="text-[11px] text-slate-400">{{ $u->job_title }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <form action="{{ route('admin.users.updateRole', $u->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="px-2.5 py-1 rounded-lg border border-slate-200 text-xs font-semibold uppercase tracking-wider {{ $u->role === 'admin' ? 'bg-purple-50 text-purple-700' : ($u->role === 'reviewer' ? 'bg-cyan-50 text-cyan-800' : 'bg-slate-50 text-slate-700') }}">
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="reviewer" {{ $u->role === 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                                        <option value="employee" {{ $u->role === 'employee' ? 'selected' : '' }}>Employee</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <p class="font-medium text-slate-800">{{ $u->department ?? '—' }}</p>
                                <p class="text-[11px] text-slate-400">{{ $u->site ?? '' }}</p>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $u->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $u->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    <span>{{ $u->is_active ? 'Active' : 'Inactive' }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                @if ($u->id !== auth()->id())
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $u->is_active ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }} transition">
                                                {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to permanently delete {{ addslashes($u->name) }}? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" 
                                                    title="Delete User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Current User</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Add User Modal -->
        <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1">Create Staff User Account</h3>
                <p class="text-xs text-slate-500 mb-4">Grant portal access to evaluators or administrators.</p>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="name" required placeholder="Abebe Balcha" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Corporate Email</label>
                            <input type="email" name="email" required placeholder="abebe.b@eec.com.et" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
                            <input type="password" name="password" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">System Role</label>
                            <select name="role" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 bg-white">
                                <option value="reviewer">Reviewer</option>
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Job Title</label>
                            <input type="text" name="job_title" placeholder="Lead Geotechnical Engineer" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Department</label>
                            <input type="text" name="department" placeholder="Civil Works" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Site / Office</label>
                            <input type="text" name="site" placeholder="Head Office" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#004B59] text-white hover:bg-[#003640]">Create Account</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
