@can('view-admins')
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Admins</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ \App\Models\Admin::count() }}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-1 text-[10px]">
        <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded">Roles: {{ \Spatie\Permission\Models\Role::where('guard_name', 'admin')->count() }}</span>
    </div>
</div>
@endcan
