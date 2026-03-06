<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    public function show(): View
    {
        return view('auth.verify-email');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email_verification_code', $request->code)
            ->where('verification_code_expires_at', '>', now())
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('success', 'Email verified successfully!');
    }

    public function resend(Request $request): RedirectResponse
    {
        $email = session('email');
        
        if (!$email) {
            return redirect(route('register'));
        }

        $user = User::where('email', $email)->whereNull('email_verified_at')->first();

        if (!$user) {
            return redirect(route('dashboard'));
        }

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'email_verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerificationCodeMail($user, $verificationCode));

        return back()->with('success', 'Verification code resent to your email.');
    }
}
