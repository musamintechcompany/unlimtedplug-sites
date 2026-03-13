<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Roles</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage admin roles and permissions</p>
        </div>
        @can('create-roles')
        <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Role
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Permissions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($roles as $role)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">
                        <div class="flex items-center gap-2">
                            @if($role->name === 'superadmin')
                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded text-xs font-medium">Super</span>
                            @endif
                            {{ $role->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-xs font-medium">
                            {{ $role->permissions_count }} permission{{ $role->permissions_count !== 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $role->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.roles.show', $role) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                View
                            </a>
                            @if($role->name !== 'superadmin')
                                @can('edit-roles')
                                <span class="text-gray-300 dark:text-gray-700">|</span>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                    Edit
                                </a>
                                @endcan
                                @can('delete-roles')
                                <span class="text-gray-300 dark:text-gray-700">|</span>
                                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline" onsubmit="return confirm('Delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No roles found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $roles->links() }}
    </div>
</x-admin-layout>
