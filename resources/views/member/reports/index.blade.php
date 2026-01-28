<x-layouts.member title="Unduh Laporan">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Unduh & Cetak Laporan</h1>
        <p class="text-base-content/60">Download dan cetak laporan dalam format PDF</p>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Laporan Santri -->
        <div class="card bg-base-100 shadow-md">
            <div class="card-body">
                <div class="flex items-center gap-4 mb-4">
                    <div class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-lg w-12 h-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title">Laporan Santri</h2>
                        <p class="text-sm text-base-content/60">Data seluruh santri</p>
                    </div>
                </div>

                <form action="{{ route('member.reports.download.santri') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Filter Unit (Opsional)</span>
                        </label>
                        <select name="unit_id" class="select select-bordered w-full">
                            <option value="">Semua Unit</option>
                            @foreach(\App\Models\Unit::orderBy('name')->get() as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Format</span>
                        </label>
                        <div class="flex flex-col gap-2">
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="pdf" checked class="radio radio-primary radio-sm">
                                <span class="label-text">PDF</span>
                            </label>
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="excel" disabled class="radio radio-sm">
                                <span class="label-text text-base-content/50">Excel (Coming Soon)</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <button type="submit" class="btn btn-primary w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Unduh Laporan
                        </button>

                        <a href="{{ route('member.reports.print', ['type' => 'santri']) }}" target="_blank" class="btn btn-outline w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Laporan Kegiatan -->
        <div class="card bg-base-100 shadow-md">
            <div class="card-body">
                <div class="flex items-center gap-4 mb-4">
                    <div class="avatar placeholder">
                        <div class="bg-secondary text-secondary-content rounded-lg w-12 h-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title">Laporan Kegiatan</h2>
                        <p class="text-sm text-base-content/60">Data kegiatan</p>
                    </div>
                </div>

                <form action="{{ route('member.reports.download.activity') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Mulai</span>
                        </label>
                        <input type="date" name="start_date" class="input input-bordered w-full">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Selesai</span>
                        </label>
                        <input type="date" name="end_date" class="input input-bordered w-full">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Filter Unit (Opsional)</span>
                        </label>
                        <select name="unit_id" class="select select-bordered w-full">
                            <option value="">Semua Unit</option>
                            @foreach(\App\Models\Unit::orderBy('name')->get() as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Format</span>
                        </label>
                        <div class="flex flex-col gap-2">
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="pdf" checked class="radio radio-secondary radio-sm">
                                <span class="label-text">PDF</span>
                            </label>
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="excel" disabled class="radio radio-sm">
                                <span class="label-text text-base-content/50">Excel (Coming Soon)</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <button type="submit" class="btn btn-secondary w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Unduh Laporan
                        </button>

                        <a href="{{ route('member.reports.print', ['type' => 'activity']) }}" target="_blank" class="btn btn-outline w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Laporan Unit -->
        <div class="card bg-base-100 shadow-md">
            <div class="card-body">
                <div class="flex items-center gap-4 mb-4">
                    <div class="avatar placeholder">
                        <div class="bg-accent text-accent-content rounded-lg w-12 h-12 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title">Laporan Unit</h2>
                        <p class="text-sm text-base-content/60">Data unit TPA/TPQ</p>
                    </div>
                </div>

                <form action="{{ route('member.reports.download.unit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Filter Region (Opsional)</span>
                        </label>
                        <select name="region_id" class="select select-bordered w-full">
                            <option value="">Semua Region</option>
                            @foreach(\App\Models\Region::orderBy('name')->get() as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Format</span>
                        </label>
                        <div class="flex flex-col gap-2">
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="pdf" checked class="radio radio-accent radio-sm">
                                <span class="label-text">PDF</span>
                            </label>
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" name="format" value="excel" disabled class="radio radio-sm">
                                <span class="label-text text-base-content/50">Excel (Coming Soon)</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <button type="submit" class="btn btn-accent w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Unduh Laporan
                        </button>

                        <a href="{{ route('member.reports.print', ['type' => 'unit']) }}" target="_blank" class="btn btn-outline w-full gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="alert alert-info mt-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h3 class="font-bold">Informasi Laporan</h3>
            <ul class="text-sm mt-2 space-y-1">
                <li>• <strong>Unduh Laporan</strong>: Download file laporan dalam format PDF</li>
                <li>• <strong>Cetak Laporan</strong>: Buka halaman print-friendly untuk mencetak langsung</li>
                <li>• Gunakan filter untuk mendapatkan data yang lebih spesifik</li>
            </ul>
        </div>
    </div>
</x-layouts.member>
