/**
 * BKPRMI KOTA MAKASSAR - Offline Database Manager
 * Uses IndexedDB for offline data storage
 */

const DB_NAME = 'sim-bkprmi-offline';
const DB_VERSION = 1;

class OfflineDB {
    constructor() {
        this.db = null;
        this.isReady = false;
    }

    async init() {
        if (this.isReady) return this.db;

        return new Promise((resolve, reject) => {
            const request = indexedDB.open(DB_NAME, DB_VERSION);

            request.onerror = () => {
                console.error('[OfflineDB] Failed to open database');
                reject(request.error);
            };

            request.onsuccess = () => {
                this.db = request.result;
                this.isReady = true;
                console.log('[OfflineDB] Database ready');
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Store for pending sync requests
                if (!db.objectStoreNames.contains('pending_sync')) {
                    const syncStore = db.createObjectStore('pending_sync', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    syncStore.createIndex('timestamp', 'timestamp', { unique: false });
                    syncStore.createIndex('type', 'type', { unique: false });
                    syncStore.createIndex('status', 'status', { unique: false });
                }

                // Store for cached data (santri, units, etc)
                if (!db.objectStoreNames.contains('cached_data')) {
                    const cacheStore = db.createObjectStore('cached_data', {
                        keyPath: 'key'
                    });
                    cacheStore.createIndex('type', 'type', { unique: false });
                    cacheStore.createIndex('updated_at', 'updated_at', { unique: false });
                }

                // Store for form drafts
                if (!db.objectStoreNames.contains('form_drafts')) {
                    const draftStore = db.createObjectStore('form_drafts', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    draftStore.createIndex('form_id', 'form_id', { unique: false });
                    draftStore.createIndex('created_at', 'created_at', { unique: false });
                }

                console.log('[OfflineDB] Database schema created');
            };
        });
    }

    // Add a pending sync request
    async addPendingSync(type, url, method, data, headers = {}) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pending_sync'], 'readwrite');
            const store = transaction.objectStore('pending_sync');

            const record = {
                type,
                url,
                method,
                data,
                headers,
                timestamp: Date.now(),
                status: 'pending',
                retries: 0
            };

            const request = store.add(record);
            request.onsuccess = () => {
                console.log('[OfflineDB] Added pending sync:', type);
                resolve(request.result);
            };
            request.onerror = () => reject(request.error);
        });
    }

    // Get all pending sync requests
    async getPendingSync() {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pending_sync'], 'readonly');
            const store = transaction.objectStore('pending_sync');
            const index = store.index('status');
            const request = index.getAll('pending');

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    // Update sync request status
    async updateSyncStatus(id, status, error = null) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pending_sync'], 'readwrite');
            const store = transaction.objectStore('pending_sync');
            const getRequest = store.get(id);

            getRequest.onsuccess = () => {
                const record = getRequest.result;
                if (record) {
                    record.status = status;
                    record.error = error;
                    record.synced_at = status === 'synced' ? Date.now() : null;
                    record.retries = (record.retries || 0) + (status === 'failed' ? 1 : 0);

                    const putRequest = store.put(record);
                    putRequest.onsuccess = () => resolve(record);
                    putRequest.onerror = () => reject(putRequest.error);
                } else {
                    reject(new Error('Record not found'));
                }
            };
            getRequest.onerror = () => reject(getRequest.error);
        });
    }

    // Delete synced requests
    async deleteSyncedRequests() {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pending_sync'], 'readwrite');
            const store = transaction.objectStore('pending_sync');
            const index = store.index('status');
            const request = index.openCursor('synced');

            request.onsuccess = (event) => {
                const cursor = event.target.result;
                if (cursor) {
                    store.delete(cursor.primaryKey);
                    cursor.continue();
                } else {
                    resolve();
                }
            };
            request.onerror = () => reject(request.error);
        });
    }

    // Cache data for offline use
    async cacheData(key, type, data) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['cached_data'], 'readwrite');
            const store = transaction.objectStore('cached_data');

            const record = {
                key,
                type,
                data,
                updated_at: Date.now()
            };

            const request = store.put(record);
            request.onsuccess = () => resolve(record);
            request.onerror = () => reject(request.error);
        });
    }

    // Get cached data
    async getCachedData(key) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['cached_data'], 'readonly');
            const store = transaction.objectStore('cached_data');
            const request = store.get(key);

            request.onsuccess = () => resolve(request.result?.data || null);
            request.onerror = () => reject(request.error);
        });
    }

    // Save form draft
    async saveDraft(formId, data) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['form_drafts'], 'readwrite');
            const store = transaction.objectStore('form_drafts');

            const record = {
                form_id: formId,
                data,
                created_at: Date.now()
            };

            const request = store.add(record);
            request.onsuccess = () => {
                console.log('[OfflineDB] Draft saved:', formId);
                resolve(request.result);
            };
            request.onerror = () => reject(request.error);
        });
    }

    // Get form drafts
    async getDrafts(formId = null) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['form_drafts'], 'readonly');
            const store = transaction.objectStore('form_drafts');

            let request;
            if (formId) {
                const index = store.index('form_id');
                request = index.getAll(formId);
            } else {
                request = store.getAll();
            }

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    // Delete draft
    async deleteDraft(id) {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['form_drafts'], 'readwrite');
            const store = transaction.objectStore('form_drafts');
            const request = store.delete(id);

            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    // Get pending sync count
    async getPendingSyncCount() {
        await this.init();

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pending_sync'], 'readonly');
            const store = transaction.objectStore('pending_sync');
            const index = store.index('status');
            const request = index.count('pending');

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }
}

// Export singleton instance
window.offlineDB = new OfflineDB();
