<!-- Notifications Sidebar (Right Side) - Using Alpine.js -->
<div x-data="{ notificationsOpen: false }" @keydown.escape="notificationsOpen = false">
    <!-- Overlay -->
    <div x-show="notificationsOpen" 
         @click="notificationsOpen = false" 
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
         class="fixed top-0 right-0 h-full w-full sm:w-96 bg-white dark:bg-[#161615] border-l border-gray-200 dark:border-[#3E3E3A] shadow-2xl z-50 flex flex-col" 
         style="display: none;"
         x-cloak>
        
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-[#3E3E3A]">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h2>
            <div class="flex items-center gap-2">
                <button @click="markAllAsRead()" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                    Mark all read
                </button>
                <button @click="notificationsOpen = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Notification Items -->
        <div class="flex-1 overflow-y-auto p-4">
            @php
                $notifications = auth()->user()->notifications()->latest()->get();
            @endphp
            @forelse($notifications as $notification)
                <div class="border-b border-gray-200 dark:border-[#3E3E3A] pb-4 mb-4 last:border-b-0 {{ $notification->read_at ? 'opacity-75' : '' }}">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            Notification
                        </span>
                        <div class="flex items-center space-x-2">
                            @if(!$notification->read_at)
                                <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                            @endif
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->format('M d') }}</span>
                        </div>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $notification->title }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">{{ $notification->message }}</p>
                    @if(!$notification->read_at)
                        <button @click="markAsRead('{{ $notification->id }}')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                            Mark as read
                        </button>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No notifications yet</p>
            @endforelse
        </div>
    </div>

    <!-- Notification Button in Nav -->
    <script>
        function toggleNotificationsSidebar() {
            const nav = document.querySelector('[x-data*="notificationsOpen"]');
            if (nav && nav.__x) {
                nav.__x.$data.notificationsOpen = !nav.__x.$data.notificationsOpen;
            }
        }

        function markAllAsRead() {
            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => location.reload());
        }

        function markAsRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => location.reload());
        }
    </script>
</div>
