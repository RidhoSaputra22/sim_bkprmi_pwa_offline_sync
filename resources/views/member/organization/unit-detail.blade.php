<x-layouts.member title="Detail Unit">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('member.organization.index') }}">Organisasi</a></li>
            <li>{{ $unit->name }}</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $unit->name }}</h1>
                <p class="text-base-content/60">Detail informasi unit TPA/TPQ</p>
            </div>
            <a href="{{ route('member.organization.index') }}" class="btn btn-outline btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h2 class="card-title">Informasi Unit</h2>

                    <div class="divider"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-base-content/60">Nomor Unit</label>
                            <p class="font-medium">{{ $unit->unit_number ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Nama Unit</label>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Region</label>
                            <p class="font-medium">{{ $unit->region->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Kelurahan/Desa</label>
                            <p class="font-medium">{{ $unit->village->name ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-base-content/60">Alamat</label>
                            <p class="font-medium">{{ $unit->address ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">RT/RW</label>
                            <p class="font-medium">{{ $unit->rt ?? '-' }} / {{ $unit->rw ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Nama Masjid/Musholla</label>
                            <p class="font-medium">{{ $unit->mosque_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Pendiri</label>
                            <p class="font-medium">{{ $unit->founder ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Tahun Berdiri</label>
                            <p class="font-medium">{{ $unit->formed_at?->format('Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Tahun Bergabung</label>
                            <p class="font-medium">{{ $unit->joined_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Email</label>
                            <p class="font-medium">{{ $unit->email ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Tipe Lokasi</label>
                            <p class="font-medium">{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Status Bangunan</label>
                            <p class="font-medium">{{ $unit->status_bangunan?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-base-content/60">Waktu Kegiatan</label>
                            <p class="font-medium">{{ $unit->waktu_kegiatan?->getLabel() ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h2 class="card-title text-lg">Statistik Santri</h2>

                    <div class="space-y-4 mt-4">
                        <div class="flex justify-between items-center p-3 bg-base-200 rounded-lg">
                            <span class="text-sm">TKA (4-7 tahun)</span>
                            <span class="badge badge-primary">{{ $unit->jumlah_tka_4_7 ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-base-200 rounded-lg">
                            <span class="text-sm">TPA (7-12 tahun)</span>
                            <span class="badge badge-secondary">{{ $unit->jumlah_tpa_7_12 ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-base-200 rounded-lg">
                            <span class="text-sm">TQA/Wisuda</span>
                            <span class="badge badge-accent">{{ $unit->jumlah_tqa_wisuda ?? 0 }}</span>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Santri</span>
                            <span class="text-xl font-bold text-primary">
                                {{ ($unit->jumlah_tka_4_7 ?? 0) + ($unit->jumlah_tpa_7_12 ?? 0) + ($unit->jumlah_tqa_wisuda ?? 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h2 class="card-title text-lg">Statistik Guru</h2>

                    <div class="space-y-4 mt-4">
                        <div class="flex justify-between items-center p-3 bg-base-200 rounded-lg">
                            <span class="text-sm">Guru Laki-laki</span>
                            <span class="badge badge-info">{{ $unit->jumlah_guru_laki_laki ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-base-200 rounded-lg">
                            <span class="text-sm">Guru Perempuan</span>
                            <span class="badge badge-success">{{ $unit->jumlah_guru_perempuan ?? 0 }}</span>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Guru</span>
                            <span class="text-xl font-bold text-secondary">
                                {{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>
