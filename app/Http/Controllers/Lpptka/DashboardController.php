<?php

namespace App\Http\Controllers\Lpptka;

use App\Enum\LevelPelatihanGuru;
use App\Http\Controllers\Controller;
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
     * Admin LPPTKA Dashboard
     */
    public function index()
    {
        // Statistik unit yang dikelola
        $stats = $this->approvalService->getApprovalStats();

        // Statistik santri & guru
        $santriStats = [
            'total'   => Santri::count(),
            'tka'     => (int) Unit::sum('jumlah_tka'),
            'tpa'     => (int) Unit::sum('jumlah_tpa'),
            'tqa'     => (int) Unit::sum('jumlah_tqa'),
        ];

        $guruStats = [
            'laki'       => (int) Unit::sum('guru_laki'),
            'perempuan'  => (int) Unit::sum('guru_perempuan'),
            'certified'  => Teacher::where('level_pelatihan_guru', '!=', LevelPelatihanGuru::BELUM_PERNAH->value)->count(),
        ];

        // Unit yang sudah approved tapi belum punya akun
        $readyForAccount = $this->approvalService->getUnitsReadyForAccount()->take(5);

        // Recent units (terbaru)
        $recentUnits = Unit::with(['village.district.city'])
            ->latest()
            ->take(5)
            ->get();

        return view('lpptka.dashboard', compact(
            'stats',
            'santriStats',
            'guruStats',
            'readyForAccount',
            'recentUnits'
        ));
    }
}
