<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Lpptka\DashboardController as LpptkaDashboardController;
use App\Http\Controllers\Lpptka\TpaAccountController;
use App\Http\Controllers\Lpptka\UnitController as LpptkaUnitController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UnitApprovalController;
use App\Http\Controllers\Tpa\DashboardController as TpaDashboardController;
use App\Http\Controllers\Tpa\SantriController as TpaSantriController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// ========================================
// AUTH ROUTES
// ========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========================================
// SUPERADMIN BKPRMI ROUTES
// Dashboard pemantauan keseluruhan data & approval TPA
// ========================================
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', CheckRole::class . ':superadmin'])
    ->group(function () {
        // Dashboard
        Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

        // Unit Approval Management
        Route::prefix('units/approval')->name('units.approval.')->group(function () {
            Route::get('/', [UnitApprovalController::class, 'index'])->name('index');
            Route::get('/{unit}', [UnitApprovalController::class, 'show'])->name('show');
            Route::post('/{unit}/approve', [UnitApprovalController::class, 'approve'])->name('approve');
            Route::post('/{unit}/reject', [UnitApprovalController::class, 'reject'])->name('reject');
            Route::get('/{unit}/certificate', [UnitApprovalController::class, 'viewCertificate'])->name('certificate');
        });

        // View All Data (Read Only)
        Route::get('/santri', function () {
            // TODO: Implement view all santri
            return view('superadmin.santri.index');
        })->name('santri.index');

        Route::get('/units', function () {
            // TODO: Implement view all units
            return view('superadmin.units.index');
        })->name('units.index');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', function () {
                return view('superadmin.reports.index');
            })->name('index');
        });
    });

// ========================================
// ADMIN LPPTKA ROUTES
// Input profil TPA & buat akun TPA
// ========================================
Route::prefix('lpptka')
    ->name('lpptka.')
    ->middleware(['auth', CheckRole::class . ':admin_lpptka'])
    ->group(function () {
        // Dashboard
        Route::get('/', [LpptkaDashboardController::class, 'index'])->name('dashboard');

        // Unit/TPA Management
        Route::resource('units', LpptkaUnitController::class);
        Route::post('/units/{unit}/certificate', [LpptkaUnitController::class, 'uploadCertificate'])
            ->name('units.upload-certificate');
        Route::post('/units/{unit}/resubmit', [LpptkaUnitController::class, 'resubmit'])
            ->name('units.resubmit');

        // TPA Account Management
        Route::prefix('tpa-accounts')->name('tpa-accounts.')->group(function () {
            Route::get('/', [TpaAccountController::class, 'index'])->name('index');
            Route::get('/{unit}/create', [TpaAccountController::class, 'create'])->name('create');
            Route::post('/{unit}', [TpaAccountController::class, 'store'])->name('store');
            Route::get('/{unit}/success', [TpaAccountController::class, 'success'])->name('success');
            Route::get('/{unit}/show', [TpaAccountController::class, 'show'])->name('show');
        });
    });

// ========================================
// ADMIN TPA ROUTES
// Input data santri & data TPA (restricted to Makassar)
// ========================================
Route::prefix('tpa')
    ->name('tpa.')
    ->middleware(['auth', CheckRole::class . ':admin_tpa'])
    ->group(function () {
        // Dashboard
        Route::get('/', [TpaDashboardController::class, 'index'])->name('dashboard');

        // Santri Management
        Route::resource('santri', TpaSantriController::class);

        // Unit Profile (view/edit own unit only)
        Route::get('/unit', function () {
            $unit = auth()->user()->managedUnit;
            if (!$unit) {
                return view('tpa.no-unit');
            }

            $unit->load(['village.district.city.province', 'unitHead.person']);

            $stats = [
                'total_santri' => $unit->santris()->count(),
                'active_santri' => $unit->santris()->where('status', 'aktif')->count(),
                'male_santri' => $unit->santris()->whereHas('person', fn($q) => $q->where('gender', 'L'))->count(),
                'female_santri' => $unit->santris()->whereHas('person', fn($q) => $q->where('gender', 'P'))->count(),
            ];

            return view('tpa.unit.show', compact('unit', 'stats'));
        })->name('unit.show');

        Route::get('/unit/edit', function () {
            $unit = auth()->user()->managedUnit;
            if (!$unit) {
                return redirect()->route('tpa.dashboard')->with('error', 'Unit tidak ditemukan.');
            }
            return view('tpa.unit.edit', compact('unit'));
        })->name('unit.edit');
    });

// ========================================
// LANDING PAGE
// ========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirect authenticated users to their dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user->isAdminLpptka()) {
        return redirect()->route('lpptka.dashboard');
    }

    if ($user->isAdminTpa()) {
        return redirect()->route('tpa.dashboard');
    }

    return redirect()->route('login');
})->middleware('auth')->name('dashboard');
