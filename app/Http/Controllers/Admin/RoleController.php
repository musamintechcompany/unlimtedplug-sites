<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')
            ->withCount('permissions')
            ->latest()
            ->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,NULL,id,guard_name,admin',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'admin'
        ]);

        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::where('guard_name', 'admin')->get()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'superadmin') {
            return back()->withErrors(['error' => 'Cannot edit superadmin role']);
        }

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id . ',id,guard_name,admin',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'superadmin') {
            return back()->withErrors(['error' => 'Cannot delete superadmin role']);
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }
}
