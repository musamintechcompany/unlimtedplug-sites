<!-- Success Message -->
@if(request('payment') === 'success')
    <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">🎉 Payment Successful!</h3>
                <p class="text-green-700 dark:text-green-300 mt-1">
                    {{ number_format(request('credits', 0)) }} credits have been added to your account. Your new balance is {{ number_format(auth()->user()->wallet->credits_balance) }} credits.
                </p>
            </div>
        </div>
    </div>
@endif

@if(request('payment') === 'failed')
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Payment Failed</h3>
                <p class="text-red-700 dark:text-red-300 mt-1">Your payment was not completed. Please try again or contact support if the issue persists.</p>
            </div>
        </div>
    </div>
@endif

@if(request('payment') === 'error')
    <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">Verification Error</h3>
                <p class="text-yellow-700 dark:text-yellow-300 mt-1">We couldn't verify your payment. Please contact support with your transaction details.</p>
            </div>
        </div>
    </div>
@endif
