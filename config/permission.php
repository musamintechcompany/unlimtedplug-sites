<?php

return [

    'models' => [
        'permission' => App\Models\Permission::class,
        'role' => App\Models\Role::class,
    ],

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        'model_morph_key' => 'model_id',
        'role_pivot_key' => 'role_id',
        'permission_pivot_key' => 'permission_id',
        'team_foreign_key' => 'team_id',
    ],

    'teams' => false,

    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],

    'display_permission_in_exception' => false,

    'display_role_in_exception' => false,

    'enable_wildcard_permission' => false,

    'permissions' => [
        'view-dashboard' => 'View Dashboard',
        'view-admins' => 'View Admins',
        'create-admins' => 'Create Admins',
        'edit-admins' => 'Edit Admins',
        'delete-admins' => 'Delete Admins',
        'view-roles' => 'View Roles',
        'create-roles' => 'Create Roles',
        'edit-roles' => 'Edit Roles',
        'delete-roles' => 'Delete Roles',
        'view-permissions' => 'View Permissions',
        'create-permissions' => 'Create Permissions',
        'edit-permissions' => 'Edit Permissions',
        'delete-permissions' => 'Delete Permissions',
        'view-projects' => 'View Projects',
        'create-projects' => 'Create Projects',
        'edit-projects' => 'Edit Projects',
        'delete-projects' => 'Delete Projects',
        'view-users' => 'View Users',
        'view-rentals' => 'View Rentals',
        'view-transactions' => 'View Transactions',
        'view-settings' => 'View Settings',
        'edit-settings' => 'Edit Settings',
    ],

];
