<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enum\Gender;
use App\Enum\LevelPelatihanGuru;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Santri;
use App\Models\Teacher;
use App\Models\Unit;
use App\Services\UnitApprovalService;

class DashboardController extends Controller
{
    public function __construct(
        protected UnitApprovalService $approvalService
    ) {}

    /**
     * SuperAdmin BKPRMI Dashboard
     * Pemantauan keseluruhan data
     */
    public function index()
    {
        // Statistik umum
        $stats = [
            'total_santri'       => Santri::count(),
            'total_units'        => Unit::count(),
            'total_activities'   => Activity::count(),
            'guru_laki'          => Teacher::where('gender', Gender::LAKI_LAKI->value)->count()
                                    + (int) Unit::sum('guru_laki'),
            'guru_perempuan'     => Teacher::where('gender', Gender::PEREMPUAN->value)->count()
                                    + (int) Unit::sum('guru_perempuan'),
            'guru_certified_a'   => Teacher::where('level_pelatihan_guru', LevelPelatihanGuru::LEVEL_A->value)->count(),
        ];

        // Statistik approval unit
        $approvalStats = $this->approvalService->getApprovalStats();

        // Unit yang menunggu approval
        $pendingUnits = $this->approvalService->getPendingUnits()->take(10);

        // Aktivitas terbaru
        $recentActivities = Activity::with('unit')
            ->latest('activity_date')
            ->take(5)
            ->get();

        // Unit terbaru yang diapprove
        $recentApprovedUnits = Unit::approved()
            ->with(['village.district.city'])
            ->latest('approved_at')
            ->take(5)
            ->get();

        return view('superadmin.dashboard', compact(
            'stats',
            'approvalStats',
            'pendingUnits',
            'recentActivities',
            'recentApprovedUnits'
        ));
    }
}
