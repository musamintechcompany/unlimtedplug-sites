<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')
            ->latest()
            ->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'created_by' => ['type' => 'admin', 'id' => auth('admin')->id(), 'timestamp' => now()->toDateTimeString()]
        ]);

        $admin->syncRoles($validated['roles']);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully');
    }

    public function show(Admin $admin)
    {
        $admin->load('roles');
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $admin->load('roles');
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(isset($validated['password']) ? ['password' => Hash::make($validated['password'])] : [])
        ]);

        $admin->syncRoles($validated['roles']);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth('admin')->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account']);
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully');
    }
}
