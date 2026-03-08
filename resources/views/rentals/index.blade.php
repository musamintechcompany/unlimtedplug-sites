<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC]">My Rentals</h1>
                <p class="mt-2 text-gray-600 dark:text-[#A1A09A]">View and manage your active rentals</p>
            </div>

            @if($rentals->isEmpty())
                <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500 dark:text-[#A1A09A]">No active rentals</p>
                    <a href="{{ route('browse') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Browse Projects
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                            <thead class="bg-gray-50 dark:bg-[#1a1a19]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Project</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Expires</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Cost</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-[#161615] divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                                @foreach($rentals as $rental)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-[#1a1a19] transition cursor-pointer" onclick="window.location='{{ route('rentals.show', $rental->id) }}'">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $rental->rentableProject->name }}</div>
                                            @if($rental->admin_email)
                                            <div class="text-xs text-gray-500 dark:text-[#A1A09A] mt-1">{{ $rental->admin_email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($rental->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($rental->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @endif">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-[#A1A09A]">
                                            {{ ucfirst($rental->duration_type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-[#A1A09A]">
                                            {{ $rental->rental_expires_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-[#A1A09A]">
                                            {{ $rental->credits_cost }} credits
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('rentals.show', $rental->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" onclick="event.stopPropagation()">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
