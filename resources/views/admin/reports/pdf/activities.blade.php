<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Data Kegiatan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Unit</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $index => $activity)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $activity->title }}</td>
                <td>{{ $activity->unit?->name ?? '-' }}</td>
                <td>{{ $activity->activity_date?->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
