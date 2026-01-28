<?php

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

// Sync API for PWA offline functionality
Route::prefix('sync')->name('api.sync.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [SyncController::class, 'index'])->name('index');
    Route::get('/delta', [SyncController::class, 'delta'])->name('delta');
    Route::post('/push', [SyncController::class, 'push'])->name('push');
    Route::get('/status', [SyncController::class, 'status'])->name('status');
});

// Public sync status endpoint
Route::get('/sync/status', [SyncController::class, 'status'])->name('api.sync.status.public');
