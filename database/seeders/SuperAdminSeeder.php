<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create superadmin role and sync ALL permissions
        $superadmin = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin'
        ]);
        
        $allPermissions = Permission::where('guard_name', 'admin')->get();
        $superadmin->syncPermissions($allPermissions);
        
        echo "Superadmin role synced with {$allPermissions->count()} permissions\n";
    }
}
