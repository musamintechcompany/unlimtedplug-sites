<x-guest1-layout>
    <!-- Browse Content -->
    <section class="py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Browse Projects</h1>
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">Rent or own professional websites, apps, and digital solutions.</p>
            </div>

            <!-- Products Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Database Projects - No Blur -->
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', $project->id) }}" class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition block">
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center overflow-hidden">
                            @if($project->banner_image)
                                <img src="{{ asset($project->banner_image) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 text-xs px-2 py-1 rounded-full">{{ $project->category?->name ?? 'Uncategorized' }}</span>
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-600 text-xs px-2 py-1 rounded-full">Available</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-1">{{ $project->name }}</h3>
                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] line-clamp-2">{{ strip_tags($project->description) }}</p>
                        </div>
                    </a>
                @empty
                @endforelse

                <!-- Template 2 - Coming Soon (Blurred) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition relative">
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
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition relative">
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
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition relative">
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
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition relative">
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
                <div class="bg-white dark:bg-[#161615] rounded-2xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-xl transition relative">
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
</x-guest1-layout>
