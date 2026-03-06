<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="pb-6">
                <h1 class="text-base sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ __('Welcome back') }}, {{ auth()->user()->name }}!</h1>
                <p class="mt-2 text-xs sm:text-base text-gray-600 dark:text-[#A1A09A]">Manage your rentals and explore amazing projects</p>
            </div>

            <!-- Stats Cards -->
            <div class="py-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Credits Balance -->
                <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-6 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Credits Balance</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mt-1">{{ auth()->user()->wallet->credits_balance ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Rentals -->
                <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-6 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Rentals</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mt-1">0</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Active Rentals Section -->
            @if($activeRentals->count() > 0)
            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-[#EDEDEC]">Active Rentals</h2>
                    <a href="{{ route('rentals.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                </div>
                
                <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                            <thead class="bg-gray-50 dark:bg-[#1a1a19]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Project</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Expires</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-[#A1A09A] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-[#161615] divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                                @foreach($activeRentals as $rental)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-[#1a1a19] transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $rental->rentableProject->name }}</div>
                                            @if($rental->admin_email)
                                            <div class="text-xs text-gray-500 dark:text-[#A1A09A] mt-1">{{ $rental->admin_email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-[#A1A09A]">
                                            {{ $rental->rental_expires_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('rentals.show', $rental->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
