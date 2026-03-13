<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Transactions</h2>
            <p class="text-gray-600 dark:text-gray-400">View all credit transactions</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Credits</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Currency</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">
                        @if($transaction->transactable_type === 'App\Models\User' && $transaction->transactable)
                            <div class="flex items-center gap-2">
                                @if($transaction->transactable->profile_photo)
                                    <img src="{{ asset('storage/' . $transaction->transactable->profile_photo) }}" alt="{{ $transaction->transactable->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($transaction->transactable->name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ $transaction->transactable->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-500">Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 capitalize">{{ $transaction->type }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">{{ number_format($transaction->credits) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium">{{ number_format($transaction->price, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 uppercase font-medium">{{ $transaction->currency }}</td>
                    <td class="px-6 py-4 text-sm border-r border-gray-200 dark:border-gray-800">
                        @if($transaction->status === 'completed')
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-xs font-medium">Completed</span>
                        @elseif($transaction->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-xs font-medium">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded-full text-xs font-medium">{{ ucfirst($transaction->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                        <p>No transactions found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</x-admin-layout>
