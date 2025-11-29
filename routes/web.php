<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [SearchController::class, 'results'])->name('search.results');
Route::get('/api/search', [SearchController::class, 'search'])->name('search.ajax');

// Auth routes
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (admin and superadmin)
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
});

// Super Admin routes only
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('roles', [UserController::class, 'roles'])->name('roles.index');
    Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::post('users/bulk-roles', [UserController::class, 'bulkUpdateRoles'])->name('users.bulkUpdateRoles');
});

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// API Documentation
Route::get('/api-docs', function () {
    return view('api-docs');
})->name('api.docs');

// API Documentation Export Routes
Route::get('/api-docs/export/json', function () {
    $path = storage_path('api-docs/api-docs.json');
    if (file_exists($path)) {
        return response()->download($path, 'FoodMart_API.json');
    }
    return abort(404, 'Documentation not found. Run: php artisan l5-swagger:generate');
})->name('api.docs.export.json');

Route::get('/api-docs/export/yaml', function () {
    $path = storage_path('api-docs/api-docs.yaml');
    if (file_exists($path)) {
        return response()->download($path, 'FoodMart_API.yaml');
    }
    return abort(404, 'YAML not found. Enable L5_SWAGGER_GENERATE_YAML_COPY in .env');
})->name('api.docs.export.yaml');
