<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Admins</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage admin accounts</p>
        </div>
        @can('create-admins')
        <a href="{{ route('admin.admins.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Admin
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap border-r border-white/10">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap border-r border-white/10">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap border-r border-white/10">Roles</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap border-r border-white/10">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap border-r border-white/10">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 min-w-0">
                        <div class="flex items-center gap-3">
                            @if($admin->profile_photo_path)
                                <img src="{{ asset('storage/' . $admin->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-shield text-gray-500 dark:text-gray-400"></i>
                                </div>
                            @endif
                            <div class="truncate max-w-[200px]" title="{{ $admin->name }}">{{ $admin->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 min-w-0">
                        <div class="truncate max-w-[250px]" title="{{ $admin->email }}">{{ $admin->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm border-r border-gray-200 dark:border-gray-800">
                        <div class="flex gap-1 flex-wrap">
                            @forelse($admin->roles as $role)
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">{{ $role->name }}</span>
                            @empty
                                <span class="text-gray-500 dark:text-gray-400 text-xs">No roles</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm border-r border-gray-200 dark:border-gray-800">
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $admin->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                            {{ ucfirst($admin->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $admin->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            @can('view-admins')
                            <a href="{{ route('admin.admins.show', $admin) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                View
                            </a>
                            @endcan
                            @can('edit-admins')
                            <span class="text-gray-300 dark:text-gray-700">|</span>
                            <a href="{{ route('admin.admins.edit', $admin) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                Edit
                            </a>
                            @endcan
                            @can('delete-admins')
                            @if($admin->id !== auth('admin')->id())
                            <span class="text-gray-300 dark:text-gray-700">|</span>
                            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                    Delete
                                </button>
                            </form>
                            @endif
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No admins found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages())
        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    @endif
</x-admin-layout>
