<x-layouts.admin title="Data & Sinkronisasi">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.settings') }}">Pengaturan</a></li>
            <li>Data & Sinkronisasi</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Data & Sinkronisasi</h1>
        <p class="text-base-content/60">Kelola data offline dan sinkronisasi</p>
    </x-slot:header>

    <div class="space-y-6">
        <!-- Status Koneksi -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                    Status Koneksi
                </h2>

                <div class="flex items-center gap-4 mt-4">
                    <div id="connection-status-card" class="flex items-center gap-2">
                        <span id="status-online" class="badge badge-success gap-2">
                            <span class="w-2 h-2 bg-success-content rounded-full animate-pulse"></span>
                            Online
                        </span>
                        <span id="status-offline" class="badge badge-warning gap-2 hidden">
                            <span class="w-2 h-2 bg-warning-content rounded-full"></span>
                            Offline
                        </span>
                    </div>
                    <span id="last-sync-time" class="text-sm text-base-content/60">Terakhir sync: -</span>
                </div>
            </div>
        </div>

        <!-- Service Worker Status -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Service Worker
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Status</span>
                        <span id="sw-status" class="badge badge-ghost">Memeriksa...</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Scope</span>
                        <span id="sw-scope" class="text-sm font-mono text-base-content/60">-</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="updateServiceWorker()" class="btn btn-sm btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Update SW
                        </button>
                        <button onclick="unregisterServiceWorker()" class="btn btn-sm btn-ghost text-error">
                            Unregister
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Pending Sinkronisasi -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Data Menunggu Sinkronisasi
                    </h2>
                    <button onclick="syncAllData()" class="btn btn-sm btn-primary" id="sync-all-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Sinkronkan Semua
                    </button>
                </div>

                <div class="mt-4">
                    <div class="stats stats-vertical lg:stats-horizontal shadow w-full">
                        <div class="stat">
                            <div class="stat-figure text-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="stat-title">Total Pending</div>
                            <div class="stat-value text-primary" id="total-pending">0</div>
                            <div class="stat-desc">data menunggu upload</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <div class="stat-title">Arsip</div>
                            <div class="stat-value text-secondary" id="pending-archives-count">0</div>
                            <div class="stat-desc">file menunggu</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-accent">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="stat-title">Santri</div>
                            <div class="stat-value text-accent" id="pending-santri-count">0</div>
                            <div class="stat-desc">data menunggu</div>
                        </div>
                    </div>
                </div>

                <!-- Pending Items List -->
                <div class="mt-4">
                    <div class="collapse collapse-arrow bg-base-200">
                        <input type="checkbox" />
                        <div class="collapse-title font-medium">
                            Lihat Detail Data Pending
                        </div>
                        <div class="collapse-content">
                            <div id="pending-list" class="space-y-2 max-h-64 overflow-y-auto">
                                <p class="text-center text-base-content/60 py-4">Tidak ada data pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cache Storage -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                    Cache Storage
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Halaman Tersimpan</span>
                        <span id="cached-pages" class="badge badge-ghost">0 halaman</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Total Ukuran Cache</span>
                        <span id="cache-size" class="text-sm font-mono">Menghitung...</span>
                    </div>

                    <div class="divider"></div>

                    <div class="flex flex-wrap gap-2">
                        <button onclick="refreshCache()" class="btn btn-sm btn-outline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh Cache
                        </button>
                        <button onclick="clearCache()" class="btn btn-sm btn-outline btn-error">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Cache
                        </button>
                        <button onclick="precachePages()" class="btn btn-sm btn-outline btn-success">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Simpan Halaman Offline
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- IndexedDB Data -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    IndexedDB (Data Lokal)
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Database</span>
                        <span id="idb-status" class="badge badge-ghost">Memeriksa...</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Pending Sync</span>
                        <span id="idb-pending" class="badge badge-warning">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Cached Data</span>
                        <span id="idb-cached" class="badge badge-info">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Form Drafts</span>
                        <span id="idb-drafts" class="badge badge-secondary">0</span>
                    </div>

                    <div class="divider"></div>

                    <button onclick="clearIndexedDB()" class="btn btn-sm btn-outline btn-error">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Semua Data Lokal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Make functions globally available
    window.updateConnectionStatus = function() {
        const online = document.getElementById('status-online');
        const offline = document.getElementById('status-offline');

        if (navigator.onLine) {
            online.classList.remove('hidden');
            offline.classList.add('hidden');
        } else {
            online.classList.add('hidden');
            offline.classList.remove('hidden');
        }
    }

    window.checkServiceWorker = async function() {
        const statusEl = document.getElementById('sw-status');
        const scopeEl = document.getElementById('sw-scope');

        if (!('serviceWorker' in navigator)) {
            statusEl.textContent = 'Tidak Didukung';
            statusEl.className = 'badge badge-error';
            return;
        }

        try {
            const registration = await navigator.serviceWorker.getRegistration();
            if (registration) {
                if (registration.active) {
                    statusEl.textContent = 'Aktif';
                    statusEl.className = 'badge badge-success';
                } else if (registration.installing) {
                    statusEl.textContent = 'Menginstall...';
                    statusEl.className = 'badge badge-warning';
                } else if (registration.waiting) {
                    statusEl.textContent = 'Menunggu Aktivasi';
                    statusEl.className = 'badge badge-info';
                }
                scopeEl.textContent = registration.scope;
            } else {
                statusEl.textContent = 'Tidak Terdaftar';
                statusEl.className = 'badge badge-error';
            }
        } catch (error) {
            statusEl.textContent = 'Error';
            statusEl.className = 'badge badge-error';
        }
    }

    window.updateServiceWorker = async function() {
        if ('serviceWorker' in navigator) {
            const registration = await navigator.serviceWorker.getRegistration();
            if (registration) {
                await registration.update();
                window.syncManager?.showNotification('Service Worker diupdate!', 'success');
                checkServiceWorker();
            }
        }
    }

    window.unregisterServiceWorker = async function() {
        if (!confirm('Yakin ingin unregister Service Worker? Fitur offline akan dinonaktifkan.')) return;

        if ('serviceWorker' in navigator) {
            const registrations = await navigator.serviceWorker.getRegistrations();
            for (const registration of registrations) {
                await registration.unregister();
            }
            window.syncManager?.showNotification('Service Worker di-unregister', 'info');
            checkServiceWorker();
        }
    }

    window.updateAllStats = async function() {
        await updatePendingStats();
        await updateCacheStats();
        await updateIndexedDBStats();
    }

    window.updatePendingStats = async function() {
        try {
            const pending = await window.offlineDB?.getPendingSync() || [];

            const archives = pending.filter(p => p.type === 'archive-create').length;
            const santri = pending.filter(p => p.type === 'santri-create').length;
            const total = pending.length;

            document.getElementById('total-pending').textContent = total;
            document.getElementById('pending-archives-count').textContent = archives;
            document.getElementById('pending-santri-count').textContent = santri;

            // Update pending list
            const listEl = document.getElementById('pending-list');
            if (pending.length > 0) {
                listEl.innerHTML = pending.map(item => `
                    <div class="flex items-center justify-between p-3 bg-base-100 rounded-lg border">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="badge badge-sm ${getTypeBadgeClass(item.type)}">${item.type}</span>
                                <span class="font-medium">${item.data?.title || item.data?.full_name || 'Data'}</span>
                            </div>
                            <p class="text-xs text-base-content/60 mt-1">
                                ${new Date(item.timestamp).toLocaleString('id-ID')}
                            </p>
                        </div>
                        <button onclick="deletePendingItem(${item.id})" class="btn btn-ghost btn-xs text-error">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                `).join('');
            } else {
                listEl.innerHTML = '<p class="text-center text-base-content/60 py-4">Tidak ada data pending</p>';
            }
        } catch (e) {
            console.error('Error updating pending stats:', e);
        }
    }

    window.getTypeBadgeClass = function(type) {
        const classes = {
            'archive-create': 'badge-secondary',
            'santri-create': 'badge-accent',
            'form-submit': 'badge-primary'
        };
        return classes[type] || 'badge-ghost';
    }

    window.deletePendingItem = async function(id) {
        if (!confirm('Hapus data pending ini?')) return;

        await window.offlineDB?.updateSyncStatus(id, 'synced');
        await window.offlineDB?.deleteSyncedRequests();
        window.syncManager?.showNotification('Data pending dihapus', 'success');
        updatePendingStats();
    }

    window.updateCacheStats = async function() {
        try {
            if (!('caches' in window)) return;

            const cacheNames = await caches.keys();
            let totalSize = 0;
            let pageCount = 0;

            for (const cacheName of cacheNames) {
                const cache = await caches.open(cacheName);
                const keys = await cache.keys();
                pageCount += keys.filter(req => req.mode === 'navigate' || req.url.includes('.html')).length;

                // Estimate size
                for (const request of keys) {
                    try {
                        const response = await cache.match(request);
                        if (response) {
                            const blob = await response.clone().blob();
                            totalSize += blob.size;
                        }
                    } catch (e) {}
                }
            }

            document.getElementById('cached-pages').textContent = `${pageCount} halaman`;
            document.getElementById('cache-size').textContent = formatBytes(totalSize);
        } catch (e) {
            console.error('Error updating cache stats:', e);
        }
    }

    window.updateIndexedDBStats = async function() {
        try {
            const statusEl = document.getElementById('idb-status');

            if (!window.offlineDB?.isReady) {
                await window.offlineDB?.init();
            }

            if (window.offlineDB?.isReady) {
                statusEl.textContent = 'Aktif';
                statusEl.className = 'badge badge-success';

                const pending = await window.offlineDB.getPendingSync() || [];
                document.getElementById('idb-pending').textContent = pending.length;

                document.getElementById('idb-cached').textContent = '0';
                document.getElementById('idb-drafts').textContent = '0';
            } else {
                statusEl.textContent = 'Tidak Aktif';
                statusEl.className = 'badge badge-warning';
            }
        } catch (e) {
            document.getElementById('idb-status').textContent = 'Error';
            document.getElementById('idb-status').className = 'badge badge-error';
        }
    }

    window.syncAllData = async function() {
        const btn = document.getElementById('sync-all-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Menyinkronkan...';

        try {
            await window.syncManager?.syncAll();
            window.syncManager?.showNotification('Sinkronisasi selesai!', 'success');
        } catch (e) {
            window.syncManager?.showNotification('Gagal sinkronisasi: ' + e.message, 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg> Sinkronkan Semua`;
            updateAllStats();
        }
    }

    window.refreshCache = async function() {
        if ('serviceWorker' in navigator) {
            const registration = await navigator.serviceWorker.getRegistration();
            if (registration) {
                await registration.update();
            }
        }
        window.syncManager?.showNotification('Cache di-refresh', 'success');
        updateCacheStats();
    }

    window.clearCache = async function() {
        if (!confirm('Yakin ingin menghapus semua cache? Halaman yang tersimpan offline akan hilang.')) return;

        const cacheNames = await caches.keys();
        for (const cacheName of cacheNames) {
            await caches.delete(cacheName);
        }
        window.syncManager?.showNotification('Cache dihapus', 'info');
        updateCacheStats();
    }

    window.precachePages = async function() {
        const pages = [
            '/',
            '/admin',
            '/admin/santri',
            '/admin/santri/create',
            '/admin/activities',
            '/admin/archives',
            '/admin/archives/create',
            '/admin/settings',
            '/login'
        ];

        window.syncManager?.showNotification('Menyimpan halaman untuk offline...', 'info');

        try {
            const cache = await caches.open('sim-bkprmi-v3');
            let success = 0;

            for (const page of pages) {
                try {
                    const response = await fetch(page);
                    if (response.ok) {
                        await cache.put(page, response);
                        success++;
                    }
                } catch (e) {
                    console.log('Failed to cache:', page);
                }
            }

            window.syncManager?.showNotification(`${success} halaman tersimpan untuk offline`, 'success');
            updateCacheStats();
        } catch (e) {
            window.syncManager?.showNotification('Gagal menyimpan halaman', 'error');
        }
    }

    window.clearIndexedDB = async function() {
        if (!confirm('Yakin ingin menghapus semua data lokal? Data yang belum disinkronkan akan hilang!')) return;

        try {
            indexedDB.deleteDatabase('sim-bkprmi-offline');
            window.offlineDB = null;
            window.syncManager?.showNotification('Data lokal dihapus', 'info');

            setTimeout(() => {
                location.reload();
            }, 1000);
        } catch (e) {
            window.syncManager?.showNotification('Gagal menghapus data', 'error');
        }
    }

    window.formatBytes = function(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', async function() {
        await updateAllStats();
        updateConnectionStatus();
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        checkServiceWorker();
        setInterval(updateAllStats, 5000);
    });
    </script>
</x-layouts.admin>
