<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mb-2">Settings</h1>
        <p class="text-gray-600 dark:text-[#A1A09A]">Configure admin panel settings</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/' . $adminLoginPrefix . '/settings') }}" enctype="multipart/form-data" x-data="{ logoPreview: null, faviconPreview: null, hasLogo: {{ $logo ? 'true' : 'false' }} }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-[#EDEDEC] mb-4">App Logo</h3>
                <div class="mb-2">
                    <img :src="logoPreview || '{{ $logo ? asset('storage/' . $logo) : '' }}'" x-show="logoPreview || {{ $logo ? 'true' : 'false' }}" class="h-16 border border-gray-200 dark:border-[#3E3E3A] rounded p-2">
                </div>
                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/20 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/30" @change="logoPreview = URL.createObjectURL($event.target.files[0]); hasLogo = true" @cannot('edit-settings') disabled @endcannot>
                <p class="text-xs text-gray-600 dark:text-[#A1A09A] mt-1">Recommended: PNG/SVG, max 2MB</p>
            </div>

            <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-[#EDEDEC] mb-4">Favicon</h3>
                <div class="mb-2">
                    <img :src="faviconPreview || '{{ $favicon ? asset('storage/' . $favicon) : '' }}'" x-show="faviconPreview || {{ $favicon ? 'true' : 'false' }}" class="h-8 border border-gray-200 dark:border-[#3E3E3A] rounded p-1">
                </div>
                <input type="file" name="favicon" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/20 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/30" @change="faviconPreview = URL.createObjectURL($event.target.files[0])" @cannot('edit-settings') disabled @endcannot>
                <p class="text-xs text-gray-600 dark:text-[#A1A09A] mt-1">Recommended: ICO/PNG 32x32, max 1MB</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-[#EDEDEC] mb-4">Logo Display Options</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">Logo Only</p>
                        <p class="text-xs text-gray-600 dark:text-[#A1A09A]">Display uploaded logo image only</p>
                    </div>
                    <div class="relative" x-data="{ showTooltip: false }">
                        <label class="relative inline-flex items-center" :class="hasLogo ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'"
                               @mouseenter="if (!hasLogo) showTooltip = true" 
                               @mouseleave="showTooltip = false">
                            <input type="radio" name="logo_display" value="logo_only" {{ $logoDisplay === 'logo_only' ? 'checked' : '' }} class="sr-only peer" :disabled="!hasLogo" @cannot('edit-settings') disabled @endcannot>
                            <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all" :class="hasLogo ? 'bg-gray-200 dark:bg-gray-700 peer-checked:bg-blue-600' : 'bg-gray-300 dark:bg-gray-600 cursor-not-allowed'"></div>
                        </label>
                        <div x-show="showTooltip" x-transition class="absolute right-0 top-full mt-2 px-3 py-2 bg-gray-900 text-white text-xs rounded shadow-lg whitespace-nowrap z-50">
                            Please upload a logo first
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">App Name Only</p>
                        <p class="text-xs text-gray-600 dark:text-[#A1A09A]">Display application name text only</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="radio" name="logo_display" value="name_only" {{ $logoDisplay === 'name_only' ? 'checked' : '' }} class="sr-only peer" @cannot('edit-settings') disabled @endcannot>
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">Both Logo & Name</p>
                        <p class="text-xs text-gray-600 dark:text-[#A1A09A]">Display logo and app name together</p>
                    </div>
                    <div class="relative" x-data="{ showTooltip: false }">
                        <label class="relative inline-flex items-center" :class="hasLogo ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'" 
                               @mouseenter="if (!hasLogo) showTooltip = true" 
                               @mouseleave="showTooltip = false">
                            <input type="radio" name="logo_display" value="both" {{ $logoDisplay === 'both' ? 'checked' : '' }} class="sr-only peer" :disabled="!hasLogo" @cannot('edit-settings') disabled @endcannot>
                            <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all" :class="hasLogo ? 'bg-gray-200 dark:bg-gray-700 peer-checked:bg-blue-600' : 'bg-gray-300 dark:bg-gray-600 cursor-not-allowed'"></div>
                        </label>
                        <div x-show="showTooltip" x-transition class="absolute right-0 top-full mt-2 px-3 py-2 bg-gray-900 text-white text-xs rounded shadow-lg whitespace-nowrap z-50">
                            Please upload a logo first
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-[#EDEDEC] mb-1">Custom Admin URL Prefix</h3>
                    <p class="text-sm text-gray-600 dark:text-[#A1A09A]">Enable to customize your admin panel URL</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="enable_custom_prefix" id="prefixToggle" value="1" onchange="togglePrefixForm()" {{ $adminLoginPrefix !== 'admin' ? 'checked' : '' }} class="sr-only peer" @cannot('edit-settings') disabled @endcannot>
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <div id="prefixForm" class="{{ $adminLoginPrefix !== 'admin' ? '' : 'hidden' }}">
                <label class="block text-sm font-semibold text-gray-900 dark:text-[#EDEDEC] mb-2">Admin Login Prefix</label>
                <input type="text" name="admin_login_prefix" value="{{ $adminLoginPrefix }}" placeholder="admin" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" @cannot('edit-settings') readonly @endcannot>
                <p class="text-xs text-gray-600 dark:text-[#A1A09A] mt-2">Custom URL prefix for admin panel (e.g., "admin", "dashboard", "panel")</p>
                @error('admin_login_prefix')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @can('edit-settings')
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2 rounded-lg font-medium transition">
            <i class="fas fa-save mr-2"></i>Save Settings
        </button>
        @endcan
    </form>

    <script>
        function togglePrefixForm() {
            const form = document.getElementById('prefixForm');
            const toggle = document.getElementById('prefixToggle');
            
            if (toggle.checked) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
