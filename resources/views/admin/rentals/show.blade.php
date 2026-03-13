<x-admin-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.rentals.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Rental Details</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ $rental->id }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Rental Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">User</span>
                        <div class="text-right">
                            <div class="flex items-center gap-2 justify-end">
                                @if($rental->user->profile_photo)
                                    <img src="{{ asset('storage/' . $rental->user->profile_photo) }}" alt="{{ $rental->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($rental->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $rental->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $rental->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Project</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $rental->rentableProject->name ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Duration</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $rental->duration_value }} {{ ucfirst($rental->duration_type) }}{{ $rental->duration_value > 1 ? 's' : '' }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Credits Cost</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ number_format($rental->credits_cost) }} credits</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Status</span>
                        <div>
                            @if($rental->status === 'active')
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-xs font-medium">Active</span>
                            @elseif($rental->status === 'suspended')
                                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-xs font-medium">Suspended</span>
                            @elseif($rental->status === 'cancelled')
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-xs font-medium">Cancelled</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300 rounded-full text-xs font-medium">{{ ucfirst($rental->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Rental Starts</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $rental->rental_starts_at->format('M d, Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Rental Expires</span>
                        <div class="text-right">
                            <p class="text-gray-900 dark:text-white font-medium">{{ $rental->rental_expires_at->format('M d, Y H:i') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $rental->rental_expires_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($rental->admin_id)
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Tenant Credentials</h3>
                
                <div class="space-y-4">
                    <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Admin ID</p>
                        <p class="text-gray-900 dark:text-white font-mono text-sm break-all">{{ $rental->admin_id }}</p>
                    </div>

                    <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Admin Email</p>
                        <p class="text-gray-900 dark:text-white font-mono text-sm">{{ $rental->admin_email }}</p>
                    </div>

                    <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Admin Password</p>
                        <p class="text-gray-900 dark:text-white font-mono text-sm break-all">{{ $rental->admin_password }}</p>
                    </div>

                    <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Admin URL</p>
                        <p class="text-blue-600 dark:text-blue-400 font-mono text-sm break-all">{{ $rental->admin_url }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">App URL</p>
                        <p class="text-blue-600 dark:text-blue-400 font-mono text-sm break-all">{{ $rental->app_url }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div>
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    @can('cancel-rentals')
                        @if($rental->status === 'active')
                            <form method="POST" action="{{ route('admin.rentals.suspend', $rental) }}" onsubmit="return confirm('Suspend this rental?')">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-700 dark:hover:bg-yellow-800 text-white rounded-lg transition font-medium">
                                    <i class="fas fa-pause mr-2"></i> Suspend Rental
                                </button>
                            </form>
                        @elseif($rental->status === 'suspended')
                            <form method="POST" action="{{ route('admin.rentals.activate', $rental) }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white rounded-lg transition font-medium">
                                    <i class="fas fa-play mr-2"></i> Activate Rental
                                </button>
                            </form>
                        @endif

                        @if($rental->status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.rentals.cancel', $rental) }}" onsubmit="return confirm('Cancel this rental?')">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg transition font-medium">
                                    <i class="fas fa-times mr-2"></i> Cancel Rental
                                </button>
                            </form>
                        @endif
                    @endcan
                </div>
            </div>

            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Summary</h3>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Cost</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($rental->credits_cost) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">credits</p>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Time Remaining</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">
                            @if($rental->isExpired())
                                Expired
                            @else
                                {{ $rental->rental_expires_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
