<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Laporan BKPRMI</title>
    <style>
        :root { color-scheme: light; }
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif; margin: 24px; color: #111827; }
        .header { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; margin-bottom: 18px; }
        h1 { font-size: 20px; margin: 0; }
        .muted { color: #6b7280; font-size: 12px; }
        h2 { font-size: 14px; margin: 18px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #e5e7eb; padding: 8px 10px; }
        td:last-child { text-align: right; font-weight: 700; }
        .actions { margin: 12px 0 18px; }
        .btn { display: inline-block; padding: 8px 12px; border: 1px solid #111827; border-radius: 6px; text-decoration: none; color: #111827; }
        @media print {
            .actions { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="actions">
        <a class="btn" href="#" onclick="window.print(); return false;">Print</a>
        <a class="btn" href="{{ route('superadmin.reports.index') }}">Kembali</a>
    </div>

    <div class="header">
        <div>
            <h1>Laporan & Statistik Sistem BKPRMI</h1>
            <div class="muted">Generated: {{ $generatedAt?->format('d M Y H:i') }}</div>
        </div>
    </div>

    <h2>Ringkasan</h2>
    <table>
        <tr><td>Total Santri</td><td>{{ number_format($stats['total_santri'] ?? 0) }}</td></tr>
        <tr><td>Total Unit TPA</td><td>{{ number_format($stats['total_units'] ?? 0) }}</td></tr>
        <tr><td>Kota/Kabupaten</td><td>{{ number_format($stats['total_cities'] ?? 0) }}</td></tr>
        <tr><td>Unit Aktif (Approved)</td><td>{{ number_format($stats['approved_units'] ?? 0) }}</td></tr>
    </table>

    <h2>Santri per Jenjang</h2>
    <table>
        <tr><td>TKA</td><td>{{ number_format($stats['by_jenjang']['tka'] ?? 0) }}</td></tr>
        <tr><td>TPA</td><td>{{ number_format($stats['by_jenjang']['tpa'] ?? 0) }}</td></tr>
        <tr><td>TQA</td><td>{{ number_format($stats['by_jenjang']['tqa'] ?? 0) }}</td></tr>
    </table>

    <h2>Santri per Jenis Kelamin</h2>
    <table>
        <tr><td>Laki-laki</td><td>{{ number_format($stats['male_santri'] ?? 0) }}</td></tr>
        <tr><td>Perempuan</td><td>{{ number_format($stats['female_santri'] ?? 0) }}</td></tr>
    </table>

    <h2>Status Approval Unit</h2>
    <table>
        <tr><td>Pending</td><td>{{ number_format($stats['pending_units'] ?? 0) }}</td></tr>
        <tr><td>Disetujui</td><td>{{ number_format($stats['approved_units'] ?? 0) }}</td></tr>
        <tr><td>Ditolak</td><td>{{ number_format($stats['rejected_units'] ?? 0) }}</td></tr>
        <tr><td>Total Unit</td><td>{{ number_format($stats['total_units'] ?? 0) }}</td></tr>
    </table>

    <h2>Status Santri</h2>
    <table>
        <tr><td>Masih Aktif</td><td>{{ number_format($stats['by_status']['aktif'] ?? 0) }}</td></tr>
        <tr><td>Lulus Wisuda TPA</td><td>{{ number_format($stats['by_status']['lulus_wisuda'] ?? 0) }}</td></tr>
        <tr><td>Lanjut TQA</td><td>{{ number_format($stats['by_status']['lanjut_tqa'] ?? 0) }}</td></tr>
        <tr><td>Pindah</td><td>{{ number_format($stats['by_status']['pindah'] ?? 0) }}</td></tr>
        <tr><td>Berhenti</td><td>{{ number_format($stats['by_status']['berhenti'] ?? 0) }}</td></tr>
    </table>

    <script>
        // Auto-open print dialog for convenience
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 200);
        });
    </script>
</body>
</html>
