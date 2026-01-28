<x-layouts.admin title="Data Santri">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Data Santri</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Data Santri</h1>
                <p class="text-base-content/60">Kelola data santri TPA/TPQ</p>
            </div>
            <x-ui.button type="primary" href="{{ route('admin.santri.create') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Santri
            </x-ui.button>
        </div>
    </x-slot:header>

    <!-- Filters -->
    <x-ui.card class="mb-6" :compact="true">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="form-control flex-1">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari nama atau NIK..."
                    value="{{ request('search') }}"
                    class="input input-bordered input-sm"
                />
            </div>

            <select name="status" class="select select-bordered select-sm">
                <option value="">Semua Status</option>
                @foreach($statusOptions as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                        {{ $status->getLabel() }}
                    </option>
                @endforeach
            </select>

            <select name="jenjang" class="select select-bordered select-sm">
                <option value="">Semua Jenjang</option>
                @foreach($jenjangOptions as $jenjang)
                    <option value="{{ $jenjang->value }}" {{ request('jenjang') === $jenjang->value ? 'selected' : '' }}>
                        {{ $jenjang->getLabel() }}
                    </option>
                @endforeach
            </select>

            <x-ui.button type="primary" size="sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </x-ui.button>

            @if(request()->hasAny(['search', 'status', 'jenjang']))
                <a href="{{ route('admin.santri.index') }}" class="btn btn-ghost btn-sm">Reset</a>
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
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Jenjang</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santri as $index => $s)
                        <tr class="hover">
                            <td>{{ $santri->firstItem() + $index }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-10">
                                            <span>{{ substr($s->person->full_name ?? 'S', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $s->person->full_name ?? '-' }}</div>
                                        <div class="text-sm text-base-content/60">
                                            {{ $s->person->birth_place ?? '' }}{{ $s->person->birth_date ? ', ' . $s->person->birth_date->format('d/m/Y') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $s->person->nik ?? '-' }}</td>
                            <td>
                                <x-ui.badge type="info">
                                    {{ $s->jenjang_santri?->getLabel() ?? '-' }}
                                </x-ui.badge>
                            </td>
                            <td>{{ $s->kelas_mengaji?->getLabel() ?? '-' }}</td>
                            <td>
                                @php
                                    $statusType = match($s->status_santri?->value ?? '') {
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'graduated' => 'info',
                                        'dropout' => 'error',
                                        default => 'neutral',
                                    };
                                @endphp
                                <x-ui.badge :type="$statusType">
                                    {{ $s->status_santri?->getLabel() ?? '-' }}
                                </x-ui.badge>
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="btn btn-ghost btn-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li>
                                            <a href="{{ route('admin.santri.show', $s) }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.santri.edit', $s) }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button onclick="confirmDelete({{ $s->id }})" class="text-error">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/60">
                                Tidak ada data santri
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($santri->hasPages())
            <div class="mt-4">
                {{ $santri->links() }}
            </div>
        @endif
    </x-ui.card>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal id="delete-modal" title="Konfirmasi Hapus" size="sm">
        <p class="py-4">Apakah Anda yakin ingin menghapus data santri ini? Tindakan ini tidak dapat dibatalkan.</p>

        <x-slot:actions>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('delete-modal').close()">Batal</button>
                <button type="submit" class="btn btn-error">Hapus</button>
            </form>
        </x-slot:actions>
    </x-ui.modal>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/santri/${id}`;
            document.getElementById('delete-modal').showModal();
        }
    </script>
    @endpush
</x-layouts.admin>
