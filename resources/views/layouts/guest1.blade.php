<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1b1b18] antialiased relative overflow-x-hidden bg-[#FDFDFC]">
        <div class="min-h-screen relative flex flex-col">
            <!-- Navigation -->
            <nav x-data="{ 
                open: false, 
                lastScrollY: 0, 
                showNav: true 
            }" 
            @scroll.window="
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    showNav = false;
                } else if (window.scrollY < lastScrollY) {
                    showNav = true;
                }
                lastScrollY = window.scrollY;
            " 
            class="bg-white/95 backdrop-blur-sm border-b border-gray-200 fixed top-0 w-full z-50 transition-transform duration-300" 
            :class="{ '-translate-y-full': !showNav, 'translate-y-0': showNav }">
                <div class="max-w-7xl mx-auto px-6 py-4">
                    <div class="flex justify-between items-center">
                        <!-- Logo -->
                        <div class="flex items-center gap-2">
                            <a href="/">
                                <x-application-logo class="h-10 w-10 fill-current text-indigo-600" />
                            </a>
                            <a href="/">
                                <span class="text-xl font-bold">{{ config('app.name') }}</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation (Center) -->
                        <div class="hidden md:flex items-center gap-8">
                            <a href="/" class="text-sm hover:text-indigo-600 {{ request()->is('/') ? 'font-medium text-indigo-600' : '' }}">Home</a>
                            <a href="{{ route('browse') }}" class="text-sm hover:text-indigo-600 {{ request()->routeIs('browse') ? 'font-medium text-indigo-600' : '' }}">Browse</a>
                            <a href="{{ route('how-it-works') }}" class="text-sm hover:text-indigo-600 {{ request()->routeIs('how-it-works') ? 'font-medium text-indigo-600' : '' }}">How It Works</a>
                        </div>

                        <!-- Desktop Auth Buttons -->
                        <div class="hidden md:flex items-center gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium">Login</a>
                                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">Get Started</a>
                            @endauth
                        </div>

                        <!-- Mobile Menu Button -->
                        <button @click="open = !open" class="md:hidden text-gray-700">
                            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Sidebar Overlay -->
                <div x-show="open" 
                     @click="open = false" 
                     x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black bg-opacity-70 z-40 md:hidden"
                     x-cloak>
                </div>

                <!-- Mobile Sidebar -->
                <div x-show="open"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="-translate-y-full"
                     x-transition:enter-end="translate-y-0"
                     x-transition:leave="transform transition ease-in duration-300"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="-translate-y-full"
                     class="fixed top-0 left-0 w-full bg-white shadow-xl z-50 md:hidden"
                     x-cloak>
                    
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <x-application-logo class="h-8 w-auto fill-current text-indigo-600" />
                            <span class="ml-2 text-xl font-bold">{{ config('app.name') }}</span>
                        </div>
                        <button @click="open = false" class="text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <nav class="mt-6 flex-1">
                        <a href="/" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->is('/') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                        <a href="{{ route('browse') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('browse') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 6.707 6.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l4-4z"></path>
                            </svg>
                            Browse
                        </a>
                        <a href="{{ route('how-it-works') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 {{ request()->routeIs('how-it-works') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            How It Works
                        </a>
                    </nav>
                    
                    <div class="border-t border-gray-200 p-6 space-y-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block w-full text-center py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50">Login</a>
                            <a href="{{ route('register') }}" class="block w-full text-center py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Get Started</a>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="pt-16 flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            @include('footer')
        </div>
    </body>
</html>
