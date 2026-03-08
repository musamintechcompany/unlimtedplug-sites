<!-- Notifications Sidebar (Right Side) - Using Alpine.js -->
<!-- Overlay -->
<div x-show="notificationsOpen" 
     @click="notificationsOpen = false; updateBodyScroll()" 
     x-transition:enter="transition-opacity ease-linear duration-300" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-300" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     class="fixed inset-0 bg-black bg-opacity-50 z-40" 
     style="display: none;"
     x-cloak>
</div>

<!-- Sidebar -->
<div x-show="notificationsOpen" 
     x-transition:enter="transform transition ease-in-out duration-300" 
     x-transition:enter-start="translate-x-full" 
     x-transition:enter-end="translate-x-0" 
     x-transition:leave="transform transition ease-in-out duration-300" 
     x-transition:leave-start="translate-x-0" 
     x-transition:leave-end="translate-x-full" 
     class="fixed top-0 right-0 h-full w-full sm:w-80 bg-white dark:bg-[#161615] border-l border-gray-200 dark:border-[#3E3E3A] shadow-2xl z-50 flex flex-col" 
     style="display: none;"
     x-cloak>
    
    <!-- Header -->
    <div class="flex items-center justify-between p-3 sm:p-6 border-b border-gray-200 dark:border-[#3E3E3A] bg-gradient-to-r from-gray-50 to-gray-100 dark:from-[#1F1F1E] dark:to-[#161615]">
        <div>
            <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Notifications</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1 hidden sm:block">Stay updated with your activities</p>
        </div>
        <div class="flex items-center gap-1 sm:gap-2">
            @php
                $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
            @endphp
            @if($unreadCount > 0)
                <button onclick="markAllAsReadNow()" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition px-2 py-1 rounded border border-blue-600 dark:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 whitespace-nowrap">
                    Mark read
                </button>
            @endif
            <button @click="notificationsOpen = false; updateBodyScroll()" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition flex-shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Notification Items -->
    <div class="flex-1 overflow-y-auto p-2 sm:p-4 space-y-2 sm:space-y-3">
        @php
            $notifications = auth()->user()->notifications()->latest()->get();
        @endphp
        @forelse($notifications as $notification)
            <div x-data="{ expanded: {{ !$notification->read_at ? 'true' : 'false' }} }" data-notification-id="{{ $notification->id }}" class="bg-white dark:bg-[#1F1F1E] border border-gray-200 dark:border-[#3E3E3A] rounded-lg transition-all hover:shadow-md {{ !$notification->read_at ? 'bg-blue-50 dark:bg-blue-950/20' : '' }}">
                <!-- Collapsed View -->
                <div @click="expanded = !expanded" class="w-full text-left p-2 sm:p-4 hover:bg-gray-50 dark:hover:bg-[#252524] transition cursor-pointer">
                    <div class="flex items-center justify-between mb-2 gap-1">
                        <span class="inline-flex items-center px-1.5 sm:px-2.5 py-0.5 rounded-full text-xs font-semibold flex-shrink-0
                            @if($notification->type === 'payment_success') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                            @elseif($notification->type === 'payment_failed') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300
                            @elseif($notification->type === 'rental_created' || $notification->type === 'rental_renewed') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300
                            @elseif($notification->type === 'rental_expired' || $notification->type === 'rental_suspended') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                            @elseif($notification->type === 'welcome') bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300
                            @else bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300
                            @endif">
                            @if($notification->type === 'payment_success')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Payment
                            @elseif($notification->type === 'payment_failed')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                Failed
                            @elseif($notification->type === 'rental_created')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                Rental
                            @elseif($notification->type === 'rental_renewed')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                Renewed
                            @elseif($notification->type === 'rental_expired' || $notification->type === 'rental_suspended')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                Alert
                            @elseif($notification->type === 'welcome')
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v4h8v-4zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                                Welcome
                            @endif
                        </span>
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                            <svg :class="expanded ? 'rotate-180' : ''" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-xs sm:text-sm line-clamp-2">{{ $notification->title }}</h4>
                </div>

                <!-- Expanded View -->
                <div x-show="expanded" x-transition class="border-t border-gray-200 dark:border-[#3E3E3A] p-2 sm:p-4 bg-gray-50 dark:bg-[#0F0F0E]">
                    <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-4 leading-relaxed">
                        @if($notification->type === 'payment_success')
                            You have successfully purchased
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-semibold ml-1">{{ $notification->data['credits'] ?? 0 }} credits</span>
                            @if(($notification->data['bonus'] ?? 0) > 0)
                                + <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-semibold ml-1">{{ $notification->data['bonus'] ?? 0 }} bonus</span>
                            @endif
                            for
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs font-semibold ml-1">{{ $notification->data['currency'] ?? 'USD' }} {{ $notification->data['price'] ?? 0 }}</span>
                        @elseif($notification->type === 'payment_failed')
                            Your payment for
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-semibold ml-1">{{ $notification->data['credits'] ?? 0 }} credits</span>
                            failed
                        @elseif($notification->type === 'rental_created')
                            You have rented <strong class="break-words">{{ $notification->data['project_name'] ?? 'Project' }}</strong> for
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 text-xs font-semibold ml-1">{{ $notification->data['duration_value'] ?? 0 }} {{ $notification->data['duration_type'] === 'daily' ? 'Day(s)' : ($notification->data['duration_type'] === 'weekly' ? 'Week(s)' : ($notification->data['duration_type'] === 'monthly' ? 'Month(s)' : 'Year(s)')) }}</span>
                            using
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-semibold ml-1">{{ $notification->data['credits'] ?? 0 }} credits</span>
                        @elseif($notification->type === 'rental_renewed')
                            You have renewed <strong class="break-words">{{ $notification->data['project_name'] ?? 'Project' }}</strong> for
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 text-xs font-semibold ml-1">{{ $notification->data['quantity'] ?? 0 }} {{ $notification->data['duration_type'] === 'daily' ? 'Day(s)' : ($notification->data['duration_type'] === 'weekly' ? 'Week(s)' : ($notification->data['duration_type'] === 'monthly' ? 'Month(s)' : 'Year(s)')) }}</span>
                            using
                            <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 text-xs font-semibold ml-1">{{ $notification->data['credits'] ?? 0 }} credits</span>
                        @elseif($notification->type === 'rental_expired')
                            Your rental for <strong class="break-words">{{ $notification->data['project_name'] ?? 'Project' }}</strong> has expired
                        @elseif($notification->type === 'rental_suspended')
                            Your rental for <strong class="break-words">{{ $notification->data['project_name'] ?? 'Project' }}</strong> has been suspended
                        @else
                            {{ $notification->message }}
                        @endif
                    </p>
                    

                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No notifications yet</p>
                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">You're all caught up!</p>
            </div>
        @endforelse
    </div>
    

</div>
