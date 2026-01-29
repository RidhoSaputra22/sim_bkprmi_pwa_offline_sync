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
            'active_santri' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id)->whereNull('left_at');
            })->where('status_santri', 'aktif')->count(),
            'male_santri' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->whereHas('person', fn ($p) => $p->where('gender', 'laki-laki'))->count(),
            'female_santri' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                $q->where('unit_id', $unit->id);
            })->whereHas('person', fn ($p) => $p->where('gender', 'perempuan'))->count(),
            'by_jenjang' => [
                'TKA' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                    $q->where('unit_id', $unit->id);
                })->where('jenjang_santri', 'TKA')->count(),
                'TPA' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                    $q->where('unit_id', $unit->id);
                })->where('jenjang_santri', 'TPA')->count(),
                'TQA' => Santri::whereHas('santriUnits', function ($q) use ($unit) {
                    $q->where('unit_id', $unit->id);
                })->where('jenjang_santri', 'TQA')->count(),
            ],
        ];

        // Santri terbaru
        $recentSantri = Santri::whereHas('santriUnits', function ($q) use ($unit) {
            $q->where('unit_id', $unit->id);
        })
        ->with('guardians')
        ->latest()
        ->take(5)
        ->get();

        return view('tpa.dashboard', compact('unit', 'stats', 'recentSantri'));
    }
}
