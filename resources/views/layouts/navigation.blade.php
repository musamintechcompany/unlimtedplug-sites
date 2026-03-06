<nav x-data="{ open: false, profileOpen: false, notificationsOpen: false }" @open.window="open = true" @close.window="open = false" class="bg-white dark:bg-[#161615] border-b border-gray-100 dark:border-[#3E3E3A] sticky top-0 z-30">
    <script>
        function updateBodyScroll() {
            const nav = document.querySelector('nav');
            const isOpen = nav.__x.$data.open || nav.__x.$data.notificationsOpen;
            document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        }
    </script>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Hamburger + Logo -->
            <div class="flex items-center">
                <!-- Hamburger (Mobile) -->
                <button @click="open = true; updateBodyScroll()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#1a1a19] focus:outline-none transition duration-150 ease-in-out sm:hidden">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex items-center ml-2 sm:ml-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-indigo-600" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('browse')" :active="request()->routeIs('browse')">
                        {{ __('Browse Projects') }}
                    </x-nav-link>
                    <x-nav-link :href="route('rentals.index')" :active="request()->routeIs('rentals.*')">
                        {{ __('My Rentals') }}
                    </x-nav-link>
                    <x-nav-link :href="route('api-keys.index')" :active="request()->routeIs('api-keys.*')">
                        {{ __('API Keys') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-nav-link>
                    <a href="{{ route('credits.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition font-semibold text-sm">
                        💰 Buy Credits
                    </a>
                </div>
            </div>

            <!-- Right: Notifications + Currency (on credits page) + User Dropdown (Desktop) / Avatar (Mobile) -->
            <div class="flex items-center gap-3 sm:gap-0 sm:ms-6">
                <!-- Notifications Button (Desktop & Mobile) -->
                <button @click="notificationsOpen = true; updateBodyScroll()" class="relative p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition sm:mr-6">
                    <svg class="w-5 h-5 text-gray-800 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @php
                        $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </button>
                <!-- Currency Selector (Only on Credits Page) -->
                @if(request()->routeIs('credits.index'))
                <div x-data="{ open: false }" class="relative hidden sm:block mr-3">
                    <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg hover:bg-gray-50 dark:hover:bg-[#1a1a19] transition text-sm">
                        <span class="text-gray-700 dark:text-gray-300">{{ session('currency', 'USD') }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white dark:bg-[#161615] rounded-lg shadow-lg border border-gray-200 dark:border-[#3E3E3A] py-1 z-50 max-h-96 overflow-y-auto">
                        @foreach(config('payment.currencies') as $code => $currencyInfo)
                            <button onclick="setCurrency('{{ $code }}')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1a1a19] {{ session('currency', 'USD') === $code ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                                {{ $code }} - {{ $currencyInfo['name'] }} ({{ $currencyInfo['symbol'] }})
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Desktop User Dropdown -->
                <div class="hidden sm:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-[#EDEDEC] bg-white dark:bg-[#161615] hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                
                <!-- Mobile User Avatar -->
                <div class="sm:hidden relative">
                    <button @click="profileOpen = !profileOpen" class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold hover:bg-blue-700 transition overflow-hidden">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </button>
                    
                    <!-- Mobile Profile Dropdown -->
                    <div x-show="profileOpen" 
                         x-cloak
                         @click.outside="profileOpen = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#161615] rounded-lg shadow-lg z-50 top-full">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div x-show="open" 
         @click="open = false; updateBodyScroll()" 
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

    <!-- Mobile Sidebar (Slides from Left) -->
    <div x-show="open" 
         x-transition:enter="transform transition ease-in-out duration-300" 
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transform transition ease-in-out duration-300" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="-translate-x-full" 
         class="fixed top-0 left-0 h-full w-72 bg-white dark:bg-[#161615] shadow-2xl z-50 flex flex-col" 
         style="display: none;"
         x-cloak>
        
        <!-- Sidebar Header with App Name -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-[#3E3E3A]">
            <div class="flex items-center space-x-2">
                <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-indigo-600" />
                <span class="font-bold text-gray-800 dark:text-[#EDEDEC]">{{ config('app.name') }}</span>
            </div>
            <button @click="open = false; updateBodyScroll()" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto py-4">
            <!-- Currency Selector (Mobile - Only on Credits Page) -->
            @if(request()->routeIs('credits.index'))
            <div class="px-3 mb-4">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg hover:bg-gray-50 dark:hover:bg-[#1a1a19] transition">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Currency: <span class="font-semibold text-gray-900 dark:text-white">{{ session('currency', 'USD') }}</span></span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute left-0 right-0 mt-2 bg-white dark:bg-[#161615] rounded-lg shadow-lg border border-gray-200 dark:border-[#3E3E3A] py-1 z-50 max-h-64 overflow-y-auto">
                        @foreach(config('payment.currencies') as $code => $currencyInfo)
                            <button onclick="setCurrency('{{ $code }}')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1a1a19] {{ session('currency', 'USD') === $code ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                                {{ $code }} - {{ $currencyInfo['name'] }} ({{ $currencyInfo['symbol'] }})
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Navigation Links -->
            <div class="space-y-1 px-3">
                <a href="{{ route('dashboard') }}" @click="open = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#1a1a19]' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('browse') }}" @click="open = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('browse') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#1a1a19]' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    <span class="font-medium">Browse Projects</span>
                </a>

                <a href="{{ route('rentals.index') }}" @click="open = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('rentals.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#1a1a19]' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="font-medium">My Rentals</span>
                </a>

                <a href="{{ route('api-keys.index') }}" @click="open = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('api-keys.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#1a1a19]' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    <span class="font-medium">API Keys</span>
                </a>

                <a href="{{ route('credits.index') }}" @click="open = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-semibold hover:bg-amber-200 dark:hover:bg-amber-900/50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">💰 Buy Credits</span>
                </a>
            </div>
        </div>

        <!-- Sidebar Footer - Profile Details -->
        <div class="p-4 border-t border-gray-200 dark:border-[#3E3E3A]">
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 hover:bg-gray-100 dark:hover:bg-[#1a1a19] p-2 rounded-lg transition">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-lg font-semibold flex-shrink-0 overflow-hidden">
                    @if (auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="font-semibold text-gray-800 dark:text-[#EDEDEC] text-sm border border-gray-300 dark:border-[#3E3E3A] rounded-md px-2 py-1">{{ Auth::user()->name }}</div>
            </a>
        </div>
    </div>

    <!-- Notifications Sidebar (Right Side) - Using Alpine.js -->
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
                <button @click="notificationsOpen = false; updateBodyScroll()" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
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
                <div class="bg-white dark:bg-[#1a1a19] border border-gray-200 dark:border-[#3E3E3A] rounded-lg p-4 mb-3 hover:shadow-md dark:hover:shadow-lg transition {{ $notification->read_at ? 'opacity-70' : 'border-l-4 border-l-blue-600' }}">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                            {{ $notification->type ?? 'Update' }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1 text-sm">{{ $notification->title }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 leading-relaxed">{{ $notification->message }}</p>
                    <div class="flex items-center justify-between">
                        @if(!$notification->read_at)
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Unread</span>
                            </span>
                        @else
                            <span class="text-xs text-gray-500 dark:text-gray-500">Read</span>
                        @endif
                        @if(!$notification->read_at)
                            <button @click="markAsRead('{{ $notification->id }}')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-xs font-medium hover:underline">
                                Mark as read
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No notifications yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
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
</nav>
