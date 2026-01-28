<x-layouts.admin title="Detail Unit">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.units.index') }}">Data Unit</a></li>
            <li>Detail Unit</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $unit->name }}</h1>
                <p class="text-base-content/60">Nomor Unit: {{ $unit->unit_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.units.index') }}" class="btn btn-ghost">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot:header>

    <div class="space-y-6">
        <!-- IDENTITAS UNIT -->
        <x-ui.card title="IDENTITAS UNIT" subtitle="Data identitas unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-base-content/60">Nomor Unit</p>
                    <p class="font-medium">{{ $unit->unit_number ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Nama TK/TP Al Qur'an</p>
                    <p class="font-medium">{{ $unit->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Lokasi Kegiatan</p>
                    <p class="font-medium">
                        @if($unit->tipe_lokasi)
                            <span class="badge badge-primary">{{ $unit->tipe_lokasi->getLabel() }}</span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Status Gedung</p>
                    <p class="font-medium">
                        @if($unit->status_bangunan)
                            <span class="badge badge-secondary">{{ $unit->status_bangunan->getLabel() }}</span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Nama Masjid/Mushallah</p>
                    <p class="font-medium">{{ $unit->mosque_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Lembaga Pendiri/Penyelenggara</p>
                    <p class="font-medium">{{ $unit->founder ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Mulai Terbentuk pada Tanggal</p>
                    <p class="font-medium">{{ $unit->formed_at?->format('d F Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Bergabung Dengan LPPTKA Pada Tahun</p>
                    <p class="font-medium">{{ $unit->joined_year ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Jam Kegiatan</p>
                    <p class="font-medium">
                        @if($unit->waktu_kegiatan)
                            <span class="badge badge-accent">{{ $unit->waktu_kegiatan->getLabel() }}</span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Email</p>
                    <p class="font-medium">
                        @if($unit->email)
                            <a href="mailto:{{ $unit->email }}" class="link link-primary">{{ $unit->email }}</a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </x-ui.card>

        <!-- ALAMAT -->
        <x-ui.card title="ALAMAT" subtitle="Alamat lokasi unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-base-content/60">Provinsi</p>
                    <p class="font-medium">{{ $unit->village?->district?->city?->province?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Kab/Kota</p>
                    <p class="font-medium">{{ $unit->village?->district?->city?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Kecamatan</p>
                    <p class="font-medium">{{ $unit->village?->district?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Kelurahan/Desa</p>
                    <p class="font-medium">{{ $unit->village?->name ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-base-content/60">Jalan / Alamat Lengkap</p>
                    <p class="font-medium">{{ $unit->address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">RT</p>
                    <p class="font-medium">{{ $unit->rt ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">RW</p>
                    <p class="font-medium">{{ $unit->rw ?? '-' }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- KEADAAN SANTRI -->
        <x-ui.card title="KEADAAN SANTRI" subtitle="Jumlah santri berdasarkan jenjang">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title">TKA (Usia 4-7 Tahun)</div>
                    <div class="stat-value text-primary">{{ $unit->jumlah_tka_4_7 ?? 0 }}</div>
                    <div class="stat-desc">Santri</div>
                </div>
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title">TPA (Usia 7-12 Tahun)</div>
                    <div class="stat-value text-secondary">{{ $unit->jumlah_tpa_7_12 ?? 0 }}</div>
                    <div class="stat-desc">Santri</div>
                </div>
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-title">TQA (Telah Wisuda)</div>
                    <div class="stat-value text-accent">{{ $unit->jumlah_tqa_wisuda ?? 0 }}</div>
                    <div class="stat-desc">Santri</div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-base-200">
                <p class="text-sm text-base-content/60">Total Santri</p>
                <p class="text-2xl font-bold text-primary">{{ ($unit->jumlah_tka_4_7 ?? 0) + ($unit->jumlah_tpa_7_12 ?? 0) + ($unit->jumlah_tqa_wisuda ?? 0) }}</p>
            </div>
        </x-ui.card>

        <!-- KEADAAN GURU MENGAJI -->
        <x-ui.card title="KEADAAN GURU MENGAJI" subtitle="Jumlah guru mengaji berdasarkan jenis kelamin">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-figure text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Laki-laki</div>
                    <div class="stat-value text-blue-500">{{ $unit->jumlah_guru_laki_laki ?? 0 }}</div>
                    <div class="stat-desc">Guru</div>
                </div>
                <div class="stat bg-base-200 rounded-box">
                    <div class="stat-figure text-pink-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Perempuan</div>
                    <div class="stat-value text-pink-500">{{ $unit->jumlah_guru_perempuan ?? 0 }}</div>
                    <div class="stat-desc">Guru</div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-base-200">
                <p class="text-sm text-base-content/60">Total Guru</p>
                <p class="text-2xl font-bold text-primary">{{ ($unit->jumlah_guru_laki_laki ?? 0) + ($unit->jumlah_guru_perempuan ?? 0) }}</p>
            </div>
        </x-ui.card>

        <!-- PENANGGUNG JAWAB UNIT -->
        @if($unitHead)
        <x-ui.card title="PENANGGUNG JAWAB UNIT" subtitle="Data kepala unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-base-content/60">Nama Kepala Unit</p>
                    <p class="font-medium">{{ $unitHead->person?->full_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">NIK</p>
                    <p class="font-medium font-mono">{{ $unitHead->person?->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Tempat, Tanggal Lahir</p>
                    <p class="font-medium">
                        {{ $unitHead->person?->birth_place ?? '' }}{{ $unitHead->person?->birth_place && $unitHead->person?->birth_date ? ', ' : '' }}{{ $unitHead->person?->birth_date?->format('d F Y') ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                    <p class="font-medium">
                        @if($unitHead->person?->gender)
                            <span class="badge {{ $unitHead->person->gender->value === 'male' ? 'badge-info' : 'badge-secondary' }}">
                                {{ $unitHead->person->gender->getLabel() }}
                            </span>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Pendidikan Terakhir</p>
                    <p class="font-medium">{{ $unitHead->pendidikan_terakhir?->getLabel() ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Pekerjaan</p>
                    <p class="font-medium">{{ $unitHead->pekerjaan?->getLabel() ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Nomor HP</p>
                    <p class="font-medium">
                        @if($unitHead->person?->phone)
                            <a href="tel:{{ $unitHead->person->phone }}" class="link link-primary">{{ $unitHead->person->phone }}</a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </x-ui.card>
        @endif

        <!-- ADMIN UNIT -->
        @if($unitAdmin)
        <x-ui.card title="ADMIN UNIT" subtitle="Data admin unit">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-base-content/60">Nama Admin</p>
                    <p class="font-medium">{{ $unitAdmin->person?->full_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Nomor HP</p>
                    <p class="font-medium">
                        @if($unitAdmin->person?->phone)
                            <a href="tel:{{ $unitAdmin->person->phone }}" class="link link-primary">{{ $unitAdmin->person->phone }}</a>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Email</p>
                    <p class="font-medium">
                        @if($unitAdmin->person?->email)
                            <a href="mailto:{{ $unitAdmin->person->email }}" class="link link-primary">{{ $unitAdmin->person->email }}</a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </x-ui.card>
        @endif

        <!-- TIMESTAMPS -->
        <x-ui.card title="INFORMASI SISTEM" subtitle="Waktu pembuatan dan perubahan data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-base-content/60">Dibuat pada</p>
                    <p class="font-medium">{{ $unit->created_at?->format('d F Y, H:i') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Terakhir diperbarui</p>
                    <p class="font-medium">{{ $unit->updated_at?->format('d F Y, H:i') ?? '-' }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-layouts.admin>
