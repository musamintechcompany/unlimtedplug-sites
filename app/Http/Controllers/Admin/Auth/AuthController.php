<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Admin::count() === 0) {
            return redirect()->route('admin.onboarding');
        }
        return view('admin.auth.login');
    }

    public function showOnboarding()
    {
        if (Admin::count() > 0) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.onboarding');
    }

    public function onboarding(Request $request)
    {
        if (Admin::count() > 0) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => ['type' => 'self', 'timestamp' => now()->toDateTimeString()]
        ]);

        // Create superadmin role if it doesn't exist
        $role = \App\Models\Role::firstOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'admin']
        );
        
        // Give superadmin all permissions
        $permissions = \App\Models\Permission::where('guard_name', 'admin')->get();
        $role->syncPermissions($permissions);
        
        // Assign superadmin role to first admin
        $admin->assignRole($role);

        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();
            
            if ($admin->roles->isEmpty()) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'You do not have any right or role to be in this department.'])->onlyInput('email');
            }
            
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function updateTheme(Request $request)
    {
        $request->validate(['theme' => 'required|in:light,dark']);
        
        $admin = Auth::guard('admin')->user();
        $admin->update(['theme' => $request->theme]);
        
        return response()->json(['success' => true, 'theme' => $request->theme]);
    }
}
