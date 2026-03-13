<x-admin-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            {{ isset($project) ? 'Edit Project' : 'Create Project' }}
        </h1>

        <form method="POST" action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($project))
                @method('PATCH')
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Project Name</label>
                    <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Description</label>
                    <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $project->description ?? '') }}</textarea>
                    @error('description') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category & Subcategory -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Category</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="loadSubcategories(this.value)">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $project->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Subcategory</label>
                        <select name="subcategory_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="subcategory_select">
                            <option value="">Select Subcategory</option>
                        </select>
                        @error('subcategory_id') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- API URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">API URL</label>
                    <input type="url" name="api_url" value="{{ old('api_url', $project->api_url ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('api_url') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">24h Price</label>
                        <input type="number" name="pricing_24h" step="0.01" value="{{ old('pricing_24h', $project->pricing_24h ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pricing_24h') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">7d Price</label>
                        <input type="number" name="pricing_7d" step="0.01" value="{{ old('pricing_7d', $project->pricing_7d ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pricing_7d') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">30d Price</label>
                        <input type="number" name="pricing_30d" step="0.01" value="{{ old('pricing_30d', $project->pricing_30d ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pricing_30d') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">365d Price</label>
                        <input type="number" name="pricing_365d" step="0.01" value="{{ old('pricing_365d', $project->pricing_365d ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('pricing_365d') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Sort Order & Status -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('sort_order') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Status</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active" {{ old('status', $project->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $project->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Flags -->
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_buyable" value="1" {{ old('is_buyable', $project->is_buyable ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                        <span class="text-sm text-gray-900 dark:text-white">Buyable</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_rentable" value="1" {{ old('is_rentable', $project->is_rentable ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                        <span class="text-sm text-gray-900 dark:text-white">Rentable</span>
                    </label>
                </div>

                <!-- Banner Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Banner Image</label>
                    @if(isset($project) && $project->banner_image)
                    <div class="mb-4">
                        <img src="{{ asset($project->banner_image) }}" alt="Banner" class="h-32 object-cover rounded-lg">
                        <label class="flex items-center gap-2 mt-2 cursor-pointer">
                            <input type="checkbox" name="delete_banner" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600">
                            <span class="text-sm text-gray-900 dark:text-white">Delete banner</span>
                        </label>
                    </div>
                    @endif
                    <input type="file" name="banner_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('banner_image') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Media Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Media Images</label>
                    @if(isset($project) && $project->media_images)
                    <div class="grid grid-cols-4 gap-4 mb-4">
                        @foreach($project->media_images as $image)
                        <img src="{{ asset($image) }}" alt="Media" class="h-24 object-cover rounded-lg">
                        @endforeach
                    </div>
                    @endif
                    <input type="file" name="media_images[]" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('media_images') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                    {{ isset($project) ? 'Update Project' : 'Create Project' }}
                </button>
                <a href="{{ route('admin.projects.index') }}" class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-6 py-2 rounded-lg font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function loadSubcategories(categoryId) {
            if (!categoryId) return;
            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(r => r.json())
                .then(data => {
                    const select = document.getElementById('subcategory_select');
                    select.innerHTML = '<option value="">Select Subcategory</option>';
                    data.forEach(sub => {
                        select.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                    });
                });
        }
        
        // Load subcategories on page load if category is selected
        document.addEventListener('DOMContentLoaded', () => {
            const categorySelect = document.querySelector('select[name="category_id"]');
            if (categorySelect.value) loadSubcategories(categorySelect.value);
        });
    </script>
    @endpush
</x-admin-layout>
