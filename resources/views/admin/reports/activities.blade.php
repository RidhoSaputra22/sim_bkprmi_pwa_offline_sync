<x-layouts.admin title="Laporan Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Laporan Kegiatan</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Laporan Kegiatan</h1>
                <p class="text-base-content/60">Ringkasan kegiatan TPA/TPQ</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="btn btn-ghost">Cetak</button>
                <form method="POST" action="{{ route('admin.reports.export', ['type' => 'activities']) }}" target="_blank">
                    @csrf
                    <input type="hidden" name="format" value="pdf">
                    <x-ui.button type="primary">Unduh PDF</x-ui.button>
                </form>
            </div>
        </div>
    </x-slot:header>

    <!-- Filter -->
    <x-ui.card class="mb-6" :compact="true">
        <form method="GET" class="flex flex-wrap gap-4">
            <x-ui.select
                name="unit_id"
                :options="$units->map(fn($u) => ['value' => $u->id, 'label' => $u->name])->toArray()"
                :value="request('unit_id')"
                placeholder="Semua Unit"
                class="select-sm"
            />

            <x-ui.select
                name="year"
                :options="collect(range(date('Y'), date('Y') - 5))->map(fn($y) => ['value' => $y, 'label' => $y])->toArray()"
                :value="request('year')"
                placeholder="Tahun"
                class="select-sm"
            />

            <x-ui.select
                name="month"
                :options="collect(range(1, 12))->map(fn($m) => ['value' => $m, 'label' => \Carbon\Carbon::create()->month($m)->translatedFormat('F')])->toArray()"
                :value="request('month')"
                placeholder="Bulan"
                class="select-sm"
            />

            <x-ui.button type="primary" size="sm">Filter</x-ui.button>
        </form>
    </x-ui.card>

    <!-- Summary -->
    <div class="stats shadow w-full mb-6">
        <x-ui.stat title="Total Kegiatan" :value="$stats['total']" />
    </div>

    <!-- By Unit -->
    <x-ui.card title="Kegiatan per Unit" class="mb-6">
        <div class="space-y-4">
            @foreach($stats['by_unit'] as $unitName => $count)
                <div class="flex items-center gap-4">
                    <span class="w-48 text-sm truncate">{{ $unitName }}</span>
                    <progress class="progress progress-primary flex-1" value="{{ $count }}" max="{{ $stats['total'] }}"></progress>
                    <span class="font-bold">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </x-ui.card>

    <!-- Data Table -->
    <x-ui.card title="Daftar Kegiatan">
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Unit</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $activity)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $activity->title }}</td>
                            <td>{{ $activity->unit?->name ?? '-' }}</td>
                            <td>{{ $activity->activity_date?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layouts.admin>
