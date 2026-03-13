<div x-data="{ open: false }" @open-permissions-helper.window="open = true" x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div @click.away="open = false" class="bg-white dark:bg-black rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto border dark:border-gray-800">
        <div class="sticky top-0 bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Permissions To Be Created</h3>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Below are recommended permissions for a complete admin system. Permissions with checkmarks are already created:</p>
            
            @php
                $existingPermissions = \App\Models\Permission::where('guard_name', 'admin')->pluck('name')->toArray();
                $permissionGroups = [
                    'Dashboard Permissions' => ['view-dashboard'],
                    'User Permissions' => ['view-users', 'view-user-details', 'edit-users', 'delete-users', 'ban-users', 'unban-users'],
                    'Project Permissions' => ['view-projects', 'create-projects', 'edit-projects', 'delete-projects'],
                    'Rental Permissions' => ['view-rentals', 'view-rental-details', 'cancel-rentals'],
                    'Transaction Permissions' => ['view-transactions', 'view-transaction-details', 'refund-transactions'],
                    'Admin Permissions' => ['view-admins', 'create-admins', 'edit-admins', 'delete-admins'],
                    'Role Permissions' => ['view-roles', 'create-roles', 'edit-roles', 'delete-roles'],
                    'Permission Permissions' => ['view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions'],
                    'Settings Permissions' => ['view-settings', 'edit-settings'],
                    'Analytics Permissions' => ['view-analytics', 'delete-analytics'],
                    'Profile Permissions' => ['view-profile', 'edit-profile', 'delete-profile'],
                    'Trash Permissions' => ['view-trash', 'restore-trash', 'force-delete-trash'],
                    'Notification Permissions' => ['view-notifications', 'mark-notifications-read'],
                ];
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($permissionGroups as $groupName => $permissions)
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm uppercase tracking-wide">{{ $groupName }}</h4>
                    <ul class="space-y-2 text-sm">
                        @foreach($permissions as $perm)
                        <li class="flex items-center gap-2 {{ in_array($perm, $existingPermissions) ? 'line-through text-gray-400 dark:text-gray-600' : 'text-gray-700 dark:text-gray-300' }}">
                            @if(in_array($perm, $existingPermissions))
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <span class="text-blue-500 flex-shrink-0">•</span>
                            @endif
                            {{ $perm }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-200"><strong>Note:</strong> Use lowercase with hyphens for permission names (e.g., view-rentals, edit-admins)</p>
            </div>
        </div>
    </div>
</div>
