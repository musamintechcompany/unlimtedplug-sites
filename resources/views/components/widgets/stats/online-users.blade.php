@can('view-users')
@php
    $onlineCount = \DB::table('sessions')
        ->whereNotNull('user_id')
        ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
        ->distinct('user_id')
        ->count('user_id');
@endphp
<div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center relative">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"></path>
            </svg>
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white dark:border-[#161615] animate-pulse"></span>
        </div>
        <div>
            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Online Now</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $onlineCount }}</p>
        </div>
    </div>
    <div class="text-[10px] text-gray-500 dark:text-[#A1A09A]">
        <span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 rounded">Active in last 5 min</span>
    </div>
</div>
@endcan
