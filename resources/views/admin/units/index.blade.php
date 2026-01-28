<x-layouts.admin title="Data Unit TPA/TPQ">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Unit TPA/TPQ</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Data Unit TPA/TPQ</h1>
                <p class="text-base-content/60">Kelola unit TPA/TPQ BKPRMI</p>
            </div>
            <x-ui.button type="primary" href="{{ route('admin.units.create') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Unit
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
                    placeholder="Cari unit..."
                    value="{{ request('search') }}"
                    class="input input-bordered input-sm"
                />
            </div>

            <select name="tipe_lokasi" class="select select-bordered select-sm">
                <option value="">Semua Tipe Lokasi</option>
                @foreach($tipeLokasiOptions as $tipe)
                    <option value="{{ $tipe->value }}" {{ request('tipe_lokasi') === $tipe->value ? 'selected' : '' }}>
                        {{ $tipe->getLabel() }}
                    </option>
                @endforeach
            </select>

            <select name="status_bangunan" class="select select-bordered select-sm">
                <option value="">Semua Status</option>
                @foreach($statusBangunanOptions as $status)
                    <option value="{{ $status->value }}" {{ request('status_bangunan') === $status->value ? 'selected' : '' }}>
                        {{ $status->getLabel() }}
                    </option>
                @endforeach
            </select>

            <x-ui.button type="primary" size="sm">Filter</x-ui.button>

            @if(request()->hasAny(['search', 'tipe_lokasi', 'status_bangunan']))
                <a href="{{ route('admin.units.index') }}" class="btn btn-ghost btn-sm">Reset</a>
            @endif
        </form>
    </x-ui.card>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($units as $unit)
            <x-ui.card>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $unit->name }}</h3>
                        <p class="text-sm text-base-content/60">{{ $unit->unit_number }}</p>
                    </div>
                    <x-ui.badge type="secondary">{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</x-ui.badge>
                </div>

                @if($unit->mosque_name)
                    <p class="text-sm mb-2">
                        <span class="text-base-content/60">Masjid:</span> {{ $unit->mosque_name }}
                    </p>
                @endif

                <div class="grid grid-cols-3 gap-2 text-center text-sm mb-4">
                    <div class="bg-base-200 rounded-lg p-2">
                        <div class="font-bold text-primary">{{ $unit->jumlah_tka_4_7 ?? 0 }}</div>
                        <div class="text-xs text-base-content/60">TKA</div>
                    </div>
                    <div class="bg-base-200 rounded-lg p-2">
                        <div class="font-bold text-secondary">{{ $unit->jumlah_tpa_7_12 ?? 0 }}</div>
                        <div class="text-xs text-base-content/60">TPA</div>
                    </div>
                    <div class="bg-base-200 rounded-lg p-2">
                        <div class="font-bold text-accent">{{ $unit->jumlah_tqa_wisuda ?? 0 }}</div>
                        <div class="text-xs text-base-content/60">TQA</div>
                    </div>
                </div>

                <div class="text-sm text-base-content/60 mb-4">
                    <span>{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }} Guru</span>
                </div>

                <x-slot:actions>
                    <a href="{{ route('admin.units.show', $unit) }}" class="btn btn-ghost btn-sm">Detail</a>
                    <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-primary btn-sm">Edit</a>
                </x-slot:actions>
            </x-ui.card>
        @empty
            <div class="col-span-full text-center py-12 text-base-content/60">
                Tidak ada data unit
            </div>
        @endforelse
    </div>

    @if($units->hasPages())
        <div class="mt-6">
            {{ $units->links() }}
        </div>
    @endif
</x-layouts.admin>
