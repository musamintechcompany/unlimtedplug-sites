<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-[#EDEDEC]">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-[#A1A09A]">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    @if (session('status') === 'email-updated')
        <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-sm text-green-800 dark:text-green-200">
                <i class="fas fa-check-circle mr-2"></i>
                Your email address has been successfully updated and verified!
            </p>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-sm text-red-800 dark:text-red-200">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_photo_path" :value="__('Profile Picture')" />
            <div class="mt-2 flex flex-col sm:flex-row sm:items-center gap-4">
                <div id="profile-preview" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-semibold flex-shrink-0 overflow-hidden">
                    @if ($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <span id="profile-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <input id="profile_photo_path" name="profile_photo_path" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/20 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/30" accept="image/*" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo_path')" />
        </div>
        
        <script>
            document.getElementById('profile_photo_path').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.getElementById('profile-preview');
                        preview.innerHTML = '<img src="' + event.target.result + '" alt="Profile" class="w-full h-full object-cover">';
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            @if(session('pending_email'))
                <div class="flex items-center gap-2">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        class="mt-1 block w-full border-[#e3e3e0] dark:border-[#3E3E3A] bg-gray-100 dark:bg-[#1a1a1a] text-[#1b1b18] dark:text-[#EDEDEC] focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                        value="{{ old('email', $user->email) }}" 
                        required 
                        autocomplete="username"
                        readonly
                    />
                    <button 
                        type="button"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'verify-email-change')"
                        class="mt-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm font-medium whitespace-nowrap"
                    >
                        <i class="fas fa-shield-alt mr-1"></i>
                        Verify
                    </button>
                </div>
                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-2">
                    <i class="fas fa-lock mr-1"></i>
                    Email verification pending for <strong>{{ session('pending_email') }}</strong>. Click Verify to enter code.
                </p>
            @else
                <x-text-input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    :value="old('email', $user->email)" 
                    required 
                    autocomplete="username"
                />
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-[#A1A09A]"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- Email Verification Modal -->
    <x-modal name="verify-email-change" :show="session('status') === 'email-verification-sent' || session('status') === 'verification-code-resent' || $errors->has('code')" focusable>
        <form method="post" action="{{ route('profile.verify-email-change') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-[#EDEDEC]">
                <i class="fas fa-shield-alt mr-2 text-yellow-600"></i>
                {{ __('Verify Your New Email Address') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-[#A1A09A]">
                We've sent a 6-digit verification code to <strong class="text-gray-900 dark:text-white">{{ session('pending_email') }}</strong>
            </p>

            @if (session('status') === 'verification-code-resent')
                <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-sm text-green-800 dark:text-green-200">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verification code has been resent!
                    </p>
                </div>
            @endif

            <div class="mt-6">
                <x-input-label for="code" value="{{ __('Verification Code') }}" />

                <x-text-input
                    id="code"
                    name="code"
                    type="text"
                    class="mt-1 block w-full text-center text-2xl tracking-widest"
                    maxlength="6"
                    placeholder="000000"
                    required
                    autofocus
                />

                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-between items-center">
                <button 
                    type="button" 
                    onclick="event.preventDefault(); document.getElementById('resend-code-form').submit();"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium"
                >
                    <i class="fas fa-redo mr-1"></i>
                    Resend Code
                </button>

                <div class="flex gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button>
                        <i class="fas fa-check mr-2"></i>
                        {{ __('Verify Email') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <form id="resend-code-form" method="post" action="{{ route('profile.resend-code') }}" class="hidden">
        @csrf
    </form>
</section>
