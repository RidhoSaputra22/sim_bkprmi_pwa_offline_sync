<x-layouts.admin title="Laporan Santri">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Laporan Santri</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Laporan Santri</h1>
                <p class="text-base-content/60">Ringkasan data santri TPA/TPQ</p>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="btn btn-ghost">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak
                </button>
                <form method="POST" action="{{ route('admin.reports.export', ['type' => 'santri']) }}" target="_blank">
                    @csrf
                    <input type="hidden" name="format" value="pdf">
                    <x-ui.button type="primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh PDF
                    </x-ui.button>
                </form>
            </div>
        </div>
    </x-slot:header>

    <!-- Summary Stats -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-6">
        <x-ui.stat title="Total Santri" :value="$stats['total']">
            <x-slot:icon>
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </x-slot:icon>
        </x-ui.stat>

        @foreach($stats['by_status'] as $status => $count)
            <x-ui.stat :title="ucfirst($status)" :value="$count" />
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- By Status Chart -->
        <x-ui.card title="Berdasarkan Status">
            <div class="space-y-4">
                @foreach($stats['by_status'] as $status => $count)
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm">{{ ucfirst($status) }}</span>
                        <progress class="progress progress-primary flex-1" value="{{ $count }}" max="{{ $stats['total'] }}"></progress>
                        <span class="font-bold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <!-- By Jenjang Chart -->
        <x-ui.card title="Berdasarkan Jenjang">
            <div class="space-y-4">
                @foreach($stats['by_jenjang'] as $jenjang => $count)
                    <div class="flex items-center gap-4">
                        <span class="w-24 text-sm">{{ ucfirst($jenjang) }}</span>
                        <progress class="progress progress-secondary flex-1" value="{{ $count }}" max="{{ $stats['total'] }}"></progress>
                        <span class="font-bold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    </div>

    <!-- Data Table -->
    <x-ui.card title="Data Santri">
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santri as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->person->full_name ?? '-' }}</td>
                            <td>{{ $s->person->nik ?? '-' }}</td>
                            <td>{{ $s->jenjang_santri?->getLabel() ?? '-' }}</td>
                            <td>
                                <x-ui.badge type="success" size="sm">
                                    {{ $s->status_santri?->getLabel() ?? '-' }}
                                </x-ui.badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layouts.admin>
