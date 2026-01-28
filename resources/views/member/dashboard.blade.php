<x-layouts.member title="Dashboard Member">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard Anggota BKPRMI</h1>
        <p class="text-base-content/60">Selamat datang, {{ auth()->user()->person?->full_name ?? auth()->user()->email }}</p>
    </x-slot:header>

    <!-- Statistics Cards -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-6">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="stat-title">Total Unit</div>
            <div class="stat-value text-primary">{{ $totalUnits }}</div>
            <div class="stat-desc">Unit TPA/TPQ Aktif</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="stat-title">Total Kegiatan</div>
            <div class="stat-value text-secondary">{{ $totalActivities }}</div>
            <div class="stat-desc">Kegiatan Terdaftar</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-accent">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Kegiatan Terbaru</div>
            <div class="stat-value text-accent">{{ $recentActivities->count() }}</div>
            <div class="stat-desc">5 Kegiatan Terakhir</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card bg-base-100 shadow-md mb-6">
        <div class="card-body">
            <h2 class="card-title">Akses Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <a href="{{ route('member.organization.index') }}" class="btn btn-outline btn-primary gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informasi Organisasi
                </a>

                <a href="{{ route('member.activities.index') }}" class="btn btn-outline btn-secondary gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Data Kegiatan
                </a>

                <a href="{{ route('member.reports.index') }}" class="btn btn-outline btn-accent gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Unduh Laporan
                </a>

                <a href="{{ route('member.organization.index') }}" class="btn btn-outline btn-info gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Struktur Organisasi
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card bg-base-100 shadow-md">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Kegiatan Terbaru</h2>
                <a href="{{ route('member.activities.index') }}" class="btn btn-ghost btn-sm">
                    Lihat Semua →
                </a>
            </div>

            @if($recentActivities->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start gap-4 p-4 bg-base-200 rounded-lg">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-lg w-12 h-12 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold">
                                    <a href="{{ route('member.activities.show', $activity) }}" class="hover:text-primary">
                                        {{ $activity->name ?? $activity->title ?? 'Kegiatan' }}
                                    </a>
                                </h3>
                                <p class="text-sm text-base-content/60 mt-1">
                                    {{ Str::limit($activity->description ?? '', 100) }}
                                </p>
                                <div class="flex items-center gap-4 mt-2 text-xs text-base-content/50">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $activity->unit->name ?? 'N/A' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $activity->start_date?->format('d/m/Y') ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-base-content/50">Belum ada kegiatan terbaru</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.member>
