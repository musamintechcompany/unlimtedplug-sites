<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Purchase Credits</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Choose a package or enter a custom amount</p>
            </div>

            <!-- Credit Packages -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($packages as $package)
                    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-sm border-2 border-gray-200 dark:border-[#3E3E3A] hover:border-blue-500 dark:hover:border-blue-500 transition-all p-6 {{ $package['savings'] > 0 ? 'relative' : '' }}">
                        @if($package['savings'] > 0)
                            <div class="absolute -top-3 -right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                Save {{ $package['savings'] }}%
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ number_format($package['credits']) }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">Credits</div>
                            
                            @if($package['bonus'] > 0)
                                <div class="text-sm text-green-600 dark:text-green-400 font-medium mb-3">
                                    + {{ $package['bonus'] }} Bonus Credits
                                </div>
                            @endif
                            
                            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-6 break-words px-2">
                                {{ $currencyData['symbol'] }}{{ number_format($package['price'], 2) }}
                            </div>
                            
                            <button onclick="selectPackage({{ $package['credits'] }}, {{ $package['price'] }}, this)" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition flex items-center justify-center">
                                <span class="button-text">Purchase Now</span>
                                <svg class="button-spinner hidden animate-spin h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <!-- Custom Package -->
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-lg shadow-sm border-2 border-purple-300 dark:border-purple-700 hover:border-purple-500 dark:hover:border-purple-500 transition-all p-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                            Custom
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">1,000+ credits</div>
                        
                        <input type="number" id="customAmount" min="1000" max="50000" step="100" value="1000" 
                            oninput="calculateCustomPrice()" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] rounded-lg text-center text-2xl font-bold bg-white dark:bg-[#161615] text-gray-900 dark:text-white mb-2">
                        
                        <div id="customError" class="text-xs text-red-600 dark:text-red-400 mb-2 hidden">
                            Minimum is 1,000 credits
                        </div>
                        
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">Credits</div>
                        
                        <div id="customBonus" class="text-sm text-green-600 dark:text-green-400 font-medium mb-3">
                            + 150 Bonus Credits (15%)
                        </div>
                        
                        <div id="customPrice" class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-6 break-words px-2">
                            {{ $currencyData['symbol'] }}10.00
                        </div>
                        
                        <button id="customButton" onclick="selectCustomPackage(this)" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition flex items-center justify-center">
                            <span class="button-text">Purchase Now</span>
                            <svg class="button-spinner hidden animate-spin h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">How Credits Work</h3>
                <ul class="space-y-2 text-blue-800 dark:text-blue-200">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Credits are used to rent projects and templates</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Larger packages include bonus credits for better value</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Credits never expire and can be used anytime</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Set credit configuration for JavaScript
        window.CREDIT_CONFIG = {
            pricePerTen: {{ $currencyData['price_per_10'] }},
            currencySymbol: '{{ $currencyData['symbol'] }}',
            currency: '{{ $currency }}',
            publicKey: '{{ config('services.flutterwave.public_key') }}',
            userEmail: '{{ auth()->user()->email }}',
            userName: '{{ auth()->user()->name }}',
            userId: '{{ auth()->id() }}',
            appName: '{{ config('app.name') }}'
        };
    </script>
</x-app-layout>
