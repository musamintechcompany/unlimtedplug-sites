<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Projects</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage rentable projects</p>
        </div>
        @can('create-projects')
        <a href="{{ route('admin.projects.create') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus"></i>New Project
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border border-gray-200 dark:border-gray-800 shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Banner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Project Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Pricing (24h)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-black divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                @if($project->banner_image)
                                    <img src="{{ asset('storage/' . $project->banner_image) }}" alt="{{ $project->name }}" class="w-16 h-16 rounded object-cover">
                                @else
                                    <div class="w-16 h-16 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-image text-gray-500 dark:text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $project->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm">{{ $project->category?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 whitespace-nowrap text-sm font-medium">${{ number_format($project->pricing_24h, 2) }}</td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800 text-sm">
                                <div class="flex gap-2">
                                    @if($project->is_rentable)
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">Rentable</span>
                                    @endif
                                    @if($project->is_buyable)
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400">Buyable</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $project->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @can('view-projects')
                                    <a href="{{ route('admin.projects.show', $project) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm">
                                        View
                                    </a>
                                    @endcan
                                    @can('edit-projects')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium text-sm">
                                        Edit
                                    </a>
                                    @endcan
                                    @can('delete-projects')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                            Delete
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                                <p>No projects found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
