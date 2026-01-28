<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - {{ ucfirst($type) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: normal;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        .no-print {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1e40af;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #6b7280;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 10px;
            }

            .container {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <button onclick="window.print()" class="btn">
                🖨️ Cetak Laporan
            </button>
            <a href="{{ route('member.reports.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>

        <div class="header">
            <h1>BKPRMI - Sistem Informasi Manajemen</h1>
            <h2>Laporan {{ ucfirst($type) }}</h2>
        </div>

        <div class="info">
            <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
            @if($type == 'santri')
                <p><strong>Total Data:</strong> {{ $santris->count() ?? 0 }} Santri</p>
            @elseif($type == 'activity')
                <p><strong>Total Data:</strong> {{ $activities->count() ?? 0 }} Kegiatan</p>
            @elseif($type == 'unit')
                <p><strong>Total Data:</strong> {{ $units->count() ?? 0 }} Unit</p>
            @endif
        </div>

        @if($type == 'santri')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Unit</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santris ?? [] as $index => $santri)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $santri->person->full_name ?? '-' }}</td>
                            <td>{{ $santri->santriUnits->first()?->unit?->name ?? '-' }}</td>
                            <td>{{ $santri->jenjang?->getLabel() ?? '-' }}</td>
                            <td>{{ $santri->status?->getLabel() ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type == 'activity')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Unit</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities ?? [] as $index => $activity)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $activity->name ?? $activity->title ?? '-' }}</td>
                            <td>{{ $activity->unit->name ?? '-' }}</td>
                            <td>{{ $activity->start_date?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $activity->end_date?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type == 'unit')
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Unit</th>
                        <th>Nama Unit</th>
                        <th>Region</th>
                        <th>Alamat</th>
                        <th>Total Santri</th>
                        <th>Total Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units ?? [] as $index => $unit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $unit->unit_number ?? '-' }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->region->name ?? '-' }}</td>
                            <td>{{ $unit->village->name ?? '-' }}</td>
                            <td>{{ ($unit->jumlah_tka_4_7 ?? 0) + ($unit->jumlah_tpa_7_12 ?? 0) + ($unit->jumlah_tqa_wisuda ?? 0) }}</td>
                            <td>{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <div class="footer">
            <p>Dicetak dari Sistem Informasi Manajemen BKPRMI</p>
            <p>© {{ date('Y') }} BKPRMI</p>
        </div>
    </div>
</body>
</html>
