# Tenant API Implementation Guide

This guide explains how to implement the tenant API system in your Laravel project to make it rentable on the Sites Platform.

## Overview

The tenant API allows the Sites Platform to:
- Create tenant admin accounts when users rent your project
- Manage tenant access (activate, suspend, hold)
- Check tenant status

## Prerequisites

- Laravel 12+
- PHP 8.2+
- Spatie Laravel Permission package
- Database with admins table

## Step 1: Environment Configuration

Add the UPS Project Connector credentials to your `.env`:

```env
# UPS Project Connector API Credentials
UPS_PROJECT_CONNECTOR_API_KEY=<your_api_key>
UPS_PROJECT_CONNECTOR_API_SECRET=<your_api_secret>
```

## Step 2: Create Authentication Middleware

```php
// app/Http/Middleware/ValidateUpsConnector.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUpsConnector
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('Authorization');
        $apiSecret = $request->header('X-Platform-Secret');
        $userId = $request->header('X-User-ID');

        $expectedKey = 'Bearer ' . env('UPS_PROJECT_CONNECTOR_API_KEY');
        $expectedSecret = env('UPS_PROJECT_CONNECTOR_API_SECRET');

        if ($apiKey !== $expectedKey || $apiSecret !== $expectedSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid API credentials'
            ], 401);
        }

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Missing user ID'
            ], 401);
        }

        return $next($request);
    }
}
```

## Step 3: Register Middleware

In `bootstrap/app.php`, add the middleware alias:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'validate.ups.connector' => \App\Http\Middleware\ValidateUpsConnector::class,
    ]);
})
```

## Step 4: Create Admin Model

```php
// app/Models/Admin.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'created_by'
    ];

    protected $casts = [
        'created_by' => 'json',
        'deleted_at' => 'datetime'
    ];

    protected $guard_name = 'admin';
}
```

## Step 5: Create Migration

```php
// database/migrations/XXXX_XX_XX_XXXXXX_create_admins_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['active', 'suspended', 'on_hold'])->default('active');
            $table->json('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
```

## Step 6: Create Role Model

```php
// app/Models/Role.php
<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guard_name = 'admin';
}
```

## Step 7: Create API Controller

```php
// app/Http/Controllers/Api/TenantController.php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateTenantRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    /**
     * Create a new tenant admin account
     * POST /api/tenant/create
     */
    public function create(CreateTenantRequest $request)
    {
        // Auto-generate unique credentials for each rental
        $uniqueId = time() . rand(1000, 9999);
        $generatedName = 'User_' . $uniqueId;
        $generatedEmail = 'user_' . $uniqueId . '@rental.local';
        $generatedPassword = Str::random(12);
        
        // Create admin with auto-generated credentials
        $admin = Admin::create([
            'name' => $generatedName,
            'email' => $generatedEmail,
            'password' => Hash::make($generatedPassword),
            'status' => 'active',
            'created_by' => [
                'type' => 'api', 
                'timestamp' => now()->toDateTimeString(),
                'rental_id' => $request->rental_id ?? null,
                'platform_user_id' => $request->platform_user_id ?? null
            ]
        ]);
        
        // Assign tenant role
        $tenantRole = Role::where('name', 'tenant')->where('guard_name', 'admin')->first();
        if ($tenantRole) {
            $admin->assignRole($tenantRole);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'admin_id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $generatedPassword,
                'admin_url' => config('app.url') . '/admin/login',
                'role' => 'tenant'
            ]
        ], 201);
    }

    /**
     * Suspend a tenant account
     * POST /api/tenant/suspend/{adminId}
     */
    public function suspend($adminId)
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin not found'], 404);
        }
        
        $admin->update(['status' => 'suspended']);
        return response()->json(['success' => true, 'data' => ['admin_id' => $admin->id, 'status' => $admin->status]]);
    }

    /**
     * Put a tenant account on hold
     * POST /api/tenant/hold/{adminId}
     */
    public function hold($adminId)
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin not found'], 404);
        }
        
        $admin->update(['status' => 'on_hold']);
        return response()->json(['success' => true, 'data' => ['admin_id' => $admin->id, 'status' => $admin->status]]);
    }

    /**
     * Activate a tenant account
     * POST /api/tenant/activate/{adminId}
     */
    public function activate($adminId)
    {
        $admin = Admin::withTrashed()->find($adminId);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin not found'], 404);
        }
        
        if ($admin->trashed()) {
            $admin->restore();
        }
        
        $admin->update(['status' => 'active']);
        return response()->json(['success' => true, 'data' => ['admin_id' => $admin->id, 'status' => $admin->status]]);
    }

    /**
     * Check tenant account status
     * GET /api/tenant/status/{adminId}
     */
    public function checkStatus($adminId)
    {
        $admin = Admin::withTrashed()->find($adminId);
        if (!$admin) {
            return response()->json(['success' => false, 'exists' => false, 'message' => 'Account not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'exists' => true,
            'data' => [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'status' => $admin->status,
                'deleted' => $admin->trashed(),
                'can_restore' => $admin->trashed()
            ]
        ]);
    }
}
```

## Step 8: Create API Routes with Authentication

```php
// routes/api.php
<?php

use App\Http\Controllers\Api\TenantController;
use Illuminate\Support\Facades\Route;

Route::middleware('validate.ups.connector')->group(function () {
    Route::post('/tenant/create', [TenantController::class, 'create']);
    Route::post('/tenant/hold/{adminId}', [TenantController::class, 'hold']);
    Route::post('/tenant/suspend/{adminId}', [TenantController::class, 'suspend']);
    Route::post('/tenant/activate/{adminId}', [TenantController::class, 'activate']);
    Route::get('/tenant/status/{adminId}', [TenantController::class, 'checkStatus']);
});
```

## Step 9: Create Request Validation

```php
// app/Http/Requests/Api/CreateTenantRequest.php
<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rental_id' => 'nullable|string',
            'platform_user_id' => 'nullable|integer',
        ];
    }
}
```

## API Endpoints Summary

| Method | Endpoint | Purpose | Auth Required |
|--------|----------|---------| ------------- |
| POST | `/api/tenant/create` | Create new tenant admin | ✅ Yes |
| POST | `/api/tenant/hold/{adminId}` | Put tenant on hold (rental expired) | ✅ Yes |
| POST | `/api/tenant/suspend/{adminId}` | Suspend tenant account | ✅ Yes |
| POST | `/api/tenant/activate/{adminId}` | Activate tenant account | ✅ Yes |
| GET | `/api/tenant/status/{adminId}` | Check tenant status | ✅ Yes |

## Authentication Headers

All API requests must include these headers:

```
Authorization: Bearer {UPS_PROJECT_CONNECTOR_API_KEY}
X-Platform-Secret: {UPS_PROJECT_CONNECTOR_API_SECRET}
X-User-ID: {authenticated_user_id}
```

## Integration Steps

1. Copy all code from this guide into your new project
2. Add credentials to `.env`
3. Create middleware and register it
4. Run migrations: `php artisan migrate`
5. Seed roles: `php artisan db:seed PermissionSeeder`
6. Deploy your project
7. Get your API URL (e.g., `http://localhost:8002`)
8. Create project on Sites Platform with this API URL
9. Users can now rent your project!
