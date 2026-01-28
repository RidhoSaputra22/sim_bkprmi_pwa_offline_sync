<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Unit</title>
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
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA UNIT</h1>
        <p>BKPRMI - Badan Koordinasi Pendidikan Remaja Masjid Indonesia</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
        <p><strong>Jumlah Data:</strong> {{ $units->count() }} unit</p>
    </div>

    @if($units->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Unit</th>
                    <th>Wilayah</th>
                    <th>Alamat</th>
                    <th class="text-center">TKA</th>
                    <th class="text-center">TPA</th>
                    <th class="text-center">TQA</th>
                    <th class="text-center">Guru L</th>
                    <th class="text-center">Guru P</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $index => $unit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $unit->name ?? '-' }}</td>
                        <td>{{ $unit->region->village->name ?? '-' }}</td>
                        <td>{{ $unit->alamat ?? '-' }}</td>
                        <td class="text-center">{{ $unit->jumlah_tka_4_7 ?? 0 }}</td>
                        <td class="text-center">{{ $unit->jumlah_tpa_7_12 ?? 0 }}</td>
                        <td class="text-center">{{ $unit->jumlah_tqa_wisuda ?? 0 }}</td>
                        <td class="text-center">{{ $unit->jumlah_guru_laki_laki ?? 0 }}</td>
                        <td class="text-center">{{ $unit->jumlah_guru_perempuan ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align: right;">Total:</th>
                    <th class="text-center">{{ $units->sum('jumlah_tka_4_7') }}</th>
                    <th class="text-center">{{ $units->sum('jumlah_tpa_7_12') }}</th>
                    <th class="text-center">{{ $units->sum('jumlah_tqa_wisuda') }}</th>
                    <th class="text-center">{{ $units->sum('jumlah_guru_laki_laki') }}</th>
                    <th class="text-center">{{ $units->sum('jumlah_guru_perempuan') }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data unit yang tersedia.</p>
        </div>
    @endif

    <div class="footer">
        <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
