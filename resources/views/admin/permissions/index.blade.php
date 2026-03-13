<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Permissions</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage system permissions</p>
        </div>
        @can('create-permissions')
        <a href="{{ route('admin.permissions.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Permission
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-x-auto" x-data="{ selected: [], selectAll: false, allIds: {{ json_encode($permissions->pluck('id')->toArray()) }} }">
        @can('delete-permissions')
        <div x-show="selected.length > 0" class="p-4 border-b border-gray-200 dark:border-gray-800 bg-blue-50 dark:bg-blue-900/20 flex justify-between items-center" x-cloak>
            <span class="text-blue-800 dark:text-blue-200"><span x-text="selected.length"></span> permission(s) selected</span>
            <button @click="if(confirm('Delete selected permissions?')) { $refs.bulkForm.submit() }" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                Delete Selected
            </button>
        </div>
        @endcan

        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                <tr>
                    @can('delete-permissions')
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10 w-12">
                        <input type="checkbox" x-model="selectAll" @change="selectAll ? selected = allIds : selected = []" class="rounded">
                    </th>
                    @endcan
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Guard</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($permissions as $permission)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                    @can('delete-permissions')
                    <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                        <input type="checkbox" :value="'{{ $permission->id }}'" x-model="selected" class="rounded">
                    </td>
                    @endcan
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">{{ $permission->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800">{{ $permission->guard_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $permission->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-3">
                            @can('view-permissions')
                            <a href="{{ route('admin.permissions.show', $permission) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                View
                            </a>
                            @endcan
                            @can('delete-permissions')
                            <span class="text-gray-300 dark:text-gray-700">|</span>
                            <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" class="inline" onsubmit="return confirm('Delete this permission?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                    Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No permissions found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @can('delete-permissions')
    <form x-ref="bulkForm" action="{{ route('admin.permissions.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="ids[]" :value="id">
        </template>
    </form>
    @endcan
</x-admin-layout>
