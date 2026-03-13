<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Users</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage user accounts and rentals</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-sync"></i>Refresh
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border border-gray-200 dark:border-gray-800 shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Credits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Rentals</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-black divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <div class="flex items-center gap-3">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                @if($user->email_verified_at)
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        <i class="fas fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                        <i class="fas fa-exclamation-circle"></i> Unverified
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm font-medium">{{ $user->wallet?->credits_balance ?? 0 }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm">{{ $user->rentals()->count() }}</td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $user->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                    {{ ucfirst($user->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm">
                                        View
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium text-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-users text-3xl mb-2 opacity-50 block"></i>
                                <p>No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
