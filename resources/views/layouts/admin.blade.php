<!DOCTYPE html>
<html lang="en" class="{{ auth('admin')->user()->theme === 'dark' ? 'dark' : '' }}" x-data="{ sidebarOpen: window.innerWidth >= 1024, notificationsOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        .dark .scrollbar-thin::-webkit-scrollbar-thumb { background: #4b5563; }
    </style>
    <script>
        function updateBodyScroll() {
            const html = document.documentElement;
            const isOpen = html.__x.$data.sidebarOpen || html.__x.$data.notificationsOpen;
            document.documentElement.style.overflow = isOpen && window.innerWidth < 1024 ? 'hidden' : 'auto';
            document.body.style.overflow = isOpen && window.innerWidth < 1024 ? 'hidden' : 'auto';
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-black" :class="{ 'overflow-hidden': (sidebarOpen || notificationsOpen) && window.innerWidth < 1024 }">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 z-40">
        <div class="h-full px-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen; updateBodyScroll()" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</h1>
            </div>
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div class="relative" x-data="{ notifCount: {{ auth('admin')->user()->notifications()->whereNull('read_at')->count() }} }">
                    <button @click="notificationsOpen = !notificationsOpen; updateBodyScroll()" class="relative text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="fas fa-bell text-xl"></i>
                        <span x-show="notifCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse" x-text="notifCount"></span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 border border-gray-200 dark:border-gray-800 rounded-lg px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if(auth('admin')->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth('admin')->user()->profile_photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-white">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <span class="text-sm text-gray-900 dark:text-white hidden lg:block">{{ auth('admin')->user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white dark:bg-black rounded-md shadow-lg py-1 border border-gray-200 dark:border-gray-800">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-16 bottom-0 bg-white dark:bg-black border-r border-gray-200 dark:border-gray-800 z-30 transition-all duration-200 -translate-x-full lg:translate-x-0 flex flex-col" :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen, 'translate-x-0': sidebarOpen }">
        <nav class="p-4 space-y-2 flex-1 overflow-y-auto scrollbar-thin">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-chart-line"></i>
                <span x-show="sidebarOpen" x-cloak>Dashboard</span>
            </a>

            @can('view-users')
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-users"></i>
                <span x-show="sidebarOpen" x-cloak>Users</span>
            </a>
            @endcan

            @can('view-projects')
            <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.projects.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-box"></i>
                <span x-show="sidebarOpen" x-cloak>Projects</span>
            </a>
            @endcan

            @can('view-rentals')
            <a href="{{ route('admin.rentals.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.rentals.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-handshake"></i>
                <span x-show="sidebarOpen" x-cloak>Rentals</span>
            </a>
            @endcan

            @can('view-transactions')
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-coins"></i>
                <span x-show="sidebarOpen" x-cloak>Transactions</span>
            </a>
            @endcan

            @can('view-admins')
            <a href="{{ route('admin.admins.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.admins.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-user-shield"></i>
                <span x-show="sidebarOpen" x-cloak>Admins</span>
            </a>
            @endcan

            @can('view-roles')
            <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.roles.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-shield-alt"></i>
                <span x-show="sidebarOpen" x-cloak>Roles</span>
            </a>
            @endcan

            @can('view-permissions')
            <a href="{{ route('admin.permissions.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-lock"></i>
                <span x-show="sidebarOpen" x-cloak>Permissions</span>
            </a>
            @endcan

            @can('view-analytics')
            <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.analytics.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-chart-bar"></i>
                <span x-show="sidebarOpen" x-cloak>Analytics</span>
            </a>
            @endcan

            @can('view-settings')
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-cog"></i>
                <span x-show="sidebarOpen" x-cloak>Settings</span>
            </a>
            @endcan

            @can('view-trash')
            <a href="{{ route('admin.trash.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-900 dark:text-white hover:bg-blue-600 hover:text-white rounded-lg {{ request()->routeIs('admin.trash.*') ? 'bg-blue-600 text-white' : '' }}" :class="{ 'justify-center': !sidebarOpen }">
                <i class="fas fa-trash"></i>
                <span x-show="sidebarOpen" x-cloak>Trash</span>
            </a>
            @endcan
        </nav>

        <div class="p-4 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3" :class="{ 'justify-center': !sidebarOpen }">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    @if(auth('admin')->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth('admin')->user()->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-lg font-bold text-white">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                    @endif
                </div>
                <div x-show="sidebarOpen" x-cloak class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ auth('admin')->user()->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ auth('admin')->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Notifications Sidebar -->
    @include('admin.notifications.index')

    <!-- Overlay for sidebar on mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false; updateBodyScroll()" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

    <!-- Main Content -->
    <main class="mt-16 transition-all duration-200" :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-20': !sidebarOpen }">
        <div class="p-6 md:p-8">
            {{ $slot }}
        </div>
    </main>
    
    @stack('scripts')
</body>
</html>
