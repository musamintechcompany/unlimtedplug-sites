<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mb-2">Analytics</h1>
        <p class="text-gray-600 dark:text-[#A1A09A]">Track visitor behavior and site performance</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Page Views</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_page_views']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Visitors Today</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['unique_visitors_today']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Page Views Today</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['page_views_today']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Visitors</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_visitors']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-globe text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Chart -->
    <x-widgets.charts.visitors />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Top Pages -->
        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Pages</h3>
            <div class="space-y-3">
                @forelse($topPages as $page)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-900 dark:text-white capitalize">{{ $page->page_type }}</span>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ number_format($page->views) }} views</span>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Top Countries -->
        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Countries</h3>
            <div class="space-y-3">
                @forelse($topCountries as $country)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-900 dark:text-white">{{ $country->country }}</span>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ number_format($country->count) }} visitors</span>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Projects -->
    <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Projects</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Project</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Views</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($topProjects as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item->project->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ number_format($item->views) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.analytics.visitors') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-users mr-2"></i>View All Visitors
            </a>
            @can('delete-analytics')
            <form method="POST" action="{{ route('admin.analytics.delete-old-data') }}" class="inline" onsubmit="return confirm('Delete visitor data older than 90 days?')">
                @csrf
                <input type="hidden" name="days" value="90">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-trash mr-2"></i>Delete Old Data (90+ days)
                </button>
            </form>
            @endcan
        </div>
    </div>
</x-admin-layout>
