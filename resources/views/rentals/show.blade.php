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
                            @elseif($rental->status === 'expired') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ ucfirst($rental->status) }}
                        </span>
                    </div>

                    <!-- Rental Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Current Duration</p>
                            <div class="flex items-baseline gap-1">
                                <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $rental->duration_value }}</p>
                                <p class="text-sm text-gray-600 dark:text-[#A1A09A]">{{ $rental->duration_type === 'daily' ? 'Day(s)' : ($rental->duration_type === 'weekly' ? 'Week(s)' : ($rental->duration_type === 'monthly' ? 'Month(s)' : 'Year(s)')) }}</p>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-1">Cost</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC]">{{ $rental->credits_cost }}</p>
                            <p class="text-sm text-gray-600 dark:text-[#A1A09A]">credits</p>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div id="countdown-container" class="bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg p-6">
                        <p class="text-xs text-gray-500 dark:text-[#A1A09A] uppercase tracking-wide mb-3">Time Remaining</p>
                        <div id="countdown" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-green-600 dark:text-green-400 font-mono whitespace-nowrap overflow-x-auto"></div>
                        <p id="countdown-status" class="text-xs sm:text-sm text-gray-600 dark:text-[#A1A09A] mt-2"></p>
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
                                <p id="expiry-date" class="text-sm font-medium text-gray-900 dark:text-[#EDEDEC]">{{ $rental->rental_expires_at->format('M d, Y') }}</p>
                                <p id="expiry-time" class="text-xs text-gray-600 dark:text-[#A1A09A]">{{ $rental->rental_expires_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Credentials Section -->
                <div>
                    <div class="{{ $rental->status === 'expired' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' : 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800' }} rounded-lg p-6 lg:sticky lg:top-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
                            <h3 class="text-base sm:text-lg font-semibold {{ $rental->status === 'expired' ? 'text-red-900 dark:text-red-100' : 'text-blue-900 dark:text-blue-100' }}">Rental Credentials</h3>
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
                            <div id="status-message" class="hidden p-3 rounded text-sm font-medium"></div>
                            <div>
                                <p class="text-xs sm:text-sm {{ $rental->status === 'expired' ? 'text-red-700 dark:text-red-300' : 'text-blue-700 dark:text-blue-300' }} mb-1">Admin URL</p>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <a href="{{ $rental->admin_url ? $rental->admin_url : '#' }}" target="_blank" class="block font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all {{ $rental->admin_url ? ($rental->status === 'expired' ? 'text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400') . ' hover:underline' : 'text-gray-400' }}" id="admin-url" data-full-url="{{ $rental->admin_url }}">{{ $rental->admin_url ? str_repeat('*', strlen($rental->admin_url) - 4) . substr($rental->admin_url, -4) : 'Pending...' }}</a>
                                        @if($rental->admin_url)
                                        <button type="button" onclick="toggleAdminUrlVisibility()" id="toggle-admin-url-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                            <svg id="admin-url-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="admin-url-eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                    @if($rental->admin_url)
                                    <button onclick="copyToClipboard('admin-url')" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm {{ $rental->status === 'expired' ? 'text-red-700 dark:text-red-300' : 'text-blue-700 dark:text-blue-300' }} mb-1">Admin ID</p>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <p class="font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all" id="admin-id-display" data-full-id="{{ $rental->admin_id }}">XXXXXXXXXXXXXXXX</p>
                                        <button type="button" onclick="toggleAdminIdVisibility()" id="toggle-admin-id-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                            <svg id="admin-id-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="admin-id-eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button onclick="copyAdminId()" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm {{ $rental->status === 'expired' ? 'text-red-700 dark:text-red-300' : 'text-blue-700 dark:text-blue-300' }} mb-1">Email</p>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <p class="font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border break-all" id="admin-email" data-full-email="{{ $rental->admin_email }}">XXXXXXXXXXXXXXXX</p>
                                        <button type="button" onclick="toggleEmailVisibility()" id="toggle-email-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                            <svg id="email-eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="email-eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button onclick="copyToClipboard('admin-email')" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            @if($rental->admin_password)
                            <div>
                                <p class="text-xs sm:text-sm {{ $rental->status === 'on_hold' ? 'text-red-700 dark:text-red-300' : 'text-blue-700 dark:text-blue-300' }} mb-1">Password</p>
                                <div class="flex gap-2">
                                    <div class="flex-1 relative">
                                        <input type="password" id="admin-password" value="{{ $rental->admin_password }}" class="w-full font-mono text-xs sm:text-sm bg-white dark:bg-gray-800 p-2 rounded border pr-10" readonly>
                                        <button type="button" onclick="togglePasswordVisibility()" id="toggle-password-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button onclick="copyPassword()" id="copy-password-btn" class="px-2 sm:px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded transition flex-shrink-0">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($rental->status !== 'suspended' && $rental->status !== 'banned')
            <div class="mt-6 flex gap-3 flex-col sm:flex-row">
                <button onclick="handleRenewClick('{{ $rental->status }}', '{{ $rental->id }}', '{{ $rental->rentable_project_id }}', {{ $rental->duration_value }}, '{{ $rental->duration_type }}', {{ $rental->credits_cost }}, '{{ $rental->rental_expires_at->toIso8601String() }}', {{ auth()->user()->wallet->credits_balance ?? 0 }})" class="inline-block {{ $rental->status === 'active' ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white px-6 py-3 rounded-lg font-medium transition relative group">
                    Renew Rental
                    @if($rental->status === 'active')
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                        You can renew when rental expires
                    </div>
                    @endif
                </button>
                <button onclick="openRenewalHistoryModal()" class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    View History
                </button>
            </div>
            @endif
        </div>
    </div>

    @include('modals.renew-modal')
    @include('modals.renewal-history-modal')

    <script>
    // ============================================
    // RENTAL DETAILS PAGE - MODAL FUNCTIONS
    // ============================================
    
    /**
     * Open renewal history modal and disable page scrolling
     */
    function openRenewalHistoryModal() {
        document.getElementById('renewalHistoryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    /**
     * Close renewal history modal and restore page scrolling
     */
    function closeRenewalHistoryModal() {
        document.getElementById('renewalHistoryModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ============================================
    // COUNTDOWN TIMER - RENTAL EXPIRY
    // ============================================
    
    // Parse rental expiry date from Blade template (server-side rendered)
    const rentalExpiresAt = new Date('{{ $rental->rental_expires_at->toIso8601String() }}');
    let countdownInterval;

    /**
     * Update countdown timer every second
     * Calculates remaining time and updates display with color coding:
     * - Green: 3+ days remaining (rental is active)
     * - Yellow: 1-3 days remaining (consider renewing soon)
     * - Red: Less than 24 hours remaining (urgent)
     * - Red: Expired (rental has ended)
     */
    function updateCountdown() {
        const now = new Date();
        const diff = rentalExpiresAt - now;

        // Handle expired rental
        if (diff <= 0) {
            document.getElementById('countdown').textContent = 'Expired';
            document.getElementById('countdown').className = 'text-4xl font-bold text-red-600 dark:text-red-400 font-mono';
            document.getElementById('countdown-status').textContent = 'This rental has expired';
            clearInterval(countdownInterval);
            return;
        }

        // Calculate time units
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        // Format countdown display
        const countdownText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        document.getElementById('countdown').textContent = countdownText;

        // Apply color coding based on time remaining
        const countdownEl = document.getElementById('countdown');
        if (days === 0 && hours < 24) {
            // Less than 24 hours - red warning
            countdownEl.className = 'text-4xl font-bold text-red-600 dark:text-red-400 font-mono';
            document.getElementById('countdown-status').textContent = '⚠️ Less than 24 hours remaining';
        } else if (days <= 3) {
            // 1-3 days - yellow caution
            countdownEl.className = 'text-4xl font-bold text-yellow-600 dark:text-yellow-400 font-mono';
            document.getElementById('countdown-status').textContent = 'Consider renewing soon';
        } else {
            // 3+ days - green active
            countdownEl.className = 'text-4xl font-bold text-green-600 dark:text-green-400 font-mono';
            document.getElementById('countdown-status').textContent = 'Rental is active';
        }
    }

    /**
     * Update expiry date/time display after renewal
     * Called when rental is renewed to reflect new expiry date
     * @param {string} newExpiryDate - ISO 8601 date string of new expiry
     */
    function updateExpiryDisplay(newExpiryDate) {
        const date = new Date(newExpiryDate);
        // Update date display (e.g., "Jan 15, 2026")
        document.getElementById('expiry-date').textContent = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        // Update time display (e.g., "14:30")
        document.getElementById('expiry-time').textContent = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        // Update countdown reference date
        rentalExpiresAt.setTime(date.getTime());
    }

    // Initialize countdown on page load
    updateCountdown();
    // Update countdown every 1 second
    countdownInterval = setInterval(updateCountdown, 1000);

    // Listen for renewal updates from renewal modal
    // When rental is renewed, update the expiry display
    window.addEventListener('rentalRenewed', (event) => {
        updateExpiryDisplay(event.detail.newExpiry);
    });
    </script>
</x-app-layout>
