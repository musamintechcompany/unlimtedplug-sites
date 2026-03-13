@can('view-projects')
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Projects</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ \App\Models\RentableProject::count() }}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-1 text-[10px]">
        <span class="px-1.5 py-0.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">Active: {{ \App\Models\RentableProject::where('status', 'active')->count() }}</span>
        <span class="px-1.5 py-0.5 bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 rounded">Inactive: {{ \App\Models\RentableProject::where('status', 'inactive')->count() }}</span>
    </div>
</div>
@endcan
