<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Welcome back</h2>
        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Sign in to your account to continue</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email address')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-2" name="remember">
                <span class="ms-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
            {{ __('Sign in') }}
        </x-primary-button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Sign up</a>
            </p>
        @endif
    </form>
</x-guest-layout>
