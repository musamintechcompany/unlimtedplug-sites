<x-guest1-layout>

    <!-- Hero Section -->
    <section class="pt-16 md:pt-24 pb-12 md:pb-16 px-4 md:px-6 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-3 md:mb-4 opacity-0" data-animation="animate-fade-in-up" data-animation-delay="0">How {{ config('app.name') }} Works</h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto opacity-0" data-animation="animate-fade-in-up" data-animation-delay="1">Rent professional digital solutions in 5 simple steps. No coding required, no long-term commitments.</p>
        </div>
    </section>

    <!-- 5-Step Process -->
    <section class="py-12 md:py-20 px-4 md:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-6">
                <!-- Step 1 -->
                <div class="text-center group opacity-0" data-animation="animate-fade-in-up" data-animation-delay="0">
                    <div class="w-14 md:w-16 h-14 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-xl md:text-2xl font-bold mx-auto mb-3 md:mb-4 group-hover:scale-110 transition">
                        <svg class="w-7 md:w-8 h-7 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2">Browse Projects</h3>
                    <p class="text-xs md:text-sm text-gray-600">Explore 1000+ professional websites, web apps, mobile apps, and desktop apps</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center opacity-0" data-animation="animate-fade-in-up" data-animation-delay="1">
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Step 2 -->
                <div class="text-center group opacity-0" data-animation="animate-fade-in-up" data-animation-delay="2">
                    <div class="w-14 md:w-16 h-14 md:h-16 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-full flex items-center justify-center text-xl md:text-2xl font-bold mx-auto mb-3 md:mb-4 group-hover:scale-110 transition">
                        <svg class="w-7 md:w-8 h-7 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2">Select & Rent</h3>
                    <p class="text-xs md:text-sm text-gray-600">Choose your rental duration: 24h, 7d, 30d, or 365d with transparent pricing</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center opacity-0" data-animation="animate-fade-in-up" data-animation-delay="3">
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Step 3 -->
                <div class="text-center group opacity-0" data-animation="animate-fade-in-up" data-animation-delay="4">
                    <div class="w-14 md:w-16 h-14 md:h-16 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl md:text-2xl font-bold mx-auto mb-3 md:mb-4 group-hover:scale-110 transition">
                        <svg class="w-7 md:w-8 h-7 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2">Buy Credits</h3>
                    <p class="text-xs md:text-sm text-gray-600">Purchase credits in 9 currencies with bonus rewards on larger packages</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center opacity-0" data-animation="animate-fade-in-up" data-animation-delay="5">
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Step 4 -->
                <div class="text-center group opacity-0" data-animation="animate-fade-in-up" data-animation-delay="6">
                    <div class="w-14 md:w-16 h-14 md:h-16 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-full flex items-center justify-center text-xl md:text-2xl font-bold mx-auto mb-3 md:mb-4 group-hover:scale-110 transition">
                        <svg class="w-7 md:w-8 h-7 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2">Get Instant Access</h3>
                    <p class="text-xs md:text-sm text-gray-600">Receive auto-generated credentials in less than 3 minutes</p>
                </div>

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center opacity-0" data-animation="animate-fade-in-up" data-animation-delay="7">
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>

                <!-- Step 5 -->
                <div class="text-center group opacity-0" data-animation="animate-fade-in-up" data-animation-delay="8">
                    <div class="w-14 md:w-16 h-14 md:h-16 bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-full flex items-center justify-center text-xl md:text-2xl font-bold mx-auto mb-3 md:mb-4 group-hover:scale-110 transition">
                        <svg class="w-7 md:w-8 h-7 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2">Customize & Launch</h3>
                    <p class="text-xs md:text-sm text-gray-600">Full customization rights. Make it yours and deploy your solution</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features -->
    <section class="py-12 md:py-20 px-4 md:px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-8 md:mb-12 opacity-0" data-animation="animate-fade-in-down" data-animation-delay="0">Why Choose {{ config('app.name') }}?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-indigo-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="0">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Credit-Based System</h3>
                    <p class="text-sm md:text-base text-gray-600">No subscriptions, no hidden fees. Pay only for what you use. Buy credits in bulk and get bonus rewards.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-green-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="1">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Flexible Rental Periods</h3>
                    <p class="text-sm md:text-base text-gray-600">Rent for 24 hours, 7 days, 30 days, or a full year. Renew anytime or cancel without penalties.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-blue-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="2">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0110.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20H7m6-4h.01M15 12h-4.5A2.5 2.5 0 0110.5 9.5 2.5 2.5 0 008 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Multi-Currency Support</h3>
                    <p class="text-sm md:text-base text-gray-600">Pay in your local currency: USD, GBP, EUR, NGN, GHS, KES, ZAR, CAD, or AUD.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-purple-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="3">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Instant Setup</h3>
                    <p class="text-sm md:text-base text-gray-600">Get auto-generated credentials in less than 3 minutes. No waiting, no delays.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-pink-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="4">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Full Customization</h3>
                    <p class="text-sm md:text-base text-gray-600">Customize colors, content, images, and more. Make it truly yours before launch.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-xl p-6 md:p-8 border border-gray-200 hover:border-orange-200 hover:shadow-lg transition opacity-0" data-animation="animate-scale-in" data-animation-delay="5">
                    <div class="w-10 md:w-12 h-10 md:h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-3 md:mb-4">
                        <svg class="w-5 md:w-6 h-5 md:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Enterprise Security</h3>
                    <p class="text-sm md:text-base text-gray-600">Bank-level encryption, DDoS protection, SSL certificates, and 99.9% uptime guarantee.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-12 md:py-20 px-4 md:px-6">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-8 md:mb-12 opacity-0" data-animation="animate-fade-in-down" data-animation-delay="0">Frequently Asked Questions</h2>
            <div class="space-y-3 md:space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-200 transition opacity-0" data-animation="animate-slide-in-left" data-animation-delay="0">
                    <button class="w-full px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-sm md:text-base text-gray-900 hover:bg-gray-50 flex items-center justify-between" onclick="this.parentElement.querySelector('.faq-content').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span>What happens when my rental expires?</span>
                        <svg class="w-5 h-5 text-gray-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-4 md:px-6 pb-3 md:pb-4 text-sm md:text-base text-gray-600">
                        Your rental will be automatically suspended. You can renew it anytime to regain access, or let it expire if you no longer need it.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-200 transition opacity-0" data-animation="animate-slide-in-left" data-animation-delay="1">
                    <button class="w-full px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-sm md:text-base text-gray-900 hover:bg-gray-50 flex items-center justify-between" onclick="this.parentElement.querySelector('.faq-content').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span>Can I customize the rented solution?</span>
                        <svg class="w-5 h-5 text-gray-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-4 md:px-6 pb-3 md:pb-4 text-sm md:text-base text-gray-600">
                        Yes! You have full customization rights. Change colors, content, images, and more to match your brand perfectly.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-200 transition opacity-0" data-animation="animate-slide-in-left" data-animation-delay="2">
                    <button class="w-full px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-sm md:text-base text-gray-900 hover:bg-gray-50 flex items-center justify-between" onclick="this.parentElement.querySelector('.faq-content').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span>How do credits work?</span>
                        <svg class="w-5 h-5 text-gray-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-4 md:px-6 pb-3 md:pb-4 text-sm md:text-base text-gray-600">
                        Credits are used to pay for rentals. Each rental duration has a fixed credit cost. Buy credits in bulk to get bonus rewards and save up to 20%.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-200 transition opacity-0" data-animation="animate-slide-in-left" data-animation-delay="3">
                    <button class="w-full px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-sm md:text-base text-gray-900 hover:bg-gray-50 flex items-center justify-between" onclick="this.parentElement.querySelector('.faq-content').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span>Is there a minimum rental period?</span>
                        <svg class="w-5 h-5 text-gray-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-4 md:px-6 pb-3 md:pb-4 text-sm md:text-base text-gray-600">
                        No! You can rent for as little as 24 hours. Choose the duration that works best for you: 24h, 7d, 30d, or 365d.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-200 transition opacity-0" data-animation="animate-slide-in-left" data-animation-delay="4">
                    <button class="w-full px-4 md:px-6 py-3 md:py-4 text-left font-semibold text-sm md:text-base text-gray-900 hover:bg-gray-50 flex items-center justify-between" onclick="this.parentElement.querySelector('.faq-content').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180')">
                        <span>What currencies do you support?</span>
                        <svg class="w-5 h-5 text-gray-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-4 md:px-6 pb-3 md:pb-4 text-sm md:text-base text-gray-600">
                        We support 9 currencies: USD, GBP, EUR, NGN, GHS, KES, ZAR, CAD, and AUD. Your currency is auto-detected based on your location.
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('cta-section')
</x-guest1-layout>
