<!-- Renewal Modal -->
<div id="renewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-[#161615] rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div id="modalContent">
            <!-- Loading state -->
            <div id="loadingState" class="text-center py-12">
                <svg class="animate-spin h-8 w-8 mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">Checking availability...</p>
            </div>

            <!-- Error state -->
            <div id="errorState" class="hidden text-center py-12 px-6">
                <svg class="h-12 w-12 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="mt-3 text-base font-semibold text-gray-900 dark:text-[#EDEDEC]">Unavailable</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" id="errorMessage"></p>
                <button onclick="closeRenewModal()" class="mt-4 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg transition">
                    Close
                </button>
            </div>

            <!-- Renewal form -->
            <div id="renewForm" class="hidden p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-[#EDEDEC] mb-4">Renew Rental</h3>
                
                <div class="space-y-3">
                    <!-- Pricing comparison -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Original</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-[#EDEDEC]" id="originalPrice"></p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded">
                            <p class="text-xs text-blue-600 dark:text-blue-300 mb-1">Current</p>
                            <p class="text-sm font-semibold text-blue-900 dark:text-blue-100" id="currentPrice"></p>
                        </div>
                    </div>

                    <!-- Duration input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Add <span id="durationType"></span>
                        </label>
                        <input type="number" id="durationInput" min="1" value="1" 
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-[#EDEDEC] focus:ring-2 focus:ring-indigo-500"
                            oninput="calculateRenewal()">
                    </div>

                    <!-- Cost summary -->
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Cost</span>
                            <span class="font-bold text-indigo-900 dark:text-indigo-100" id="totalCost"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700 dark:text-gray-300">Balance</span>
                            <span class="font-semibold" id="userBalance"></span>
                        </div>
                        <div class="border-t border-gray-300 dark:border-gray-600 pt-2">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600 dark:text-gray-400">Expires</span>
                                <span>{{ $rental->rental_expires_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-xs mt-1">
                                <span class="text-gray-600 dark:text-gray-400">New Expiry</span>
                                <span class="font-bold text-indigo-900 dark:text-indigo-100" id="newExpiry"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Insufficient credits warning -->
                    <div id="insufficientCredits" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded p-2">
                        <p class="text-xs text-red-700 dark:text-red-300">⚠️ Insufficient credits</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 mt-4">
                    <button onclick="closeRenewModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-[#EDEDEC] text-sm rounded-lg transition">
                        Cancel
                    </button>
                    <button onclick="submitRenewal()" id="renewButton" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
