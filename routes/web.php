<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Lpptka\DashboardController as LpptkaDashboardController;
use App\Http\Controllers\Lpptka\TpaAccountController;
use App\Http\Controllers\Lpptka\UnitController as LpptkaUnitController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\SuperAdmin\UnitApprovalController;
use App\Http\Controllers\Tpa\DashboardController as TpaDashboardController;
use App\Http\Controllers\Tpa\SantriController as TpaSantriController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

// ========================================
// AUTH ROUTES
// ========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

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

        // Profile Management
        Route::get('/profile', [SuperAdminProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [SuperAdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [SuperAdminProfileController::class, 'updatePassword'])->name('password.update');

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
                'male' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'laki-laki'))->count(),
                'female' => \App\Models\Santri::whereHas('person', fn ($q) => $q->where('gender', 'perempuan'))->count(),
                'graduated' => \App\Models\Santri::where('status_santri', 'lulus_wisuda')->count(),
            ];

            return view('superadmin.santri.index', compact('santris', 'stats'));
        })->name('santri.index');

        Route::get('/santri/{santri}/detail', function (\App\Models\Santri $santri) {
            $santri->load([
                'person',
                'village.district.city.province',
                'santriUnits.unit',
                'guardianSantris.guardian.person',
            ]);

            $unit = $santri->santriUnits->sortByDesc('joined_at')->first()?->unit;

            $guardians = $santri->guardianSantris
                ->map(function (\App\Models\GuardianSantri $gs) {
                    return [
                        'hubungan' => $gs->hubungan?->value,
                        'hubungan_label' => $gs->hubungan?->getLabel(),
                        'full_name' => $gs->guardian?->person?->full_name,
                        'nik' => $gs->guardian?->person?->nik,
                        'phone' => $gs->guardian?->person?->phone,
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $santri->id,
                    'person' => [
                        'full_name' => $santri->person?->full_name,
                        'nik' => $santri->person?->nik,
                        'gender' => $santri->person?->gender?->value,
                        'gender_label' => $santri->person?->gender?->getLabel(),
                        'birth_place' => $santri->person?->birth_place,
                        'birth_date' => $santri->person?->birth_date?->format('Y-m-d'),
                        'birth_date_human' => $santri->person?->birth_date?->format('d M Y'),
                        'phone' => $santri->person?->phone,
                    ],
                    'jenjang' => [
                        'value' => $santri->jenjang_santri?->value,
                        'label' => $santri->jenjang_santri?->getLabel(),
                    ],
                    'kelas' => [
                        'value' => $santri->kelas_mengaji?->value,
                        'label' => $santri->kelas_mengaji?->getLabel(),
                    ],
                    'status' => [
                        'value' => $santri->status_santri?->value,
                        'label' => $santri->status_santri?->getLabel(),
                    ],
                    'unit' => $unit ? [
                        'id' => $unit->id,
                        'unit_number' => $unit->unit_number,
                        'name' => $unit->name,
                    ] : null,
                    'location' => [
                        'province' => $santri->village?->district?->city?->province?->name,
                        'city' => $santri->village?->district?->city?->name,
                        'district' => $santri->village?->district?->name,
                        'village' => $santri->village?->name,
                    ],
                    'address' => [
                        'address' => $santri->address,
                        'rt' => $santri->rt,
                        'rw' => $santri->rw,
                    ],
                    'parents' => [
                        'nama_ayah' => $santri->nama_ayah,
                        'nama_ibu' => $santri->nama_ibu,
                    ],
                    'guardians' => $guardians,
                    'created_at' => $santri->created_at?->toISOString(),
                ],
            ]);
        })->name('santri.detail');

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
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
            Route::get('/print', [ReportController::class, 'print'])->name('print');
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

        // Teacher/Guru Management
        Route::resource('teachers', TeacherController::class)->except(['index', 'create', 'store']);
        Route::get('/guru', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/guru/create', [TeacherController::class, 'create'])->name('teachers.create');
        Route::post('/guru', [TeacherController::class, 'store'])->name('teachers.store');

        // AJAX routes for location cascading
        Route::get('/api/cities', [TeacherController::class, 'getCities'])->name('api.cities');
        Route::get('/api/districts', [TeacherController::class, 'getDistricts'])->name('api.districts');
        Route::get('/api/villages', [TeacherController::class, 'getVillages'])->name('api.villages');

        // Unit Profile (view/edit own unit only)
        Route::get('/unit', function () {
            $unit = auth()->user()->managedUnit;
            if (! $unit) {
                return view('tpa.no-unit');
            }

            $unit->load(['village.district.city.province', 'unitHead.person']);

            $stats = [
                'total_santri' => $unit->santris()->count(),
                'active_santri' => $unit->santris()->where('status_santri', 'aktif')->count(),
                'male_santri' => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'laki-laki'))->count(),
                'female_santri' => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'perempuan'))->count(),
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
