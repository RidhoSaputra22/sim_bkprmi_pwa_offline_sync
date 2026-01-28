<x-layouts.member title="Informasi Organisasi">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Informasi Organisasi BKPRMI</h1>
        <p class="text-base-content/60">Informasi lengkap tentang struktur dan data organisasi</p>
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
            <div class="stat-value text-primary">{{ $statistics['total_units'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
            </div>
            <div class="stat-title">Total Region</div>
            <div class="stat-value text-secondary">{{ $statistics['total_regions'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-accent">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Total Santri</div>
            <div class="stat-value text-accent">{{ number_format($statistics['total_santri']) }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-info">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="stat-title">Total Guru</div>
            <div class="stat-value text-info">{{ number_format($statistics['total_guru']) }}</div>
        </div>
    </div>

    <!-- Regions List -->
    <div class="space-y-6">
        @forelse($regions as $region)
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="card-title">{{ $region->name }}</h2>
                            <p class="text-sm text-base-content/60">
                                {{ $region->units->count() }} Unit TPA/TPQ
                            </p>
                        </div>
                        <div class="badge badge-primary badge-lg">
                            {{ $region->province->name ?? 'N/A' }}
                        </div>
                    </div>

                    @if($region->units->count() > 0)
                        <div class="divider"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($region->units as $unit)
                                <div class="card bg-base-200">
                                    <div class="card-body p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="badge badge-primary badge-outline">{{ $unit->unit_number }}</div>
                                            <a href="{{ route('member.organization.unit.show', $unit) }}" class="btn btn-ghost btn-xs btn-circle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>

                                        <h3 class="font-semibold mt-2">{{ $unit->name }}</h3>

                                        <div class="space-y-1 text-sm text-base-content/60 mt-2">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $unit->village->name ?? 'N/A' }}</span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                <span>{{ ($unit->jumlah_tka_4_7 ?? 0) + ($unit->jumlah_tpa_7_12 ?? 0) + ($unit->jumlah_tqa_wisuda ?? 0) }} Santri</span>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span>{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }} Guru</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-base-content/50">
                            Belum ada unit di region ini
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card bg-base-100 shadow-md">
                <div class="card-body text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-base-content/50">Belum ada data organisasi tersedia</p>
                </div>
            </div>
        @endforelse
    </div>
</x-layouts.member>
