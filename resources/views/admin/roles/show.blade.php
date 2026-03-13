<x-admin-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $role->name }}</h2>
            <p class="text-gray-600 dark:text-gray-400">Role Details</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Permissions</h3>
                
                @if($role->permissions->count() > 0)
                    <div class="space-y-6">
                        @php
                            $grouped = $role->permissions->groupBy(function ($permission) {
                                return explode('-', $permission->name)[0];
                            });
                        @endphp
                        
                        @foreach($grouped as $module => $permissions)
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase mb-3 px-4 py-2 bg-gray-100 dark:bg-gray-900 rounded">
                                    {{ ucfirst($module) }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-4">
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center gap-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                            <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No permissions assigned</p>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    @if($role->name !== 'superadmin')
                        @can('edit-roles')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="block w-full px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white rounded-lg transition font-medium text-center">
                            <i class="fas fa-edit mr-2"></i> Edit Role
                        </a>
                        @endcan
                        @can('delete-roles')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg transition font-medium">
                                <i class="fas fa-trash mr-2"></i> Delete Role
                            </button>
                        </form>
                        @endcan
                    @else
                        <div class="px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-lg text-center text-sm font-medium">
                            <i class="fas fa-lock mr-2"></i> Superadmin role cannot be edited
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Summary</h3>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Permissions</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $role->permissions->count() }}</p>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Created</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->created_at->format('M d, Y') }}</p>
                    </div>

                    @if($role->updated_at->ne($role->created_at))
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Last Updated</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
