<x-admin-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.transactions.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transaction Details</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ $transaction->id }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Transaction Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">User</span>
                        <div class="text-right">
                            @if($transaction->transactable_type === 'App\Models\User' && $transaction->transactable)
                                <div class="flex items-center gap-2 justify-end">
                                    @if($transaction->transactable->profile_photo)
                                        <img src="{{ asset('storage/' . $transaction->transactable->profile_photo) }}" alt="{{ $transaction->transactable->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($transaction->transactable->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ $transaction->transactable->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transactable->email }}</p>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-500">Unknown</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Type</span>
                        <span class="text-gray-900 dark:text-white font-medium capitalize">{{ $transaction->type }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Credits</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ number_format($transaction->credits) }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Amount</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ number_format($transaction->price, 2) }} {{ $transaction->currency }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Status</span>
                        <div>
                            @if($transaction->status === 'completed')
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-xs font-medium">Completed</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-xs font-medium">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-xs font-medium">{{ ucfirst($transaction->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">Description</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $transaction->description ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Date</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $transaction->created_at->format('M d, Y H:i:s') }}</span>
                    </div>
                </div>
            </div>

            @if($transaction->data)
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Additional Data</h3>
                <pre class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-sm text-gray-700 dark:text-gray-300 overflow-x-auto">{{ json_encode($transaction->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
            @endif
        </div>

        <div>
            <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Summary</h3>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Credits</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($transaction->credits) }}</p>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Amount Paid</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($transaction->price, 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $transaction->currency }}</p>
                    </div>

                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Rate</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">
                            {{ number_format($transaction->credits / $transaction->price, 2) }} credits per {{ $transaction->currency }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
