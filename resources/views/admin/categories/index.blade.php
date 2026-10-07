<x-app-layout title="Innovation Categories">
    <x-slot:header>
        Innovation Categories
    </x-slot:header>

    <div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, currentCategory: {} }">
        
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500">Manage categories available for employees when submitting innovative ideas.</p>
            </div>
            <button @click="addModalOpen = true" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#004B59] hover:bg-[#003640] text-white font-semibold text-xs shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Category</span>
            </button>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6">Name & Description</th>
                        <th class="py-3.5 px-6">Color</th>
                        <th class="py-3.5 px-6">Order</th>
                        <th class="py-3.5 px-6">Active</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $cat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-white shrink-0 shadow-xs" style="background-color: {{ $cat->color ?? '#004B59' }}">
                                        {{ substr($cat->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $cat->name }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5 max-w-md truncate">{{ $cat->description ?? 'No description.' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap font-mono text-slate-600">
                                <span class="inline-block w-3 h-3 rounded-full mr-1.5 align-middle border border-slate-300" style="background-color: {{ $cat->color }}"></span>
                                {{ $cat->color ?? '—' }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap font-bold text-slate-700">
                                {{ $cat->sort_order }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <form action="{{ route('admin.categories.toggle', $cat->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $cat->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $cat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $cat->is_active ? 'Active' : 'Disabled' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <button @click="currentCategory = {{ json_encode($cat) }}; editModalOpen = true" 
                                        class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No categories created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add Category Modal -->
        <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="addModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1">Add Innovation Category</h3>
                <p class="text-xs text-slate-500 mb-4">Define a new theme for employee submissions.</p>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Name</label>
                        <input type="text" name="name" required placeholder="e.g., Artificial Intelligence & Automation" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Brief scope of this category..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Theme Color Hex</label>
                        <input type="text" name="color" value="#004B59" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#004B59] text-white hover:bg-[#003640]">Create Category</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="editModalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-1">Edit Category</h3>
                <p class="text-xs text-slate-500 mb-4">Modify category properties.</p>

                <form :action="'/admin/categories/' + currentCategory.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Name</label>
                        <input type="text" name="name" :value="currentCategory.name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description</label>
                        <textarea name="description" rows="2" :value="currentCategory.description" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Theme Color Hex</label>
                        <input type="text" name="color" :value="currentCategory.color" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-[#004B59] text-white hover:bg-[#003640]">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
