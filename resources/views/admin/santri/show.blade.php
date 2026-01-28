<x-layouts.admin title="Detail Santri">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.santri.index') }}">Data Santri</a></li>
            <li>Detail</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="avatar placeholder">
                    <div
                        class="bg-primary text-primary-content rounded-full w-16 flex items-center justify-center text-2xl font-bold">
                        <span class="text-2xl">{{ substr($santri->person->full_name ?? 'S', 0, 1) }}</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ $santri->person->full_name ?? 'Santri' }}</h1>
                    <p class="text-base-content/60">NIK: {{ $santri->person->nik ?? '-' }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <x-ui.button type="ghost" href="{{ route('admin.santri.index') }}">
                    Kembali
                </x-ui.button>
                <x-ui.button type="primary" href="{{ route('admin.santri.edit', $santri) }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </x-ui.button>
            </div>
        </div>
    </x-slot:header>

    @php
    $guardian = $santri->guardians->first();
    $guardianPerson = $guardian?->person;
    $guardianSantri = $guardian?->guardianSantri?->where('santri_id', $santri->id)->first();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- IDENTITAS SANTRI -->
            <x-ui.card title="IDENTITAS SANTRI">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-base-content/60">NIK (Nomor Induk Kependudukan)</label>
                        <p class="font-medium">{{ $santri->person->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Nama Lengkap Santri</label>
                        <p class="font-medium">{{ $santri->person->full_name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Tempat Lahir</label>
                        <p class="font-medium">{{ $santri->person->birth_place ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Tanggal Lahir</label>
                        <p class="font-medium">{{ $santri->person->birth_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Jenis Kelamin</label>
                        <p class="font-medium">{{ $santri->person->gender?->getLabel() ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Anak Ke- / Jumlah Saudara</label>
                        <p class="font-medium">{{ $santri->child_order ?? '-' }} dari
                            {{ ($santri->siblings_count ?? 0) + 1 }} bersaudara</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- ALAMAT -->
            <x-ui.card title="ALAMAT">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-base-content/60">Provinsi</label>
                        <p class="font-medium">{{ $santri->village?->district?->city?->province?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Kab/Kota</label>
                        <p class="font-medium">{{ $santri->village?->district?->city?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Kecamatan</label>
                        <p class="font-medium">{{ $santri->village?->district?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Kelurahan/Desa</label>
                        <p class="font-medium">{{ $santri->village?->name ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm text-base-content/60">Jalan/Alamat Lengkap</label>
                        <p class="font-medium">{{ $santri->address ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">RT</label>
                        <p class="font-medium">{{ $santri->rt ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">RW</label>
                        <p class="font-medium">{{ $santri->rw ?? '-' }}</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- NAMA ORANG TUA -->
            <x-ui.card title="NAMA ORANG TUA">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-base-content/60">Nama Ayah Kandung</label>
                        <p class="font-medium">{{ $santri->nama_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Nama Ibu Kandung</label>
                        <p class="font-medium">{{ $santri->nama_ibu ?? '-' }}</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- PENGAMPU / WALI SANTRI -->
            <x-ui.card title="NAMA PENGAMPU / WALI SANTRI">
                @if($guardian)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-base-content/60">NIK Wali</label>
                        <p class="font-medium">{{ $guardianPerson->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Nama Lengkap</label>
                        <p class="font-medium">{{ $guardianPerson->full_name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Tempat Lahir</label>
                        <p class="font-medium">{{ $guardianPerson->birth_place ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Tanggal Lahir</label>
                        <p class="font-medium">{{ $guardianPerson->birth_date?->format('d F Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Jenis Kelamin</label>
                        <p class="font-medium">{{ $guardianPerson->gender?->getLabel() ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Hubungan Dengan Santri</label>
                        <p class="font-medium">
                            @php
                            $hubungan = $guardianSantri?->hubungan;
                            if ($hubungan instanceof \App\Enum\HubunganWaliSantri) {
                            echo $hubungan->getLabel();
                            } elseif ($hubungan && is_string($hubungan)) {
                            $hubunganEnum = \App\Enum\HubunganWaliSantri::tryFrom($hubungan);
                            echo $hubunganEnum?->getLabel() ?? $hubungan;
                            } else {
                            echo '-';
                            }
                            @endphp
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Pendidikan Terakhir</label>
                        <p class="font-medium">
                            @php
                            $pendidikan = $guardian->pendidikan_terakhir;
                            if ($pendidikan instanceof \App\Enum\PendidikanTerakhir) {
                            echo $pendidikan->getLabel();
                            } elseif ($pendidikan && is_string($pendidikan)) {
                            $pendidikanEnum = \App\Enum\PendidikanTerakhir::tryFrom($pendidikan);
                            echo $pendidikanEnum?->getLabel() ?? $pendidikan;
                            } else {
                            echo '-';
                            }
                            @endphp
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Pekerjaan</label>
                        <p class="font-medium">
                            @php
                            $pekerjaan = $guardian->pekerjaan;
                            if ($pekerjaan instanceof \App\Enum\PekerjaanWali) {
                            echo $pekerjaan->getLabel();
                            } elseif ($pekerjaan && is_string($pekerjaan)) {
                            $pekerjaanEnum = \App\Enum\PekerjaanWali::tryFrom($pekerjaan);
                            echo $pekerjaanEnum?->getLabel() ?? $pekerjaan;
                            } else {
                            echo '-';
                            }
                            @endphp
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Nomor HP</label>
                        <p class="font-medium">{{ $guardianPerson->phone ?? '-' }}</p>
                    </div>
                </div>
                @else
                <p class="text-base-content/60">Belum ada data wali</p>
                @endif
            </x-ui.card>
        </div>

        <!-- Side Info -->
        <div class="space-y-6">
            <!-- STATUS SANTRI -->
            <x-ui.card title="STATUS SANTRI">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-base-content/60">Jenjang</label>
                        <div class="mt-1">
                            <x-ui.badge type="info" size="lg">
                                {{ $santri->jenjang_santri?->getLabel() ?? '-' }}
                            </x-ui.badge>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Kelas Bacaan</label>
                        <p class="font-medium">{{ $santri->kelas_mengaji?->getLabel() ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Status</label>
                        <div class="mt-1">
                            @php
                            $statusType = match($santri->status_santri?->value ?? '') {
                            'aktif' => 'success',
                            'lulus_wisuda' => 'info',
                            'lanjut_tqa' => 'primary',
                            'pindah' => 'warning',
                            'berhenti' => 'error',
                            default => 'neutral',
                            };
                            @endphp
                            <x-ui.badge :type="$statusType" size="lg">
                                {{ $santri->status_santri?->getLabel() ?? '-' }}
                            </x-ui.badge>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Wisuda</label>
                        <p class="font-medium">{{ $santri->graduated ? 'Sudah' : 'Belum' }}</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Timestamps -->
            <x-ui.card title="Informasi Sistem" :compact="true">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Dibuat</span>
                        <span>{{ $santri->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Diperbarui</span>
                        <span>{{ $santri->updated_at?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                </div>
            </x-ui.card>

            <!-- Actions -->
            <x-ui.card title="Aksi" :compact="true">
                <div class="space-y-2">
                    <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-primary btn-block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Data
                    </a>
                    <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data santri ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error btn-outline btn-block">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Data
                        </button>
                    </form>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-layouts.admin>
