<x-admin-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Admin</h1>

        <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('email') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Roles -->
            <div>
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Roles</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $admin->roles->contains($role->id) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                        <span class="text-sm text-gray-900 dark:text-white">{{ ucfirst($role->name) }}</span>
                    </label>
                    @endforeach
                </div>
                @error('roles') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    Update Admin
                </button>
                <a href="{{ route('admin.admins.index') }}" class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-6 py-2 rounded-lg font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
