<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.projects.index') }}\" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium transition text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Projects
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 px-6 py-8">
                <h1 class="text-2xl md:text-3xl font-bold text-white">✏️ Edit Project</h1>
                <p class="text-blue-100 mt-2 text-sm">Update project details and pricing</p>
            </div>

            <!-- Form Section -->
            <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PATCH')

                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                            Basic Information
                        </h2>
                        <div class="space-y-5">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Project Name *</label>
                                <input type="text" name="name" value="{{ old('name', $project->name) }}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description with Quill -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                                <div id="description-editor" style="height: 300px;" class="bg-white dark:bg-gray-700"></div>
                                <input type="hidden" name="description" id="description-input" value="{{ old('description', $project->description) }}" required>
                                @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Category & Subcategory -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                                    <select name="category_id" id="categorySelect" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Subcategory *</label>
                                    <select name="subcategory_id" id="subcategorySelect" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">Select a subcategory</option>
                                        @if($project->subcategory)
                                            <option value="{{ $project->subcategory->id }}" selected>{{ $project->subcategory->name }}</option>
                                        @endif
                                    </select>
                                    @error('subcategory_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- API URL -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">API URL *</label>
                                <input type="text" name="api_url" value="{{ old('api_url', $project->api_url) }}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('api_url') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center mr-3 text-sm font-bold">2</span>
                            Pricing (Credits)
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">24 Hours *</label>
                                <input type="number" name="pricing_24h" value="{{ old('pricing_24h', $project->pricing_24h) }}" step="1" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('pricing_24h') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">7 Days *</label>
                                <input type="number" name="pricing_7d" value="{{ old('pricing_7d', $project->pricing_7d) }}" step="1" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('pricing_7d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">30 Days *</label>
                                <input type="number" name="pricing_30d" value="{{ old('pricing_30d', $project->pricing_30d) }}" step="1" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('pricing_30d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">365 Days *</label>
                                <input type="number" name="pricing_365d" value="{{ old('pricing_365d', $project->pricing_365d) }}" step="1" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('pricing_365d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center mr-3 text-sm font-bold">3</span>
                            Project Images
                        </h2>
                        
                        <!-- Banner Image -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Banner Image</label>
                            @if($project->banner_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $project->banner_image) }}" class="w-full h-32 object-cover rounded-lg">
                                    <label class="flex items-center gap-2 mt-2 cursor-pointer">
                                        <input type="checkbox" name="delete_banner" value="1" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Delete banner</span>
                                    </label>
                                </div>
                            @elseif(!empty($project->media_images) && count($project->media_images) > 0)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $project->media_images[0]) }}" class="w-full h-32 object-cover rounded-lg">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">No banner set — showing first media image as preview</p>
                                </div>
                            @endif
                            <input type="file" name="banner_image" accept="image/*" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('banner_image') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Media Images -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Media Images</label>
                            @if($project->media_images && count($project->media_images) > 0)
                                <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach($project->media_images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-24 object-cover rounded-lg">
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="media_images[]" multiple accept="image/*" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('media_images') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sort Order & Status -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center mr-3 text-sm font-bold">4</span>
                            Display & Availability
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sort Order *</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('sort_order') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                                <select name="status" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex gap-4 mt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_buyable" value="1" {{ $project->is_buyable ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Buyable</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_rentable" value="1" {{ $project->is_rentable ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Rentable</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8 flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('admin.projects.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition text-center">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium hover:shadow-lg transition">
                            💾 Update Project
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Quill editor
        const quill = new Quill('#description-editor', {
            theme: 'snow',
            modules: {
                toolbar: [[{ 'header': [1, 2, 3, false] }], ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['link']]
            }
        });
        const descInput = document.getElementById('description-input');
        if (descInput.value) quill.root.innerHTML = descInput.value;
        document.querySelector('form').addEventListener('submit', () => {
            descInput.value = quill.root.innerHTML;
        });

        // Category/Subcategory dropdown
        document.getElementById('categorySelect').addEventListener('change', async (e) => {
            const categoryId = e.target.value;
            const subcategorySelect = document.getElementById('subcategorySelect');
            subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
            if (categoryId) {
                const response = await fetch(`/api/categories/${categoryId}/subcategories`);
                const subcategories = await response.json();
                subcategories.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    subcategorySelect.appendChild(option);
                });
            }
        });

        // Load subcategories on page load
        const categoryId = document.getElementById('categorySelect').value;
        if (categoryId) {
            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(r => r.json())
                .then(data => {
                    const select = document.getElementById('subcategorySelect');
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
                        option.selected = sub.id === '{{ $project->subcategory_id }}';
                        select.appendChild(option);
                    });
                });
        }
    </script>
    @endpush
</x-admin-layout>
