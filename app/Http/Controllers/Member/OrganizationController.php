<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * Display organization information (Lihat Informasi Organisasi).
     */
    public function index(): View
    {
        // Get all regions with their units
        $regions = Region::with(['units'])->get();

        // Get organization statistics
        $statistics = [
            'total_units' => Unit::count(),
            'total_regions' => Region::count(),
            'total_santri' => Unit::sum('jumlah_tka_4_7') +
                             Unit::sum('jumlah_tpa_7_12') +
                             Unit::sum('jumlah_tqa_wisuda'),
            'total_guru' => Unit::sum('jumlah_guru_laki_laki') +
                           Unit::sum('jumlah_guru_perempuan'),
        ];

        return view('member.organization.index', compact('regions', 'statistics'));
    }

    /**
     * Display details about a specific unit.
     */
    public function showUnit(Unit $unit): View
    {
        $unit->load(['region', 'village']);

        return view('member.organization.unit-detail', compact('unit'));
    }

    /**
     * Display organization structure.
     */
    public function structure(): View
    {
        $regions = Region::with(['units'])->get();

        return view('member.organization.structure', compact('regions'));
    }
}
