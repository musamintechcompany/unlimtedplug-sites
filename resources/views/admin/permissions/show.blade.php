<x-admin-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.permissions.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $permission->name }}</h2>
            <p class="text-gray-600 dark:text-gray-400">Permission Details</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Name</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $permission->name }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Guard</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $permission->guard_name }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">ID</span>
                        <span class="text-gray-600 dark:text-gray-400 font-mono text-sm">{{ $permission->id }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Created</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $permission->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            @if($permission->roles->count() > 0)
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Assigned to Roles</h3>
                
                <div class="space-y-2">
                    @foreach($permission->roles as $role)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-blue-600 dark:text-blue-400"></i>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $role->name }}</span>
                            </div>
                            <a href="{{ route('admin.roles.show', $role) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                View Role
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div>
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    @can('delete-permissions')
                    <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" onsubmit="return confirm('Delete this permission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg transition font-medium">
                            <i class="fas fa-trash mr-2"></i> Delete Permission
                        </button>
                    </form>
                    @endcan
                </div>
            </div>

            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Summary</h3>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Assigned to Roles</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $permission->roles->count() }}</p>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Module</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ ucfirst(explode('-', $permission->name)[0]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
