<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class AutoLoginController extends Controller
{
    public function autoLogin(Request $request)
    {
        $token = $request->query('token');
        
        if (!$token) {
            return redirect('/login')->with('error', 'Invalid login token');
        }
        
        $userId = Cache::get("auto_login:{$token}");
        
        if (!$userId) {
            return redirect('/login')->with('error', 'Login token expired or invalid');
        }
        
        Cache::forget("auto_login:{$token}");
        
        $user = User::find($userId);
        Auth::login($user);
        
        return redirect('/dashboard')->with('success', 'Welcome to Sites!');
    }
}
