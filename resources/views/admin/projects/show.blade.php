<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium transition text-sm mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Projects
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                @can('edit-projects')
                <a href="{{ route('admin.projects.edit', $project) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete-projects')
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Banner Image -->
                @if($project->banner_image)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $project->banner_image) }}" alt="{{ $project->name }}" class="w-full h-64 sm:h-96 object-cover">
                </div>
                @elseif(!empty($project->media_images) && count($project->media_images) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $project->media_images[0]) }}" alt="{{ $project->name }}" class="w-full h-64 sm:h-96 object-cover">
                </div>
                @endif

                <!-- Media Images -->
                @if($project->media_images && count($project->media_images) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4">Media Gallery</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($project->media_images as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Media" class="w-full h-32 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                    <div class="prose prose-sm sm:prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400">
                        {!! $project->description !!}
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4">Rental Pricing</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">24 Hours</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($project->pricing_24h) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">credits</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">7 Days</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($project->pricing_7d) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">credits</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">30 Days</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($project->pricing_30d) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">credits</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">365 Days</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($project->pricing_365d) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">credits</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-4">Status</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mt-1">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Buyable</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mt-1">{{ $project->is_buyable ? '✓ Yes' : '✗ No' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Rentable</p>
                            <p class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mt-1">{{ $project->is_rentable ? '✓ Yes' : '✗ No' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-4">Details</h3>
                    <div class="space-y-3 text-xs sm:text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Category</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $project->category?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Subcategory</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $project->subcategory?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Sort Order</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $project->sort_order }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">API URL</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1 break-all text-xs">{{ $project->api_url }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Created</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $project->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Last Updated</p>
                            <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $project->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Prose styling for description HTML */
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }
        .prose h1 { font-size: 2em; }
        .prose h2 { font-size: 1.5em; }
        .prose h3 { font-size: 1.25em; }
        .prose p { margin-bottom: 1em; }
        .prose ul, .prose ol { margin-left: 1.5em; margin-bottom: 1em; }
        .prose ul { list-style-type: disc; }
        .prose ol { list-style-type: decimal; }
        .prose li { margin-bottom: 0.5em; }
        .prose strong { font-weight: 700; }
        .prose em { font-style: italic; }
        .prose a { color: #3b82f6; text-decoration: underline; }
        .prose a:hover { color: #2563eb; }
    </style>
</x-admin-layout>
