<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Projects</h1>
                    <p class="text-gray-600 mt-2">Manage your rentable projects</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:shadow-lg transition font-medium text-center">
                        ➕ Add Project
                    </a>
                    <a href="{{ route('admin.projects.logout') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                        🚪 Logout
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <div>
                        <p class="font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Projects Table -->
            @if($projects->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Image</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Name</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Category</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Pricing</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Sort</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Buy/Rent</th>
                                    <th class="px-4 py-4 text-left text-sm font-semibold border-r border-indigo-500">Status</th>
                                    <th class="px-4 py-4 text-right text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($projects as $project)
                                    @php
                                        $isBuyable = $project->is_buyable ?? false;
                                        $isRentable = $project->is_rentable ?? false;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Image -->
                                        <td class="px-4 py-4 border-r border-gray-200 w-20">
                                            @if($project->banner_image)
                                                <img src="{{ asset($project->banner_image) }}" alt="{{ $project->name }}" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Name -->
                                        <td class="px-4 py-4 border-r border-gray-200 max-w-xs">
                                            <div class="truncate">
                                                <p class="font-semibold text-gray-900 truncate max-w-xs" title="{{ $project->name }}">{{ Str::limit($project->name, 20, '...') }}</p>
                                                <p class="text-xs text-gray-500 truncate max-w-xs" title="{{ $project->slug }}">{{ Str::limit($project->slug, 20, '...') }}</p>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td class="px-4 py-4 border-r border-gray-200 max-w-xs">
                                            <span class="inline-block bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium truncate" title="{{ $project->category?->name ?? 'Uncategorized' }}">
                                                {{ $project->category?->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>

                                        <!-- Pricing -->
                                        <td class="px-4 py-4 border-r border-gray-200 max-w-xs">
                                            <div class="text-xs space-y-0.5">
                                                <p class="truncate"><span class="font-semibold">24h:</span> {{ $project->pricing_24h }}</p>
                                                <p class="truncate"><span class="font-semibold">7d:</span> {{ $project->pricing_7d }}</p>
                                                <p class="truncate"><span class="font-semibold">30d:</span> {{ $project->pricing_30d }}</p>
                                                <p class="truncate"><span class="font-semibold">365d:</span> {{ $project->pricing_365d }}</p>
                                            </div>
                                        </td>

                                        <!-- Sort Order -->
                                        <td class="px-4 py-4 border-r border-gray-200 text-center">
                                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm font-semibold">
                                                {{ $project->sort_order }}
                                            </span>
                                        </td>

                                        <!-- Buy/Rent Flags -->
                                        <td class="px-4 py-4 border-r border-gray-200 max-w-xs">
                                            <div class="flex gap-1 flex-wrap">
                                                @if($isBuyable)
                                                    <span class="inline-block bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-medium">Buy ✓</span>
                                                @else
                                                    <span class="inline-block bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-xs font-medium">Buy ✗</span>
                                                @endif
                                                @if($isRentable)
                                                    <span class="inline-block bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-medium">Rent ✓</span>
                                                @else
                                                    <span class="inline-block bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-xs font-medium">Rent ✗</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-4 py-4 border-r border-gray-200">
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-4 py-4">
                                            <div class="flex gap-2 justify-end flex-wrap">
                                                <a href="{{ route('admin.projects.show', $project->id) }}" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition font-medium text-xs whitespace-nowrap hidden md:inline-block" title="View">
                                                    👁️ View
                                                </a>
                                                <a href="{{ route('admin.projects.show', $project->id) }}" class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition font-medium text-xs md:hidden" title="View">
                                                    👁️
                                                </a>
                                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition font-medium text-xs whitespace-nowrap hidden md:inline-block" title="Edit">
                                                    ✏️ Edit
                                                </a>
                                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-2 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition font-medium text-xs md:hidden" title="Edit">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" class="inline" onsubmit="return confirm('Delete this project?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-50 text-red-600 rounded hover:bg-red-100 transition font-medium text-xs whitespace-nowrap hidden md:inline-block" title="Delete">
                                                        🗑️ Delete
                                                    </button>
                                                    <button type="submit" class="px-2 py-1 bg-red-50 text-red-600 rounded hover:bg-red-100 transition font-medium text-xs md:hidden" title="Delete">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Projects Yet</h3>
                    <p class="text-gray-600 mb-6">Create your first rentable project to get started</p>
                    <a href="{{ route('admin.projects.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:shadow-lg transition font-medium">
                        ➕ Create First Project
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
