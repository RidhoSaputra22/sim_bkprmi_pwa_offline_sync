<x-layouts.admin title="Dashboard">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p class="text-base-content/60">Selamat datang di Sistem Informasi BKPRMI</p>
    </x-slot:header>

    <!-- Stats Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-6">
        <x-ui.stat title="Total Santri" :value="$stats['total_santri']">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </x-slot:icon>
        </x-ui.stat>

        <x-ui.stat title="Total Unit TPA/TPQ" :value="$stats['total_units']">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </x-slot:icon>
        </x-ui.stat>

        <x-ui.stat title="Total Kegiatan" :value="$stats['total_activities']">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-ui.stat>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <x-ui.card title="Kegiatan Terbaru">
            <div class="space-y-4">
                @forelse($stats['recent_activities'] as $activity)
                <div class="flex items-start gap-4">
                    <div class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-10 flex items-center justify-center">
                            <span class="text-xs">{{ substr($activity->title, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium">{{ $activity->title }}</h4>
                        <p class="text-sm text-base-content/60">
                            {{ $activity->unit?->name ?? 'Unit tidak diketahui' }}
                        </p>
                        <p class="text-xs text-base-content/50">
                            {{ $activity->activity_date->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-center text-base-content/60 py-4">Belum ada kegiatan</p>
                @endforelse
            </div>

            <x-slot:actions>
                <x-ui.button type="ghost" size="sm" href="{{ route('admin.activities.index') }}">
                    Lihat Semua
                </x-ui.button>
            </x-slot:actions>
        </x-ui.card>

        <!-- Quick Actions -->
        <x-ui.card title="Aksi Cepat">
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.santri.create') }}" class="btn btn-outline btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Santri
                </a>

                <a href="{{ route('admin.activities.create') }}" class="btn btn-outline btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Kegiatan
                </a>

                <a href="{{ route('admin.units.create') }}" class="btn btn-outline btn-accent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Unit
                </a>

                <a href="{{ route('admin.reports.santri') }}" class="btn btn-outline">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Lihat Laporan
                </a>
            </div>
        </x-ui.card>
    </div>
</x-layouts.admin>
