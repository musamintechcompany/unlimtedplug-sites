<!-- Renewal History Modal -->
<div id="renewalHistoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-[#161615] rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-900 dark:to-indigo-800 px-6 py-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-white">Rental History</h2>
                <p class="text-indigo-100 text-sm mt-1">Track all renewals and changes</p>
            </div>
            <button onclick="closeRenewalHistoryModal()" class="text-white hover:text-indigo-100 transition flex-shrink-0" onclick="event.stopPropagation()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Initial Rental -->
            @if($rental->initial_details)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Initial Rental</h3>
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Started</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($rental->initial_details['rental_starts_at'])->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Duration</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $rental->initial_details['duration_value'] }} {{ str_replace('ly', '', $rental->initial_details['duration_type']) }}{{ $rental->initial_details['duration_value'] !== 1 ? 's' : '' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Cost</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $rental->initial_details['credits_cost'] }} cr</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Initial details not available for this rental</p>
            </div>
            @endif

            <!-- Renewal History Timeline -->
            @if($rental->renewal_history && count($rental->renewal_history) > 0)
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        Renewals ({{ count($rental->renewal_history) }})
                    </h3>
                    <div class="space-y-3">
                        @foreach($rental->renewal_history as $index => $renewal)
                            <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">{{ $index + 1 }}</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($renewal['renewed_at'])->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 text-xs">Added</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $renewal['quantity'] }} {{ str_replace('ly', '', $renewal['duration_type']) }}{{ $renewal['quantity'] !== 1 ? 's' : '' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 text-xs">Cost</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $renewal['cost'] }} cr</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-gray-600 dark:text-gray-400 text-xs">New Expiry</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($renewal['new_expiry'])->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">No renewals yet</p>
                </div>
            @endif

            <!-- Current Status -->
            @php
            $lastRenewal = $rental->renewal_history ? $rental->renewal_history[count($rental->renewal_history) - 1] : null;
            @endphp
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Current Status</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Status</p>
                        <p class="font-medium text-gray-900 dark:text-white capitalize">{{ $rental->status }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Expires</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $rental->rental_expires_at->format('M d, Y') }}</p>
                    </div>
                    @if($lastRenewal)
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Last Renewed</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($lastRenewal['renewed_at'])->format('M d, Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
