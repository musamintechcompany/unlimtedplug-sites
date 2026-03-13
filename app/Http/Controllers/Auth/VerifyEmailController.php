<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\VerificationCodeMail;

class VerifyEmailController extends Controller
{
    public function show(): View
    {
        $email = auth()->user()?->email ?? session('verify_email');
        return view('auth.verify-email', compact('email'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        // Get the authenticated user or find by code
        $user = auth()->user();
        
        if (!$user) {
            // If not authenticated, find user by code
            $user = User::where('email_verification_code', $request->code)
                ->where('verification_code_expires_at', '>', now())
                ->whereNull('email_verified_at')
                ->first();
        } else {
            // If authenticated, verify the code matches
            if ($user->email_verification_code !== $request->code) {
                return back()->withErrors(['code' => 'Invalid verification code.']);
            }
            
            if (!$user->verification_code_expires_at || $user->verification_code_expires_at->isPast()) {
                return back()->withErrors(['code' => 'Verification code has expired.']);
            }
        }

        if (!$user) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        if (!auth()->check()) {
            Auth::login($user);
        }

        // Clear the verification email from session
        session()->forget('verify_email');

        return redirect(route('dashboard', absolute: false))->with('success', 'Email verified successfully!');
    }

    public function resend(Request $request): RedirectResponse
    {
        // Try to get user from auth or session email
        $user = auth()->user();
        
        if (!$user) {
            // Get email from persistent session (set during registration)
            $email = session('verify_email');
            
            if (!$email) {
                return redirect(route('register'))->with('error', 'Session expired. Please register again.');
            }
            
            // Find user by email
            $user = User::where('email', $email)->whereNull('email_verified_at')->first();
            
            if (!$user) {
                return redirect(route('register'))->with('error', 'User not found or already verified.');
            }
        }

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'email_verification_code' => $verificationCode,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));
            return back()->with('success', 'Verification code sent to your email.');
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            return back()->with('error', 'Failed to send email. Please try again.');
        }
    }
}
