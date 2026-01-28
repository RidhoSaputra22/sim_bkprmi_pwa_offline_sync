<x-layouts.member title="Detail Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('member.activities.index') }}">Kegiatan</a></li>
            <li>{{ $activity->name ?? $activity->title ?? 'Detail' }}</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $activity->name ?? $activity->title ?? 'Detail Kegiatan' }}</h1>
                <p class="text-base-content/60">Detail informasi kegiatan</p>
            </div>
            <a href="{{ route('member.activities.index') }}" class="btn btn-outline btn-sm gap-2">
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
                    <h2 class="card-title">Informasi Kegiatan</h2>

                    <div class="divider"></div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-base-content/60">Nama Kegiatan</label>
                            <p class="font-medium">{{ $activity->name ?? $activity->title ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-base-content/60">Deskripsi</label>
                            <p>{{ $activity->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-base-content/60">Tanggal Mulai</label>
                                <p class="font-medium">{{ $activity->start_date?->format('d F Y') ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-base-content/60">Tanggal Selesai</label>
                                <p class="font-medium">{{ $activity->end_date?->format('d F Y') ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm text-base-content/60">Unit</label>
                            <p class="font-medium">{{ $activity->unit->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs Section - Fitur akan ditambahkan jika diperlukan -->
            {{-- Log kegiatan dapat ditampilkan di halaman terpisah melalui menu "Lihat Log" --}}
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h2 class="card-title text-lg">Aksi</h2>

                    <div class="space-y-2 mt-4">
                        <a href="{{ route('member.activities.logs', $activity) }}" class="btn btn-primary btn-block gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Log Kegiatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h2 class="card-title text-lg">Info Unit</h2>

                    @if($activity->unit)
                        <div class="space-y-3 mt-4">
                            <div>
                                <label class="text-sm text-base-content/60">Nama Unit</label>
                                <p class="font-medium">{{ $activity->unit->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-base-content/60">Nomor Unit</label>
                                <p class="font-medium">{{ $activity->unit->unit_number ?? '-' }}</p>
                            </div>
                            <a href="{{ route('member.organization.unit.show', $activity->unit) }}" class="btn btn-outline btn-sm btn-block">
                                Lihat Detail Unit
                            </a>
                        </div>
                    @else
                        <p class="text-base-content/50 mt-4">Unit tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>
