<x-admin-layout>
    <div class="container mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <!-- User Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->email }}</p>
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
                    <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        {{ ucfirst($user->status ?? 'active') }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Joined</p>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Wallet Information -->
        @if ($wallet)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Wallet & Credits</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Current Balance</p>
                        <p class="text-3xl font-bold text-green-600">{{ $wallet->balance }} credits</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Spent</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $transactions->sum('credits') ?? 0 }} credits</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Active Rentals -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Rentals ({{ $rentals->where('status', 'active')->count() }})</h3>
            @if ($rentals->where('status', 'active')->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Project</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Expires</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($rentals->where('status', 'active') as $rental)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $rental->rentableProject->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">{{ ucfirst($rental->status) }}</span></td>
                                    <td class="px-4 py-2 text-sm">{{ $rental->rental_expires_at?->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">No active rentals</p>
            @endif
        </div>

        <!-- Rental History -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Rental History ({{ $rentals->count() }})</h3>
            @if ($rentals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Project</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Started</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Expires</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($rentals as $rental)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $rental->rentableProject->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ ucfirst($rental->status) }}</span></td>
                                    <td class="px-4 py-2 text-sm">{{ $rental->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $rental->rental_expires_at?->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">No rental history</p>
            @endif
        </div>
    </div>
</x-admin-layout>
