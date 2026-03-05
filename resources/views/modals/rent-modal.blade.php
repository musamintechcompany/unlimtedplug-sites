<!-- Rental Options Modal -->
<div id="rental-options-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Rental Options</h3>
            <button onclick="closeRentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 cursor-pointer transition-colors" data-id="daily">
                <div class="font-semibold text-lg mb-2">Daily Rental</div>
                <div class="text-gray-600 mb-3">Standard rental with basic support and documentation.</div>
                <div class="text-2xl font-bold text-green-600">10 credits/day</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 cursor-pointer transition-colors" data-id="weekly">
                <div class="font-semibold text-lg mb-2">Weekly Rental</div>
                <div class="text-gray-600 mb-3">Includes priority support and access to premium features.</div>
                <div class="text-2xl font-bold text-green-600">16 credits/week</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 cursor-pointer transition-colors" data-id="monthly">
                <div class="font-semibold text-lg mb-2">Monthly Rental</div>
                <div class="text-gray-600 mb-3">Includes priority support and access to premium features.</div>
                <div class="text-2xl font-bold text-green-600">22 credits/month</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 cursor-pointer transition-colors" data-id="yearly">
                <div class="font-semibold text-lg mb-2">Yearly Rental</div>
                <div class="text-gray-600 mb-3">Best value with full support and all features included.</div>
                <div class="text-2xl font-bold text-green-600">200 credits/year</div>
            </div>
        </div>
        <div class="flex justify-between p-6 border-t bg-gray-50">
            <button onclick="closeRentModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Back</button>
            <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Continue</button>
        </div>
    </div>
</div>

<!-- Rental Duration Modal -->
<div id="rental-duration-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Rental Duration</h3>
            <button onclick="closeRentDurationModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Duration Type</label>
                    <select id="duration-type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white text-sm" onchange="updateDurationLabel()">
                        <option value="">-- Choose --</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                
                <div id="quantity-section" class="hidden">
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 sm:p-4 rounded-lg mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400" id="price-label">Price per day:</span>
                            <span class="font-semibold text-gray-900 dark:text-white" id="price-per-unit">0 credits</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" id="duration-label">How many days?</label>
                        <input type="number" min="1" value="" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white" id="duration-input" onchange="calculateTotal()" oninput="calculateTotal()">
                    </div>
                    <div class="flex justify-between items-center text-lg font-semibold mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <span class="text-gray-900 dark:text-white">Total:</span>
                        <span id="rental-total-amount" class="text-green-600 dark:text-green-400">0 credits</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-0 p-4 sm:p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <button id="confirm-rental-btn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed disabled:hover:bg-gray-400" disabled onclick="confirmRental()">Confirm Rental</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="rental-success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full text-center" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Rental Created!</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Your rental credentials have been generated successfully.</p>
            <a href="{{ route('rentals.index') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">View Rentals</a>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div id="login-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center p-4" onclick="event.stopPropagation()">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sign In Required</h3>
            <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 dark:text-gray-400 mb-6">You need to be signed in to rent this project.</p>
            <a href="{{ route('login') }}" class="block w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center text-sm font-medium mb-3">Sign In</a>
            <a href="{{ route('register') }}" class="block w-full px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-center text-sm font-medium">Create Account</a>
        </div>
    </div>
</div>

<script>
    const pricingMap = {
        daily: { label: 'days', priceLabel: 'Price per day:' },
        weekly: { label: 'weeks', priceLabel: 'Price per week:' },
        monthly: { label: 'months', priceLabel: 'Price per month:' },
        yearly: { label: 'years', priceLabel: 'Price per year:' }
    };

    function closeLoginModal() {
        document.body.style.overflow = '';
        document.getElementById('login-modal').classList.add('hidden');
    }

    function updateDurationLabel() {
        const durationType = document.getElementById('duration-type').value;
        const quantitySection = document.getElementById('quantity-section');
        const durationLabel = document.getElementById('duration-label');
        const durationInput = document.getElementById('duration-input');
        const pricePerUnit = document.getElementById('price-per-unit');
        const priceLabel = document.getElementById('price-label');
        
        if (durationType && pricingMap[durationType]) {
            quantitySection.classList.remove('hidden');
            const config = pricingMap[durationType];
            durationLabel.textContent = `How many ${config.label}?`;
            priceLabel.textContent = config.priceLabel;
            durationInput.value = '';
            
            const projectPricing = window.projectPricing || {};
            const price = projectPricing[durationType] || 0;
            pricePerUnit.textContent = price + ' credits';
            
            calculateTotal();
        } else {
            quantitySection.classList.add('hidden');
        }
    }

    function calculateTotal() {
        const durationType = document.getElementById('duration-type').value;
        const quantity = parseInt(document.getElementById('duration-input').value) || 0;
        const projectPricing = window.projectPricing || {};
        const price = projectPricing[durationType] || 0;
        const confirmBtn = document.getElementById('confirm-rental-btn');
        
        if (durationType && price && quantity > 0) {
            const total = price * quantity;
            document.getElementById('rental-total-amount').textContent = total + ' credits';
            confirmBtn.disabled = false;
        } else {
            confirmBtn.disabled = true;
        }
    }

    function confirmRental() {
        const durationType = document.getElementById('duration-type').value;
        const quantity = parseInt(document.getElementById('duration-input').value);
        const projectId = window.projectId;
        const projectPricing = window.projectPricing || {};
        const price = projectPricing[durationType];
        const totalCredits = price * quantity;
        const confirmBtn = document.getElementById('confirm-rental-btn');
        
        // Check if CSRF token exists
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }
        
        // Disable button and show loading
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Processing...';

        console.log('Sending rental request:', {
            project_id: projectId,
            duration_type: durationType,
            duration_value: quantity
        });

        fetch('{{ route('rentals.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                project_id: projectId,
                duration_type: durationType,
                duration_value: quantity
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (response.status === 401) {
                console.log('User not authenticated, showing login modal');
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Confirm Rental';
                closeRentDurationModal();
                document.body.style.overflow = 'hidden';
                document.getElementById('login-modal').classList.remove('hidden');
                return null;
            }
            if (response.status === 400) {
                // Try to parse JSON for 400 errors to get specific error message
                return response.json().catch(() => ({ error: 'Bad request - please check your input' }));
            }
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                closeRentDurationModal();
                document.body.style.overflow = 'hidden';
                document.getElementById('rental-success-modal').classList.remove('hidden');
            } else if (data && data.error) {
                alert(data.error);
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Confirm Rental';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Confirm Rental';
        });
    }
</script>
