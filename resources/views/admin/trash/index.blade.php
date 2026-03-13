<x-admin-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Trash</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Restore or permanently delete items</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-200">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="space-y-6">
        @can('view-users')
        <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-hidden" x-data="bulkActions('user')">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Deleted Users ({{ $trashedUsers->count() }})</h3>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-800" x-show="selectedCount > 0" x-cloak>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400"><span x-text="selectedCount"></span> selected</span>
                    <div class="flex gap-2">
                        @can('restore-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-restore') }}" class="inline">
                            @csrf
                            <input type="hidden" name="type" value="user">
                            <input type="hidden" name="ids" id="bulk-ids-user">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg text-sm font-medium transition">
                                Restore Selected
                            </button>
                        </form>
                        @endcan
                        @can('force-delete-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-force-delete') }}" onsubmit="return confirm('Permanently delete selected items?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="type" value="user">
                            <input type="hidden" name="ids" id="bulk-ids-user-delete">
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg text-sm font-medium transition">
                                Delete Forever
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10 w-12">
                                <input type="checkbox" id="select-all-user" @change="toggleAll($el.checked)" class="rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($trashedUsers as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <input type="checkbox" value="{{ $user->id }}" class="rounded user-checkbox" @change="updateCount(); syncHeaderCheckbox()">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium max-w-xs truncate">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 max-w-xs truncate">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $user->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    @can('restore-trash')
                                    <form method="POST" action="{{ route('admin.trash.restore-user', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Restore</button>
                                    </form>
                                    @endcan
                                    @can('force-delete-trash')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.trash.force-delete-user', $user) }}" class="inline" onsubmit="return confirm('Permanently delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete Forever</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                                <p>No deleted users</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endcan

        @can('view-admins')
        <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-hidden" x-data="bulkActions('admin')">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Deleted Admins ({{ $trashedAdmins->count() }})</h3>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-800" x-show="selectedCount > 0" x-cloak>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400"><span x-text="selectedCount"></span> selected</span>
                    <div class="flex gap-2">
                        @can('restore-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-restore') }}" class="inline">
                            @csrf
                            <input type="hidden" name="type" value="admin">
                            <input type="hidden" name="ids" id="bulk-ids-admin">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg text-sm font-medium transition">
                                Restore Selected
                            </button>
                        </form>
                        @endcan
                        @can('force-delete-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-force-delete') }}" onsubmit="return confirm('Permanently delete selected items?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="type" value="admin">
                            <input type="hidden" name="ids" id="bulk-ids-admin-delete">
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg text-sm font-medium transition">
                                Delete Forever
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10 w-12">
                                <input type="checkbox" id="select-all-admin" @change="toggleAll($el.checked)" class="rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($trashedAdmins as $admin)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <input type="checkbox" value="{{ $admin->id }}" class="rounded admin-checkbox" @change="updateCount(); syncHeaderCheckbox()">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium max-w-xs truncate">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 max-w-xs truncate">{{ $admin->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $admin->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    @can('restore-trash')
                                    <form method="POST" action="{{ route('admin.trash.restore-admin', $admin) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Restore</button>
                                    </form>
                                    @endcan
                                    @can('force-delete-trash')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.trash.force-delete-admin', $admin) }}" class="inline" onsubmit="return confirm('Permanently delete this admin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete Forever</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                                <p>No deleted admins</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endcan

        @can('view-projects')
        <div class="bg-white dark:bg-black rounded-lg border dark:border-gray-800 overflow-hidden" x-data="bulkActions('project')">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Deleted Projects ({{ $trashedProjects->count() }})</h3>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-800" x-show="selectedCount > 0" x-cloak>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400"><span x-text="selectedCount"></span> selected</span>
                    <div class="flex gap-2">
                        @can('restore-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-restore') }}" class="inline">
                            @csrf
                            <input type="hidden" name="type" value="project">
                            <input type="hidden" name="ids" id="bulk-ids-project">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg text-sm font-medium transition">
                                Restore Selected
                            </button>
                        </form>
                        @endcan
                        @can('force-delete-trash')
                        <form method="POST" action="{{ route('admin.trash.bulk-force-delete') }}" onsubmit="return confirm('Permanently delete selected items?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="type" value="project">
                            <input type="hidden" name="ids" id="bulk-ids-project-delete">
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg text-sm font-medium transition">
                                Delete Forever
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10 w-12">
                                <input type="checkbox" id="select-all-project" @change="toggleAll($el.checked)" class="rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase border-r border-white/10">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($trashedProjects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                            <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-800">
                                <input type="checkbox" value="{{ $project->id }}" class="rounded project-checkbox" @change="updateCount(); syncHeaderCheckbox()">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-800 font-medium max-w-xs truncate">{{ $project->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 capitalize">{{ $project->type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 border-r border-gray-200 dark:border-gray-800 whitespace-nowrap">{{ $project->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    @can('restore-trash')
                                    <form method="POST" action="{{ route('admin.trash.restore-project', $project) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Restore</button>
                                    </form>
                                    @endcan
                                    @can('force-delete-trash')
                                    <span class="text-gray-300 dark:text-gray-700">|</span>
                                    <form method="POST" action="{{ route('admin.trash.force-delete-project', $project) }}" class="inline" onsubmit="return confirm('Permanently delete this project?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete Forever</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 opacity-50 block"></i>
                                <p>No deleted projects</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    </div>

    <script>
        function bulkActions(type) {
            return {
                selectedCount: 0,
                toggleAll(checked) {
                    document.querySelectorAll(`.${type}-checkbox`).forEach(cb => cb.checked = checked);
                    this.updateCount();
                },
                updateCount() {
                    const checked = document.querySelectorAll(`.${type}-checkbox:checked`);
                    this.selectedCount = checked.length;
                    const ids = Array.from(checked).map(cb => cb.value);
                    document.getElementById(`bulk-ids-${type}`).value = ids.join(',');
                    document.getElementById(`bulk-ids-${type}-delete`).value = ids.join(',');
                },
                syncHeaderCheckbox() {
                    const total = document.querySelectorAll(`.${type}-checkbox`).length;
                    const checked = document.querySelectorAll(`.${type}-checkbox:checked`).length;
                    const headerCheckbox = document.getElementById(`select-all-${type}`);
                    headerCheckbox.checked = total > 0 && checked === total;
                    headerCheckbox.indeterminate = checked > 0 && checked < total;
                }
            }
        }
    </script>
</x-admin-layout>
