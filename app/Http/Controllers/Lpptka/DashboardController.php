<?php

namespace App\Http\Controllers\Lpptka;

use App\Enum\JenjangSantri;
use App\Enum\LevelPelatihanGuru;
use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriUnit;
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
            'total' => SantriUnit::whereNull('left_at')->count(),
            'tka' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', JenjangSantri::TKA))->whereNull('left_at')->count(),
            'tpa' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', JenjangSantri::TPA))->whereNull('left_at')->count(),
            'tqa' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', JenjangSantri::TQA))->whereNull('left_at')->count(),
        ];

        $guruStats = [
            'laki' => Teacher::where('gender', 'laki-laki')->count(),
            'perempuan' => Teacher::where('gender', 'perempuan')->count(),
            'certified' => Teacher::where('level_pelatihan_guru', '!=', LevelPelatihanGuru::BELUM_PERNAH->value)->count(),
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
