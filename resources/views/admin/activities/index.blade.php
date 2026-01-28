<x-layouts.admin title="Data Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Data Kegiatan</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Data Kegiatan</h1>
                <p class="text-base-content/60">Kelola kegiatan TPA/TPQ</p>
            </div>
            <x-ui.button type="primary" href="{{ route('admin.activities.create') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kegiatan
            </x-ui.button>
        </div>
    </x-slot:header>

    <!-- Filters -->
    <x-ui.card class="mb-6" :compact="true">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="form-control flex-1">
                <input type="text" name="search" placeholder="Cari kegiatan..." value="{{ request('search') }}"
                    class="input input-bordered input-sm" />
            </div>

            <select name="unit_id" class="select select-bordered select-sm">
                <option value="">Semua Unit</option>
                @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}
                </option>
                @endforeach
            </select>

            <input type="date" name="date_from" value="{{ request('date_from') }}" class="input input-bordered input-sm"
                placeholder="Dari tanggal" />
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="input input-bordered input-sm"
                placeholder="Sampai tanggal" />

            <x-ui.button type="primary" size="sm">Filter</x-ui.button>

            @if(request()->hasAny(['search', 'unit_id', 'date_from', 'date_to']))
            <a href="{{ route('admin.activities.index') }}" class="btn btn-ghost btn-sm">Reset</a>
            @endif
        </form>
    </x-ui.card>

    <!-- Data Table -->
    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Kegiatan</th>
                        <th>Unit</th>
                        <th>Tanggal</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $activity)
                    <tr class="hover">
                        <td>{{ $activities->firstItem() + $index }}</td>
                        <td>
                            <div class="font-bold">{{ $activity->title }}</div>
                            @if($activity->description)
                            <div class="text-sm text-base-content/60 truncate max-w-xs">
                                {{ Str::limit($activity->description, 50) }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <x-ui.badge type="secondary">
                                {{ $activity->unit?->name ?? '-' }}
                            </x-ui.badge>
                        </td>
                        <td>{{ $activity->activity_date?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $activity->createdBy?->person?->full_name ?? $activity->createdBy?->email ?? '-' }}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><a href="{{ route('admin.activities.show', $activity) }}">Detail</a></li>
                                    <li><a href="{{ route('admin.activities.edit', $activity) }}">Edit</a></li>
                                    <li>
                                        <button onclick="confirmDelete({{ $activity->id }})"
                                            class="text-error">Hapus</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-base-content/60">
                            Tidak ada data kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
        @endif
    </x-ui.card>

    <!-- Delete Modal -->
    <x-ui.modal id="delete-modal" title="Konfirmasi Hapus" size="sm">
        <p>Apakah Anda yakin ingin menghapus kegiatan ini?</p>
        <x-slot:actions>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('delete-modal').close()">Batal</button>
                <button type="submit" class="btn btn-error">Hapus</button>
            </form>
        </x-slot:actions>
    </x-ui.modal>

    @push('scripts')
    <script>
    function confirmDelete(id) {
        document.getElementById('delete-form').action = `/admin/activities/${id}`;
        document.getElementById('delete-modal').showModal();
    }
    </script>
    @endpush
</x-layouts.admin>
