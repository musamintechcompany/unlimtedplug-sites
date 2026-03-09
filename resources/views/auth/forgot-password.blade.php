<x-guest-layout>
    <x-auth-card>
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Reset your password</h2>
            <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Enter your email to receive a reset code</p>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email address')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
                <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                {{ __('Send Reset Code') }}
            </x-primary-button>

            <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Remember your password?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Sign in</a>
            </p>
        </form>
    </x-auth-card>
</x-guest-layout>
