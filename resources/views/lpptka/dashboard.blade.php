<x-layouts.lpptka title="Dashboard Admin LPPTKA">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard Admin LPPTKA</h1>
        <p class="text-base-content/60">Selamat datang, {{ auth()->user()->person?->full_name ?? 'Admin' }}</p>
    </x-slot:header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="stat-title">Total Unit TPA</div>
            <div class="stat-value text-primary">{{ $stats['total_units'] }}</div>
            <div class="stat-desc">Unit terdaftar</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-warning">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Menunggu Approval</div>
            <div class="stat-value text-warning">{{ $stats['pending_units'] }}</div>
            <div class="stat-desc">Perlu diproses SuperAdmin</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Sudah Disetujui</div>
            <div class="stat-value text-success">{{ $stats['approved_units'] }}</div>
            <div class="stat-desc">Siap buat akun</div>
        </div>

        <div class="stat bg-base-100 shadow rounded-box">
            <div class="stat-figure text-info">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="stat-title">Akun TPA Aktif</div>
            <div class="stat-value text-info">{{ $stats['active_accounts'] }}</div>
            <div class="stat-desc">Admin TPA terdaftar</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Unit Siap Buat Akun -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Unit Siap Buat Akun</h2>
                    <a href="{{ route('lpptka.tpa-accounts.index') }}" class="btn btn-ghost btn-sm">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @forelse($readyForAccount as $unit)
                <div class="flex items-center justify-between py-3 border-b border-base-200 last:border-0">
                    <div>
                        <p class="font-medium">{{ $unit->name }}</p>
                        <p class="text-sm text-base-content/60">{{ $unit->unit_number }}</p>
                    </div>
                    <a href="{{ route('lpptka.tpa-accounts.create', $unit) }}" class="btn btn-primary btn-sm">
                        Buat Akun
                    </a>
                </div>
                @empty
                <div class="text-center py-8 text-base-content/60">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p>Belum ada unit siap buat akun</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Unit Terbaru -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Unit Terbaru</h2>
                    <a href="{{ route('lpptka.units.index') }}" class="btn btn-ghost btn-sm">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @forelse($recentUnits as $unit)
                <div class="flex items-center justify-between py-3 border-b border-base-200 last:border-0">
                    <div>
                        <p class="font-medium">{{ $unit->name }}</p>
                        <p class="text-sm text-base-content/60">{{ $unit->created_at->format('d M Y') }}</p>
                    </div>
                    <span class="badge badge-{{ $unit->approval_status->getColor() }}">
                        {{ $unit->approval_status->getLabel() }}
                    </span>
                </div>
                @empty
                <div class="text-center py-8 text-base-content/60">
                    <p>Belum ada unit terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('lpptka.units.create') }}" class="card bg-primary text-primary-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <h3 class="card-title">Daftar Unit TPA Baru</h3>
                    <p class="text-sm opacity-80">Input profil TPA baru ke sistem</p>
                </div>
            </a>

            <a href="{{ route('lpptka.units.index') }}" class="card bg-secondary text-secondary-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <h3 class="card-title">Daftar Unit</h3>
                    <p class="text-sm opacity-80">Lihat dan kelola semua unit TPA</p>
                </div>
            </a>

            <a href="{{ route('lpptka.tpa-accounts.index') }}" class="card bg-accent text-accent-content shadow hover:shadow-lg transition-shadow">
                <div class="card-body items-center text-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="card-title">Kelola Akun TPA</h3>
                    <p class="text-sm opacity-80">Buat dan kelola akun admin TPA</p>
                </div>
            </a>
        </div>
    </div>
</x-layouts.lpptka>
