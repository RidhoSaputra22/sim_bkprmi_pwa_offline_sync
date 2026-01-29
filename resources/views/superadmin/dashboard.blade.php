<x-layouts.superadmin title="Dashboard">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard SuperAdmin BKPRMI</h1>
        <p class="text-base-content/60">Pemantauan keseluruhan data sistem</p>
    </x-slot:header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-title">Total Santri</div>
            <div class="stat-value text-primary">{{ number_format($stats['total_santri']) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="stat-title">Total Unit TPA</div>
            <div class="stat-value text-secondary">{{ number_format($stats['total_units']) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-warning">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Menunggu Approval</div>
            <div class="stat-value text-warning">{{ number_format($approvalStats['pending']) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Unit Disetujui</div>
            <div class="stat-value text-success">{{ number_format($approvalStats['approved']) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Approval -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Unit Menunggu Approval
                </h2>

                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama Unit</th>
                                <th>Lokasi</th>
                                <th>Sertifikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingUnits as $unit)
                            <tr>
                                <td class="font-medium">{{ $unit->name }}</td>
                                <td class="text-sm">{{ $unit->village?->district?->city?->name ?? '-' }}</td>
                                <td>
                                    @if($unit->hasCertificate())
                                        <span class="badge badge-success badge-sm">Ada</span>
                                    @else
                                        <span class="badge badge-error badge-sm">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('superadmin.units.approval.show', $unit) }}" class="btn btn-xs btn-primary">
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-base-content/60 py-4">
                                    Tidak ada unit menunggu approval
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pendingUnits->count() > 0)
                <div class="card-actions justify-end">
                    <a href="{{ route('superadmin.units.approval.index') }}" class="btn btn-sm btn-ghost">
                        Lihat Semua
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Approval Statistics -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistik Approval
                </h2>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span>Total Unit</span>
                        <span class="font-bold">{{ $approvalStats['total_units'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="badge badge-warning badge-xs"></span> Pending
                        </span>
                        <span class="font-bold text-warning">{{ $approvalStats['pending'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="badge badge-success badge-xs"></span> Disetujui
                        </span>
                        <span class="font-bold text-success">{{ $approvalStats['approved'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="badge badge-error badge-xs"></span> Ditolak
                        </span>
                        <span class="font-bold text-error">{{ $approvalStats['rejected'] }}</span>
                    </div>
                    <div class="divider my-2"></div>
                    <div class="flex justify-between items-center">
                        <span>Dengan Sertifikat</span>
                        <span class="font-bold">{{ $approvalStats['with_certificate'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Sudah Punya Akun</span>
                        <span class="font-bold">{{ $approvalStats['with_account'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Belum Punya Akun</span>
                        <span class="font-bold">{{ $approvalStats['without_account'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Approved Units -->
        <div class="card bg-base-100 shadow lg:col-span-2">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Unit Terbaru Disetujui
                </h2>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Unit</th>
                                <th>Lokasi</th>
                                <th>Tanggal Disetujui</th>
                                <th>Status Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentApprovedUnits as $unit)
                            <tr>
                                <td class="font-medium">{{ $unit->name }}</td>
                                <td>{{ $unit->village?->district?->city?->name ?? '-' }}</td>
                                <td>{{ $unit->approved_at?->format('d M Y H:i') ?? '-' }}</td>
                                <td>
                                    @if($unit->hasAdminAccount())
                                        <span class="badge badge-success">Sudah Ada</span>
                                    @else
                                        <span class="badge badge-warning">Belum Dibuat</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-base-content/60 py-4">
                                    Belum ada unit yang disetujui
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.superadmin>
