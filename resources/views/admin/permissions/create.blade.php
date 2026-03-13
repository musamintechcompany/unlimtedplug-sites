<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Permission</h2>
            <p class="text-gray-600 dark:text-gray-400">Add a new system permission</p>
        </div>
        <button @click="$dispatch('open-permissions-helper')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition flex items-center gap-2">
            <i class="fas fa-lightbulb mr-2"></i> Permissions To Be Created
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200">
            <ul class="list-disc pl-6 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 p-6">
        <form method="POST" action="{{ route('admin.permissions.store') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Permission Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., view-reports" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <small class="text-gray-500 dark:text-gray-400 block mt-2">Use lowercase with hyphens (e.g., view-reports, edit-users)</small>
            </div>

            <div class="flex flex-col-reverse md:flex-row gap-3">
                <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-center font-medium">
                    Cancel
                </a>
                <button type="submit" name="action" value="create_new" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition font-medium">
                    <i class="fas fa-plus mr-2"></i> Create & Add New
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition font-medium">
                    <i class="fas fa-check mr-2"></i> Create Permission
                </button>
            </div>
        </form>
    </div>

    @include('modals.permissions-helper')
</x-admin-layout>
