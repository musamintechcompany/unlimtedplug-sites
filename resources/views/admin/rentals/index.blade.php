<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Rentals</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage all active and inactive rentals</p>
        </div>
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
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Project</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Expires</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($rentals as $rental)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">
                        <div class="flex items-center gap-2">
                            @if($rental->user->profile_photo)
                                <img src="{{ asset('storage/' . $rental->user->profile_photo) }}" alt="{{ $rental->user->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($rental->user->name, 0, 1) }}
                                </div>
                            @endif
                            <span>{{ $rental->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800">{{ $rental->rentableProject->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">
                        {{ $rental->duration_value }} {{ ucfirst($rental->duration_type) }}{{ $rental->duration_value > 1 ? 's' : '' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">{{ number_format($rental->credits_cost) }} credits</td>
                    <td class="px-6 py-4 text-sm border-r border-gray-200 dark:border-gray-800">
                        @if($rental->status === 'active')
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-xs font-medium">Active</span>
                        @elseif($rental->status === 'suspended')
                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-xs font-medium">Suspended</span>
                        @elseif($rental->status === 'cancelled')
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-xs font-medium">Cancelled</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300 rounded-full text-xs font-medium">{{ ucfirst($rental->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">
                        @if($rental->rental_expires_at)
                            <div>{{ $rental->rental_expires_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500">{{ $rental->rental_expires_at->diffForHumans() }}</div>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.rentals.show', $rental) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                View
                            </a>
                            @can('cancel-rentals')
                                @if($rental->status === 'active')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.rentals.suspend', $rental) }}" class="inline" onsubmit="return confirm('Suspend this rental?')">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium">
                                            Suspend
                                        </button>
                                    </form>
                                @elseif($rental->status === 'suspended')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.rentals.activate', $rental) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                            Activate
                                        </button>
                                    </form>
                                @endif
                                @if($rental->status !== 'cancelled')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.rentals.cancel', $rental) }}" class="inline" onsubmit="return confirm('Cancel this rental?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No rentals found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $rentals->links() }}
    </div>
</x-admin-layout>
