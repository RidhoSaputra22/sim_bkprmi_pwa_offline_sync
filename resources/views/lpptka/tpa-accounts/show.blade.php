<x-layouts.lpptka title="Detail Akun Admin TPA">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.tpa-accounts.index', ['tab' => 'active']) }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Detail Akun Admin TPA</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Informasi Akun</h2>

                    <div class="overflow-x-auto mt-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Email</td>
                                    <td class="text-right font-medium">{{ $unit->adminUser?->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Admin</td>
                                    <td class="text-right font-medium">{{ $unit->adminUser?->person?->full_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>No. HP</td>
                                    <td class="text-right font-medium">{{ $unit->adminUser?->person?->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td class="text-right">
                                        @if($unit->adminUser?->is_active)
                                            <span class="badge badge-success badge-outline">Aktif</span>
                                        @else
                                            <span class="badge badge-warning badge-outline">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dibuat</td>
                                    <td class="text-right font-medium">{{ $unit->adminUser?->created_at?->format('d M Y H:i') ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-4">
                        <svg class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium">Login Admin TPA</p>
                            <p class="text-sm">Admin TPA bisa login dari halaman <a class="link" href="{{ route('login') }}">Login</a> menggunakan email di atas dan password yang diberikan saat pembuatan akun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Informasi Unit</h2>

                    <div class="space-y-3 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Unit</p>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">No. Unit</p>
                            <p class="font-mono">{{ $unit->unit_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Lokasi</p>
                            <p>{{ $unit->village?->district?->city?->name ?? '-' }}, {{ $unit->village?->district?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Status Approval</h2>

                    <div class="flex items-center gap-2 mt-4">
                        <span class="badge badge-lg badge-{{ $unit->approval_status->getColor() }}">
                            {{ $unit->approval_status->getLabel() }}
                        </span>
                    </div>

                    @if($unit->approved_at)
                        <p class="text-sm text-base-content/60 mt-2">
                            Disetujui: {{ $unit->approved_at->format('d M Y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.lpptka>
