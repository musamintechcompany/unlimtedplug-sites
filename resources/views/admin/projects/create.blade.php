<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Projects
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 md:px-8 py-8 md:py-10">
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        {{ isset($project) ? '✏️ Edit Project' : '➕ Create New Project' }}
                    </h1>
                    <p class="text-indigo-100 mt-2 text-sm md:text-base">
                        {{ isset($project) ? 'Update project details and pricing' : 'Add a new rentable project to your platform' }}
                    </p>
                </div>

                <!-- Form Section -->
                <form method="POST" action="{{ isset($project) ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" enctype="multipart/form-data" class="p-6 md:p-8">
                    @csrf
                    @if(isset($project))
                        @method('PATCH')
                    @endif

                    <div class="space-y-8">
                        <!-- Basic Information Section -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Basic Information
                            </h2>
                            <div class="space-y-5">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Project Name *</label>
                                    <input type="text" name="name" value="{{ $project->name ?? '' }}" required placeholder="e.g., ShipFast, E-Commerce Pro" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('name') border-red-500 @enderror">
                                    @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                    <div id="description" style="height: 300px;"></div>
                                    <input type="hidden" name="description" id="description-input" value="{{ isset($project) ? $project->description : '' }}" required>
                                    @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Category & Subcategory -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                                        <select name="category_id" id="categorySelect" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('category_id') border-red-500 @enderror">
                                            <option value="">Select a category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ (isset($project) && $project->category_id === $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subcategory *</label>
                                        <select name="subcategory_id" id="subcategorySelect" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('subcategory_id') border-red-500 @enderror">
                                            <option value="">Select a subcategory</option>
                                            @if(isset($project) && $project->subcategory)
                                                <option value="{{ $project->subcategory->id }}" selected>{{ $project->subcategory->name }}</option>
                                            @endif
                                        </select>
                                        @error('subcategory_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- API URL -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">API URL *</label>
                                    <input type="text" name="api_url" value="{{ $project->api_url ?? '' }}" placeholder="https://api.example.com" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('api_url') border-red-500 @enderror">
                                    @error('api_url') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="border-t pt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Pricing (Credits)
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">24 Hours *</label>
                                    <input type="number" name="pricing_24h" value="{{ $project->pricing_24h ?? '' }}" step="1" required placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('pricing_24h') border-red-500 @enderror">
                                    @error('pricing_24h') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">7 Days *</label>
                                    <input type="number" name="pricing_7d" value="{{ $project->pricing_7d ?? '' }}" step="1" required placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('pricing_7d') border-red-500 @enderror">
                                    @error('pricing_7d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">30 Days *</label>
                                    <input type="number" name="pricing_30d" value="{{ $project->pricing_30d ?? '' }}" step="1" required placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('pricing_30d') border-red-500 @enderror">
                                    @error('pricing_30d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">365 Days *</label>
                                    <input type="number" name="pricing_365d" value="{{ $project->pricing_365d ?? '' }}" step="1" required placeholder="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('pricing_365d') border-red-500 @enderror">
                                    @error('pricing_365d') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Images Section -->
                        <div class="border-t pt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">3</span>
                                Project Images
                            </h2>
                            
                            <!-- Banner Image -->
                            <div class="mb-8">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Banner Image</label>
                                <div id="bannerPreviewContainer" class="mb-3 relative group" style="{{ (isset($project) && $project->banner_image) ? '' : 'display:none;' }}">
                                    <img id="bannerPreviewImg" src="{{ isset($project) && $project->banner_image ? asset($project->banner_image) : '' }}" class="w-full h-32 object-cover rounded-lg">
                                    <button type="button" onclick="document.getElementById('bannerDeleteInput').value='1'; document.getElementById('bannerPreviewContainer').style.display='none';" class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <input type="hidden" id="bannerDeleteInput" name="delete_banner" value="0">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition" id="bannerDropZone">
                                    <input type="file" name="banner_image" accept="image/*" class="hidden" id="bannerInput">
                                    <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 12M9 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    <p class="text-gray-700 font-medium">{{ isset($project) && $project->banner_image ? 'Change banner image' : 'Upload banner image' }}</p>
                                    <p class="text-gray-500 text-sm mt-1">PNG, JPG up to 5MB</p>
                                </div>
                            </div>
                            
                            <!-- Media Images -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Media Images</label>
                                @if(isset($project) && $project->media_images)
                                    <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="existingMediaPreview">
                                        @foreach($project->media_images as $index => $image)
                                            <div class="relative group" draggable="true" data-index="{{ $index }}">
                                                <img src="{{ asset($image) }}" class="w-full h-24 object-cover rounded-lg cursor-move">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-white text-xs font-medium">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition" id="mediaDropZone">
                                    <input type="file" name="media_images[]" multiple accept="image/*" class="hidden" id="mediaInput">
                                    <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 12M9 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    <p class="text-gray-700 font-medium">Add media images</p>
                                    <p class="text-gray-500 text-sm mt-1">Drag to reorder, PNG, JPG up to 5MB each</p>
                                </div>
                                <div id="mediaPreview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
                            </div>
                        </div>

                        <!-- Sort Order Section -->
                        <div class="border-t pt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">4</span>
                                Display Order
                            </h2>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order *</label>
                                <input type="number" name="sort_order" value="{{ $project->sort_order ?? 0 }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('sort_order') border-red-500 @enderror">
                                <p class="text-gray-500 text-sm mt-2">Lower numbers appear first (0, 1, 2, etc.)</p>
                                @error('sort_order') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Availability Section -->
                        <div class="border-t pt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">5</span>
                                Availability
                            </h2>
                            <div class="space-y-4">
                                <!-- Buyable Toggle -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <div>
                                        <p class="font-medium text-gray-900">Enable Purchase</p>
                                        <p class="text-sm text-gray-500">Allow users to buy this project</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_buyable" value="1" {{ (isset($project) && $project->is_buyable) ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>

                                <!-- Rentable Toggle -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <div>
                                        <p class="font-medium text-gray-900">Enable Rental</p>
                                        <p class="text-sm text-gray-500">Allow users to rent this project</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_rentable" value="1" {{ (isset($project) && $project->is_rentable) ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="border-t pt-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold">6</span>
                                Status
                            </h2>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="active" {{ ($project->status ?? 'active') === 'active' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600">
                                    <span class="ml-2 text-gray-700 font-medium">Active</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="inactive" {{ ($project->status ?? '') === 'inactive' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600">
                                    <span class="ml-2 text-gray-700 font-medium">Inactive</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="border-t pt-8 flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('admin.projects.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-center">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg font-medium hover:shadow-lg transition">
                                {{ isset($project) ? '💾 Update Project' : '✨ Create Project' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Banner image upload
        const bannerDropZone = document.getElementById('bannerDropZone');
        const bannerInput = document.getElementById('bannerInput');
        bannerDropZone.addEventListener('click', () => bannerInput.click());
        bannerDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            bannerDropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });
        bannerDropZone.addEventListener('dragleave', () => {
            bannerDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
        bannerDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            bannerDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            bannerInput.files = e.dataTransfer.files;
            previewBannerImage();
        });
        bannerInput.addEventListener('change', previewBannerImage);
        
        function previewBannerImage() {
            if (bannerInput.files.length > 0) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('bannerPreviewImg').src = e.target.result;
                    document.getElementById('bannerPreviewContainer').style.display = '';
                    document.getElementById('bannerDeleteInput').value = '0';
                };
                reader.readAsDataURL(bannerInput.files[0]);
            }
        }

        // Media images upload and drag-reorder
        const mediaDropZone = document.getElementById('mediaDropZone');
        const mediaInput = document.getElementById('mediaInput');
        const mediaPreview = document.getElementById('mediaPreview');
        let draggedElement = null;

        mediaDropZone.addEventListener('click', () => mediaInput.click());
        mediaDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            mediaDropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });
        mediaDropZone.addEventListener('dragleave', () => {
            mediaDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
        mediaDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            mediaDropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            mediaInput.files = e.dataTransfer.files;
            previewMediaImages();
        });

        mediaInput.addEventListener('change', previewMediaImages);

        function previewMediaImages() {
            mediaPreview.innerHTML = '';
            Array.from(mediaInput.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.draggable = true;
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg cursor-move">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-white text-xs font-medium">Remove</button>
                        </div>
                    `;
                    div.addEventListener('dragstart', () => draggedElement = div);
                    div.addEventListener('dragover', (e) => e.preventDefault());
                    div.addEventListener('drop', (e) => {
                        e.preventDefault();
                        if (draggedElement !== div) {
                            mediaPreview.insertBefore(draggedElement, div);
                        }
                    });
                    mediaPreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

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

        // Quill editor
        const quill = new Quill('#description', {
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
    </script>
</x-guest-layout>
