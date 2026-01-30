<x-layouts.tpa title="Detail Guru">
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('tpa.teachers.index') }}" class="btn btn-circle btn-ghost">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Detail Data Guru</h1>
                    <p class="text-base-content/60">{{ $teacher->full_name }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tpa.teachers.edit', $teacher) }}" class="btn btn-warning">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot:header>

    @if(session('success'))
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Foto & Status -->
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow">
                <div class="card-body items-center text-center">
                    @if($teacher->photo_path)
                    <div class="avatar">
                        <div class="w-48 rounded-lg">
                            <img src="{{ Storage::url($teacher->photo_path) }}" alt="{{ $teacher->full_name }}" />
                        </div>
                    </div>
                    @else
                    <div class="avatar placeholder">
                        <div class="bg-neutral text-neutral-content rounded-lg w-48 h-48">
                            <span class="text-6xl">{{ substr($teacher->full_name, 0, 1) }}</span>
                        </div>
                    </div>
                    @endif

                    <h2 class="card-title mt-4">{{ $teacher->full_name }}</h2>
                    <p class="text-base-content/60">{{ $teacher->jabatan_utama->label() }}</p>

                    <div class="divider"></div>

                    <div class="w-full space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm">Status:</span>
                            @if($teacher->is_active)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-ghost">Tidak Aktif</span>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm">Usia:</span>
                            <span class="font-semibold">{{ $teacher->age }} tahun</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sertifikasi -->
            <div class="card bg-base-100 shadow mt-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">Sertifikasi</h3>
                    <div class="space-y-3">
                        <!-- LMD -->
                        <div>
                            <p class="text-sm text-base-content/60">LMD</p>
                            <p class="font-semibold">{{ $teacher->level_lmd->label() }}</p>
                            @if($teacher->sertifikat_lmd_path)
                            <a href="{{ Storage::url($teacher->sertifikat_lmd_path) }}" target="_blank"
                                class="btn btn-xs btn-outline btn-info mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lihat Sertifikat
                            </a>
                            @endif
                        </div>

                        <!-- Pelatihan Guru -->
                        <div>
                            <p class="text-sm text-base-content/60">Pelatihan Guru Mengaji</p>
                            <p class="font-semibold">{{ $teacher->level_pelatihan_guru->label() }}</p>
                            @if($teacher->sertifikat_pelatihan_path)
                            <a href="{{ Storage::url($teacher->sertifikat_pelatihan_path) }}" target="_blank"
                                class="btn btn-xs btn-outline btn-warning mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lihat Sertifikat
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- IDENTITAS -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-primary">IDENTITAS</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-base-content/60">NIK</p>
                            <p class="font-semibold">{{ $teacher->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Lengkap</p>
                            <p class="font-semibold">{{ $teacher->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tempat Lahir</p>
                            <p class="font-semibold">{{ $teacher->birth_place }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tanggal Lahir</p>
                            <p class="font-semibold">{{ $teacher->birth_date->format('d F Y') }} ({{ $teacher->age }}
                                tahun)</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                            <p class="font-semibold">{{ $teacher->gender->getLabel() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nomor HP</p>
                            <p class="font-semibold">{{ $teacher->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Pendidikan Terakhir</p>
                            <p class="font-semibold">{{ $teacher->educationLevel?->name ?? '-' }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm text-base-content/60">Pekerjaan Utama</p>
                            @if(!empty($teacher->pekerjaan_labels))
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($teacher->pekerjaan_labels as $pekerjaan)
                                <span class="badge badge-outline">{{ $pekerjaan }}</span>
                                @endforeach
                            </div>
                            @else
                            <p class="font-semibold">-</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ALAMAT -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-primary">ALAMAT</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-base-content/60">Provinsi</p>
                            <p class="font-semibold">{{ $teacher->province?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kab/Kota</p>
                            <p class="font-semibold">{{ $teacher->city?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kecamatan</p>
                            <p class="font-semibold">{{ $teacher->district?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kelurahan/Desa</p>
                            <p class="font-semibold">{{ $teacher->village?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jalan</p>
                            <p class="font-semibold">{{ $teacher->jalan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">RT/RW</p>
                            <p class="font-semibold">
                                {{ $teacher->rt ? "RT {$teacher->rt}" : '-' }}
                                {{ $teacher->rw ? "/ RW {$teacher->rw}" : '' }}
                            </p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm text-base-content/60">Alamat Lengkap</p>
                            <p class="font-semibold">{{ $teacher->full_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JABATAN -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title text-primary">JABATAN</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-base-content/60">Unit</p>
                            <p class="font-semibold">{{ $teacher->unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tugas Utama</p>
                            <p class="font-semibold">{{ $teacher->jabatan_utama->label() }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-sm text-base-content/60">Tugas Tambahan</p>
                            @if(!empty($teacher->tugas_tambahan_labels))
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($teacher->tugas_tambahan_labels as $tugas)
                                <span class="badge badge-outline">{{ $tugas }}</span>
                                @endforeach
                            </div>
                            @else
                            <p class="font-semibold">-</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Timestamps -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="text-sm text-base-content/60">
                        <p>Ditambahkan: {{ $teacher->created_at->format('d F Y H:i') }}</p>
                        <p>Terakhir diupdate: {{ $teacher->updated_at->format('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.tpa>
