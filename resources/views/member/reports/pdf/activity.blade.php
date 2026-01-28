<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Kegiatan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
        }
        .info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .description {
            max-width: 200px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA KEGIATAN</h1>
        <p>BKPRMI - Badan Koordinasi Pendidikan Remaja Masjid Indonesia</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
        <p><strong>Jumlah Data:</strong> {{ $activities->count() }} kegiatan</p>
    </div>

    @if($activities->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Judul Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $index => $activity)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activity->title ?? '-' }}</td>
                        <td class="description">{{ Str::limit($activity->description, 100) ?? '-' }}</td>
                        <td>{{ $activity->activity_date?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $activity->unit->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data kegiatan yang tersedia.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
