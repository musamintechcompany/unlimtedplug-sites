<x-guest-layout>
    <x-auth-card>
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Verify your email</h2>
            <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">We've sent a 6-digit code to your email address</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 text-sm rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify-email.store') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="code" :value="__('Verification Code')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
                <x-text-input id="code" class="block mt-2 w-full text-center text-2xl tracking-widest" type="text" name="code" maxlength="6" placeholder="000000" :value="old('code')" required autofocus />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                {{ __('Verify Email') }}
            </x-primary-button>
        </form>

        <div class="mt-6 text-center space-y-3">
            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                If you don't see the email, please check your spam or promotions folder.
            </p>
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Didn't receive the code?
                <a href="{{ route('resend-verification-code') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Resend</a>
            </p>
        </div>
    </x-auth-card>
</x-guest-layout>
