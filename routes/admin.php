<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('onboarding', [AuthController::class, 'showOnboarding'])->name('onboarding');
Route::post('onboarding', [AuthController::class, 'onboarding']);
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:admin'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('theme/update', [AuthController::class, 'updateTheme'])->name('theme.update');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    
    // Projects
    Route::resource('projects', ProjectController::class)->middleware('can:view-projects');
    
    // Rentals
    Route::resource('rentals', RentalController::class)->only(['index', 'show'])->middleware('can:view-rentals');
    Route::post('rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel')->middleware('can:cancel-rentals');
    Route::post('rentals/{rental}/suspend', [RentalController::class, 'suspend'])->name('rentals.suspend')->middleware('can:cancel-rentals');
    Route::post('rentals/{rental}/activate', [RentalController::class, 'activate'])->name('rentals.activate')->middleware('can:cancel-rentals');
    
    // Transactions
    Route::resource('transactions', TransactionController::class)->only(['index', 'show'])->middleware('can:view-transactions');
    
    // Admins
    Route::resource('admins', AdminController::class)->middleware('can:view-admins');
    
    // Roles
    Route::resource('roles', RoleController::class)->middleware('can:view-roles');
    
    // Permissions
    Route::resource('permissions', PermissionController::class)->only(['index', 'show', 'create', 'store', 'destroy'])->middleware('can:view-permissions');
    Route::delete('permissions/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('permissions.bulk-delete')->middleware('can:delete-permissions');
    
    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('can:view-settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update')->middleware('can:edit-settings');
    Route::patch('settings', [SettingsController::class, 'update'])->middleware('can:edit-settings');
    
    // Analytics
    Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index')->middleware('can:view-analytics');
    Route::get('analytics/visitors', [\App\Http\Controllers\Admin\AnalyticsController::class, 'visitors'])->name('analytics.visitors')->middleware('can:view-analytics');
    Route::post('analytics/delete-old-data', [\App\Http\Controllers\Admin\AnalyticsController::class, 'deleteOldData'])->name('analytics.delete-old-data')->middleware('can:delete-analytics');
    Route::get('analytics/visitor-chart-data', [\App\Http\Controllers\Admin\AnalyticsController::class, 'getVisitorChartData'])->name('analytics.visitor-chart-data')->middleware('can:view-analytics');
    
    // Trash
    Route::get('trash', [TrashController::class, 'index'])->name('trash.index')->middleware('can:view-trash');
    Route::post('trash/users/{user}/restore', [TrashController::class, 'restoreUser'])->name('trash.restore-user')->middleware('can:restore-trash');
    Route::post('trash/admins/{admin}/restore', [TrashController::class, 'restoreAdmin'])->name('trash.restore-admin')->middleware('can:restore-trash');
    Route::post('trash/projects/{project}/restore', [TrashController::class, 'restoreProject'])->name('trash.restore-project')->middleware('can:restore-trash');
    Route::delete('trash/users/{user}', [TrashController::class, 'forceDeleteUser'])->name('trash.force-delete-user')->middleware('can:force-delete-trash');
    Route::delete('trash/admins/{admin}', [TrashController::class, 'forceDeleteAdmin'])->name('trash.force-delete-admin')->middleware('can:force-delete-trash');
    Route::delete('trash/projects/{project}', [TrashController::class, 'forceDeleteProject'])->name('trash.force-delete-project')->middleware('can:force-delete-trash');
    Route::post('trash/bulk-restore', [TrashController::class, 'bulkRestore'])->name('trash.bulk-restore')->middleware('can:restore-trash');
    Route::delete('trash/bulk-force-delete', [TrashController::class, 'bulkForceDelete'])->name('trash.bulk-force-delete')->middleware('can:force-delete-trash');
    Route::post('trash/empty', [TrashController::class, 'emptyTrash'])->name('trash.empty')->middleware('can:force-delete-trash');
    
    Route::delete('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete')->middleware('can:delete-users');
    Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban')->middleware('can:ban-users');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban')->middleware('can:unban-users');
    Route::resource('users', UserController::class)->middleware('can:view-users');
});
