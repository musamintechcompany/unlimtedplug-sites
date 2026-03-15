<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC]">Dashboard</h1>
        <p class="text-gray-600 dark:text-[#A1A09A] mt-2">Welcome back, {{ auth('admin')->user()->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <x-widgets.stats.total-users />
        <x-widgets.stats.online-users />
        <x-widgets.stats.total-projects />
        <x-widgets.stats.total-rentals />
        <x-widgets.stats.total-admins />
    </div>

    <x-widgets.charts.visitors />

    @can('view-rentals')
    <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-[#EDEDEC] mb-4">Recent Rentals</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Project</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Expires At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse(\App\Models\Rental::with('user', 'project')->latest()->take(10)->get() as $rental)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                        <td class="px-4 py-3 border-r border-gray-200 dark:border-gray-800">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $rental->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rental->user->email }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 border-r border-gray-200 dark:border-gray-800">
                            <span class="text-sm text-gray-900 dark:text-white">{{ $rental->project->name }}</span>
                        </td>
                        <td class="px-4 py-3 border-r border-gray-200 dark:border-gray-800">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($rental->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($rental->status === 'suspended') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border-r border-gray-200 dark:border-gray-800">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $rental->rental_expires_at ? $rental->rental_expires_at->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $rental->created_at->format('M d, Y') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500 dark:text-[#A1A09A]">No rentals found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endcan
</x-admin-layout>
