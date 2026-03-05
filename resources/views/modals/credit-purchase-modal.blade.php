<!-- Credit Purchase Modal -->
<div id="credit-purchase-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-6 border-b dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Purchase Credits</h3>
            <button onclick="closeCreditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- 100 Credits -->
                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition-all" onclick="selectCreditPackage(100, 10)">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">100 Credits</div>
                        <div class="text-2xl font-semibold text-green-600 mb-2">$10.00</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Perfect for trying out</div>
                    </div>
                </div>

                <!-- 500 Credits -->
                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition-all" onclick="selectCreditPackage(500, 45)">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">500 Credits</div>
                        <div class="text-2xl font-semibold text-green-600 mb-2">$45.00</div>
                        <div class="text-sm text-green-600 font-medium mb-1">Save $5 (10% bonus)</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Most popular</div>
                    </div>
                </div>

                <!-- 1000 Credits -->
                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition-all" onclick="selectCreditPackage(1000, 85)">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">1,000 Credits</div>
                        <div class="text-2xl font-semibold text-green-600 mb-2">$85.00</div>
                        <div class="text-sm text-green-600 font-medium mb-1">Save $15 (15% bonus)</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Best value</div>
                    </div>
                </div>

                <!-- 5000 Credits -->
                <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition-all" onclick="selectCreditPackage(5000, 400)">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">5,000 Credits</div>
                        <div class="text-2xl font-semibold text-green-600 mb-2">$400.00</div>
                        <div class="text-sm text-green-600 font-medium mb-1">Save $100 (20% bonus)</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Enterprise</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between p-6 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <button onclick="closeCreditModal()" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">Cancel</button>
        </div>
    </div>
</div>
