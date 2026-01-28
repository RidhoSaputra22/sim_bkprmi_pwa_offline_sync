<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Santri;
use App\Models\Unit;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Laporan Santri
     */
    public function santri(Request $request)
    {
        $query = Santri::with(['person', 'region']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status_santri', $request->status);
        }

        if ($request->filled('jenjang')) {
            $query->where('jenjang_santri', $request->jenjang);
        }

        $santri = $query->get();

        // Summary stats
        $stats = [
            'total' => $santri->count(),
            'by_status' => $santri->groupBy('status_santri')->map->count(),
            'by_jenjang' => $santri->groupBy('jenjang_santri')->map->count(),
        ];

        return view('admin.reports.santri', [
            'santri' => $santri,
            'stats' => $stats,
        ]);
    }

    /**
     * Laporan Kegiatan
     */
    public function activities(Request $request)
    {
        $query = Activity::with(['unit', 'createdBy']);

        // Apply filters
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->filled('year')) {
            $query->whereYear('activity_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('activity_date', $request->month);
        }

        $activities = $query->latest('activity_date')->get();

        // Summary stats
        $stats = [
            'total' => $activities->count(),
            'by_unit' => $activities->groupBy('unit.name')->map->count(),
            'by_month' => $activities->groupBy(fn($a) => $a->activity_date->format('Y-m'))->map->count(),
        ];

        return view('admin.reports.activities', [
            'activities' => $activities,
            'stats' => $stats,
            'units' => Unit::orderBy('name')->get(),
        ]);
    }

    /**
     * Laporan Unit
     */
    public function units(Request $request)
    {
        $query = Unit::with('region');

        // Apply filters
        if ($request->filled('tipe_lokasi')) {
            $query->where('tipe_lokasi', $request->tipe_lokasi);
        }

        $units = $query->get();

        // Summary stats
        $stats = [
            'total' => $units->count(),
            'total_santri' => $units->sum(fn($u) => $u->jumlah_tka_4_7 + $u->jumlah_tpa_7_12 + $u->jumlah_tqa_wisuda),
            'total_guru' => $units->sum(fn($u) => $u->jumlah_guru_laki_laki + $u->jumlah_guru_perempuan),
            'by_tipe' => $units->groupBy('tipe_lokasi')->map->count(),
            'by_status' => $units->groupBy('status_bangunan')->map->count(),
        ];

        return view('admin.reports.units', [
            'units' => $units,
            'stats' => $stats,
        ]);
    }

    /**
     * Export report to PDF/Excel
     */
    public function export(Request $request, string $type)
    {
        // Implementation for export functionality
        // Can be extended with packages like DomPDF, Laravel Excel, etc.

        return response()->json([
            'message' => 'Export functionality will be implemented here',
            'type' => $type,
            'format' => $request->input('format', 'pdf'),
        ]);
    }
}
