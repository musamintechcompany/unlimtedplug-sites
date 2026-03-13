<x-admin-layout>
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $admin->name }}</h1>
            <div class="flex gap-2">
                @can('edit-admins')
                <a href="{{ route('admin.admins.edit', $admin) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete-admins')
                @if($admin->id !== auth('admin')->id())
                <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endif
                @endcan
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
            <!-- Admin Info -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Information</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Name</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $admin->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Email</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $admin->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Status</p>
                        <p class="text-gray-900 dark:text-white font-medium">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $admin->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Theme</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ ucfirst($admin->theme) }}</p>
                    </div>
                </div>
            </div>

            <!-- Roles -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Roles</h2>
                <div class="flex gap-2 flex-wrap">
                    @forelse($admin->roles as $role)
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">{{ ucfirst($role->name) }}</span>
                    @empty
                    <p class="text-gray-600 dark:text-gray-400">No roles assigned</p>
                    @endforelse
                </div>
            </div>

            <!-- Dates -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Dates</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Created</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $admin->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    @if($admin->last_login_at)
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Last Login</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $admin->last_login_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.admins.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="fas fa-arrow-left"></i> Back to Admins
            </a>
        </div>
    </div>
</x-admin-layout>
