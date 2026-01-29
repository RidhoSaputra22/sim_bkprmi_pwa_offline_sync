<x-layouts.admin title="Upload Arsip">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.archives.index') }}">Arsip</a></li>
            <li>Upload</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Upload Arsip Baru</h1>
    </x-slot:header>

    <!-- Offline Status Indicator -->
    <div id="offline-form-status" class="mb-4 hidden">
        <div class="alert alert-warning">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Anda sedang offline. Data akan disimpan lokal dan disinkronkan saat online.</span>
        </div>
    </div>

    <!-- Pending Uploads Info -->
    <div id="pending-archives" class="mb-4 hidden">
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="pending-archives-count">0 arsip menunggu upload</span>
            <button type="button" onclick="viewPendingArchives()" class="btn btn-sm btn-ghost">Lihat</button>
        </div>
    </div>

    <x-ui.card>
        <form id="archive-form" method="POST" action="{{ route('admin.archives.store') }}" enctype="multipart/form-data"
            class="space-y-4">
            @csrf

            <x-ui.input name="title" label="Judul Arsip" placeholder="Masukkan judul arsip" :required="true" />

            <x-ui.textarea name="description" label="Deskripsi" placeholder="Deskripsi arsip (opsional)..." />

            <x-ui.select name="category" label="Kategori" :options="$categories" :required="true"
                placeholder="Pilih kategori" />

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">File <span class="text-error">*</span></span>
                </label>
                <input type="file" name="file" id="archive-file"
                    class="file-input file-input-bordered w-full @error('file') file-input-error @enderror"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.zip,.rar" required />
                @error('file')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
                @else
                <label class="label">
                    <span class="label-text-alt">Maksimal 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, ZIP,
                        RAR</span>
                </label>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t">
                <a href="{{ route('admin.archives.index') }}" class="btn btn-ghost">Batal</a>
                <x-ui.button type="primary" id="submit-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>

    <!-- Pending Archives Modal -->
    <dialog id="pending-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Arsip Menunggu Upload</h3>
            <div id="pending-list" class="py-4 space-y-2">
                <!-- Will be populated by JS -->
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>
</x-layouts.admin>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('archive-form');
    const fileInput = document.getElementById('archive-file');
    const submitBtn = document.getElementById('submit-btn');

    // Check for pending archives
    updatePendingArchivesUI();

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const file = fileInput.files[0];

        if (!file) {
            window.syncManager?.showNotification('Pilih file terlebih dahulu', 'error');
            return;
        }

        // Check file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            window.syncManager?.showNotification('Ukuran file maksimal 10MB', 'error');
            return;
        }

        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="loading loading-spinner loading-sm"></span> Mengupload...';

        try {
            if (navigator.onLine) {
                // Online: Submit normally
                form.submit();
            } else {
                // Offline: Save to IndexedDB with file
                await saveArchiveOffline(formData, file);
            }
        } catch (error) {
            console.error('Submit error:', error);

            // If network error, save offline
            if (!navigator.onLine) {
                await saveArchiveOffline(formData, file);
            } else {
                window.syncManager?.showNotification('Gagal mengupload: ' + error.message, 'error');
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    async function saveArchiveOffline(formData, file) {
        // Convert file to base64
        const base64 = await fileToBase64(file);

        const data = {
            title: formData.get('title'),
            description: formData.get('description'),
            category: formData.get('category'),
            file: {
                name: file.name,
                type: file.type,
                size: file.size,
                data: base64
            },
            _token: formData.get('_token')
        };

        await window.offlineDB.addPendingSync(
            'archive-create',
            '{{ route("admin.archives.store") }}',
            'POST',
            data
        );

        window.syncManager?.showNotification('Arsip disimpan offline. Akan diupload saat online.', 'info');
        window.syncManager?.updatePendingBadge();
        updatePendingArchivesUI();

        // Reset form
        form.reset();
    }

    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    async function updatePendingArchivesUI() {
        try {
            const pending = await window.offlineDB.getPendingSync();
            const archivePending = pending.filter(p => p.type === 'archive-create');

            const container = document.getElementById('pending-archives');
            const countEl = document.getElementById('pending-archives-count');

            if (archivePending.length > 0) {
                container.classList.remove('hidden');
                countEl.textContent = `${archivePending.length} arsip menunggu upload`;
            } else {
                container.classList.add('hidden');
            }
        } catch (e) {
            console.error('Error updating pending UI:', e);
        }
    }

    // Make viewPendingArchives global
    window.viewPendingArchives = async function() {
        const pending = await window.offlineDB.getPendingSync();
        const archivePending = pending.filter(p => p.type === 'archive-create');

        const list = document.getElementById('pending-list');
        list.innerHTML = archivePending.map(item => `
            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                <div>
                    <p class="font-medium">${item.data.title}</p>
                    <p class="text-sm text-base-content/60">${item.data.file?.name || 'No file'}</p>
                    <p class="text-xs text-base-content/40">${new Date(item.timestamp).toLocaleString('id-ID')}</p>
                </div>
                <button onclick="deletePendingArchive(${item.id})" class="btn btn-ghost btn-sm text-error">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        `).join('') || '<p class="text-center text-base-content/60">Tidak ada arsip pending</p>';

        document.getElementById('pending-modal').showModal();
    };

    window.deletePendingArchive = async function(id) {
        if (confirm('Hapus arsip pending ini?')) {
            await window.offlineDB.updateSyncStatus(id, 'synced'); // Mark as synced to delete
            await window.offlineDB.deleteSyncedRequests();
            window.syncManager?.updatePendingBadge();
            updatePendingArchivesUI();
            document.getElementById('pending-modal').close();
            window.syncManager?.showNotification('Arsip pending dihapus', 'success');
        }
    };

    // Listen for sync events
    window.syncManager?.onSync((event, data) => {
        if (event === 'sync-complete') {
            updatePendingArchivesUI();
        }
    });
});
</script>
@endpush