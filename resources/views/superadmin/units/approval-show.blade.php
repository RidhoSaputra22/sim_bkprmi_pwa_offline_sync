<x-layouts.superadmin title="Review Unit - {{ $unit->name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.units.approval.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Review Unit: {{ $unit->name }}</h1>
                <p class="text-base-content/60">No. Unit: {{ $unit->unit_number }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Unit Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Identitas Unit</h2>
                    <div class="grid grid-cols-2 gap-4">
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
                    <div class="grid grid-cols-2 gap-4">
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
                    <div class="grid grid-cols-2 gap-4">
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
                    <p class="text-base-content/60">Data kepala unit tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar - Actions -->
        <div class="space-y-6">
            <!-- Status Card -->
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
                        @if($unit->approvedByUser)
                        <p class="text-base-content/60 mt-2">Oleh:</p>
                        <p>{{ $unit->approvedByUser->person?->full_name ?? 'Unknown' }}</p>
                        @endif
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

            <!-- Certificate Card -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Sertifikat Unit</h2>

                    @if($unit->hasCertificate())
                    <div class="text-center py-4">
                        <svg class="w-16 h-16 mx-auto text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-success font-medium mt-2">Sertifikat Tersedia</p>
                        <p class="text-xs text-base-content/60 mt-1">
                            Diupload: {{ $unit->certificate_uploaded_at?->format('d M Y H:i') ?? '-' }}
                        </p>
                        <a href="{{ route('superadmin.units.approval.certificate', $unit) }}" target="_blank" class="btn btn-sm btn-primary mt-4">
                            Lihat Sertifikat
                        </a>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <svg class="w-16 h-16 mx-auto text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-error font-medium mt-2">Sertifikat Belum Diupload</p>
                        <p class="text-xs text-base-content/60 mt-1">
                            Unit tidak dapat disetujui tanpa sertifikat
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            @if($unit->isPending())
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Aksi</h2>

                    @if($unit->canBeApproved())
                    <!-- Approve Form -->
                    <form action="{{ route('superadmin.units.approval.approve', $unit) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-control">
                            <label class="label"><span class="label-text">Catatan (opsional)</span></label>
                            <textarea name="notes" class="textarea textarea-bordered" rows="2" placeholder="Catatan approval..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui Unit
                        </button>
                    </form>

                    <div class="divider">ATAU</div>
                    @endif

                    <!-- Reject Form -->
                    <form action="{{ route('superadmin.units.approval.reject', $unit) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-control">
                            <label class="label"><span class="label-text">Alasan Penolakan <span class="text-error">*</span></span></label>
                            <textarea name="notes" class="textarea textarea-bordered" rows="3" placeholder="Alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-error w-full" onclick="return confirm('Yakin ingin menolak unit ini?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Unit
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.superadmin>
