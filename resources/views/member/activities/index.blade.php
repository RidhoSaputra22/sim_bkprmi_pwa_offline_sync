<x-layouts.member title="Data Kegiatan">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Data Kegiatan</h1>
        <p class="text-base-content/60">Daftar kegiatan BKPRMI</p>
    </x-slot:header>

    <!-- Filter Section -->
    <div class="card bg-base-100 shadow-md mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('member.activities.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Cari Kegiatan</span>
                        </label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Nama atau deskripsi..."
                               class="input input-bordered w-full">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Mulai</span>
                        </label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="input input-bordered w-full">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tanggal Selesai</span>
                        </label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="input input-bordered w-full">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'start_date', 'end_date', 'unit_id']))
                    <div class="flex justify-end">
                        <a href="{{ route('member.activities.index') }}" class="btn btn-ghost btn-sm">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Activities List -->
    @if($activities->count() > 0)
        <div class="space-y-4">
            @foreach($activities as $activity)
                <div class="card bg-base-100 shadow-md hover:shadow-lg transition">
                    <div class="card-body">
                        <div class="flex flex-col lg:flex-row justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h2 class="card-title">
                                        <a href="{{ route('member.activities.show', $activity) }}" class="hover:text-primary">
                                            {{ $activity->name ?? $activity->title ?? 'Kegiatan' }}
                                        </a>
                                    </h2>
                                    @if($activity->is_featured ?? false)
                                        <span class="badge badge-warning">Featured</span>
                                    @endif
                                </div>

                                <p class="text-base-content/60 mb-4">
                                    {{ $activity->description ?? 'Tidak ada deskripsi' }}
                                </p>

                                <div class="flex flex-wrap gap-4 text-sm text-base-content/60">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span>{{ $activity->unit->name ?? 'N/A' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $activity->start_date?->format('d/m/Y') ?? '-' }}</span>
                                        @if($activity->end_date)
                                            <span>-</span>
                                            <span>{{ $activity->end_date->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-row lg:flex-col gap-2">
                                <a href="{{ route('member.activities.show', $activity) }}"
                                   class="btn btn-primary btn-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>

                                <a href="{{ route('member.activities.logs', $activity) }}"
                                   class="btn btn-outline btn-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Log
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    @else
        <div class="card bg-base-100 shadow-md">
            <div class="card-body text-center py-8">
                <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-base-content/50">
                    @if(request()->hasAny(['search', 'start_date', 'end_date', 'unit_id']))
                        Tidak ada kegiatan yang sesuai dengan filter
                    @else
                        Belum ada kegiatan tersedia
                    @endif
                </p>
            </div>
        </div>
    @endif
</x-layouts.member>
