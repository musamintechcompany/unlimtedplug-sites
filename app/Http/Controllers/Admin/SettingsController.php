<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $adminLoginPrefix = Setting::get('admin_login_prefix', 'admin');
        $logo = Setting::get('logo');
        $favicon = Setting::get('favicon');
        $logoDisplay = Setting::get('logo_display', 'name_only');
        
        return view('admin.settings.index', compact('adminLoginPrefix', 'logo', 'favicon', 'logoDisplay'));
    }

    public function update(Request $request)
    {
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            Setting::set('logo', $path);
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('favicons', 'public');
            Setting::set('favicon', $path);
        }

        if ($request->has('logo_display')) {
            Setting::set('logo_display', $request->logo_display);
        }

        if (!$request->has('enable_custom_prefix')) {
            $newPrefix = 'admin';
        } else {
            $request->validate([
                'admin_login_prefix' => 'required|string|max:50|alpha_dash',
            ]);
            $newPrefix = $request->admin_login_prefix;
        }
        
        Setting::set('admin_login_prefix', $newPrefix);

        return redirect('/' . $newPrefix . '/settings')->with('success', 'Settings updated successfully!');
    }
}
