<x-layouts.tpa title="Detail Santri - {{ $santri->person?->full_name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">{{ $santri->person?->full_name ?? 'Santri' }}</h1>
                <p class="text-base-content/60">Detail Data Santri</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Pribadi -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title">Data Pribadi</h2>
                        <a href="{{ route('tpa.santri.edit', $santri) }}" class="btn btn-ghost btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Lengkap</p>
                            <p class="font-medium">{{ $santri->person?->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Panggilan</p>
                            <p>{{ $santri->person?->nickname ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">NIK</p>
                            <p class="font-mono">{{ $santri->person?->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                            <p>{{ $santri->person?->gender?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tempat Lahir</p>
                            <p>{{ $santri->person?->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tanggal Lahir</p>
                            <p>{{ $santri->person?->birth_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Anak Ke</p>
                            <p>{{ $santri->child_order ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Jumlah Saudara</p>
                            <p>{{ $santri->siblings_count ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pendidikan TPA -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Pendidikan TPA</h2>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Jenjang</p>
                            <p class="font-medium">{{ $santri->jenjang_santri?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kelas Mengaji</p>
                            <p>{{ $santri->kelas_mengaji?->getLabel() ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Status</p>
                            <span class="badge badge-{{ $santri->status_santri?->getColor() ?? 'ghost' }}">
                                {{ $santri->status_santri?->getLabel() ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Tanggal Masuk</p>
                            <p>{{ $santri->santriUnits?->firstWhere('unit_id', $unit->id)?->joined_at?->format('d M Y') ?? '-' }}
                            </p>
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
                            <p>{{ $santri->village?->district?->city?->province?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kota</p>
                            <p>{{ $santri->village?->district?->city?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kecamatan</p>
                            <p>{{ $santri->village?->district?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kelurahan</p>
                            <p>{{ $santri->village?->name ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-base-content/60">Alamat Lengkap</p>
                            <p>{{ $santri->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="card bg-base-100 shadow">
                <div class="card-body items-center text-center">
                    <div class="avatar placeholder">
                        <div
                            class="bg-primary text-primary-content rounded-full w-24 flex items-center justify-center font-bold">
                            <span class="text-3xl">{{ substr($santri->person?->full_name ?? 'S', 0, 1) }}</span>
                        </div>
                    </div>
                    <h2 class="card-title mt-4">{{ $santri->person?->full_name ?? '-' }}</h2>
                    <p class="text-base-content/60">{{ $santri->person?->nickname ?? '' }}</p>

                    <div class="flex gap-2 mt-2">
                        <span
                            class="badge badge-{{ $santri->person?->gender?->value == \App\Enum\Gender::LAKI_LAKI->value ? 'info' : 'secondary' }}">
                            {{ $santri->person?->gender?->getLabel() ?? '-' }}
                        </span>
                        <span class="badge badge-{{ $santri->status_santri?->getColor() ?? 'ghost' }}">
                            {{ $santri->status_santri?->getLabel() ?? '-' }}
                        </span>
                    </div>

                    @if($santri->person?->birth_date)
                    <p class="text-sm text-base-content/60 mt-2">
                        Usia: {{ $santri->person->birth_date->age }} tahun
                    </p>
                    @endif
                </div>
            </div>

            <!-- Nama Orang Tua -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Nama Orang Tua</h2>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Ayah Kandung</p>
                            <p class="font-medium">{{ $santri->nama_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Ibu Kandung</p>
                            <p class="font-medium">{{ $santri->nama_ibu ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Wali -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Wali</h2>

                    @forelse($santri->guardianSantris as $guardianSantri)
                    <div class="mt-4 p-4 bg-base-200 rounded-lg">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="avatar placeholder">
                                <div
                                    class="bg-neutral text-neutral-content rounded-full w-10 flex items-center justify-center font-bold">
                                    <span>{{ substr($guardianSantri->guardian?->person?->full_name ?? 'W', 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-medium">{{ $guardianSantri->guardian?->person?->full_name ?? '-' }}</p>
                                <p class="text-sm text-base-content/60">
                                    {{ $guardianSantri->hubungan?->getLabel() ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-base-content/60">NIK</span>
                                <span class="font-mono">{{ $guardianSantri->guardian?->person?->nik ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-base-content/60">No. HP</span>
                                <span>{{ $guardianSantri->guardian?->person?->phone ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between gap-2 ">
                                <span class="text-base-content/60">Pekerjaan</span>
                                <span>
                                    @if($guardianSantri->guardian?->pekerjaan_enums)
                                    @foreach($guardianSantri->guardian->pekerjaan_enums as $pekerjaan)
                                    <span
                                        class="badge badge-sm badge-primary mr-1 mb-2">{{ $pekerjaan->getLabel() }}</span>
                                    @endforeach
                                    @else
                                    -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-base-content/60 mt-4">Tidak ada data wali</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Aksi</h2>

                    <div class="space-y-2 mt-4">
                        <a href="{{ route('tpa.santri.edit', $santri) }}" class="btn btn-primary btn-block">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Data
                        </a>

                        <form action="{{ route('tpa.santri.destroy', $santri) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus santri ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error btn-outline btn-block">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Santri
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.tpa>
