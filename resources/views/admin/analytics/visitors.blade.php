<x-admin-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-[#EDEDEC] mb-2">Visitors</h1>
            <p class="text-gray-600 dark:text-[#A1A09A]">Detailed visitor tracking and analytics</p>
        </div>
        <a href="{{ route('admin.analytics.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-arrow-left mr-2"></i>Back to Analytics
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-[#161615] rounded-lg border border-gray-200 dark:border-[#3E3E3A] shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Visitor ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">Page Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase border-r border-white/10">First Visit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Last Visit</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-black divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($visitors as $visitor)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="text-xs font-mono text-gray-600 dark:text-gray-400">{{ substr($visitor->visitor_id, 0, 8) }}...</span>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                @if($visitor->user)
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $visitor->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $visitor->user->email }}</p>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Guest</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <div class="text-sm">
                                    @if($visitor->country)
                                        <p class="text-gray-900 dark:text-white">{{ $visitor->country }}</p>
                                        @if($visitor->city)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $visitor->city }}</p>
                                        @endif
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Unknown</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="px-2 py-1 text-xs font-semibold rounded 
                                    @if($visitor->device_type === 'mobile') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                    @elseif($visitor->device_type === 'tablet') bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                    @endif">
                                    {{ ucfirst($visitor->device_type ?? 'desktop') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visitor->pageViews->count() }}</span>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $visitor->first_visit?->format('M d, Y H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $visitor->last_visit?->format('M d, Y H:i') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                                <p>No visitors found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($visitors->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                {{ $visitors->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
