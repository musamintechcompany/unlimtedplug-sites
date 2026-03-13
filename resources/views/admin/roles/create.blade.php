<x-admin-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Role</h1>

        <form method="POST" action="{{ route('admin.roles.store') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
            @csrf

            <!-- Role Name -->
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Role Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Permissions -->
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-4">Permissions</label>
                <div class="space-y-6">
                    @foreach($permissions as $group => $groupPermissions)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 capitalize">{{ $group }}</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($groupPermissions as $permission)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                                <span class="text-sm text-gray-900 dark:text-white">{{ str_replace('-', ' ', $permission->name) }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('permissions') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    Create Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-6 py-2 rounded-lg font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
