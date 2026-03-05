<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">API Keys</h2>
                        <a href="{{ route('api-keys.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            Create Key
                        </a>
                    </div>

                    @if($apiKeys->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No API keys yet. <a href="{{ route('api-keys.create') }}" class="text-indigo-600 hover:underline">Create one now</a></p>
                    @else
                        <div class="space-y-4">
                            @foreach($apiKeys as $key)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex flex-col space-y-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Key</p>
                                            <p class="font-mono text-xs break-all">{{ substr($key->key, 0, 10) }}...{{ substr($key->key, -10) }}</p>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($key->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ ucfirst($key->status) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Created</p>
                                                <p class="text-sm">{{ $key->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                            <form action="{{ route('api-keys.toggle', $key) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                                                    {{ $key->status === 'active' ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('api-keys.destroy', $key) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this key?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
