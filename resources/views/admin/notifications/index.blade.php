@php
    $notifications = auth('admin')->user()->notifications()->latest()->limit(50)->get();
@endphp

<!-- Notifications Sidebar (Right Side) -->
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

<div x-show="notificationsOpen" 
     x-transition:enter="transform transition ease-in-out duration-300" 
     x-transition:enter-start="translate-x-full" 
     x-transition:enter-end="translate-x-0" 
     x-transition:leave="transform transition ease-in-out duration-300" 
     x-transition:leave-start="translate-x-0" 
     x-transition:leave-end="translate-x-full" 
     class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white dark:bg-black border-l border-gray-200 dark:border-gray-800 shadow-2xl z-50 flex flex-col" 
     style="display: none;"
     x-cloak>
    
    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800 bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800">
        <div>
            <h2 class="text-lg font-bold text-white">Notifications</h2>
            <p class="text-xs text-blue-100 mt-1">Stay updated with your activities</p>
        </div>
        <div class="flex items-center gap-2">
            @php
                $unreadCount = auth('admin')->user()->notifications()->whereNull('read_at')->count();
            @endphp
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('admin.notifications.mark-all-read') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-white hover:text-blue-100 transition px-2 py-1 rounded border border-white hover:bg-white/10 whitespace-nowrap">
                        Mark all read
                    </button>
                </form>
            @endif
            <button @click="notificationsOpen = false; updateBodyScroll()" class="text-white hover:text-blue-100 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
    </div>
    
    <div class="flex-1 overflow-y-auto p-4 space-y-3 scrollbar-thin">
        @forelse($notifications as $notification)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg transition-all hover:shadow-md {{ !$notification->read_at ? 'bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800' : '' }}">
                <a href="{{ route('admin.notifications.mark-read', $notification->id) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center
                                @switch($notification->type)
                                    @case('admin_new_user') bg-green-100 dark:bg-green-900/30 @break
                                    @case('admin_new_rental') bg-blue-100 dark:bg-blue-900/30 @break
                                    @case('admin_rental_renewed') bg-purple-100 dark:bg-purple-900/30 @break
                                    @case('admin_payment_received') bg-yellow-100 dark:bg-yellow-900/30 @break
                                    @case('admin_rental_expired') bg-red-100 dark:bg-red-900/30 @break
                                    @default bg-blue-100 dark:bg-blue-900/30
                                @endswitch
                            ">
                                @switch($notification->type)
                                    @case('admin_new_user')
                                        <i class="fas fa-user-plus text-xl text-green-600 dark:text-green-400"></i>
                                        @break
                                    @case('admin_new_rental')
                                        <i class="fas fa-handshake text-xl text-blue-600 dark:text-blue-400"></i>
                                        @break
                                    @case('admin_rental_renewed')
                                        <i class="fas fa-sync-alt text-xl text-purple-600 dark:text-purple-400"></i>
                                        @break
                                    @case('admin_payment_received')
                                        <i class="fas fa-coins text-xl text-yellow-600 dark:text-yellow-400"></i>
                                        @break
                                    @case('admin_rental_expired')
                                        <i class="fas fa-clock text-xl text-red-600 dark:text-red-400"></i>
                                        @break
                                    @default
                                        <i class="fas fa-bell text-xl text-blue-600 dark:text-blue-400"></i>
                                @endswitch
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-1">
                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $notification->title }}</p>
                                @if(!$notification->read_at)
                                <span class="inline-block w-2 h-2 bg-blue-600 rounded-full flex-shrink-0 ml-2 mt-1"></span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <i class="fas fa-bell text-6xl text-gray-300 dark:text-gray-700 mb-3 opacity-50"></i>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No notifications yet</p>
                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">You're all caught up!</p>
            </div>
        @endforelse
    </div>
</div>
