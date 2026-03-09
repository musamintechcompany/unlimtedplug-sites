<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetCodeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('verify-email', [VerifyEmailController::class, 'show'])
        ->name('verify-email');

    Route::post('verify-email', [VerifyEmailController::class, 'store'])
        ->name('verify-email.store');

    Route::get('resend-verification-code', [VerifyEmailController::class, 'resend'])
        ->name('resend-verification-code');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetCodeController::class, 'requestCode'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetCodeController::class, 'sendCode'])
        ->name('password.email');

    Route::get('verify-reset-code', [PasswordResetCodeController::class, 'verifyCode'])
        ->name('password.verify-code');

    Route::post('verify-reset-code', [PasswordResetCodeController::class, 'checkCode'])
        ->name('password.check-code');

    Route::get('reset-password', [PasswordResetCodeController::class, 'resetForm'])
        ->name('password.reset');

    Route::post('reset-password', [PasswordResetCodeController::class, 'resetPassword'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email-prompt', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
