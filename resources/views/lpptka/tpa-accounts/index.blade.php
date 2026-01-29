<x-layouts.lpptka title="Kelola Akun TPA">
    <x-slot:header>
        <div>
            <h1 class="text-2xl font-bold">Kelola Akun TPA</h1>
            <p class="text-base-content/60">Buat dan kelola akun admin untuk unit TPA yang sudah disetujui</p>
        </div>
    </x-slot:header>

    <!-- Tabs -->
    <div class="tabs tabs-boxed mb-6">
        <a href="{{ route('lpptka.tpa-accounts.index', ['tab' => 'ready']) }}"
           class="tab {{ request('tab', 'ready') == 'ready' ? 'tab-active' : '' }}">
            Siap Buat Akun
            @if($readyCount > 0)
            <span class="badge badge-primary badge-sm ml-2">{{ $readyCount }}</span>
            @endif
        </a>
        <a href="{{ route('lpptka.tpa-accounts.index', ['tab' => 'active']) }}"
           class="tab {{ request('tab') == 'active' ? 'tab-active' : '' }}">
            Akun Aktif
            <span class="badge badge-ghost badge-sm ml-2">{{ $activeCount }}</span>
        </a>
    </div>

    @if(request('tab', 'ready') == 'ready')
    <!-- Unit Siap Buat Akun -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title">Unit Siap Buat Akun</h2>
            <p class="text-sm text-base-content/60 mb-4">
                Unit-unit berikut sudah disetujui SuperAdmin dan siap dibuatkan akun admin TPA.
            </p>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No. Unit</th>
                            <th>Nama Unit</th>
                            <th>Lokasi</th>
                            <th>Disetujui Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($readyUnits as $unit)
                        <tr>
                            <td class="font-mono">{{ $unit->unit_number }}</td>
                            <td>
                                <div class="font-medium">{{ $unit->name }}</div>
                                <div class="text-sm text-base-content/60">{{ $unit->unitHead?->person?->full_name ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="text-sm">{{ $unit->village?->district?->city?->name ?? '-' }}</div>
                                <div class="text-xs text-base-content/60">{{ $unit->village?->district?->name ?? '-' }}</div>
                            </td>
                            <td>{{ $unit->approved_at?->format('d M Y') ?? '-' }}</td>
                            <td>
                                <a href="{{ route('lpptka.tpa-accounts.create', $unit) }}" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    Buat Akun
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-base-content/60">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Belum ada unit siap buat akun</p>
                                <p class="text-xs mt-2">Unit harus disetujui SuperAdmin terlebih dahulu</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($readyUnits->hasPages())
            <div class="mt-6">{{ $readyUnits->links() }}</div>
            @endif
        </div>
    </div>
    @else
    <!-- Akun Aktif -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h2 class="card-title">Akun TPA Aktif</h2>
            <p class="text-sm text-base-content/60 mb-4">
                Daftar akun admin TPA yang sudah dibuat dan aktif.
            </p>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Email</th>
                            <th>Nama Admin</th>
                            <th>Dibuat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeAccounts as $user)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $user->managedUnit?->name ?? '-' }}</div>
                                <div class="text-xs text-base-content/60 font-mono">{{ $user->managedUnit?->unit_number ?? '-' }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->person?->full_name ?? '-' }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-success badge-outline">Aktif</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-base-content/60">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p>Belum ada akun TPA yang dibuat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activeAccounts->hasPages())
            <div class="mt-6">{{ $activeAccounts->links() }}</div>
            @endif
        </div>
    </div>
    @endif
</x-layouts.lpptka>
