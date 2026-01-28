<x-layouts.admin title="Laporan Unit">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Laporan Unit</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Laporan Unit TPA/TPQ</h1>
                <p class="text-base-content/60">Ringkasan data unit</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="btn btn-ghost">Cetak</button>
                <x-ui.button type="primary">Unduh PDF</x-ui.button>
            </div>
        </div>
    </x-slot:header>

    <!-- Summary Stats -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-6">
        <x-ui.stat title="Total Unit" :value="$stats['total']" />
        <x-ui.stat title="Total Santri" :value="$stats['total_santri']" />
        <x-ui.stat title="Total Guru" :value="$stats['total_guru']" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- By Tipe Lokasi -->
        <x-ui.card title="Berdasarkan Tipe Lokasi">
            <div class="space-y-4">
                @foreach($stats['by_tipe'] as $tipe => $count)
                    <div class="flex items-center gap-4">
                        <span class="w-32 text-sm">{{ ucfirst($tipe) }}</span>
                        <progress class="progress progress-primary flex-1" value="{{ $count }}" max="{{ $stats['total'] }}"></progress>
                        <span class="font-bold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <!-- By Status Bangunan -->
        <x-ui.card title="Berdasarkan Status Bangunan">
            <div class="space-y-4">
                @foreach($stats['by_status'] as $status => $count)
                    <div class="flex items-center gap-4">
                        <span class="w-32 text-sm">{{ ucfirst($status) }}</span>
                        <progress class="progress progress-secondary flex-1" value="{{ $count }}" max="{{ $stats['total'] }}"></progress>
                        <span class="font-bold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    </div>

    <!-- Data Table -->
    <x-ui.card title="Daftar Unit">
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
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
                    @forelse($units as $index => $unit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</td>
                            <td>{{ $unit->jumlah_tka_4_7 ?? 0 }}</td>
                            <td>{{ $unit->jumlah_tpa_7_12 ?? 0 }}</td>
                            <td>{{ $unit->jumlah_tqa_wisuda ?? 0 }}</td>
                            <td>{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layouts.admin>
