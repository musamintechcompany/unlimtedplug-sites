<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col lg:overflow-hidden">
        <div class="flex items-center justify-center w-full flex-1">
            <main class="max-w-7xl w-full grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left order-2 lg:order-1">
                    <div class="text-[13px] leading-[20px] p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                            Build Your SaaS
                            <span class="text-indigo-600">Faster</span>
                        </h1>
                        <p class="text-base lg:text-lg text-[#706f6c] dark:text-[#A1A09A] mb-6">
                            Customized <a href="https://unlimitedplug.com" target="_blank" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Laravel SaaS Starter Kit "v1.0"</a> by <a href="https://unlimitedplug.com" target="_blank" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Unlimited Plug</a> - everything you need to launch your product faster.
                        </p>
                        <div class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-6 mt-6">
                            <div class="flex items-center gap-4 mb-6">
                                <x-application-logo class="h-12 w-12 fill-current text-indigo-600" />
                                <div>
                                    <h3 class="font-semibold text-base text-[#1b1b18] dark:text-[#EDEDEC]">Laravel Powered</h3>
                                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Built on the world's best PHP framework</p>
                                </div>
                            </div>
                            <ul class="flex flex-col">
                                <li class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute">
                                    <span class="relative py-1 bg-white dark:bg-[#161615]">
                                        <span class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
                                            <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
                                        </span>
                                    </span>
                                    <span>
                                        Read the
                                        <a href="https://docs.unlimitedplug.com" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-indigo-600 dark:text-indigo-400 ml-1">
                                            <span>Documentation</span>
                                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                                                <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square" />
                                            </svg>
                                        </a>
                                    </span>
                                </li>
                                <li class="flex items-center gap-4 py-2 relative before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A] before:bottom-1/2 before:top-0 before:left-[0.4rem] before:absolute">
                                    <span class="relative py-1 bg-white dark:bg-[#161615]">
                                        <span class="flex items-center justify-center rounded-full bg-[#FDFDFC] dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border dark:border-[#3E3E3A] border-[#e3e3e0]">
                                            <span class="rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] w-1.5 h-1.5"></span>
                                        </span>
                                    </span>
                                    <span>
                                        Watch video tutorials at
                                        <a href="https://youtube.com/@unlimitedplugofficial" target="_blank" class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-indigo-600 dark:text-indigo-400 ml-1">
                                            <span>YouTube</span>
                                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                                                <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square" />
                                            </svg>
                                        </a>
                                    </span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Right Phone Mockup -->
                <div class="flex justify-center lg:justify-end order-1 lg:order-2">
                    <div class="relative">
                        <!-- Phone Frame -->
                        <div class="relative w-[280px] h-[560px] bg-gray-900 dark:bg-gray-800 rounded-[3rem] p-3 shadow-2xl">
                            <!-- Notch -->
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-40 h-7 bg-gray-900 dark:bg-gray-800 rounded-b-3xl z-10"></div>
                            
                            <!-- Screen -->
                            <div class="relative w-full h-full bg-white dark:bg-[#161615] rounded-[2.5rem] overflow-hidden">
                                <!-- App Content -->
                                <div class="h-full bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-[#1a1a19] dark:to-[#1a1a19] p-6 overflow-y-scroll" style="scrollbar-width: none; -ms-overflow-style: none;">
                                    <style>
                                        .overflow-y-scroll::-webkit-scrollbar {
                                            display: none;
                                        }
                                    </style>
                                    <!-- Header -->
                                    <div class="mb-6 mt-4">
                                        <div class="flex items-center justify-between mb-6">
                                            <x-application-logo class="h-10 w-10 fill-current text-indigo-600 border-2 border-gray-200 dark:border-[#3E3E3A] rounded-full p-1.5" />
                                            <!-- Hamburger Icon -->
                                            <div class="w-8 h-8 flex flex-col justify-center items-center gap-1.5 pointer-events-none">
                                                <span class="w-5 h-0.5 bg-gray-700 dark:bg-gray-300 rounded"></span>
                                                <span class="w-5 h-0.5 bg-gray-700 dark:bg-gray-300 rounded"></span>
                                                <span class="w-5 h-0.5 bg-gray-700 dark:bg-gray-300 rounded"></span>
                                            </div>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mb-2">Dashboard</h2>
                                        <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Welcome back!</p>
                                    </div>

                                    <!-- Stats Cards -->
                                    <div class="space-y-4 mb-6">
                                        <div class="bg-white dark:bg-[#161615] rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-[#3E3E3A]">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-xs text-gray-600 dark:text-[#A1A09A] mb-1">Total Users</p>
                                                    <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">1,234</p>
                                                </div>
                                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-white dark:bg-[#161615] rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-[#3E3E3A]">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-xs text-gray-600 dark:text-[#A1A09A] mb-1">Revenue</p>
                                                    <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">$12.5k</p>
                                                </div>
                                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auth Buttons -->
                                    @if (Route::has('login'))
                                        @auth
                                            <div class="space-y-3">
                                                <a href="{{ route('dashboard') }}" class="block bg-indigo-600 rounded-xl py-3 text-center text-white">
                                                    <p class="text-sm font-semibold">Dashboard</p>
                                                </a>
                                            </div>
                                        @else
                                            <div class="space-y-3">
                                                <a href="{{ route('login') }}" class="block bg-white dark:bg-[#161615] border border-gray-200 dark:border-[#3E3E3A] rounded-xl py-3 text-center">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]">Login</p>
                                                </a>
                                                @if (Route::has('register'))
                                                    <a href="{{ route('register') }}" class="block bg-indigo-600 rounded-xl py-3 text-center text-white">
                                                        <p class="text-sm font-semibold">Register</p>
                                                    </a>
                                                @endif
                                            </div>
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Elements -->
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-indigo-200 dark:bg-indigo-900/30 rounded-full opacity-50 blur-xl"></div>
                        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-purple-200 dark:bg-purple-900/30 rounded-full opacity-50 blur-xl"></div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
