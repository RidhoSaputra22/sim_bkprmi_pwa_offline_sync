<x-layouts.lpptka title="Daftar Unit TPA">
    <x-slot:header>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Daftar Unit TPA</h1>
                <p class="text-base-content/60">Kelola semua unit TPA dalam sistem</p>
            </div>
            <a href="{{ route('lpptka.units.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Unit
            </a>
        </div>
    </x-slot:header>

    <!-- Filters -->
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <form action="{{ route('lpptka.units.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="form-control flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="input input-bordered" placeholder="Cari nama/nomor unit...">
                </div>

                <div class="form-control w-40">
                    <select name="status" class="select select-bordered">
                        <option value="">Semua Status</option>
                        @foreach(\App\Enum\StatusApprovalUnit::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->getLabel() }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>

                @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('lpptka.units.index') }}" class="btn btn-ghost">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Units Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No. Unit</th>
                            <th>Nama Unit</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Sertifikat</th>
                            <th>Akun TPA</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                        <tr>
                            <td class="font-mono">{{ $unit->unit_number }}</td>
                            <td>
                                <div class="font-medium">{{ $unit->name }}</div>
                                <div class="text-sm text-base-content/60">{{ $unit->mosque_name ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ $unit->village?->district?->city?->name ?? '-' }}
                                </div>
                                <div class="text-xs text-base-content/60">
                                    {{ $unit->village?->district?->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $unit->approval_status->getColor() }}">
                                    {{ $unit->approval_status->getLabel() }}
                                </span>
                            </td>
                            <td>
                                @if($unit->hasCertificate())
                                <span class="badge badge-success badge-outline">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Ada
                                </span>
                                @else
                                <span class="badge badge-error badge-outline">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Belum
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($unit->hasAdminAccount())
                                <span class="badge badge-info badge-outline">Aktif</span>
                                @elseif($unit->canCreateAdminAccount())
                                <a href="{{ route('lpptka.tpa-accounts.create', $unit) }}" class="btn btn-xs btn-primary">
                                    Buat Akun
                                </a>
                                @else
                                <span class="text-base-content/40">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('lpptka.units.show', $unit) }}" class="btn btn-ghost btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('lpptka.units.edit', $unit) }}" class="btn btn-ghost btn-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/60">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Belum ada data unit TPA</p>
                                <a href="{{ route('lpptka.units.create') }}" class="btn btn-primary btn-sm mt-4">
                                    Tambah Unit Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($units->hasPages())
            <div class="mt-6">
                {{ $units->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.lpptka>
