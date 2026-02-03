<x-guest-layout>
    <div class="mb-4 text-sm text-[#706f6c] dark:text-[#A1A09A]">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="w-full py-3 text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-indigo-600 dark:hover:text-indigo-400 font-medium border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
