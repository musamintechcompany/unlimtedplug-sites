<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::where('guard_name', 'admin')
            ->latest()
            ->paginate(20);
        
        $grouped = Permission::where('guard_name', 'admin')
            ->get()
            ->groupBy(function ($permission) {
                return explode('-', $permission->name)[0];
            });

        return view('admin.permissions.index', compact('permissions', 'grouped'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,NULL,id,guard_name,admin',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'admin'
        ]);

        // Auto-assign to superadmin role if it exists
        $superadminRole = \App\Models\Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        if ($superadminRole) {
            $superadminRole->givePermissionTo($permission);
        }

        // Check if "Create & Add New" button was clicked
        if ($request->input('action') === 'create_new') {
            return redirect()->route('admin.permissions.create')
                ->with('success', 'Permission "' . $permission->name . '" created successfully. Add another one.');
        }

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully');
    }

    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:permissions,id',
        ]);

        Permission::whereIn('id', $validated['ids'])->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permissions deleted successfully');
    }
}
