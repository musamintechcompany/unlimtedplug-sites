<!-- Own Options Modal -->
<div id="own-options-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <!-- Sticky Header -->
        <div class="sticky top-0 bg-white border-b flex items-center justify-between p-6 z-10">
            <h3 class="text-xl font-semibold text-gray-900">Own Options</h3>
            <button onclick="closeOwnModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Scrollable Content -->
        <div class="overflow-y-auto flex-1 p-6 space-y-4">
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors" data-id="source">
                <div class="font-semibold text-lg mb-2">Own Source Code</div>
                <div class="text-gray-600 mb-3">Get full access to the source code and documentation to deploy on your own servers.</div>
                <div class="text-2xl font-bold text-green-600">4990 coins</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors" data-id="hosting">
                <div class="font-semibold text-lg mb-2">Own + Hosting Package</div>
                <div class="text-gray-600 mb-3">We'll host the product for you with premium support and automatic updates.</div>
                <div class="text-2xl font-bold text-green-600">6990 coins</div>
            </div>
        </div>
        
        <!-- Sticky Footer -->
        <div class="sticky bottom-0 bg-gray-50 border-t p-6">
            <button class="w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Continue</button>
        </div>
    </div>
</div>
