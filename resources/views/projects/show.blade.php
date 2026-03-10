<x-guest1-layout>
    
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L9 3.414V19a1 1 0 0 0 2 0V3.414l7.293 7.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="#" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Projects</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $project['name'] }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Desktop: Vertical Thumbnails (Left) -->
                <div class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-4">
                        <div class="max-h-96 overflow-y-auto overflow-x-hidden space-y-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            @if($project['banner_image'])
                                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden shadow-sm border cursor-pointer hover:ring-2 hover:ring-blue-500 ring-2 ring-blue-500" 
                                     onclick="window.projectShow.changeMainImage('{{ asset($project['banner_image']) }}', this)">
                                    <img src="{{ asset($project['banner_image']) }}" alt="Banner" class="w-full h-full object-cover">
                                </div>
                            @endif
                            @foreach($project['images'] as $index => $image)
                                <div class="w-16 h-16 bg-white rounded-lg overflow-hidden shadow-sm border cursor-pointer hover:ring-2 hover:ring-blue-500" 
                                     onclick="window.projectShow.changeMainImage('{{ asset($image) }}', this)">
                                    <img src="{{ asset($image) }}" alt="{{ $project['name'] }} - Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Image -->
                <div class="lg:col-span-6">
                    <div class="sticky top-4">
                        <div class="aspect-square bg-white rounded-lg overflow-hidden shadow-sm border" id="main-media-container">
                            <img id="mainImage" src="{{ asset($project['banner_image'] ?? ($project['images'][0] ?? '')) }}" alt="{{ $project['name'] }}" class="w-full h-full object-cover cursor-pointer" onclick="window.projectShow.openFullscreen()">
                        </div>
                        
                        <!-- Mobile: Horizontal Thumbnails (Below main image) -->
                        <div class="lg:hidden mt-4">
                            <div class="overflow-x-auto scrollbar-hide">
                                <div class="flex gap-2 pb-2" style="min-width: max-content;">
                                    @if($project['banner_image'])
                                        <div class="flex-shrink-0 w-16 h-16 bg-white rounded-lg overflow-hidden shadow-sm border cursor-pointer hover:ring-2 hover:ring-blue-500 ring-2 ring-blue-500" 
                                             onclick="window.projectShow.changeMainImage('{{ asset($project['banner_image']) }}', this)">
                                            <img src="{{ asset($project['banner_image']) }}" alt="Banner" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    @foreach($project['images'] as $index => $image)
                                        <div class="flex-shrink-0 w-16 h-16 bg-white rounded-lg overflow-hidden shadow-sm border cursor-pointer hover:ring-2 hover:ring-blue-500" 
                                             onclick="window.projectShow.changeMainImage('{{ asset($image) }}', this)">
                                            <img src="{{ asset($image) }}" alt="{{ $project['name'] }} - Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Details -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Title -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $project['name'] }}</h1>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <!-- Buy Button -->
                        @if($project['is_buyable'] ?? false)
                            <button onclick="window.projectShow.openBuyModal()" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                Buy Now
                            </button>
                        @endif
                        
                        <!-- Rent Button -->
                        @if($project['is_rentable'] ?? false)
                            <button onclick="window.projectShow.openRentModal()" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                Rent Now
                            </button>
                        @endif
                        
                        <!-- Share Button -->
                        <button onclick="window.projectShow.openShareModal()" class="w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                            Share
                        </button>
                    </div>

                    <!-- Collapsible Sections -->
                    <div class="space-y-4">
                        <!-- Description -->
                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="window.projectShow.toggleSection('description')" class="w-full px-4 py-3 text-left font-medium text-gray-900 hover:bg-gray-50 flex items-center justify-between">
                                Description
                                <svg id="description-icon" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="description-content" class="px-4 pb-4 text-gray-600 leading-relaxed prose-content">
                                {!! $project['description'] !!}
                            </div>
                        </div>

                        <!-- Project Details -->
                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="window.projectShow.toggleSection('details')" class="w-full px-4 py-3 text-left font-medium text-gray-900 hover:bg-gray-50 flex items-center justify-between">
                                Project Details
                                <svg id="details-icon" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="details-content" class="px-4 pb-4">
                                <dl class="grid grid-cols-1 gap-4">
                                    @if($project['category'])
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                                            <dd class="text-sm text-gray-900">{{ $project['category'] }}</dd>
                                        </div>
                                    @endif
                                    @if($project['subcategory'])
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Subcategory</dt>
                                            <dd class="text-sm text-gray-900">{{ $project['subcategory'] }}</dd>
                                        </div>
                                    @endif
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Available
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Reviews Section -->
                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="window.projectShow.toggleSection('reviews')" class="w-full px-4 py-3 text-left font-medium text-gray-900 hover:bg-gray-50 flex items-center justify-between">
                                Reviews (0)
                                <svg id="reviews-icon" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="reviews-content" class="px-4 pb-4 hidden">
                                <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review this project!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Modal -->
    <div id="fullscreen-modal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden flex items-center justify-center p-4" onclick="closeFullscreen()">
        <button onclick="closeFullscreen()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-white/10 hover:bg-white/20 p-2 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Include Modals -->
    @include('modals.buy-modal')
    @include('modals.rent-modal')
    @include('modals.share-modal')
    
    <script>
        window.projectId = '{{ $project['id'] }}';
        window.projectPricing = {
            daily: {{ $project['pricing_24h'] ?? 10 }},
            weekly: {{ $project['pricing_7d'] ?? 60 }},
            monthly: {{ $project['pricing_30d'] ?? 200 }},
            yearly: {{ $project['pricing_365d'] ?? 2000 }}
        };
    </script>
</x-guest1-layout>