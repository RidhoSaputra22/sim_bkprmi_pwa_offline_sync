<x-layouts.superadmin title="Daftar Santri">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Daftar Santri</h1>
        <p class="text-base-content/60">Pantau data santri dari seluruh unit TPA</p>
    </x-slot:header>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-title">Total Santri</div>
            <div class="stat-value text-primary">{{ number_format($stats['total'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-success">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-title">Santri Aktif</div>
            <div class="stat-value text-success">{{ number_format($stats['aktif'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-info">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="stat-title">Laki-laki</div>
            <div class="stat-value text-info">{{ number_format($stats['male'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-secondary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="stat-title">Perempuan</div>
            <div class="stat-value text-secondary">{{ number_format($stats['female'] ?? 0) }}</div>
        </div>

        <div class="stat bg-base-100 rounded-lg shadow">
            <div class="stat-figure text-warning">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div class="stat-title">Lulus Wisuda</div>
            <div class="stat-value text-warning">{{ number_format($stats['graduated'] ?? 0) }}</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card bg-base-100 shadow mb-6">
        <div class="card-body">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="form-control">
                    <label class="label"><span class="label-text">Status Santri</span></label>
                    <select name="status" class="select select-bordered">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Masih Aktif</option>
                        <option value="lulus_wisuda" {{ request('status') == 'lulus_wisuda' ? 'selected' : '' }}>Lulus
                            Wisuda TPA</option>
                        <option value="lanjut_tqa" {{ request('status') == 'lanjut_tqa' ? 'selected' : '' }}>Lanjut TQA
                        </option>
                        <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="berhenti" {{ request('status') == 'berhenti' ? 'selected' : '' }}>Berhenti
                        </option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Jenjang</span></label>
                    <select name="jenjang" class="select select-bordered">
                        <option value="">Semua Jenjang</option>
                        <option value="tka" {{ request('jenjang') == 'tka' ? 'selected' : '' }}>TKA</option>
                        <option value="tpa" {{ request('jenjang') == 'tpa' ? 'selected' : '' }}>TPA</option>
                        <option value="tqa" {{ request('jenjang') == 'tqa' ? 'selected' : '' }}>TQA</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Jenis Kelamin</span></label>
                    <select name="gender" class="select select-bordered">
                        <option value="">Semua</option>
                        <option value="laki-laki" {{ request('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="perempuan" {{ request('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Cari</span></label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama santri, NIK..."
                        class="input input-bordered">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </button>
                <a href="{{ route('superadmin.santri.index') }}" class="btn btn-ghost">Reset</a>
            </form>
        </div>
    </div>

    <!-- Santri Table -->
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>NIK</th>
                            <th>L/P</th>
                            <th>Jenjang</th>
                            <th>Unit TPA</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($santris ?? [] as $index => $santri)
                        <tr>
                            <td>{{ ($santris->currentPage() - 1) * $santris->perPage() + $index + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div
                                            class="bg-neutral text-neutral-content rounded-full w-10 flex items-center justify-center">
                                            <span>{{ substr($santri->person->full_name ?? 'S', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $santri->person->full_name ?? '-' }}</div>
                                        <div class="text-sm opacity-50">{{ $santri->person->birth_place ?? '-' }},
                                            {{ $santri->person->birth_date?->format('d M Y') ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="font-mono text-sm">{{ $santri->person->nik ?? '-' }}</td>
                            <td>
                                @if($santri->person->gender?->value == 'laki-laki')
                                <span class="badge badge-info badge-sm">L</span>
                                @elseif($santri->person->gender?->value == 'perempuan')
                                <span class="badge badge-secondary badge-sm">P</span>
                                @else
                                <span class="badge badge-ghost badge-sm">-</span>
                                @endif
                            </td>
                            <td>
                                @if($santri->jenjang_santri)
                                <span class="badge badge-outline">{{ $santri->jenjang_santri->getLabel() }}</span>
                                @else
                                <span class="text-base-content/50">-</span>
                                @endif
                            </td>
                            <td class="text-sm">
                                @php
                                $unitName = $santri->santriUnits->first()?->unit?->name ?? '-';
                                @endphp
                                {{ $unitName }}
                            </td>
                            <td>
                                @if($santri->status_santri)
                                @php
                                $statusColor = match($santri->status_santri->value) {
                                'aktif' => 'success',
                                'lulus_wisuda' => 'warning',
                                'lanjut_tqa' => 'info',
                                'pindah' => 'secondary',
                                'berhenti' => 'error',
                                default => 'ghost'
                                };
                                @endphp
                                <span class="badge badge-{{ $statusColor }} ">
                                    {{ $santri->status_santri->getShortLabel() }}
                                </span>
                                @else
                                <span class="badge badge-ghost badge-sm">-</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-ghost js-santri-detail"
                                    data-santri-id="{{ $santri->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-base-content/60">
                                <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p>Tidak ada data santri yang ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($santris) && $santris->hasPages())
            <div class="mt-4">
                <div>
                    @php
                    $statusSantri = App\Enum\StatusSantri::cases();

                    @endphp
                    @foreach ($statusSantri as $status)
                    @php
                    $statusColor = match($status->value) {
                    'aktif' => 'success',
                    'lulus_wisuda' => 'warning',
                    'lanjut_tqa' => 'info',
                    'pindah' => 'secondary',
                    'berhenti' => 'error',
                    default => 'ghost'
                    };
                    @endphp
                    <div class="flex items-center gap-2 mb-1">
                        <span class="badge badge-{{ $statusColor }}">{{ $status->getShortLabel() }}</span>
                        <span class="badge badge-{{ $statusColor }}">{{ $status->getLabel() }}</span>
                    </div>

                    @endforeach
                </div>
                {{ $santris->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Detail Modal -->
    <dialog id="santri_detail_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Detail Santri</h3>
            <div id="santri_detail_content" class="space-y-4"
                data-detail-url-template="{{ route('superadmin.santri.detail', ['santri' => '__ID__']) }}">
                <div class="flex justify-center">
                    <span class="loading loading-spinner loading-lg"></span>
                </div>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
    function escapeHtml(value) {
        if (value === null || value === undefined) return '-';
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function showSantriDetail(santriId) {
        const modal = document.getElementById('santri_detail_modal');
        const content = document.getElementById('santri_detail_content');

        content.innerHTML =
            '<div class="flex justify-center py-8"><span class="loading loading-spinner loading-lg"></span></div>';
        modal.showModal();

        const urlTemplate = content.dataset.detailUrlTemplate;
        const url = urlTemplate.replace('__ID__', santriId);

        fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(async (res) => {
                const payload = await res.json().catch(() => null);
                if (!res.ok) {
                    const message = payload?.message || 'Gagal memuat detail santri.';
                    throw new Error(message);
                }
                return payload;
            })
            .then((payload) => {
                const data = payload?.data;
                if (!data) throw new Error('Data tidak ditemukan.');

                const person = data.person || {};
                const unit = data.unit || null;
                const jenjangLabel = data.jenjang?.label || '-';
                const kelasLabel = data.kelas?.label || '-';
                const statusLabel = data.status?.label || '-';
                const genderShort = person.gender === 'laki-laki' ? 'L' : (person.gender === 'perempuan' ? 'P' :
                    '-');

                const locationParts = [
                    data.location?.village,
                    data.location?.district,
                    data.location?.city,
                    data.location?.province
                ].filter(Boolean);
                const locationText = locationParts.length ? locationParts.join(', ') : '-';

                const addressText = [
                    data.address?.address,
                    (data.address?.rt || data.address?.rw) ?
                    `RT ${escapeHtml(data.address?.rt || '-')}/RW ${escapeHtml(data.address?.rw || '-')}` : null
                ].filter(Boolean).join(' • ') || '-';

                const guardians = Array.isArray(data.guardians) ? data.guardians : [];
                const guardiansHtml = guardians.length ?
                    `<div class="space-y-2">
                        ${guardians.map(g => `
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="font-semibold">${escapeHtml(g.full_name)}</div>
                                    <span class="badge badge-outline badge-sm">${escapeHtml(g.hubungan_label || g.hubungan)}</span>
                                </div>
                                <div class="text-sm text-base-content/70 mt-1">
                                    NIK: <span class="font-mono">${escapeHtml(g.nik)}</span> • HP: ${escapeHtml(g.phone)}
                                </div>
                            </div>
                        `).join('')}
                    </div>` :
                    `<div class="text-sm text-base-content/60">Tidak ada data wali.</div>`;

                content.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xl font-bold">${escapeHtml(person.full_name)}</div>
                                <div class="text-sm text-base-content/60">
                                    ${escapeHtml(person.birth_place)}${person.birth_date_human ? ', ' + escapeHtml(person.birth_date_human) : ''}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="badge badge-ghost">${escapeHtml(genderShort)}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">NIK</div>
                                <div class="font-mono">${escapeHtml(person.nik)}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">No. HP</div>
                                <div>${escapeHtml(person.phone)}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">Jenjang / Kelas</div>
                                <div>${escapeHtml(jenjangLabel)} / ${escapeHtml(kelasLabel)}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">Status</div>
                                <div>${escapeHtml(statusLabel)}</div>
                            </div>
                        </div>

                        <div class="p-3 rounded-lg bg-base-200">
                            <div class="text-xs text-base-content/60">Unit TPA</div>
                            <div>${unit ? `${escapeHtml(unit.name)} <span class="text-base-content/60">(${escapeHtml(unit.unit_number)})</span>` : '-'}</div>
                        </div>

                        <div class="p-3 rounded-lg bg-base-200">
                            <div class="text-xs text-base-content/60">Alamat</div>
                            <div class="text-sm">${escapeHtml(addressText)}</div>
                            <div class="text-sm text-base-content/60 mt-1">${escapeHtml(locationText)}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">Nama Ayah</div>
                                <div>${escapeHtml(data.parents?.nama_ayah)}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-base-200">
                                <div class="text-xs text-base-content/60">Nama Ibu</div>
                                <div>${escapeHtml(data.parents?.nama_ibu)}</div>
                            </div>
                        </div>

                        <div>
                            <div class="font-semibold mb-2">Data Wali</div>
                            ${guardiansHtml}
                        </div>
                    </div>
                `;
            })
            .catch((err) => {
                content.innerHTML = `
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${escapeHtml(err?.message || 'Terjadi kesalahan.')}</span>
                    </div>
                `;
            });
    }

    document.addEventListener('click', (e) => {
        const button = e.target.closest('.js-santri-detail');
        if (!button) return;
        const santriId = button.dataset.santriId;
        if (!santriId) return;
        showSantriDetail(santriId);
    });
    </script>
</x-layouts.superadmin>