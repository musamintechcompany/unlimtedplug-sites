<x-guest1-layout>
    <!-- Hero Section -->
    <section class="py-16 md:py-24 relative overflow-hidden" id="hero-section">
        <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-indigo-200 to-transparent rounded-full blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
        <style>
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes gradientShift { 0%, 100% { color: rgb(79, 70, 229); } 50% { color: rgb(99, 102, 241); } }
            .hero-animate-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
            .hero-animate-right { animation: fadeInRight 0.8s ease-out forwards; opacity: 0; }
            .animate-gradient-text { animation: gradientShift 3s ease-in-out infinite; }
        </style>
        <script>
            const heroSection = document.getElementById('hero-section');
            const heroObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.querySelectorAll('.animate-fade-in-up').forEach((el, i) => {
                            setTimeout(() => el.classList.add('hero-animate-up'), i * 100);
                        });
                        entry.target.querySelectorAll('.animate-fade-in-right').forEach(el => {
                            el.classList.add('hero-animate-right');
                        });
                        heroObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            if (heroSection) heroObserver.observe(heroSection);
        </script>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/2 mb-8 md:mb-0 animate-fade-in-up">
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 md:mb-6 leading-tight">
                        Rent or Own Professional <span class="text-indigo-600 animate-gradient-text">Websites & Apps</span> — Launch in Minutes
                    </h1>
                    <p class="text-gray-600 text-base md:text-lg mb-6 md:mb-8 max-w-lg animate-fade-in-up" style="animation-delay: 0.1s">
                        No coding required. Choose from ready-made websites, web apps, mobile apps, and business systems. Customize to your brand and go live fast.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 animate-fade-in-up" style="animation-delay: 0.2s">
                        @guest
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 md:px-8 rounded-lg transition duration-300 shadow-lg text-center text-sm md:text-base">
                                Get Started Free
                            </a>
                        @endguest
                        <a href="{{ route('browse') }}" class="bg-white hover:bg-gray-100 text-gray-900 font-medium py-3 px-6 md:px-8 rounded-lg transition duration-300 border border-gray-300 shadow-sm text-center text-sm md:text-base">
                            Browse
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center w-full animate-fade-in-right">
                    <div class="relative w-full max-w-md md:max-w-4xl">
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl w-full h-64 md:h-96 flex items-center justify-center">
                            <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-11/12">
                                <div class="flex items-center justify-between mb-3 md:mb-4">
                                    <h3 class="font-semibold text-xs md:text-sm">Go Live</h3>
                                    <span class="flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                    </span>
                                </div>
                                <div class="h-32 md:h-48 bg-white border-2 border-gray-200 rounded-lg overflow-hidden">
                                    <!-- Browser mockup -->
                                    <div class="bg-gray-100 px-2 md:px-4 py-1.5 md:py-2 border-b border-gray-300 flex items-center gap-1.5 md:gap-2">
                                        <div class="flex gap-1">
                                            <div class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-red-400"></div>
                                            <div class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-yellow-400"></div>
                                            <div class="w-2 h-2 md:w-3 md:h-3 rounded-full bg-green-400"></div>
                                        </div>
                                        <div class="flex-1 text-xs text-gray-600 ml-1 md:ml-2 truncate">www.yoursite.com</div>
                                    </div>
                                    <!-- Website content -->
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 h-full p-3 md:p-6 flex flex-col justify-center">
                                        <div class="mb-2 md:mb-4">
                                            <div class="h-2 md:h-3 bg-indigo-600 rounded w-24 md:w-32 mb-1 md:mb-2"></div>
                                            <div class="h-1.5 md:h-2 bg-gray-300 rounded w-32 md:w-48 mb-0.5 md:mb-1"></div>
                                            <div class="h-1.5 md:h-2 bg-gray-300 rounded w-28 md:w-40"></div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 md:gap-3">
                                            <div class="bg-white p-2 md:p-3 rounded shadow-sm">
                                                <div class="h-1.5 md:h-2 bg-blue-400 rounded mb-1 md:mb-2"></div>
                                                <div class="h-1 md:h-1.5 bg-gray-200 rounded"></div>
                                            </div>
                                            <div class="bg-white p-2 md:p-3 rounded shadow-sm">
                                                <div class="h-1.5 md:h-2 bg-green-400 rounded mb-1 md:mb-2"></div>
                                                <div class="h-1 md:h-1.5 bg-gray-200 rounded"></div>
                                            </div>
                                            <div class="bg-white p-2 md:p-3 rounded shadow-sm">
                                                <div class="h-1.5 md:h-2 bg-purple-400 rounded mb-1 md:mb-2"></div>
                                                <div class="h-1 md:h-1.5 bg-gray-200 rounded"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6 bg-gradient-to-br from-green-50 to-emerald-50 p-2 md:p-3 rounded-xl shadow-lg w-48 md:w-56 border-2 border-green-200">
                            <div class="flex items-center mb-1.5 md:mb-2">
                                <div class="bg-green-100 p-1 md:p-1.5 rounded-lg">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold ml-1.5 md:ml-2 text-xs md:text-sm text-green-900">Automatic Setup</h3>
                            </div>
                            <p class="text-xl md:text-2xl font-bold text-green-900 mb-0.5 md:mb-1">&lt; 3 <span class="text-green-600">Minutes</span></p>
                            <p class="text-xs text-green-700 font-medium" id="rotatingText">Go live instantly</p>
                        </div>
                        <script>
                            const messages = [
                                { text: 'Instant Setup', icon: '⚡' },
                                { text: 'Secure Payments', icon: '🔒' },
                                { text: 'Go live in minutes', icon: '🚀' },
                                { text: 'Easy Customization', icon: '🎨' },
                                { text: 'No coding needed', icon: '💻' },
                                { text: 'Multi-currency support', icon: '💰' },
                                { text: 'Professional templates', icon: '✨' },
                                { text: 'Full control', icon: '🎯' }
                            ];
                            let index = 0;
                            setInterval(() => {
                                const el = document.getElementById('rotatingText');
                                if(el) {
                                    el.style.opacity = '0';
                                    setTimeout(() => {
                                        index = (index + 1) % messages.length;
                                        el.textContent = messages[index].icon + ' ' + messages[index].text;
                                        el.style.opacity = '1';
                                    }, 300);
                                }
                            }, 3000);
                        </script>
                        <style>
                            #rotatingText { transition: opacity 0.3s ease; }
                        </style>
                        <div class="absolute -bottom-8 md:-bottom-14 -left-4 md:-left-6 bg-gradient-to-br from-indigo-50 to-purple-50 p-2 md:p-3 rounded-xl shadow-lg w-48 md:w-56 border-2 border-indigo-200">
                            <div class="flex items-center mb-1.5 md:mb-2">
                                <div class="bg-indigo-100 p-1 md:p-1.5 rounded-lg">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold ml-1.5 md:ml-2 text-xs md:text-sm text-indigo-900">Enterprise Security</h3>
                            </div>
                            <p class="text-xl md:text-2xl font-bold text-indigo-900 mb-0.5 md:mb-1">100% <span class="text-indigo-600">Secure</span></p>
                            <p class="text-xs text-indigo-700 font-medium" id="rotatingText2">Bank-level encryption</p>
                        </div>
                        <script>
                            const messages2 = [
                                { text: 'Bank-level encryption', icon: '🔐' },
                                { text: 'DDoS protection', icon: '🛡️' },
                                { text: 'SSL certificates', icon: '🔒' },
                                { text: 'Daily backups', icon: '💾' },
                                { text: '99.9% uptime', icon: '⏱️' },
                                { text: 'Advanced firewall', icon: '🚨' },
                                { text: 'Data privacy', icon: '👁️' },
                                { text: '24/7 monitoring', icon: '👀' }
                            ];
                            let index2 = 0;
                            setInterval(() => {
                                const el = document.getElementById('rotatingText2');
                                if(el) {
                                    el.style.opacity = '0';
                                    setTimeout(() => {
                                        index2 = (index2 + 1) % messages2.length;
                                        el.textContent = messages2[index2].icon + ' ' + messages2[index2].text;
                                        el.style.opacity = '1';
                                    }, 300);
                                }
                            }, 3500);
                        </script>
                        <style>
                            #rotatingText2 { transition: opacity 0.3s ease; }
                        </style>
                    </div>
                </div>
        </div>
    </section>

    <!-- Templates Showcase -->
    <section id="templates" class="py-8 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-4">Choose Your Perfect Solution</h2>
            <p class="text-center text-[#706f6c] dark:text-[#A1A09A] mb-8 text-sm md:text-base px-4">Browse our collection of professional websites, web apps, mobile apps, and desktop apps</p>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Database Projects - No Blur -->
                @forelse($projects as $project)
                    @php
                        $details = json_decode($project->details, true) ?? [];
                        $images = $details['images'] ?? [];
                        $firstImage = $images[0] ?? null;
                    @endphp
                    <a href="{{ route('projects.show', $project->id) }}" class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-blue-400/20 dark:border-blue-500/20 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-xl transition block">
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center overflow-hidden">
                            @if($firstImage)
                                <img src="{{ asset($firstImage) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 text-xs px-2 py-1 rounded-full">{{ $project->type }}</span>
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-600 text-xs px-2 py-1 rounded-full">Available</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-1">{{ $project->name }}</h3>
                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] line-clamp-2">{{ strip_tags($project->description) }}</p>
                        </div>
                    </a>
                @empty
                @endforelse

                <!-- Template 2 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-purple-400/20 dark:border-purple-500/20 hover:border-purple-400 dark:hover:border-purple-500 hover:shadow-xl transition relative">
                    <div class="absolute inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 z-10 flex items-center justify-center">
                        <span class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-lg">Coming Soon</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-600 text-xs px-2 py-1 rounded-full">Portfolio</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Creative Portfolio</h3>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-3">Showcase your work beautifully. Ideal for designers and artists.</p>
                    </div>
                </div>

                <!-- Template 3 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-green-400/20 dark:border-green-500/20 hover:border-green-400 dark:hover:border-green-500 hover:shadow-xl transition relative">
                    <div class="absolute inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 z-10 flex items-center justify-center">
                        <span class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-lg">Coming Soon</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-green-100 dark:bg-green-900/30 text-green-600 text-xs px-2 py-1 rounded-full">E-commerce</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Online Store</h3>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-3">Start selling online today. Full e-commerce functionality included.</p>
                    </div>
                </div>

                <!-- Template 4 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-orange-400/20 dark:border-orange-500/20 hover:border-orange-400 dark:hover:border-orange-500 hover:shadow-xl transition relative">
                    <div class="absolute inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 z-10 flex items-center justify-center">
                        <span class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-lg">Coming Soon</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-600 text-xs px-2 py-1 rounded-full">Business</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Business Pro</h3>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-3">Professional business website with contact forms and services.</p>
                    </div>
                </div>

                <!-- Template 5 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-pink-400/20 dark:border-pink-500/20 hover:border-pink-400 dark:hover:border-pink-500 hover:shadow-xl transition relative">
                    <div class="absolute inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 z-10 flex items-center justify-center">
                        <span class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-lg">Coming Soon</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-pink-100 dark:bg-pink-900/30 text-pink-600 text-xs px-2 py-1 rounded-full">Education</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Course Platform</h3>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-3">Teach online with course management and student enrollment.</p>
                    </div>
                </div>

                <!-- Template 6 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border-2 border-red-400/20 dark:border-red-500/20 hover:border-red-400 dark:hover:border-red-500 hover:shadow-xl transition relative">
                    <div class="absolute inset-0 backdrop-blur-sm bg-white/30 dark:bg-black/30 z-10 flex items-center justify-center">
                        <span class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-lg">Coming Soon</span>
                    </div>
                    <div class="h-48 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="bg-red-100 dark:bg-red-900/30 text-red-600 text-xs px-2 py-1 rounded-full">Community</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-1">Community Forum</h3>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-3">Build your community with forums, discussions, and user profiles.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">Why Rent With Us?</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Everything you need to launch your online presence in minutes</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <!-- Card 1 - From Left -->
                <div class="group bg-white rounded-2xl p-8 transition duration-300 border border-gray-100 hover:border-indigo-200 scroll-animate" data-animation="slide-left">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Instant Setup</h3>
                    <p class="text-gray-600 leading-relaxed">Select your app or website, and instant credentials are generated for you to access it immediately.</p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-semibold text-indigo-600">⚡ < 3 minutes</span>
                    </div>
                </div>
                <!-- Card 2 - From Right -->
                <div class="group bg-white rounded-2xl p-8 transition duration-300 border border-gray-100 hover:border-green-200 scroll-animate" data-animation="slide-right">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Flexible Pricing</h3>
                    <p class="text-gray-600 leading-relaxed">Pay only for what you use. Buy credits in your local currency. No subscriptions, no hidden fees, cancel anytime.</p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-semibold text-green-600">💰 Multi-currency</span>
                    </div>
                </div>
                <!-- Card 3 - From Left -->
                <div class="group bg-white rounded-2xl p-8 transition duration-300 border border-gray-100 hover:border-purple-200 scroll-animate" data-animation="slide-left">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Full Customization</h3>
                    <p class="text-gray-600 leading-relaxed">Customize colors, content, images, and more to match your brand. Make it truly yours in minutes.</p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm font-semibold text-purple-600">🎨 Fully customizable</span>
                    </div>
                </div>
            </div>
            <!-- Additional Benefits Row -->
            <div class="grid md:grid-cols-4 gap-4 mt-8">
                <div class="bg-white rounded-xl p-4 text-center border border-gray-100 scroll-animate" data-animation="fade-in">
                    <div class="text-2xl font-bold text-indigo-600 mb-1">99.9%</div>
                    <p class="text-sm text-gray-600">Uptime Guarantee</p>
                </div>
                <div class="bg-white rounded-xl p-4 text-center border border-gray-100 scroll-animate" data-animation="fade-in">
                    <div class="text-2xl font-bold text-green-600 mb-1">24/7</div>
                    <p class="text-sm text-gray-600">Support Available</p>
                </div>
                <div class="bg-white rounded-xl p-4 text-center border border-gray-100 scroll-animate" data-animation="fade-in">
                    <div class="text-2xl font-bold text-purple-600 mb-1">∞</div>
                    <p class="text-sm text-gray-600">Scalable Solutions</p>
                </div>
                <div class="bg-white rounded-xl p-4 text-center border border-gray-100 scroll-animate" data-animation="fade-in">
                    <div class="text-2xl font-bold text-blue-600 mb-1">🔒</div>
                    <p class="text-sm text-gray-600">Enterprise Security</p>
                </div>
            </div>
        </div>
        <style>
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-40px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(40px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .scroll-animate {
                opacity: 0;
            }
            .scroll-animate.animated {
                animation: slideInLeft 0.8s ease-out forwards;
            }
            .scroll-animate[data-animation="slide-right"].animated {
                animation: slideInRight 0.8s ease-out forwards;
            }
            .scroll-animate[data-animation="fade-in"].animated {
                animation: fadeIn 0.8s ease-out forwards;
            }
        </style>
        <script>
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animated');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            document.querySelectorAll('.scroll-animate').forEach(el => observer.observe(el));
        </script>
    </section>

    <!-- CTA Section -->
    <section class="py-20 md:py-32 px-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-10 -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl opacity-10 translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <div class="inline-block mb-4">
                        <span class="text-indigo-300 text-sm font-semibold tracking-wider uppercase opacity-0" data-animation="animate-fade-in-up" data-animation-delay="0">Ready to launch?</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight opacity-0" data-animation="animate-fade-in-up" data-animation-delay="1">Transform Your Digital Presence <span class="bg-gradient-to-r from-indigo-400 to-blue-400 bg-clip-text text-transparent">Today</span></h2>
                    <p class="text-lg text-slate-300 mb-8 leading-relaxed max-w-lg opacity-0" data-animation="animate-fade-in-up" data-animation-delay="2">Stop waiting. Start building. Join thousands of entrepreneurs who've already launched their online success with our professional, ready-to-use solutions.</p>
                    
                    <!-- Quick Benefits -->
                    <div class="grid grid-cols-2 gap-4 mb-10 opacity-0" data-animation="animate-fade-in-up" data-animation-delay="3">
                        <div class="flex items-start gap-3 group">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mt-0.5 group-hover:scale-110 transition">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-slate-200 font-medium text-sm">No credit card</span>
                        </div>
                        <div class="flex items-start gap-3 group">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mt-0.5 group-hover:scale-110 transition">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-slate-200 font-medium text-sm">Free to start</span>
                        </div>
                        <div class="flex items-start gap-3 group">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mt-0.5 group-hover:scale-110 transition">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-slate-200 font-medium text-sm">Cancel anytime</span>
                        </div>
                        <div class="flex items-start gap-3 group">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mt-0.5 group-hover:scale-110 transition">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-slate-200 font-medium text-sm">Expert support</span>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 opacity-0" data-animation="animate-fade-in-up" data-animation-delay="4">
                        @guest
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-600 hover:to-blue-600 transition duration-300 text-center shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                                Get Started Free
                            </a>
                        @endguest
                        <a href="#templates" class="bg-slate-800 text-white px-8 py-4 rounded-xl font-semibold hover:bg-slate-700 transition duration-300 border border-slate-600 text-center shadow-lg hover:shadow-xl">
                            Explore Templates
                        </a>
                    </div>
                </div>
                
                <!-- Right Visual -->
                <div class="hidden md:flex justify-center items-center opacity-0" data-animation="animate-fade-in-up" data-animation-delay="5">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="w-56 bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition duration-300 transform hover:scale-105">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">50K+</div>
                                    <p class="text-slate-400 text-xs">Active Users</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-56 bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition duration-300 transform hover:scale-105">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">1000+</div>
                                    <p class="text-slate-400 text-xs">Templates</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-56 bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition duration-300 transform hover:scale-105">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20H7m6-4h.01M15 12h-4.5A2.5 2.5 0 0010.5 9.5 2.5 2.5 0 008 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">150+</div>
                                    <p class="text-slate-400 text-xs">Countries</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-56 bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition duration-300 transform hover:scale-105">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-rose-400 to-orange-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">99.9%</div>
                                    <p class="text-slate-400 text-xs">Uptime</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
