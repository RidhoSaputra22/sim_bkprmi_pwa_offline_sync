<x-layouts.member title="Struktur Organisasi">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('member.organization.index') }}">Organisasi</a></li>
            <li>Struktur</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold">Struktur Organisasi BKPRMI</h1>
                <p class="text-base-content/60">Struktur hierarki organisasi</p>
            </div>
            <a href="{{ route('member.organization.index') }}" class="btn btn-outline btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot:header>

    <!-- Organization Tree -->
    <div class="card bg-base-100 shadow-md">
        <div class="card-body">
            <h2 class="card-title mb-6">Hierarki Organisasi</h2>

            <div class="space-y-6">
                <!-- BKPRMI Pusat -->
                <div class="flex flex-col items-center">
                    <div class="p-4 bg-primary text-primary-content rounded-lg shadow-lg text-center min-w-48">
                        <h3 class="font-bold text-lg">BKPRMI</h3>
                        <p class="text-sm opacity-80">Badan Koordinasi Pusat</p>
                    </div>
                    <div class="w-0.5 h-8 bg-base-300"></div>
                </div>

                <!-- Regions -->
                @if($regions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($regions as $region)
                            <div class="flex flex-col items-center">
                                <div class="w-0.5 h-4 bg-base-300"></div>
                                <div class="card bg-secondary text-secondary-content w-full">
                                    <div class="card-body p-4">
                                        <h4 class="font-bold">{{ $region->name }}</h4>
                                        <p class="text-sm opacity-80">{{ $region->units->count() }} Unit</p>

                                        @if($region->units->count() > 0)
                                            <div class="divider my-2"></div>
                                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                                @foreach($region->units as $unit)
                                                    <a href="{{ route('member.organization.unit.show', $unit) }}"
                                                       class="block p-2 bg-base-100 text-base-content rounded hover:bg-base-200 transition">
                                                        <span class="text-sm font-medium">{{ $unit->name }}</span>
                                                        <span class="text-xs block opacity-60">{{ $unit->unit_number }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-base-content/50">Belum ada data region tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mt-6">
        <div class="stat">
            <div class="stat-title">Total Region</div>
            <div class="stat-value text-primary">{{ $regions->count() }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total Unit</div>
            <div class="stat-value text-secondary">{{ $regions->sum(fn($r) => $r->units->count()) }}</div>
        </div>
    </div>
</x-layouts.member>
