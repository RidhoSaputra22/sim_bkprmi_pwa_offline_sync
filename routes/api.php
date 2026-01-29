<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Region API for cascading dropdowns (public)
Route::prefix('regions')->name('api.regions.')->group(function () {
    Route::get('/provinces', [RegionController::class, 'provinces'])->name('provinces');
    Route::get('/cities', [RegionController::class, 'cities'])->name('cities');
    Route::get('/districts', [RegionController::class, 'districts'])->name('districts');
    Route::get('/villages', [RegionController::class, 'villages'])->name('villages');
});

// Location API for Admin TPA (Makassar only)
Route::prefix('location')->name('api.location.')->group(function () {
    Route::get('/makassar-info', [LocationController::class, 'makassarInfo'])->name('makassar-info');
    Route::get('/districts-makassar', [LocationController::class, 'districtsMakassar'])->name('districts-makassar');
    Route::get('/villages', [LocationController::class, 'villagesByDistrict'])->name('villages');
});

// Sync API for PWA offline functionality
Route::prefix('sync')->name('api.sync.')->group(function () {
    Route::get('/status', [SyncController::class, 'status'])->name('status');

    // Protected sync routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [SyncController::class, 'index'])->name('index');
        Route::get('/delta', [SyncController::class, 'delta'])->name('delta');
        Route::post('/push', [SyncController::class, 'push'])->name('push');
    });
});

// Web-based sync routes (uses session auth)
Route::prefix('sync')->name('api.sync.web.')->middleware('web', 'auth')->group(function () {
    Route::post('/push', [SyncController::class, 'push'])->name('push');
});
