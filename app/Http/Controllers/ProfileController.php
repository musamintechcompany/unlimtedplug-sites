<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Mail\VerificationCodeMail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's theme.
     */
    public function updateTheme(Request $request)
    {
        $request->validate(['theme' => 'required|in:light,dark']);
        
        $user = Auth::user();
        $user->update(['theme' => $request->theme]);
        
        return response()->json(['success' => true, 'theme' => $request->theme]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('profile_photo_path')) {
            $path = $request->file('profile_photo_path')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }
        
        // Check if email is being changed
        if ($request->user()->email !== $data['email']) {
            // Generate verification code
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store new email and code in session temporarily
            session([
                'pending_email' => $data['email'],
                'email_change_code' => $verificationCode,
                'email_change_code_expires_at' => now()->addMinutes(15),
            ]);
            
            // Send verification code to NEW email
            try {
                Mail::to($data['email'])->send(new VerificationCodeMail($request->user(), $verificationCode));
                return Redirect::route('profile.edit')->with('status', 'email-verification-sent');
            } catch (\Exception $e) {
                \Log::error('Failed to send email change verification: ' . $e->getMessage());
                return Redirect::route('profile.edit')->with('error', 'Failed to send verification email.');
            }
        }
        
        // Update other fields (not email)
        unset($data['email']);
        $request->user()->fill($data);
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Verify email change with code.
     */
    public function verifyEmailChange(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);
        
        $pendingEmail = session('pending_email');
        $storedCode = session('email_change_code');
        $expiresAt = session('email_change_code_expires_at');
        
        if (!$pendingEmail || !$storedCode || !$expiresAt) {
            return Redirect::route('profile.edit')->with('error', 'No pending email change found.');
        }
        
        if (now()->greaterThan($expiresAt)) {
            session()->forget(['pending_email', 'email_change_code', 'email_change_code_expires_at']);
            return Redirect::route('profile.edit')->with('error', 'Verification code has expired.');
        }
        
        if ($request->code !== $storedCode) {
            return Redirect::route('profile.edit')->withErrors(['code' => 'Invalid verification code.']);
        }
        
        // Update email
        $user = $request->user();
        $user->email = $pendingEmail;
        $user->email_verified_at = now();
        $user->save();
        
        // Clear session
        session()->forget(['pending_email', 'email_change_code', 'email_change_code_expires_at']);
        
        return Redirect::route('profile.edit')->with('status', 'email-updated');
    }
    
    /**
     * Resend email change verification code.
     */
    public function resendCode(Request $request): RedirectResponse
    {
        $pendingEmail = session('pending_email');
        
        if (!$pendingEmail) {
            return Redirect::route('profile.edit')->with('error', 'No pending email change found.');
        }
        
        // Generate new code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        session([
            'email_change_code' => $verificationCode,
            'email_change_code_expires_at' => now()->addMinutes(15),
        ]);
        
        try {
            Mail::to($pendingEmail)->send(new VerificationCodeMail($request->user(), $verificationCode));
            return Redirect::route('profile.edit')->with('status', 'verification-code-resent');
        } catch (\Exception $e) {
            \Log::error('Failed to resend email change verification: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('error', 'Failed to send verification email.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
