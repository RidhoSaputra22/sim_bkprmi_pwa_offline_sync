<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Santri</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA SANTRI</h1>
        <p>BKPRMI - Badan Koordinasi Pendidikan Remaja Masjid Indonesia</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
        <p><strong>Jumlah Data:</strong> {{ $santris->count() }} santri</p>
    </div>

    @if($santris->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Jenjang</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($santris as $index => $santri)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $santri->person->nama ?? '-' }}</td>
                        <td>{{ $santri->person->jenis_kelamin?->value ?? '-' }}</td>
                        <td>
                            {{ $santri->person->tempat_lahir ?? '-' }},
                            {{ $santri->person->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                        </td>
                        <td>{{ $santri->jenjang_santri?->value ?? '-' }}</td>
                        <td>{{ $santri->kelas_mengaji?->value ?? '-' }}</td>
                        <td>{{ $santri->status_santri?->value ?? '-' }}</td>
                        <td>
                            @if($santri->santriUnits->isNotEmpty())
                                {{ $santri->santriUnits->first()->unit->name ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data santri yang tersedia.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
