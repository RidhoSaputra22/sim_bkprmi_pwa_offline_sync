<?php

namespace App\Http\Controllers\Lpptka;

use App\Http\Controllers\Controller;
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

        // Unit pending approval
        $pendingUnits = Unit::pending()
            ->with(['village.district.city'])
            ->latest()
            ->take(5)
            ->get();

        // Unit yang sudah approved tapi belum punya akun
        $unitsReadyForAccount = $this->approvalService->getUnitsReadyForAccount()->take(5);

        // Unit yang ditolak
        $rejectedUnits = Unit::rejected()
            ->with(['village.district.city'])
            ->latest('approved_at')
            ->take(5)
            ->get();

        return view('lpptka.dashboard', compact(
            'stats',
            'pendingUnits',
            'unitsReadyForAccount',
            'rejectedUnits'
        ));
    }
}
