<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\SantriUnit;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = $this->buildStats();

        return view('superadmin.reports.index', compact('stats'));
    }

    public function exportPdf(Request $request)
    {
        $stats = $this->buildStats();
        $generatedAt = now();

        $pdf = Pdf::loadView('superadmin.reports.pdf', compact('stats', 'generatedAt'))
            ->setPaper('a4', 'portrait');

        return $pdf->download($this->makeFileName('pdf'));
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $stats = $this->buildStats();
        $generatedAt = now();

        $filename = $this->makeFileName('csv');

        return response()->streamDownload(function () use ($stats, $generatedAt) {
            // UTF-8 BOM supaya Excel Windows kebaca rapi
            echo "\xEF\xBB\xBF";

            $out = fopen('php://output', 'w');

            fputcsv($out, ['Laporan & Statistik BKPRMI']);
            fputcsv($out, ['Generated At', $generatedAt->format('Y-m-d H:i:s')]);
            fputcsv($out, []);

            fputcsv($out, ['Ringkasan']);
            fputcsv($out, ['Total Santri', $stats['total_santri'] ?? 0]);
            fputcsv($out, ['Total Unit TPA', $stats['total_units'] ?? 0]);
            fputcsv($out, ['Kota/Kabupaten', $stats['total_cities'] ?? 0]);
            fputcsv($out, ['Unit Aktif (Approved)', $stats['approved_units'] ?? 0]);
            fputcsv($out, []);

            fputcsv($out, ['Santri per Jenjang']);
            fputcsv($out, ['TKA', $stats['by_jenjang']['tka'] ?? 0]);
            fputcsv($out, ['TPA', $stats['by_jenjang']['tpa'] ?? 0]);
            fputcsv($out, ['TQA', $stats['by_jenjang']['tqa'] ?? 0]);
            fputcsv($out, []);

            fputcsv($out, ['Santri per Gender']);
            fputcsv($out, ['Laki-laki', $stats['male_santri'] ?? 0]);
            fputcsv($out, ['Perempuan', $stats['female_santri'] ?? 0]);
            fputcsv($out, []);

            fputcsv($out, ['Status Approval Unit']);
            fputcsv($out, ['Pending', $stats['pending_units'] ?? 0]);
            fputcsv($out, ['Disetujui', $stats['approved_units'] ?? 0]);
            fputcsv($out, ['Ditolak', $stats['rejected_units'] ?? 0]);
            fputcsv($out, ['Total Unit', $stats['total_units'] ?? 0]);
            fputcsv($out, []);

            fputcsv($out, ['Status Santri']);
            fputcsv($out, ['Masih Aktif', $stats['by_status']['aktif'] ?? 0]);
            fputcsv($out, ['Lulus Wisuda TPA', $stats['by_status']['lulus_wisuda'] ?? 0]);
            fputcsv($out, ['Lanjut TQA', $stats['by_status']['lanjut_tqa'] ?? 0]);
            fputcsv($out, ['Pindah', $stats['by_status']['pindah'] ?? 0]);
            fputcsv($out, ['Berhenti', $stats['by_status']['berhenti'] ?? 0]);

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print(Request $request)
    {
        $stats = $this->buildStats();
        $generatedAt = now();

        return view('superadmin.reports.print', compact('stats', 'generatedAt'));
    }

    private function makeFileName(string $ext): string
    {
        return 'laporan-bkprmi-'.now()->format('Ymd-His').'.'.$ext;
    }

    private function buildStats(): array
    {
        return [
            'total_santri' => SantriUnit::whereNull('left_at')->count(),
            'total_units' => Unit::count(),
            'total_cities' => City::count(),

            'approved_units' => Unit::where('approval_status', 'approved')->count(),
            'pending_units' => Unit::where('approval_status', 'pending')->count(),
            'rejected_units' => Unit::where('approval_status', 'rejected')->count(),

            // Mengikuti data existing di route sebelumnya (L/P)
            'male_santri' => SantriUnit::whereHas('santri.person', fn ($q) => $q->where('gender', 'L'))->whereNull('left_at')->count(),
            'female_santri' => SantriUnit::whereHas('santri.person', fn ($q) => $q->where('gender', 'P'))->whereNull('left_at')->count(),

            'by_jenjang' => [
                'tka' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', 'tka'))->whereNull('left_at')->count(),
                'tpa' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', 'tpa'))->whereNull('left_at')->count(),
                'tqa' => SantriUnit::whereHas('santri', fn ($q) => $q->where('jenjang_santri', 'tqa'))->whereNull('left_at')->count(),
            ],

            'by_status' => [
                'aktif' => SantriUnit::whereHas('santri', fn ($q) => $q->where('status_santri', 'aktif'))->whereNull('left_at')->count(),
                'lulus_wisuda' => SantriUnit::whereHas('santri', fn ($q) => $q->where('status_santri', 'lulus_wisuda'))->whereNull('left_at')->count(),
                'lanjut_tqa' => SantriUnit::whereHas('santri', fn ($q) => $q->where('status_santri', 'lanjut_tqa'))->whereNull('left_at')->count(),
                'pindah' => SantriUnit::whereHas('santri', fn ($q) => $q->where('status_santri', 'pindah'))->whereNull('left_at')->count(),
                'berhenti' => SantriUnit::whereHas('santri', fn ($q) => $q->where('status_santri', 'berhenti'))->whereNull('left_at')->count(),
            ],
        ];
    }
}
