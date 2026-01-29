<x-layouts.tpa title="Daftar Santri">
    <x-slot:header>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Daftar Santri</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
            <a href="{{ route('tpa.santri.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Santri
            </a>
        </div>
    </x-slot:header>

    <!-- Filters -->
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <form action="{{ route('tpa.santri.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="form-control flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" class="input input-bordered"
                        placeholder="Cari nama santri...">
                </div>

                <div class="form-control w-40">
                    <select name="jenjang" class="select select-bordered">
                        <option value="">Semua Jenjang</option>
                        @foreach(\App\Enum\JenjangSantri::cases() as $jenjang)
                        <option value="{{ $jenjang->value }}"
                            {{ request('jenjang') == $jenjang->value ? 'selected' : '' }}>
                            {{ $jenjang->getLabel() }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-40">
                    <select name="status" class="select select-bordered">
                        <option value="">Semua Status</option>
                        @foreach(\App\Enum\StatusSantri::cases() as $status)
                        <option value="{{ $status->value }}"
                            {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->getLabel() }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-40">
                    <select name="gender" class="select select-bordered">
                        <option value="">L/P</option>
                        @foreach(\App\Enum\Gender::cases() as $gender)
                        <option value="{{ $gender->value }}"
                            {{ request('gender') == $gender->value ? 'selected' : '' }}>
                            {{ $gender->getLabel() }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>

                @if(request()->hasAny(['search', 'jenjang', 'status', 'gender']))
                <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Santri Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Nama Santri</th>
                            <th>L/P</th>
                            <th>Jenjang</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Wali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santris as $santri)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div
                                            class="bg-neutral text-neutral-content rounded-full w-10 flex items-center justify-center font-bold">
                                            <span>{{ substr($santri->person?->full_name ?? 'S', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $santri->person?->full_name ?? '-' }}</div>
                                        <div class="text-sm text-base-content/60">{{ $santri->person?->nik ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ $santri->person?->gender?->value == \App\Enum\Gender::LAKI_LAKI->value ? 'info' : 'secondary' }} badge-sm">
                                    {{ $santri->person?->gender?->getLabel() ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $santri->jenjang_santri?->getLabel() ?? '-' }}</td>
                            <td>{{ $santri->kelas_mengaji?->getLabel() ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ $santri->status_santri?->getColor() ?? 'ghost' }} badge-outline">
                                    {{ $santri->status_santri?->getLabel() ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @php($guardianSantri = $santri->guardianSantris->first())

                                @if($guardianSantri)
                                <div class="text-sm">
                                    {{ $guardianSantri->guardian?->person?->full_name ?? '-' }}
                                    <span
                                        class="text-base-content/60">({{ $guardianSantri->hubungan?->getLabel() ?? '-' }})</span>
                                </div>
                                @else
                                <span class="text-base-content/40">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('tpa.santri.show', $santri) }}" class="btn btn-ghost btn-xs"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('tpa.santri.edit', $santri) }}" class="btn btn-ghost btn-xs"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('tpa.santri.destroy', $santri) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-xs text-error" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/60">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p>Belum ada data santri</p>
                                <a href="{{ route('tpa.santri.create') }}" class="btn btn-primary btn-sm mt-4">
                                    Tambah Santri Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($santris->hasPages())
            <div class="mt-6">
                {{ $santris->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.tpa>