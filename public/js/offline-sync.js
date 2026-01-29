/**
 * SIM BKPRMI - Offline Sync Manager
 * Handles syncing offline data when back online
 */

class OfflineSyncManager {
    constructor() {
        this.isSyncing = false;
        this.syncQueue = [];
        this.listeners = [];
    }

    init() {
        // Listen for online event
        window.addEventListener('online', () => {
            console.log('[Sync] Back online, starting sync...');
            this.showNotification('Koneksi kembali! Menyinkronkan data...', 'info');
            this.syncAll();
        });

        window.addEventListener('offline', () => {
            console.log('[Sync] Gone offline');
            this.showNotification('Anda sedang offline. Data akan disimpan lokal.', 'warning');
        });

        // Try to sync on page load if online
        if (navigator.onLine) {
            setTimeout(() => this.syncAll(), 2000);
        }

        // Update UI badge
        this.updatePendingBadge();

        console.log('[Sync] Sync manager initialized');
    }

    // Add listener for sync events
    onSync(callback) {
        this.listeners.push(callback);
    }

    // Notify listeners
    notifyListeners(event, data) {
        this.listeners.forEach(cb => cb(event, data));
    }

    // Sync all pending requests
    async syncAll() {
        if (this.isSyncing || !navigator.onLine) {
            console.log('[Sync] Skip sync:', this.isSyncing ? 'already syncing' : 'offline');
            return;
        }

        this.isSyncing = true;
        this.notifyListeners('sync-start', {});

        try {
            const pending = await window.offlineDB.getPendingSync();
            console.log('[Sync] Found', pending.length, 'pending requests');

            if (pending.length === 0) {
                this.isSyncing = false;
                return;
            }

            let successCount = 0;
            let failCount = 0;

            for (const item of pending) {
                try {
                    await this.syncItem(item);
                    await window.offlineDB.updateSyncStatus(item.id, 'synced');
                    successCount++;
                    console.log('[Sync] Synced:', item.type, item.url);
                } catch (error) {
                    console.error('[Sync] Failed:', item.type, error);
                    await window.offlineDB.updateSyncStatus(item.id, 'failed', error.message);
                    failCount++;
                }
            }

            // Clean up synced items
            await window.offlineDB.deleteSyncedRequests();

            // Show result
            if (successCount > 0) {
                this.showNotification(`${successCount} data berhasil disinkronkan!`, 'success');
            }
            if (failCount > 0) {
                this.showNotification(`${failCount} data gagal disinkronkan. Akan dicoba lagi.`, 'error');
            }

            this.notifyListeners('sync-complete', { success: successCount, failed: failCount });

        } catch (error) {
            console.error('[Sync] Sync error:', error);
            this.showNotification('Gagal menyinkronkan data', 'error');
        } finally {
            this.isSyncing = false;
            this.updatePendingBadge();
        }
    }

    // Sync single item
    async syncItem(item) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Check if this is a file upload (archive)
        if (item.type === 'archive-create' && item.data.file) {
            return this.syncFileUpload(item, csrfToken);
        }

        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            ...item.headers
        };

        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }

        const response = await fetch(item.url, {
            method: item.method,
            headers,
            body: item.method !== 'GET' ? JSON.stringify(item.data) : undefined,
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || `HTTP ${response.status}`);
        }

        return response.json();
    }

    // Sync file upload (for archives)
    async syncFileUpload(item, csrfToken) {
        const formData = new FormData();

        // Add regular fields
        formData.append('title', item.data.title);
        formData.append('description', item.data.description || '');
        formData.append('category', item.data.category);
        formData.append('_token', csrfToken);

        // Convert base64 back to file
        if (item.data.file && item.data.file.data) {
            const blob = await this.base64ToBlob(item.data.file.data, item.data.file.type);
            formData.append('file', blob, item.data.file.name);
        }

        const response = await fetch(item.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData,
            credentials: 'same-origin'
        });

        if (!response.ok) {
            // Try to get error message
            const text = await response.text();
            let errorMessage = `HTTP ${response.status}`;
            try {
                const json = JSON.parse(text);
                errorMessage = json.message || errorMessage;
            } catch (e) {}
            throw new Error(errorMessage);
        }

        // Response might be redirect or JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        }

        return { success: true };
    }

    // Convert base64 to Blob
    async base64ToBlob(base64, mimeType) {
        // Remove data URL prefix if present
        const base64Data = base64.includes(',') ? base64.split(',')[1] : base64;

        const byteCharacters = atob(base64Data);
        const byteArrays = [];

        for (let offset = 0; offset < byteCharacters.length; offset += 512) {
            const slice = byteCharacters.slice(offset, offset + 512);
            const byteNumbers = new Array(slice.length);

            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            byteArrays.push(new Uint8Array(byteNumbers));
        }

        return new Blob(byteArrays, { type: mimeType });
    }

    // Save data for offline sync
    async saveForSync(type, url, method, data) {
        try {
            const id = await window.offlineDB.addPendingSync(type, url, method, data);
            console.log('[Sync] Saved for sync:', type);
            this.showNotification('Data disimpan offline. Akan disinkronkan saat online.', 'info');
            this.updatePendingBadge();
            return id;
        } catch (error) {
            console.error('[Sync] Failed to save:', error);
            throw error;
        }
    }

    // Update pending badge in UI
    async updatePendingBadge() {
        try {
            const count = await window.offlineDB.getPendingSyncCount();
            const badge = document.getElementById('offline-sync-badge');

            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            // Update any sync status indicators
            const statusEl = document.getElementById('offline-sync-status');
            if (statusEl) {
                if (count > 0) {
                    statusEl.innerHTML = `<span class="text-warning">📤 ${count} data menunggu sinkronisasi</span>`;
                } else {
                    statusEl.innerHTML = `<span class="text-success">✅ Semua data tersinkronisasi</span>`;
                }
            }
        } catch (error) {
            console.error('[Sync] Badge update error:', error);
        }
    }

    // Show notification toast
    showNotification(message, type = 'info') {
        // Check if there's a toast container
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast toast-top toast-end z-50';
            document.body.appendChild(container);
        }

        const alertClass = {
            'info': 'alert-info',
            'success': 'alert-success',
            'warning': 'alert-warning',
            'error': 'alert-error'
        }[type] || 'alert-info';

        const toast = document.createElement('div');
        toast.className = `alert ${alertClass} shadow-lg`;
        toast.innerHTML = `
            <span>${message}</span>
        `;

        container.appendChild(toast);

        // Remove after 4 seconds
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Check if online
    isOnline() {
        return navigator.onLine;
    }
}

// Export singleton
window.syncManager = new OfflineSyncManager();

// Initialize when DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.offlineDB.init().then(() => {
        window.syncManager.init();
    });
});
