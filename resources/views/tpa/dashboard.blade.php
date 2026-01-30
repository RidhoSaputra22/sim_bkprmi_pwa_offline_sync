<x-layouts.tpa title="Dashboard Admin TPA">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard Admin TPA</h1>
        <p class="text-base-content/60">Unit: {{ $unit->name ?? 'Tidak ada unit' }}</p>
    </x-slot:header>

    @if($unit)
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-title">Total Santri</div>
            <div class="stat-value text-primary">{{ $stats['total_santri'] }}</div>
            <div class="stat-desc">Terdaftar di unit</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Santri Aktif</div>
            <div class="stat-value text-success">{{ $stats['active_santri'] }}</div>
            <div class="stat-desc">Sedang belajar</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-info">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="stat-title">Laki-laki</div>
            <div class="stat-value text-info">{{ $stats['male_santri'] }}</div>
            <div class="stat-desc">Santri putra</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="stat-title">Perempuan</div>
            <div class="stat-value text-secondary">{{ $stats['female_santri'] }}</div>
            <div class="stat-desc">Santri putri</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Santri Terbaru -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Santri Terbaru</h2>
                    <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost btn-sm">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @forelse($recentSantri as $santri)
                <div class="flex items-center justify-between py-3 border-b border-base-200 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div
                                class="bg-neutral text-neutral-content rounded-full w-10 flex items-center justify-center font-bold">
                                <span>{{ substr($santri->person?->full_name ?? 'S', 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium">{{ $santri->person?->full_name ?? '-' }}</p>
                            <p class="text-sm text-base-content/60">{{ $santri->jenjang?->getLabel() ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="badge badge-{{ $santri->status?->getColor() ?? 'ghost' }} badge-outline">
                        {{ $santri->status?->getLabel() ?? '-' }}
                    </span>
                </div>
                @empty
                <div class="text-center py-8 text-base-content/60">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p>Belum ada data santri</p>
                    <a href="{{ route('tpa.santri.create') }}" class="btn btn-primary btn-sm mt-4">
                        Tambah Santri Pertama
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Statistik per Jenjang -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Statistik per Jenjang</h2>

                <div class="space-y-3 mt-4">
                    @foreach($stats['by_jenjang'] as $jenjang => $count)
                    <div class="flex justify-between items-center">
                        <span>{{ $jenjang }}</span>
                        <span class="badge badge-primary">{{ $count }}</span>
                    </div>
                    @endforeach

                    @if(empty($stats['by_jenjang']))
                    <p class="text-center text-base-content/60 py-4">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('tpa.santri.create') }}"
                class="card bg-primary text-primary-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <h3 class="card-title">Tambah Santri</h3>
                    <p class="text-sm opacity-80">Daftarkan santri baru</p>
                </div>
            </a>

            <a href="{{ route('tpa.santri.index') }}"
                class="card bg-secondary text-secondary-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <h3 class="card-title">Daftar Santri</h3>
                    <p class="text-sm opacity-80">Kelola data santri</p>
                </div>
            </a>

            <a href="{{ route('tpa.teachers.index') }}"
                class="card bg-info text-info-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="card-title">Daftar Guru</h3>
                    <p class="text-sm opacity-80">Kelola data guru</p>
                </div>
            </a>

            <a href="{{ route('tpa.unit.show') }}"
                class="card bg-accent text-accent-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="card-title">Profil Unit</h3>
                    <p class="text-sm opacity-80">Lihat data unit TPA</p>
                </div>
            </a>
        </div>
    </div>
    @else
    <!-- No Unit Assigned -->
    <div class="card bg-base-100 shadow">
        <div class="card-body text-center py-16">
            <svg class="w-20 h-20 mx-auto text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h2 class="text-2xl font-bold mt-4">Tidak Ada Unit</h2>
            <p class="text-base-content/60 mt-2">Akun Anda belum terhubung dengan unit TPA manapun.</p>
            <p class="text-sm text-base-content/40 mt-1">Silakan hubungi Admin LPPTKA untuk bantuan.</p>
        </div>
    </div>
    @endif
</x-layouts.tpa>
