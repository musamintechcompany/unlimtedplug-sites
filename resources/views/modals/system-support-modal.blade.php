<!-- System Support Modal -->
<div id="system-support-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 animate-in relative" onclick="event.stopPropagation()">
        <!-- Close Button (X Icon) -->
        <button onclick="window.projectShow.closeSystemSupportModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-2.87 1.693-4.773 4.574-4.773 7.88 0 1.141.147 2.25.43 3.285L2.98 22l3.528-.931c.95.541 2.04.834 3.158.834 5.514 0 10-4.486 10-10S13.485 2.5 7.97 2.5c-1.119 0-2.208.292-3.16.833L2.98 2l1.33 3.861c-.283 1.035-.43 2.143-.43 3.285 0 3.306 1.903 6.187 4.773 7.88a9.865 9.865 0 005.031 1.378h.004c5.514 0 10-4.486 10-10s-4.486-10-10-10z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Get Support</h2>
            <p class="text-gray-600 mt-2">Contact us via WhatsApp for assistance</p>
        </div>

        <!-- Content -->
        <div class="mb-6">
            <p class="text-gray-700 text-center mb-4">
                Our support team is ready to help you with any questions about purchasing or renting projects.
            </p>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-600 mb-2">WhatsApp Number:</p>
                <p class="text-lg font-semibold text-green-600">+447452792596</p>
            </div>
        </div>

        <!-- Button -->
        <button onclick="window.projectShow.openWhatsApp()" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-2.87 1.693-4.773 4.574-4.773 7.88 0 1.141.147 2.25.43 3.285L2.98 22l3.528-.931c.95.541 2.04.834 3.158.834 5.514 0 10-4.486 10-10S13.485 2.5 7.97 2.5c-1.119 0-2.208.292-3.16.833L2.98 2l1.33 3.861c-.283 1.035-.43 2.143-.43 3.285 0 3.306 1.903 6.187 4.773 7.88a9.865 9.865 0 005.031 1.378h.004c5.514 0 10-4.486 10-10s-4.486-10-10-10z"/>
            </svg>
            Continue to WhatsApp
        </button>
    </div>
</div>
