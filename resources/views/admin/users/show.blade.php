<x-admin-layout>
    <div class="container mx-auto px-4">
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 text-sm">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4 sm:mb-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</h2>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center text-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- User Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">User Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Name</p>
                    <p class="text-base sm:text-lg font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Email</p>
                    <p class="text-base sm:text-lg font-medium text-gray-900 dark:text-white truncate">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Email Verified</p>
                    @if($user->email_verified_at)
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->email_verified_at->format('M d, Y H:i') }}</p>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                            <i class="fas fa-exclamation-circle"></i> Not Verified
                        </span>
                    @endif
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Status</p>
                    <span class="px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold bg-green-100 text-green-800">
                        {{ ucfirst($user->status ?? 'active') }}
                    </span>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Joined</p>
                    <p class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Wallet Information -->
        @if ($wallet)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Wallet & Credits</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Current Balance</p>
                        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ number_format($wallet->balance) }}</p>
                        <p class="text-xs text-gray-500">credits</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Credits Purchased</p>
                        <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ number_format($transactions->where('type', 'credit')->sum('credits')) }}</p>
                        <p class="text-xs text-gray-500">credits</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Credits Spent</p>
                        <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ number_format($rentals->sum('credits_cost')) }}</p>
                        <p class="text-xs text-gray-500">credits</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Active Rentals -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Rentals ({{ $rentals->where('status', 'active')->count() }})</h3>
            @if ($rentals->where('status', 'active')->count() > 0)
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <table class="w-full min-w-[600px]">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Project</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Status</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Expires</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($rentals->where('status', 'active') as $rental)
                                <tr>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm truncate max-w-[200px]">{{ $rental->rentableProject->name ?? 'N/A' }}</td>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm"><span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs whitespace-nowrap">{{ ucfirst($rental->status) }}</span></td>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm whitespace-nowrap">{{ $rental->rental_expires_at?->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400">No active rentals</p>
            @endif
        </div>

        <!-- Rental History -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Rental History ({{ $rentals->count() }})</h3>
            @if ($rentals->count() > 0)
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <table class="w-full min-w-[700px]">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Project</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Status</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Started</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs sm:text-sm font-semibold">Expires</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($rentals as $rental)
                                <tr>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm truncate max-w-[200px]">{{ $rental->rentableProject->name ?? 'N/A' }}</td>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs whitespace-nowrap">{{ ucfirst($rental->status) }}</span></td>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm whitespace-nowrap">{{ $rental->created_at->format('M d, Y') }}</td>
                                    <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm whitespace-nowrap">{{ $rental->rental_expires_at?->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400">No rental history</p>
            @endif
        </div>
    </div>
</x-admin-layout>
