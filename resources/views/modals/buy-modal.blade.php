<!-- Buy Options Modal -->
<div id="buy-options-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <!-- Sticky Header -->
        <div class="sticky top-0 bg-white border-b flex items-center justify-between p-6 z-10">
            <h3 class="text-xl font-semibold text-gray-900">Buy Options</h3>
            <button onclick="closeBuyModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Scrollable Content -->
        <div class="overflow-y-auto flex-1 p-6 space-y-4">
            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-all buy-option" data-id="source">
                <div class="flex items-start">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded mt-1 mr-3 flex items-center justify-center checkbox-icon">
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-lg mb-2">Buy Source Code</div>
                        <div class="text-gray-600">Get full access to the source code and documentation to deploy on your own servers.</div>
                    </div>
                </div>
            </div>
            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-all buy-option" data-id="hosting">
                <div class="flex items-start">
                    <div class="w-5 h-5 border-2 border-gray-300 rounded mt-1 mr-3 flex items-center justify-center checkbox-icon">
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-lg mb-2">Buy + Hosting Package</div>
                        <div class="text-gray-600">We'll host the product for you with premium support and automatic updates.</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sticky Footer -->
        <div class="sticky bottom-0 bg-gray-50 border-t p-6">
            <button onclick="window.projectShow.proceedToSupport()" class="w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" id="buy-continue-btn" disabled>Continue</button>
        </div>
    </div>
</div>
