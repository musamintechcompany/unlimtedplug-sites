<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()->theme === 'dark' ? 'dark' : '' }}" x-data="{ sidebarOpen: false }">
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
        
        <!-- Flutterwave -->
        <script src="https://checkout.flutterwave.com/v3.js"></script>
        
        <!-- User Data for JavaScript -->
        <meta name="user-email" content="{{ auth()->user()->email }}">
        <meta name="user-name" content="{{ auth()->user()->name }}">
        <meta name="user-id" content="{{ auth()->id() }}">
        <meta name="flutterwave-public-key" content="{{ config('services.flutterwave.public_key') }}">
        <meta name="app-name" content="{{ config('app.name') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50 dark:bg-[#0a0a0a]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-[#161615] shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Include WhatsApp Welcome Modal -->
        @include('modals.whatsapp-welcome')
    </body>
</html>
