<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Unit</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Data Unit</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Unit</th>
                <th>Tipe Lokasi</th>
                <th>TKA</th>
                <th>TPA</th>
                <th>TQA</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $index => $unit)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $unit->name }}</td>
                <td>{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</td>
                <td>{{ $unit->jumlah_tka_4_7 ?? 0 }}</td>
                <td>{{ $unit->jumlah_tpa_7_12 ?? 0 }}</td>
                <td>{{ $unit->jumlah_tqa_wisuda ?? 0 }}</td>
                <td>{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
