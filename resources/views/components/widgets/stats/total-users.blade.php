@can('view-users')
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Total Users</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ \App\Models\User::count() }}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-1 text-[10px]">
        <span class="px-1.5 py-0.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">Verified: {{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</span>
        <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded">Unverified: {{ \App\Models\User::whereNull('email_verified_at')->count() }}</span>
    </div>
</div>
@endcan
