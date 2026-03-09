<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PasswordResetCodeController extends Controller
{
    public function requestCode(): View
    {
        return view('auth.forgot-password');
    }

    public function sendCode(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No account found with this email.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'password_reset_code' => $code,
            'password_reset_code_expires_at' => now()->addMinutes(15)
        ]);

        Mail::to($user->email)->send(new PasswordResetCodeMail($code));

        return redirect()->route('password.verify-code')
            ->with('email', $user->email)
            ->with('status', 'Password reset code sent to your email.');
    }

    public function verifyCode(): View
    {
        return view('auth.verify-reset-code');
    }

    public function checkCode(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->password_reset_code) {
            return back()->withInput($request->only('email'))
                ->withErrors(['code' => 'No reset code found.']);
        }

        if ($user->password_reset_code !== $request->code) {
            return back()->withInput($request->only('email'))
                ->withErrors(['code' => 'Invalid reset code.']);
        }

        if ($user->password_reset_code_expires_at < now()) {
            return back()->withInput($request->only('email'))
                ->withErrors(['code' => 'Reset code has expired.']);
        }

        return redirect()->route('password.reset')
            ->with('email', $user->email)
            ->with('code', $request->code);
    }

    public function resetForm(): View
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->password_reset_code !== $request->code) {
            return back()->withErrors(['code' => 'Invalid reset code.']);
        }

        if ($user->password_reset_code_expires_at < now()) {
            return back()->withErrors(['code' => 'Reset code has expired.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_code' => null,
            'password_reset_code_expires_at' => null
        ]);

        return redirect()->route('login')->with('status', 'Password reset successfully. Please log in.');
    }
}
