<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Santri;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display report page (Unduh Laporan).
     */
    public function index(): View
    {
        return view('member.reports.index');
    }

    /**
     * Download santri report.
     */
    public function downloadSantriReport(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'unit_id' => 'required|exists:units,id',
        ]);

        $query = Santri::with(['person', 'santriUnits.unit']);

        if ($request->unit_id) {
            $query->whereHas('santriUnits', function($q) use ($request) {
                $q->where('unit_id', $request->unit_id);
            });
        }

        $santris = $query->get();

        if ($request->input('format') === 'pdf') {
            return $this->generateSantriPDF($santris);
        }

        // Excel format will be implemented later
        return back()->with('error', 'Format Excel belum tersedia');
    }

    /**
     * Download activity report.
     */
    public function downloadActivityReport(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'unit_id' => 'required|exists:units,id',
        ]);

        $query = Activity::with(['unit']);

        if ($request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->start_date) {
            $query->where('activity_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('activity_date', '<=', $request->end_date);
        }

        $activities = $query->get();

        if ($request->input('format') === 'pdf') {
            return $this->generateActivityPDF($activities);
        }

        return back()->with('error', 'Format Excel belum tersedia');
    }

    /**
     * Download unit report.
     */
    public function downloadUnitReport(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'region_id' => 'required|exists:regions,id',
        ]);

        $query = Unit::with(['region', 'village']);

        if ($request->region_id) {
            $query->where('region_id', $request->region_id);
        }

        $units = $query->get();

        if ($request->input('format') === 'pdf') {
            return $this->generateUnitPDF($units);
        }

        return back()->with('error', 'Format Excel belum tersedia');
    }

    /**
     * Print report (Cerak Laporan - extends download).
     */
    public function print(Request $request): View
    {
        $request->validate([
            'type' => 'required|in:santri,activity,unit',
        ]);

        $data = [];

        switch ($request->type) {
            case 'santri':
                $query = Santri::with(['person', 'santriUnits.unit']);
                if ($request->unit_id) {
                    $query->whereHas('santriUnits', function($q) use ($request) {
                        $q->where('unit_id', $request->unit_id);
                    });
                }
                $data['santris'] = $query->get();
                break;

            case 'activity':
                $query = Activity::with(['unit']);
                if ($request->unit_id) {
                    $query->where('unit_id', $request->unit_id);
                }
                if ($request->start_date) {
                    $query->where('activity_date', '>=', $request->start_date);
                }
                if ($request->end_date) {
                    $query->where('activity_date', '<=', $request->end_date);
                }
                $data['activities'] = $query->get();
                break;

            case 'unit':
                $query = Unit::with(['region', 'village']);
                if ($request->region_id) {
                    $query->where('region_id', $request->region_id);
                }
                $data['units'] = $query->get();
                break;
        }

        $data['type'] = $request->type;

        return view('member.reports.print', $data);
    }

    /**
     * Generate PDF for santri report.
     */
    private function generateSantriPDF($santris)
    {
        $pdf = Pdf::loadView('member.reports.pdf.santri', compact('santris'));
        return $pdf->download('laporan-santri-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for activity report.
     */
    private function generateActivityPDF($activities)
    {
        $pdf = Pdf::loadView('member.reports.pdf.activity', compact('activities'));
        return $pdf->download('laporan-kegiatan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for unit report.
     */
    private function generateUnitPDF($units)
    {
        $pdf = Pdf::loadView('member.reports.pdf.unit', compact('units'));
        return $pdf->download('laporan-unit-' . date('Y-m-d') . '.pdf');
    }
}
