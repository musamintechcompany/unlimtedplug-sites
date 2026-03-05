<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AutoLoginController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProjectAdminController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $projects = \App\Models\RentableProject::where('status', 'active')->orderBy('sort_order')->get();
    return view('welcome', compact('projects'));
})->name('home');

Route::get('/browse', function () {
    $projects = \App\Models\RentableProject::where('status', 'active')->orderBy('sort_order')->get();
    return view('browse', compact('projects'));
})->name('browse');

Route::get('/how-it-works', function () {
    return view('how-it-works-page');
})->name('how-it-works');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

// Temporary Admin Panel (delete after admin panel is built)
Route::prefix('admin-projects')->group(function () {
    Route::get('/login', [ProjectAdminController::class, 'login'])->name('admin.projects.login');
    Route::post('/login', [ProjectAdminController::class, 'login']);
    Route::get('/logout', [ProjectAdminController::class, 'logout'])->name('admin.projects.logout');
    Route::get('/', [ProjectAdminController::class, 'index'])->name('admin.projects.index');
    Route::get('/create', [ProjectAdminController::class, 'create'])->name('admin.projects.create');
    Route::post('/', [ProjectAdminController::class, 'store'])->name('admin.projects.store');
    Route::get('/{id}', [ProjectAdminController::class, 'show'])->name('admin.projects.show');
    Route::get('/{id}/edit', [ProjectAdminController::class, 'edit'])->name('admin.projects.edit');
    Route::patch('/{id}', [ProjectAdminController::class, 'update'])->name('admin.projects.update');
    Route::delete('/{id}', [ProjectAdminController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('/upload-image', [ProjectAdminController::class, 'uploadImage'])->name('admin.projects.upload-image');
});

Route::get('/product/{id}', function ($id) {
    return view('product-details');
})->name('product.details');

Route::get('/projects/{id}', function ($id) {
    $project = \App\Models\RentableProject::where('id', $id)->where('status', 'active')->firstOrFail();
    $details = json_decode($project->details, true) ?? [];
    
    return view('projects.show', [
        'project' => [
            'id' => $project->id,
            'name' => $project->name,
            'type' => $project->type,
            'category' => $project->type,
            'description' => $project->description,
            'is_buyable' => $details['is_buyable'] ?? false,
            'is_rentable' => $details['is_rentable'] ?? false,
            'pricing_24h' => $project->pricing_24h,
            'pricing_7d' => $project->pricing_7d,
            'pricing_30d' => $project->pricing_30d,
            'pricing_365d' => $project->pricing_365d,
            'images' => $details['images'] ?? [],
        ]
    ]);
})->name('projects.show');

// Auto-login from Marketplace
Route::get('/auto-login', [AutoLoginController::class, 'autoLogin'])->name('auto-login');

Route::get('/dashboard', function () {
    $activeRentals = \App\Models\Rental::with('rentableProject')
        ->where('user_id', auth()->id())
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
    
    return view('dashboard', compact('activeRentals'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/theme/update', [ProfileController::class, 'updateTheme'])->name('theme.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Credits
    Route::get('/credits', [CreditController::class, 'index'])->name('credits.index');
    Route::post('/credits', [CreditController::class, 'store'])->name('credits.store');
    Route::post('/credits/verify-payment', [PaymentController::class, 'verifyPayment'])->name('credits.verify-payment');
    Route::post('/currency/set', [CurrencyController::class, 'setCurrency'])->name('currency.set');
    
    // Rentals
    Route::get('rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::post('rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::post('rentals/{rental}/renew', [RentalController::class, 'renew'])->name('rentals.renew');
    
    // API Keys
    Route::resource('api-keys', ApiKeyController::class);
    Route::patch('api-keys/{apiKey}/toggle', [ApiKeyController::class, 'toggle'])->name('api-keys.toggle');
});

// Dynamic Favicon
Route::get('/favicon.svg', function () {
    $appName = config('app.name', 'Laravel');
    $initials = strtoupper(substr($appName, 0, 2));
    
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
  <rect width="100" height="100" fill="#4F46E5"/>
  <text x="50" y="70" font-family="Arial, sans-serif" font-size="50" font-weight="bold" fill="white" text-anchor="middle">{$initials}</text>
</svg>
SVG;
    
    return response($svg)->header('Content-Type', 'image/svg+xml');
});

require __DIR__.'/auth.php';
