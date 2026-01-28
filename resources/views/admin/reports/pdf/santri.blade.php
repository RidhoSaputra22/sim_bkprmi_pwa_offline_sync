<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Santri</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Data Santri</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jenjang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($santri as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->person->full_name ?? '-' }}</td>
                <td>{{ $s->person->nik ?? '-' }}</td>
                <td>{{ $s->jenjang_santri?->getLabel() ?? '-' }}</td>
                <td>{{ $s->status_santri?->getLabel() ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
