/**
 * PWA Management Functions
 * Fitur untuk mengelola Progressive Web App
 */

// Cek status PWA
function checkPWAStatus() {
    const isOnline = navigator.onLine;
    const hasSW = 'serviceWorker' in navigator;

    let swStatus = 'Not Registered';
    let cacheStatus = 'Unknown';

    if (hasSW && navigator.serviceWorker.controller) {
        swStatus = 'Active';
    } else if (hasSW) {
        swStatus = 'Supported but not active';
    }

    // Check cache storage
    if ('caches' in window) {
        caches.keys().then(keys => {
            cacheStatus = keys.length > 0 ? `${keys.length} cache(s) available` : 'No cache';

            showPWAStatusModal(isOnline, swStatus, cacheStatus, keys);
        });
    } else {
        showPWAStatusModal(isOnline, swStatus, cacheStatus, []);
    }
}

// Tampilkan modal status PWA
function showPWAStatusModal(isOnline, swStatus, cacheStatus, cacheKeys) {
    const connectionColor = isOnline ? 'success' : 'error';
    const connectionText = isOnline ? 'Online' : 'Offline';
    const swColor = swStatus === 'Active' ? 'success' : 'warning';

    let cacheList = '';
    if (cacheKeys.length > 0) {
        cacheList = '<div class="mt-2"><strong>Cache Keys:</strong><ul class="list-disc ml-6">';
        cacheKeys.forEach(key => {
            cacheList += `<li>${key}</li>`;
        });
        cacheList += '</ul></div>';
    }

    const modal = document.createElement('div');
    modal.innerHTML = `
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Status PWA</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span>Status Koneksi</span>
                        <span class="badge badge-${connectionColor}">${connectionText}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span>Service Worker</span>
                        <span class="badge badge-${swColor}">${swStatus}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span>Cache Storage</span>
                        <span class="badge badge-info">${cacheStatus}</span>
                    </div>

                    ${cacheList}

                    <div class="divider"></div>

                    <div class="stats stats-vertical lg:stats-horizontal shadow w-full">
                        <div class="stat">
                            <div class="stat-title">Install Status</div>
                            <div class="stat-value text-sm">${isPWAInstalled() ? 'Installed' : 'Not Installed'}</div>
                        </div>

                        <div class="stat">
                            <div class="stat-title">Last Sync</div>
                            <div class="stat-value text-sm">${getLastSyncTime()}</div>
                        </div>
                    </div>
                </div>

                <div class="modal-action">
                    <button class="btn" onclick="this.closest('.modal').remove()">Tutup</button>
                </div>
            </div>
            <div class="modal-backdrop" onclick="this.closest('.modal').remove()"></div>
        </div>
    `;

    document.body.appendChild(modal);
}

// Clear offline cache
function clearOfflineCache() {
    if (!confirm('Apakah Anda yakin ingin menghapus semua cache offline? Data yang belum tersinkronisasi tidak akan hilang.')) {
        return;
    }

    if ('caches' in window) {
        caches.keys().then(keys => {
            Promise.all(
                keys.map(key => caches.delete(key))
            ).then(() => {
                showNotification('Cache berhasil dihapus', 'success');

                // Reload service worker
                if (navigator.serviceWorker.controller) {
                    navigator.serviceWorker.controller.postMessage({
                        type: 'CACHE_CLEARED'
                    });
                }
            }).catch(err => {
                console.error('Error clearing cache:', err);
                showNotification('Gagal menghapus cache', 'error');
            });
        });
    } else {
        showNotification('Cache Storage tidak didukung', 'warning');
    }
}

// Sync offline data
function syncOfflineData() {
    if (!navigator.onLine) {
        showNotification('Tidak dapat melakukan sinkronisasi saat offline', 'warning');
        return;
    }

    showNotification('Memulai sinkronisasi data...', 'info');

    // Trigger sync if available
    if ('serviceWorker' in navigator && 'SyncManager' in window) {
        navigator.serviceWorker.ready.then(registration => {
            return registration.sync.register('sync-data');
        }).then(() => {
            showNotification('Sinkronisasi dimulai', 'success');
        }).catch(err => {
            console.error('Sync registration failed:', err);
            manualSync();
        });
    } else {
        manualSync();
    }
}

// Manual sync fallback
function manualSync() {
    // Check for pending offline data
    if (typeof syncOfflineFormsToServer === 'function') {
        syncOfflineFormsToServer().then(result => {
            if (result && result.synced > 0) {
                showNotification(`${result.synced} data berhasil disinkronkan`, 'success');
            } else {
                showNotification('Tidak ada data yang perlu disinkronkan', 'info');
            }
        }).catch(err => {
            console.error('Manual sync failed:', err);
            showNotification('Gagal melakukan sinkronisasi', 'error');
        });
    } else {
        showNotification('Tidak ada data offline yang perlu disinkronkan', 'info');
    }
}

// Check if PWA is installed
function isPWAInstalled() {
    // Check if running in standalone mode
    if (window.matchMedia('(display-mode: standalone)').matches) {
        return true;
    }

    // Check if running on iOS in standalone mode
    if (window.navigator.standalone === true) {
        return true;
    }

    return false;
}

// Get last sync time
function getLastSyncTime() {
    const lastSync = localStorage.getItem('lastSyncTime');
    if (lastSync) {
        const date = new Date(parseInt(lastSync));
        return date.toLocaleString('id-ID');
    }
    return 'Belum pernah';
}

// Show notification
function showNotification(message, type = 'info') {
    const colors = {
        success: 'alert-success',
        error: 'alert-error',
        warning: 'alert-warning',
        info: 'alert-info'
    };

    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
    };

    const toast = document.createElement('div');
    toast.className = 'toast toast-top toast-end z-50';
    toast.innerHTML = `
        <div class="alert ${colors[type]} shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                ${icons[type]}
            </svg>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Install PWA prompt
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    // Show install button if available
    const installBtn = document.getElementById('pwa-install-btn');
    if (installBtn) {
        installBtn.classList.remove('hidden');
        installBtn.addEventListener('click', installPWA);
    }
});

function installPWA() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
                showNotification('PWA berhasil diinstall', 'success');
            }
            deferredPrompt = null;
        });
    }
}

// Update last sync time on successful sync
window.addEventListener('online', () => {
    localStorage.setItem('lastSyncTime', Date.now().toString());
});

// Export functions for global use
window.checkPWAStatus = checkPWAStatus;
window.clearOfflineCache = clearOfflineCache;
window.syncOfflineData = syncOfflineData;
window.installPWA = installPWA;
