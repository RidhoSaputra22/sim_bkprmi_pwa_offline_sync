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
                <x-ui.button type="primary">Unduh PDF</x-ui.button>
            </div>
        </div>
    </x-slot:header>

    <!-- Filter -->
    <x-ui.card class="mb-6" :compact="true">
        <form method="GET" class="flex flex-wrap gap-4">
            <select name="unit_id" class="select select-bordered select-sm">
                <option value="">Semua Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
            <select name="year" class="select select-bordered select-sm">
                <option value="">Tahun</option>
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <select name="month" class="select select-bordered select-sm">
                <option value="">Bulan</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
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
