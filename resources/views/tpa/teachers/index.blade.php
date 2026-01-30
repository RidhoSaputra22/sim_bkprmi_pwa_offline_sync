<x-layouts.tpa title="Daftar Guru">
    <x-slot:header>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Daftar Guru & Tenaga Pendidik</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
            <a href="{{ route('tpa.teachers.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Guru
            </a>
        </div>
    </x-slot:header>

    @if(session('success'))
    <div class="alert alert-success mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Total Guru</div>
                <div class="stat-value text-primary">{{ $teachers->total() }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Guru Aktif</div>
                <div class="stat-value text-success">{{ $unit->activeTeachers()->count() }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Bersertifikat LMD</div>
                <div class="stat-value text-info">{{ $unit->teachers()->withLMD()->count() }}</div>
            </div>
        </div>
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Bersertifikat Mengajar</div>
                <div class="stat-value text-warning">{{ $unit->teachers()->withTeachingCertification()->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Jabatan Utama</th>
                            <th>Status</th>
                            <th>Sertifikat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td>{{ $teachers->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($teacher->photo_path)
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            <img src="{{ Storage::url($teacher->photo_path) }}"
                                                alt="{{ $teacher->full_name }}" />
                                        </div>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ $teacher->full_name }}</div>
                                        <div class="text-sm opacity-50">{{ $teacher->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $teacher->nik }}</td>
                            <td>
                                <span class="badge badge-outline">{{ $teacher->jabatan_utama->label() }}</span>
                            </td>
                            <td>
                                @if($teacher->is_active)
                                <span class="badge badge-success">Aktif</span>
                                @else
                                <span class="badge badge-ghost">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex flex-col gap-1">
                                    @if($teacher->hasLMDCertification())
                                    <span class="badge badge-info badge-sm">{{ $teacher->level_lmd->label() }}</span>
                                    @endif
                                    @if($teacher->hasTeachingCertification())
                                    <span class="badge badge-warning badge-sm">{{
                                        $teacher->level_pelatihan_guru->label() }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('tpa.teachers.show', $teacher) }}"
                                        class="btn btn-sm btn-info btn-outline">
                                        Detail
                                    </a>
                                    <a href="{{ route('tpa.teachers.edit', $teacher) }}"
                                        class="btn btn-sm btn-warning btn-outline">
                                        Edit
                                    </a>
                                    <form action="{{ route('tpa.teachers.destroy', $teacher) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-outline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8">
                                <div class="text-base-content/50">
                                    Belum ada data guru. <a href="{{ route('tpa.teachers.create') }}"
                                        class="link link-primary">Tambah Guru</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($teachers->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $teachers->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.tpa>
