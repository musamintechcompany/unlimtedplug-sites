<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Create account</h2>
        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Start your journey with us today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full name')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="name" class="block mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email address')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
            {{ __('Create account') }}
        </x-primary-button>

        <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Sign in</a>
        </p>
    </form>
</x-guest-layout>
