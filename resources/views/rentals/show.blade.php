<x-app-layout>
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('rentals.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-2 inline-block">
                    ← Back to Rentals
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-[#EDEDEC]">Rental Details</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Main Details -->
                <div class="space-y-4">
                    <!-- Project Name -->
                    <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-[#EDEDEC] mb-2">{{ $rental->rentableProject->name }}</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($rental->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($rental->status === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ ucfirst($rental->status) }}
                        </span>
                    </div>

                    <!-- Rental Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Duration</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $rental->duration_days }}</p>
                            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">days</p>
                        </div>
                        <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Cost</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $rental->credits_cost }}</p>
                            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">credits</p>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Started</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $rental->rental_starts_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-600 dark:text-[#A1A09A]">{{ $rental->rental_starts_at->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Expires</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $rental->rental_expires_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-600 dark:text-[#A1A09A]">{{ $rental->rental_expires_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Credentials Section -->
                <div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 lg:sticky lg:top-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
                            <h3 class="text-base sm:text-lg font-semibold text-blue-900 dark:text-blue-100">Access Credentials</h3>
                            @if($rental->status === 'active')
                            <button onclick="refreshCredentials()" id="refresh-btn" class="text-xs sm:text-sm px-2 sm:px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition self-start">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh
                            </button>
                            @endif
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mb-1">Admin ID</p>
                                <div class="flex gap-2">
                                    <p class="flex-1 font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all" id="admin-id-display">{{ substr($rental->admin_id, 0, 4) }}XXXXXXXX{{ substr($rental->admin_id, -4) }}</p>
                                    <button onclick="copyAdminId()" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mb-1">Email</p>
                                <div class="flex gap-2">
                                    <p class="flex-1 font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all" id="admin-email">{{ $rental->admin_email }}</p>
                                    <button onclick="copyToClipboard('admin-email')" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @if($rental->admin_password)
                            <div>
                                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mb-1">Password</p>
                                <div class="flex gap-2">
                                    <p class="flex-1 font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all" id="admin-password">{{ $rental->admin_password }}</p>
                                    <button onclick="copyToClipboard('admin-password')" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">⚠️ Original password. Use new password if changed.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($rental->status !== 'suspended' && $rental->status !== 'banned')
            <div class="mt-6">
                <button onclick="openRenewModal('{{ $rental->id }}', '{{ $rental->rentable_project_id }}', {{ $rental->duration_days }}, {{ $rental->credits_cost }}, '{{ $rental->rental_expires_at->toIso8601String() }}', {{ auth()->user()->wallet->credits_balance ?? 0 }})" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Renew Rental
                </button>
            </div>
            @endif
        </div>
    </div>

    @include('modals.renew-modal')

    <script>
    function copyAdminId() {
        const adminId = '{{ $rental->admin_id }}';
        navigator.clipboard.writeText(adminId).then(() => {
            const element = document.getElementById('admin-id-display');
            const originalText = element.textContent;
            element.textContent = 'Copied!';
            element.classList.add('text-green-600');
            setTimeout(() => {
                element.textContent = originalText;
                element.classList.remove('text-green-600');
            }, 1500);
        });
    }

    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        navigator.clipboard.writeText(element.textContent).then(() => {
            const originalText = element.textContent;
            element.textContent = 'Copied!';
            element.classList.add('text-green-600');
            setTimeout(() => {
                element.textContent = originalText;
                element.classList.remove('text-green-600');
            }, 1500);
        });
    }

    function refreshCredentials() {
        const btn = document.getElementById('refresh-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="w-4 h-4 inline animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';

        fetch('{{ $rental->rentableProject->api_url }}/api/tenant/status/{{ $rental->admin_id }}')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    document.getElementById('admin-email').textContent = data.data.email;
                    alert('Credentials refreshed successfully!');
                } else {
                    alert('Failed to refresh credentials');
                }
            })
            .catch(() => alert('An error occurred'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Refresh';
            });
    }
    </script>
</x-app-layout>
