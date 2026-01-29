<x-layouts.superadmin title="Daftar Unit TPA">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Daftar Unit TPA</h1>
        <p class="text-base-content/60">Kelola dan pantau semua unit TPA yang terdaftar</p>
    </x-slot:header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="stat-title">Total Unit</div>
            <div class="stat-value text-primary">{{ number_format($stats['total'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Unit Disetujui</div>
            <div class="stat-value text-success">{{ number_format($stats['approved'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-warning">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Menunggu Approval</div>
            <div class="stat-value text-warning">{{ number_format($stats['pending'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-error">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Unit Ditolak</div>
            <div class="stat-value text-error">{{ number_format($stats['rejected'] ?? 0) }}</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="form-control">
                    <label class="label"><span class="label-text">Status Approval</span></label>
                    <select name="status" class="select select-bordered">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Provinsi</span></label>
                    <select name="province_id" class="select select-bordered">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces ?? [] as $province)
                            <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Cari</span></label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama unit, nomor unit..." class="input input-bordered">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </button>
                <a href="{{ route('superadmin.units.index') }}" class="btn btn-ghost">Reset</a>
            </form>
        </div>
    </div>

    <!-- Units Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Unit</th>
                            <th>Nama Unit</th>
                            <th>Lokasi</th>
                            <th>Kepala Unit</th>
                            <th>Total Santri</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units ?? [] as $unit)
                        <tr>
                            <td class="font-mono">{{ $unit->unit_number ?? '-' }}</td>
                            <td>
                                <div class="font-medium">{{ $unit->name }}</div>
                                <div class="text-sm text-base-content/60">{{ $unit->email ?? '-' }}</div>
                            </td>
                            <td class="text-sm">
                                <div>{{ $unit->village?->name ?? '-' }}</div>
                                <div class="text-base-content/60">
                                    {{ $unit->village?->district?->city?->name ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $unit->unitHead?->person?->full_name ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge badge-info badge-lg">{{ $unit->santris_count ?? 0 }}</span>
                            </td>
                            <td>
                                @if($unit->approval_status)
                                    <span class="badge badge-{{ $unit->approval_status->getColor() }}">
                                        {{ $unit->approval_status->getLabel() }}
                                    </span>
                                @else
                                    <span class="badge badge-ghost">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-sm btn-ghost">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </div>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li>
                                            <a href="{{ route('superadmin.units.approval.show', $unit) }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Lihat Detail
                                            </a>
                                        </li>
                                        @if($unit->hasCertificate())
                                        <li>
                                            <a href="{{ route('superadmin.units.approval.certificate', $unit) }}" target="_blank">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Lihat Sertifikat
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/60">
                                <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p>Tidak ada unit yang ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($units) && $units->hasPages())
            <div class="mt-4">
                {{ $units->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.superadmin>
