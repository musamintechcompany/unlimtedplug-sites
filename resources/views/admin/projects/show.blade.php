<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Projects
                </a>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-center font-medium">
                        ✏️ Edit
                    </a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" class="inline" onsubmit="return confirm('Delete this project?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Images & Description -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Images Card -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        @php
                            $details = json_decode($project->details, true) ?? [];
                            $images = $details['images'] ?? [];
                        @endphp
                        
                        <!-- Main Image -->
                        <div class="bg-gray-100 aspect-video flex items-center justify-center">
                            @if(count($images) > 0)
                                <img id="mainImage" src="{{ asset($images[0]) }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-gray-500">No images uploaded</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Thumbnails -->
                        @if(count($images) > 1)
                            <div class="p-4 bg-white border-t flex gap-2 overflow-x-auto">
                                @foreach($images as $index => $image)
                                    <img src="{{ asset($image) }}" alt="Thumbnail {{ $index + 1 }}" class="w-20 h-20 object-cover rounded-lg cursor-pointer flex-shrink-0 hover:ring-2 hover:ring-indigo-500 transition {{ $index === 0 ? 'ring-2 ring-indigo-500' : '' }}" onclick="changeImage('{{ asset($image) }}', this)">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Description Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Description</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $project->description }}</p>
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="space-y-6">
                    <!-- Project Title Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $project->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $project->slug }}</p>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Status</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Project Info Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Project Info</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Type</p>
                                <p class="text-gray-900 font-medium">{{ $project->type }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">API URL</p>
                                <p class="text-gray-900 font-medium break-all text-sm">{{ $project->api_url }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Sort Order</p>
                                <p class="text-gray-900 font-medium">{{ $project->sort_order }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buy/Rent Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Availability</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Buyable</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $details['is_buyable'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $details['is_buyable'] ? '✓ Yes' : '✗ No' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Rentable</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $details['is_rentable'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $details['is_rentable'] ? '✓ Yes' : '✗ No' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Pricing (Credits)</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">24 Hours</span>
                                <span class="text-lg font-bold text-indigo-600">{{ $project->pricing_24h }} credits</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">7 Days</span>
                                <span class="text-lg font-bold text-indigo-600">{{ $project->pricing_7d }} credits</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">30 Days</span>
                                <span class="text-lg font-bold text-indigo-600">{{ $project->pricing_30d }} credits</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">365 Days</span>
                                <span class="text-lg font-bold text-indigo-600">{{ $project->pricing_365d }} credits</span>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Metadata</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-500">Created</p>
                                <p class="text-gray-900 font-medium">{{ $project->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Updated</p>
                                <p class="text-gray-900 font-medium">{{ $project->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Images</p>
                                <p class="text-gray-900 font-medium">{{ count($images) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeImage(imageSrc, thumbnail) {
            document.getElementById('mainImage').src = imageSrc;
            document.querySelectorAll('[onclick*="changeImage"]').forEach(el => {
                el.classList.remove('ring-2', 'ring-indigo-500');
            });
            thumbnail.classList.add('ring-2', 'ring-indigo-500');
        }
    </script>
</x-guest-layout>
