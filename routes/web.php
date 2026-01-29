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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================================
// SUPERADMIN BKPRMI ROUTES
// Dashboard pemantauan keseluruhan data & approval TPA
// ========================================
Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', CheckRole::class.':superadmin'])
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
            $santris = \App\Models\Santri::with(['person', 'santriUnits.unit', 'village.district.city'])
                ->when(request('status'), fn ($q, $status) => $q->where('status_santri', $status))
                ->when(request('jenjang'), fn ($q, $jenjang) => $q->where('jenjang_santri', $jenjang))
                ->when(request('gender'), fn ($q, $gender) => $q->whereHas('person', fn ($pq) => $pq->where('gender', $gender)))
                ->when(request('search'), fn ($q, $search) => $q->whereHas('person', fn ($pq) => $pq->where('full_name', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%")))
                ->latest()
                ->paginate(15)
                ->withQueryString();

            $stats = [
                'total' => \App\Models\Santri::count(),
                'aktif' => \App\Models\Santri::where('status_santri', 'aktif')->count(),
                'male' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'L'))->count(),
                'female' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'P'))->count(),
                'graduated' => \App\Models\Santri::where('status_santri', 'lulus_wisuda')->count(),
            ];

            return view('superadmin.santri.index', compact('santris', 'stats'));
        })->name('santri.index');

        Route::get('/units', function () {
            $units = \App\Models\Unit::with(['village.district.city.province', 'unitHead.person'])
                ->withCount('santris')
                ->when(request('status'), fn ($q, $status) => $q->where('approval_status', $status))
                ->when(request('province_id'), fn ($q, $provinceId) => $q->whereHas('village.district.city.province', fn ($pq) => $pq->where('id', $provinceId)))
                ->when(request('search'), fn ($q, $search) => $q->where('name', 'like', "%{$search}%")->orWhere('unit_number', 'like', "%{$search}%"))
                ->latest()
                ->paginate(15)
                ->withQueryString();

            $stats = [
                'total' => \App\Models\Unit::count(),
                'approved' => \App\Models\Unit::where('approval_status', 'approved')->count(),
                'pending' => \App\Models\Unit::where('approval_status', 'pending')->count(),
                'rejected' => \App\Models\Unit::where('approval_status', 'rejected')->count(),
            ];

            $provinces = \App\Models\Province::orderBy('name')->get();

            return view('superadmin.units.index', compact('units', 'stats', 'provinces'));
        })->name('units.index');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', function () {
                $stats = [
                    'total_santri' => \App\Models\Santri::count(),
                    'total_units' => \App\Models\Unit::count(),
                    'total_cities' => \App\Models\City::count(),
                    'approved_units' => \App\Models\Unit::where('approval_status', 'approved')->count(),
                    'pending_units' => \App\Models\Unit::where('approval_status', 'pending')->count(),
                    'rejected_units' => \App\Models\Unit::where('approval_status', 'rejected')->count(),
                    'male_santri' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'L'))->count(),
                    'female_santri' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'P'))->count(),
                    'by_jenjang' => [
                        'tka' => \App\Models\Santri::where('jenjang_santri', 'tka')->count(),
                        'tpa' => \App\Models\Santri::where('jenjang_santri', 'tpa')->count(),
                        'tqa' => \App\Models\Santri::where('jenjang_santri', 'tqa')->count(),
                    ],
                    'by_status' => [
                        'aktif' => \App\Models\Santri::where('status_santri', 'aktif')->count(),
                        'lulus_wisuda' => \App\Models\Santri::where('status_santri', 'lulus_wisuda')->count(),
                        'lanjut_tqa' => \App\Models\Santri::where('status_santri', 'lanjut_tqa')->count(),
                        'pindah' => \App\Models\Santri::where('status_santri', 'pindah')->count(),
                        'berhenti' => \App\Models\Santri::where('status_santri', 'berhenti')->count(),
                    ],
                ];

                return view('superadmin.reports.index', compact('stats'));
            })->name('index');
        });
    });

// ========================================
// ADMIN LPPTKA ROUTES
// Input profil TPA & buat akun TPA
// ========================================
Route::prefix('lpptka')
    ->name('lpptka.')
    ->middleware(['auth', CheckRole::class.':admin_lpptka'])
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
    ->middleware(['auth', CheckRole::class.':admin_tpa'])
    ->group(function () {
        // Dashboard
        Route::get('/', [TpaDashboardController::class, 'index'])->name('dashboard');

        // Santri Management
        Route::resource('santri', TpaSantriController::class);

        // Unit Profile (view/edit own unit only)
        Route::get('/unit', function () {
            $unit = auth()->user()->managedUnit;
            if (! $unit) {
                return view('tpa.no-unit');
            }

            $unit->load(['village.district.city.province', 'unitHead.person']);

            $stats = [
                'total_santri' => $unit->santris()->count(),
                'active_santri' => $unit->santris()->where('status', 'aktif')->count(),
                'male_santri' => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'L'))->count(),
                'female_santri' => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'P'))->count(),
            ];

            return view('tpa.unit.show', compact('unit', 'stats'));
        })->name('unit.show');

        Route::get('/unit/edit', function () {
            $unit = auth()->user()->managedUnit;
            if (! $unit) {
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
