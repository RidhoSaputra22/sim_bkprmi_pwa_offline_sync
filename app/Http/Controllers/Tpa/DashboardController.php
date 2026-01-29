<?php

namespace App\Http\Controllers\Tpa;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Admin TPA Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $unit = $user->getUnit();

        if (! $unit) {
            return view('tpa.no-unit');
        }

        // Statistik unit
        $stats = [
            'total_santri' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->count(),
            'santri_aktif' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id)->whereNull('left_at');
            })->where('status', 'aktif')->count(),
            'santri_tka' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->where('level', 'TKA')->count(),
            'santri_tpa' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->where('level', 'TPA')->count(),
            'santri_tqa' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->where('level', 'TQA')->count(),
        ];

        // Santri terbaru
        $recentSantri = Santri::whereHas('santriUnits', function ($q) use ($unit) {
            $q->where('unit_id', $unit->id);
        })
        ->with('guardian')
        ->latest()
        ->take(5)
        ->get();

        return view('tpa.dashboard', compact('unit', 'stats', 'recentSantri'));
    }
}
