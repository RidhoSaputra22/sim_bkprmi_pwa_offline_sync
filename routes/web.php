<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ValidationController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Member\OrganizationController;
use App\Http\Controllers\Member\ActivityController as MemberActivityController;
use App\Http\Controllers\Member\ReportController as MemberReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Santri Management (Kelola Data Santri)
        Route::resource('santri', SantriController::class);

        // Activity Management (Kelola Data Kegiatan)
        Route::resource('activities', ActivityController::class);

        // Unit Management
        Route::resource('units', UnitController::class);

        // Reports (Kelola Laporan)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/santri', [ReportController::class, 'santri'])->name('santri');
            Route::get('/activities', [ReportController::class, 'activities'])->name('activities');
            Route::get('/units', [ReportController::class, 'units'])->name('units');
            Route::post('/export/{type}', [ReportController::class, 'export'])->name('export');
        });

        // Archives (Kelola Arsip)
        Route::resource('archives', ArchiveController::class)->except(['edit', 'update']);
        Route::get('archives/{archive}/download', [ArchiveController::class, 'download'])->name('archives.download');

        // Validation (Validasi Data)
        Route::prefix('validation')->name('validation.')->group(function () {
            Route::get('/', [ValidationController::class, 'index'])->name('index');
            Route::post('/approve/{type}/{id}', [ValidationController::class, 'approve'])->name('approve');
            Route::post('/reject/{type}/{id}', [ValidationController::class, 'reject'])->name('reject');
            Route::post('/bulk-approve', [ValidationController::class, 'bulkApprove'])->name('bulk-approve');
        });

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
    });

// Member routes (Pengguna / Anggota)
Route::prefix('member')
    ->name('member.')
    ->middleware(['auth'])
    ->group(function () {
        // Dashboard
        Route::get('/', [MemberDashboardController::class, 'index'])->name('dashboard');

        // Organization Information (Lihat Informasi Organisasi)
        Route::prefix('organization')->name('organization.')->group(function () {
            Route::get('/', [OrganizationController::class, 'index'])->name('index');
            Route::get('/structure', [OrganizationController::class, 'structure'])->name('structure');
            Route::get('/unit/{unit}', [OrganizationController::class, 'showUnit'])->name('unit.show');
        });

        // Activities (Lihat Data Kegiatan)
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [MemberActivityController::class, 'index'])->name('index');
            Route::get('/{activity}', [MemberActivityController::class, 'show'])->name('show');
            Route::get('/{activity}/logs', [MemberActivityController::class, 'logs'])->name('logs');
        });

        // Reports (Unduh Laporan & Cerak Laporan)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [MemberReportController::class, 'index'])->name('index');
            Route::post('/download/santri', [MemberReportController::class, 'downloadSantriReport'])->name('download.santri');
            Route::post('/download/activity', [MemberReportController::class, 'downloadActivityReport'])->name('download.activity');
            Route::post('/download/unit', [MemberReportController::class, 'downloadUnitReport'])->name('download.unit');
            Route::get('/print', [MemberReportController::class, 'print'])->name('print');
        });
    });
