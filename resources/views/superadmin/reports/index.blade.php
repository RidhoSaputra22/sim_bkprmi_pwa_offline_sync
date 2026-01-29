<x-layouts.superadmin title="Laporan & Statistik">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Laporan & Statistik</h1>
        <p class="text-base-content/60">Lihat laporan dan statistik keseluruhan sistem BKPRMI</p>
    </x-slot:header>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-title">Total Santri</div>
            <div class="stat-value text-primary">{{ number_format($stats['total_santri'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="stat-title">Total Unit TPA</div>
            <div class="stat-value text-secondary">{{ number_format($stats['total_units'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-accent">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="stat-title">Kota/Kabupaten</div>
            <div class="stat-value text-accent">{{ number_format($stats['total_cities'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Unit Aktif</div>
            <div class="stat-value text-success">{{ number_format($stats['approved_units'] ?? 0) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Statistik Santri per Jenjang -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Santri per Jenjang
                </h2>

                <div class="space-y-4 mt-4">
                    @php
                    $jenjangStats = $stats['by_jenjang'] ?? ['tka' => 0, 'tpa' => 0, 'tqa' => 0];
                    $totalJenjang = max(array_sum($jenjangStats), 1);
                    @endphp

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="font-medium">TKA (Taman Kanak-kanak Al-Qur'an)</span>
                            <span class="text-primary font-bold">{{ number_format($jenjangStats['tka'] ?? 0) }}</span>
                        </div>
                        <progress class="progress progress-primary w-full" value="{{ $jenjangStats['tka'] ?? 0 }}"
                            max="{{ $totalJenjang }}"></progress>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="font-medium">TPA (Taman Pendidikan Al-Qur'an)</span>
                            <span class="text-secondary font-bold">{{ number_format($jenjangStats['tpa'] ?? 0) }}</span>
                        </div>
                        <progress class="progress progress-secondary w-full" value="{{ $jenjangStats['tpa'] ?? 0 }}"
                            max="{{ $totalJenjang }}"></progress>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="font-medium">TQA (Ta'limul Qur'an lil Aulad)</span>
                            <span class="text-accent font-bold">{{ number_format($jenjangStats['tqa'] ?? 0) }}</span>
                        </div>
                        <progress class="progress progress-accent w-full" value="{{ $jenjangStats['tqa'] ?? 0 }}"
                            max="{{ $totalJenjang }}"></progress>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Santri per Gender -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Santri per Jenis Kelamin
                </h2>

                <div class="flex justify-center items-center gap-8 py-6">
                    @php
                    $maleCount = $stats['male_santri'] ?? 0;
                    $femaleCount = $stats['female_santri'] ?? 0;
                    $totalGender = max($maleCount + $femaleCount, 1);
                    $malePercent = round(($maleCount / $totalGender) * 100);
                    $femalePercent = 100 - $malePercent;
                    @endphp

                    <div class="text-center">
                        <div class="radial-progress text-info" style="--value:{{ $malePercent }}; --size:8rem;"
                            role="progressbar">
                            <span class="text-2xl font-bold">{{ $malePercent }}%</span>
                        </div>
                        <p class="mt-2 font-medium">Laki-laki</p>
                        <p class="text-2xl font-bold text-info">{{ number_format($maleCount) }}</p>
                    </div>

                    <div class="text-center">
                        <div class="radial-progress text-secondary" style="--value:{{ $femalePercent }}; --size:8rem;"
                            role="progressbar">
                            <span class="text-2xl font-bold">{{ $femalePercent }}%</span>
                        </div>
                        <p class="mt-2 font-medium">Perempuan</p>
                        <p class="text-2xl font-bold text-secondary">{{ number_format($femaleCount) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Status Approval Unit -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Status Approval Unit
                </h2>

                <div class="overflow-x-auto mt-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-warning badge-xs"></span> Pending
                                    </span>
                                </td>
                                <td class="text-right font-bold text-warning">
                                    {{ number_format($stats['pending_units'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-success badge-xs"></span> Disetujui
                                    </span>
                                </td>
                                <td class="text-right font-bold text-success">
                                    {{ number_format($stats['approved_units'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-error badge-xs"></span> Ditolak
                                    </span>
                                </td>
                                <td class="text-right font-bold text-error">
                                    {{ number_format($stats['rejected_units'] ?? 0) }}</td>
                            </tr>
                            <tr class="border-t-2">
                                <td class="font-medium">Total Unit</td>
                                <td class="text-right font-bold">{{ number_format($stats['total_units'] ?? 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status Santri -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status Santri
                </h2>

                <div class="overflow-x-auto mt-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-success badge-xs"></span> Masih Aktif
                                    </span>
                                </td>
                                <td class="text-right font-bold text-success">
                                    {{ number_format($stats['by_status']['aktif'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-warning badge-xs"></span> Lulus Wisuda TPA
                                    </span>
                                </td>
                                <td class="text-right font-bold text-warning">
                                    {{ number_format($stats['by_status']['lulus_wisuda'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-info badge-xs"></span> Lanjut TQA
                                    </span>
                                </td>
                                <td class="text-right font-bold text-info">
                                    {{ number_format($stats['by_status']['lanjut_tqa'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-secondary badge-xs"></span> Pindah
                                    </span>
                                </td>
                                <td class="text-right font-bold text-secondary">
                                    {{ number_format($stats['by_status']['pindah'] ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="flex items-center gap-2">
                                        <span class="badge badge-error badge-xs"></span> Berhenti
                                    </span>
                                </td>
                                <td class="text-right font-bold text-error">
                                    {{ number_format($stats['by_status']['berhenti'] ?? 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Laporan
            </h2>

            <div class="alert alert-success mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Export tersedia: PDF, Excel (CSV), dan Print.</span>
            </div>

            <div class="flex flex-wrap gap-4 mt-4">
                <a class="btn btn-outline btn-primary" href="{{ route('superadmin.reports.export.pdf') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
                <a class="btn btn-outline btn-success" href="{{ route('superadmin.reports.export.excel') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
                <a class="btn btn-outline btn-info" href="{{ route('superadmin.reports.print') }}" target="_blank"
                    rel="noopener">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </a>
            </div>
        </div>
    </div>
</x-layouts.superadmin>