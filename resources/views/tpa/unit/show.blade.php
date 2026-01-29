<x-layouts.tpa title="Profil Unit TPA">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Profil Unit TPA</h1>
        <p class="text-base-content/60">Informasi lengkap unit TPA Anda</p>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Identitas Unit</h2>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Unit</p>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nomor Unit</p>
                            <p class="font-mono">{{ $unit->unit_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tipe Lokasi</p>
                            <p>{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Status Bangunan</p>
                            <p>{{ $unit->status_bangunan?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Waktu Kegiatan</p>
                            <p>{{ $unit->waktu_kegiatan?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Masjid/Mushalla</p>
                            <p>{{ $unit->mosque_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Lembaga Pendiri</p>
                            <p>{{ $unit->founder ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Email</p>
                            <p>{{ $unit->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Alamat</h2>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Provinsi</p>
                            <p>{{ $unit->village?->district?->city?->province?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kota/Kabupaten</p>
                            <p>{{ $unit->village?->district?->city?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kecamatan</p>
                            <p>{{ $unit->village?->district?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kelurahan</p>
                            <p>{{ $unit->village?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepala Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Kepala Unit</h2>

                    @if($unit->unitHead?->person)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Lengkap</p>
                            <p class="font-medium">{{ $unit->unitHead->person->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">NIK</p>
                            <p class="font-mono">{{ $unit->unitHead->person->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                            <p>{{ $unit->unitHead->person->gender?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">No. HP</p>
                            <p>{{ $unit->unitHead->person->phone ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-base-content/60 mt-4">Data kepala unit tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Status Unit</h2>

                    <div class="flex items-center gap-3 my-4">
                        <span class="badge badge-lg badge-{{ $unit->approval_status->getColor() }}">
                            {{ $unit->approval_status->getLabel() }}
                        </span>
                    </div>

                    @if($unit->approved_at)
                    <div class="text-sm">
                        <p class="text-base-content/60">Disetujui pada:</p>
                        <p>{{ $unit->approved_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistik -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Statistik</h2>

                    <div class="space-y-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span>Total Santri</span>
                            <span class="badge badge-primary badge-lg">{{ $stats['total_santri'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Santri Aktif</span>
                            <span class="badge badge-success badge-lg">{{ $stats['active_santri'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Laki-laki</span>
                            <span class="badge badge-info badge-lg">{{ $stats['male_santri'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Perempuan</span>
                            <span class="badge badge-secondary badge-lg">{{ $stats['female_santri'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sertifikat -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Sertifikat Unit</h2>

                    @if($unit->hasCertificate())
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-success font-medium mt-2">Sertifikat Tersedia</p>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-warning font-medium mt-2">Belum Ada Sertifikat</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="alert alert-info">
                <svg class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm">Untuk mengubah data unit, silakan hubungi Admin LPPTKA.</span>
            </div>
        </div>
    </div>
</x-layouts.tpa>
