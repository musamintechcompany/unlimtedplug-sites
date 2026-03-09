<x-guest-layout>
    <x-auth-card>
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Enter reset code</h2>
            <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Check your email for the 6-digit code</p>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('password.check-code') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="email" value="{{ request('email') ?? session('email') }}">

            <div>
                <x-input-label for="code" :value="__('Reset Code')" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]" />
                <x-text-input id="code" class="block mt-2 w-full text-center text-2xl tracking-widest" type="text" name="code" maxlength="6" placeholder="000000" required autofocus />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                {{ __('Verify Code') }}
            </x-primary-button>

            <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Didn't receive the code?
                <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Resend</a>
            </p>
        </form>
    </x-auth-card>
</x-guest-layout>
