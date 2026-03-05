<x-guest-layout>
    <x-auth-card>
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

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <div class="relative">
                <input id="password" class="block mt-2 w-full pr-10 border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
            <div class="relative">
                <input id="password_confirmation" class="block mt-2 w-full pr-10 border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Privacy Agreement -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded bg-white dark:bg-[#161615] text-indigo-600 focus:ring-indigo-500">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-[#706f6c] dark:text-[#A1A09A]">
                    I agree to the 
                    <a href="{{ route('terms') }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Terms of Service</a>
                    and 
                    <a href="{{ route('privacy') }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Privacy Policy</a>
                </label>
            </div>
        </div>
        <x-input-error :messages="$errors->get('terms')" class="mt-2" />

        <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
            {{ __('Create account') }}
        </x-primary-button>

        <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Sign in</a>
        </p>
        </form>
    </x-auth-card>
</x-guest-layout>
