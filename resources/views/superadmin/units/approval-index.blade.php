<x-layouts.superadmin title="Approval Unit TPA">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Approval Unit TPA</h1>
        <p class="text-base-content/60">Review dan setujui unit TPA yang diajukan</p>
    </x-slot:header>

    <!-- Filter -->
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="form-control">
                    <label class="label"><span class="label-text">Status</span></label>
                    <select name="status" class="select select-bordered">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->getLabel() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Cari</span></label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama unit..." class="input input-bordered">
                </div>
                <div class="form-control">
                    <label class="label cursor-pointer gap-2">
                        <input type="checkbox" name="with_certificate" value="1" class="checkbox checkbox-primary" {{ request('with_certificate') ? 'checked' : '' }}>
                        <span class="label-text">Hanya yang punya sertifikat</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('superadmin.units.approval.index') }}" class="btn btn-ghost">Reset</a>
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
                            <th>Sertifikat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                        <tr>
                            <td class="font-mono">{{ $unit->unit_number }}</td>
                            <td class="font-medium">{{ $unit->name }}</td>
                            <td class="text-sm">
                                {{ $unit->village?->name ?? '-' }},
                                {{ $unit->village?->district?->name ?? '-' }}
                            </td>
                            <td>{{ $unit->unitHead?->person?->full_name ?? '-' }}</td>
                            <td>
                                @if($unit->hasCertificate())
                                    <a href="{{ route('superadmin.units.approval.certificate', $unit) }}" target="_blank" class="badge badge-success gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="badge badge-error">Belum Ada</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $unit->approval_status->getColor() }}">
                                    {{ $unit->approval_status->getLabel() }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('superadmin.units.approval.show', $unit) }}" class="btn btn-sm btn-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/60">
                                Tidak ada unit yang ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $units->links() }}
            </div>
        </div>
    </div>
</x-layouts.superadmin>
