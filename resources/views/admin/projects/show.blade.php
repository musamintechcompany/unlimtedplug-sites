<x-admin-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
            <div class="flex gap-2">
                @can('edit-projects')
                <a href="{{ route('admin.projects.edit', $project) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete-projects')
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="col-span-2 space-y-6">
                <!-- Banner Image -->
                @if($project->banner_image)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <img src="{{ asset($project->banner_image) }}" alt="{{ $project->name }}" class="w-full h-64 object-cover">
                </div>
                @endif

                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $project->description }}</p>
                </div>

                <!-- Media Images -->
                @if($project->media_images && count($project->media_images) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Media Gallery</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($project->media_images as $image)
                        <img src="{{ asset($image) }}" alt="Media" class="h-32 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pricing -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pricing</h2>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">24 Hours</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($project->pricing_24h, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">7 Days</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($project->pricing_7d, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">30 Days</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($project->pricing_30d, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 text-sm">365 Days</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($project->pricing_365d, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Status</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Status</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Buyable</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->is_buyable ? '✓ Yes' : '✗ No' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Rentable</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->is_rentable ? '✓ Yes' : '✗ No' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Details</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Category</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->category?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Subcategory</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->subcategory?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Sort Order</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->sort_order }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">API URL</p>
                            <p class="text-gray-900 dark:text-white font-medium break-all text-xs">{{ $project->api_url }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Created</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.projects.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>
</x-admin-layout>
