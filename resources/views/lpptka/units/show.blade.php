<x-layouts.lpptka title="Detail Unit - {{ $unit->name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.units.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">{{ $unit->name }}</h1>
                <p class="text-base-content/60">No. Unit: {{ $unit->unit_number }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Unit Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title">Identitas Unit</h2>
                        <a href="{{ route('lpptka.units.edit', $unit) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nomor Unit</p>
                            <p class="font-mono">{{ $unit->unit_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Unit</p>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Lokasi Kegiatan</p>
                            <p>{{ $unit->tipe_lokasi?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Status Gedung</p>
                            <p>{{ $unit->status_bangunan?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Masjid/Mushallah</p>
                            <p>{{ $unit->mosque_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Lembaga Pendiri</p>
                            <p>{{ $unit->founder ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Mulai Terbentuk</p>
                            <p>{{ $unit->formed_at?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Bergabung LPPTKA</p>
                            <p>{{ $unit->joined_year ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jam Kegiatan</p>
                            <p>{{ $unit->waktu_kegiatan?->getLabel() ?? '-' }}</p>
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
                            <p class="text-sm text-base-content/60">Kab/Kota</p>
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
                        <div class="col-span-2">
                            <p class="text-sm text-base-content/60">Jalan</p>
                            <p>{{ $unit->region?->jalan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">RT</p>
                            <p>{{ $unit->region?->rt ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">RW</p>
                            <p>{{ $unit->region?->rw ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keadaan Santri -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Keadaan Santri</h2>
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div class="stat bg-base-200 rounded-lg">
                            <div class="stat-title">TKA (4-7 Tahun)</div>
                            <div class="stat-value text-primary">{{ $unit->jumlah_tka ?? 0 }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-lg">
                            <div class="stat-title">TPA (7-12 Tahun)</div>
                            <div class="stat-value text-success">{{ $unit->jumlah_tpa ?? 0 }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-lg">
                            <div class="stat-title">TQA (Wisuda)</div>
                            <div class="stat-value text-info">{{ $unit->jumlah_tqa ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keadaan Guru -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Keadaan Guru Mengaji</h2>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="stat bg-base-200 rounded-lg">
                            <div class="stat-title">Guru Laki-laki</div>
                            <div class="stat-value text-primary">{{ $unit->guru_laki ?? 0 }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-lg">
                            <div class="stat-title">Guru Perempuan</div>
                            <div class="stat-value text-secondary">{{ $unit->guru_perempuan ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penanggung Jawab -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Penanggung Jawab Unit</h2>
                    @if($unit->unitHead?->person)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Kepala Unit</p>
                            <p class="font-medium">{{ $unit->unitHead->person->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">NIK</p>
                            <p class="font-mono">{{ $unit->unitHead->person->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tempat, Tanggal Lahir</p>
                            <p>{{ $unit->unitHead->person->birth_place ?? '-' }},
                                {{ $unit->unitHead->person->birth_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                            <p>{{ $unit->unitHead->person->gender?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Pendidikan Terakhir</p>
                            <p>{{ $unit->unitHead->education_level?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Pekerjaan</p>
                            <p>{{ $unit->unitHead->job?->getLabel() ?? '-' }}</p>
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

            <!-- Data Admin -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Admin Unit</h2>
                    @if($unit->unitAdmin?->person)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Admin</p>
                            <p class="font-medium">{{ $unit->unitAdmin->person->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">No. HP Admin</p>
                            <p>{{ $unit->unitAdmin->person->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Email Admin</p>
                            <p>{{ $unit->unitAdmin->person->email ?? '-' }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-base-content/60 mt-4">Data admin unit tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Approval -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Status Approval</h2>

                    <div class="flex items-center gap-3 my-4">
                        <span class="badge badge-lg badge-{{ $unit->approval_status->getColor() }}">
                            {{ $unit->approval_status->getLabel() }}
                        </span>
                    </div>

                    @if($unit->approved_at)
                    <div class="text-sm">
                        <p class="text-base-content/60">Diproses pada:</p>
                        <p>{{ $unit->approved_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif

                    @if($unit->approval_notes)
                    <div class="mt-4">
                        <p class="text-sm text-base-content/60">Catatan:</p>
                        <p class="text-sm bg-base-200 p-2 rounded">{{ $unit->approval_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sertifikat -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Sertifikat Unit</h2>

                    @if($unit->hasCertificate())
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-success" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-success font-medium mt-2">Sertifikat Tersedia</p>
                        <a href="{{ Storage::url($unit->certificate_path) }}" target="_blank"
                            class="btn btn-sm btn-primary mt-4">
                            Lihat Sertifikat
                        </a>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-warning" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-warning font-medium mt-2">Belum Ada Sertifikat</p>

                        <form action="{{ route('lpptka.units.upload-certificate', $unit) }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="form-control">
                                <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png"
                                    class="file-input file-input-bordered file-input-sm w-full" required>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2 w-full">Upload</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Akun Admin TPA -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Akun Admin TPA</h2>

                    @if($unit->hasAdminAccount())
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-success" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="text-success font-medium mt-2">Akun Aktif</p>
                        <p class="text-sm text-base-content/60 mt-1">
                            {{ $unit->adminUser?->email ?? '-' }}
                        </p>
                    </div>
                    @elseif($unit->canCreateAdminAccount())
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <p class="text-info font-medium mt-2">Siap Buat Akun</p>
                        <a href="{{ route('lpptka.tpa-accounts.create', $unit) }}" class="btn btn-sm btn-primary mt-4">
                            Buat Akun Admin TPA
                        </a>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-base-content/40" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <p class="text-base-content/60 font-medium mt-2">Belum Bisa Buat Akun</p>
                        <p class="text-xs text-base-content/40 mt-1">
                            Unit harus disetujui SuperAdmin terlebih dahulu
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.lpptka>
