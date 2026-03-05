<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CrossPlatformAuthController extends Controller
{
    public function checkUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        return response()->json([
            'exists' => $user !== null,
        ]);
    }
    
    public function verifyPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['same_password' => false]);
        }
        
        return response()->json([
            'same_password' => $user->password === $request->password_hash,
        ]);
    }
    
    public function createAccountFromMarketplace(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password_hash,
        ]);
        
        $token = Str::random(64);
        Cache::put("auto_login:{$token}", $user->id, now()->addMinutes(5));
        
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
    
    public function generateLoginToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $token = Str::random(64);
        Cache::put("auto_login:{$token}", $user->id, now()->addMinutes(5));
        
        return response()->json(['token' => $token]);
    }
    
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false], 401);
        }
        
        $token = Str::random(64);
        Cache::put("auto_login:{$token}", $user->id, now()->addMinutes(5));
        
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
