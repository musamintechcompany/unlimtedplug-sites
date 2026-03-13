<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view-dashboard',

            // User management permissions
            'view-users',
            'view-user-details',
            'edit-users',
            'delete-users',
            'ban-users',
            'unban-users',

            // Project management permissions
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',

            // Rental management permissions
            'view-rentals',
            'view-rental-details',
            'cancel-rentals',

            // Transaction management permissions
            'view-transactions',
            'view-transaction-details',
            'refund-transactions',

            // Admin management permissions
            'view-admins',
            'create-admins',
            'edit-admins',
            'delete-admins',

            // Role management permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Permission management permissions
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',

            // Settings permissions
            'view-settings',
            'edit-settings',

            // Analytics permissions
            'view-analytics',
            'delete-analytics',

            // Profile permissions
            'view-profile',
            'edit-profile',
            'delete-profile',

            // Trash permissions
            'view-trash',
            'restore-trash',
            'force-delete-trash',

            // Notification permissions
            'view-notifications',
            'mark-notifications-read',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'admin'
                ],
                [
                    'id' => Str::uuid()
                ]
            );
        }
    }
}
