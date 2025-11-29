<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SearchApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    // Search APIs
    Route::get('/search', [SearchApiController::class, 'search']);
    Route::get('/search/quick', [SearchApiController::class, 'quickSearch']);
    Route::get('/search/filters', [SearchApiController::class, 'filters']);

    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});
