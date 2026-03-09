<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6">Create API Key</h2>

                    @if(session('api_key'))
                        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 rounded-lg">
                            <p class="text-green-800 dark:text-green-200 font-semibold mb-2">API Key Created Successfully</p>
                            <p class="text-sm text-green-700 dark:text-green-300 mb-3">Save this key somewhere safe. You won't be able to see it again.</p>
                            <div class="flex items-center gap-2">
                                <code id="api-key-display" class="flex-1 bg-green-50 dark:bg-green-950 p-3 rounded font-mono text-sm break-all" data-full-key="{{ session('api_key') }}">{{ session('api_key') }}</code>
                                <button onclick="copyApiKey()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded whitespace-nowrap">
                                    Copy
                                </button>
                            </div>
                            <a href="{{ route('api-keys.index') }}" class="inline-block mt-4 text-green-600 hover:underline">Back to API Keys</a>
                        </div>
                    @else
                        <form action="{{ route('api-keys.store') }}" method="POST">
                            @csrf

                            <div class="mb-6 p-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-700 rounded-lg">
                                <p class="text-blue-800 dark:text-blue-200 text-sm">
                                    <strong>API Key Usage:</strong> Use this key to programmatically create rentals via the <code class="bg-blue-50 dark:bg-blue-950 px-2 py-1 rounded">POST /api/rental/create</code> endpoint.
                                </p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">API Key Name</label>
                                <input type="text" name="name" placeholder="e.g., Production API, Mobile App" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500" required>
                            </div>

                            <div class="flex gap-4">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                                    Generate Key
                                </button>
                                <a href="{{ route('api-keys.index') }}" class="bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-6 py-2 rounded-lg">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    function copyApiKey() {
        const element = document.getElementById('api-key-display');
        const fullKey = element.getAttribute('data-full-key');
        navigator.clipboard.writeText(fullKey).then(() => {
            const originalText = element.textContent;
            element.textContent = 'Copied!';
            element.classList.add('text-green-600');
            setTimeout(() => {
                element.textContent = originalText;
                element.classList.remove('text-green-600');
            }, 1500);
        });
    }
    </script>
</x-app-layout>
