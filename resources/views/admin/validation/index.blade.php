<x-layouts.admin title="Validasi Data">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Validasi Data</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div>
            <h1 class="text-2xl font-bold">Validasi Data</h1>
            <p class="text-base-content/60">Verifikasi data yang menunggu validasi</p>
        </div>
    </x-slot:header>

    <!-- Tabs -->
    <div class="tabs tabs-boxed mb-6">
        <a class="tab tab-active">Santri</a>
        <a class="tab">Kegiatan</a>
        <a class="tab">Unit</a>
    </div>

    <!-- Pending Santri -->
    <x-ui.card title="Santri Menunggu Validasi">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" id="select-all" />
                            </label>
                        </th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingSantri as $santri)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="checkbox item-checkbox" value="{{ $santri->id }}" />
                                </label>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-warning text-warning-content rounded-full w-10">
                                            <span>{{ substr($santri->person->full_name ?? 'S', 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $santri->person->full_name ?? '-' }}</div>
                                        <div class="text-sm text-base-content/60">
                                            {{ $santri->jenjang_santri?->getLabel() ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $santri->person->nik ?? '-' }}</td>
                            <td>{{ $santri->created_at?->format('d M Y') }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.validation.approve', ['type' => 'santri', 'id' => $santri->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Terima
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $santri->id }})" class="btn btn-error btn-sm btn-outline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-base-content/60">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada data yang menunggu validasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendingSantri->count() > 0)
            <x-slot:actions>
                <button onclick="bulkApprove()" class="btn btn-success">
                    Terima Semua Terpilih
                </button>
            </x-slot:actions>
        @endif

        @if($pendingSantri->hasPages())
            <div class="mt-4">
                {{ $pendingSantri->links() }}
            </div>
        @endif
    </x-ui.card>

    <!-- Reject Modal -->
    <x-ui.modal id="reject-modal" title="Tolak Data" size="sm">
        <form id="reject-form" method="POST">
            @csrf
            <x-ui.textarea name="reason" label="Alasan Penolakan" placeholder="Masukkan alasan penolakan..." :required="true" />

            <x-slot:actions>
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('reject-modal').close()">Batal</button>
                <button type="submit" class="btn btn-error">Tolak</button>
            </x-slot:actions>
        </form>
    </x-ui.modal>

    @push('scripts')
    <script>
        function openRejectModal(id) {
            document.getElementById('reject-form').action = `/admin/validation/reject/santri/${id}`;
            document.getElementById('reject-modal').showModal();
        }

        document.getElementById('select-all')?.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
        });

        function bulkApprove() {
            const selected = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                alert('Pilih minimal satu data');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.validation.bulk-approve") }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="type" value="santri" />
                ${selected.map(id => `<input type="hidden" name="ids[]" value="${id}" />`).join('')}
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @endpush
</x-layouts.admin>
