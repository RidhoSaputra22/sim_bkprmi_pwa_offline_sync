<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan BKPRMI</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .subtitle { color: #6b7280; margin-bottom: 16px; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .grid td { padding: 8px 10px; border: 1px solid #e5e7eb; }
        .section { font-size: 14px; font-weight: 700; margin: 18px 0 8px; }
        .kv { width: 100%; border-collapse: collapse; }
        .kv td { padding: 6px 10px; border: 1px solid #e5e7eb; }
        .key { width: 55%; }
        .val { width: 45%; text-align: right; font-weight: 700; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <div class="title">Laporan & Statistik Sistem BKPRMI</div>
    <div class="subtitle">Generated: <span class="muted">{{ $generatedAt?->format('d M Y H:i') }}</span></div>

    <div class="section">Ringkasan</div>
    <table class="kv">
        <tr>
            <td class="key">Total Santri</td>
            <td class="val">{{ number_format($stats['total_santri'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Total Unit TPA</td>
            <td class="val">{{ number_format($stats['total_units'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Kota/Kabupaten</td>
            <td class="val">{{ number_format($stats['total_cities'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Unit Aktif (Approved)</td>
            <td class="val">{{ number_format($stats['approved_units'] ?? 0) }}</td>
        </tr>
    </table>

    <div class="section">Santri per Jenjang</div>
    <table class="kv">
        <tr>
            <td class="key">TKA</td>
            <td class="val">{{ number_format($stats['by_jenjang']['tka'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">TPA</td>
            <td class="val">{{ number_format($stats['by_jenjang']['tpa'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">TQA</td>
            <td class="val">{{ number_format($stats['by_jenjang']['tqa'] ?? 0) }}</td>
        </tr>
    </table>

    <div class="section">Santri per Jenis Kelamin</div>
    <table class="kv">
        <tr>
            <td class="key">Laki-laki</td>
            <td class="val">{{ number_format($stats['male_santri'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Perempuan</td>
            <td class="val">{{ number_format($stats['female_santri'] ?? 0) }}</td>
        </tr>
    </table>

    <div class="section">Status Approval Unit</div>
    <table class="kv">
        <tr>
            <td class="key">Pending</td>
            <td class="val">{{ number_format($stats['pending_units'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Disetujui</td>
            <td class="val">{{ number_format($stats['approved_units'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Ditolak</td>
            <td class="val">{{ number_format($stats['rejected_units'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Total Unit</td>
            <td class="val">{{ number_format($stats['total_units'] ?? 0) }}</td>
        </tr>
    </table>

    <div class="section">Status Santri</div>
    <table class="kv">
        <tr>
            <td class="key">Masih Aktif</td>
            <td class="val">{{ number_format($stats['by_status']['aktif'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Lulus Wisuda TPA</td>
            <td class="val">{{ number_format($stats['by_status']['lulus_wisuda'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Lanjut TQA</td>
            <td class="val">{{ number_format($stats['by_status']['lanjut_tqa'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Pindah</td>
            <td class="val">{{ number_format($stats['by_status']['pindah'] ?? 0) }}</td>
        </tr>
        <tr>
            <td class="key">Berhenti</td>
            <td class="val">{{ number_format($stats['by_status']['berhenti'] ?? 0) }}</td>
        </tr>
    </table>
</body>
</html>
