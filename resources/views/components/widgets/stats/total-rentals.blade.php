@can('view-rentals')
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Rentals</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ \App\Models\Rental::count() }}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-1 text-[10px]">
        <span class="px-1.5 py-0.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">Active: {{ \App\Models\Rental::where('status', 'active')->count() }}</span>
        <span class="px-1.5 py-0.5 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded">Suspended: {{ \App\Models\Rental::where('status', 'suspended')->count() }}</span>
        <span class="px-1.5 py-0.5 bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 rounded">Expired: {{ \App\Models\Rental::where('status', 'expired')->count() }}</span>
    </div>
</div>
@endcan
