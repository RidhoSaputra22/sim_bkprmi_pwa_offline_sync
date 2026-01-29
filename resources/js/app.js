import './bootstrap';
import offlineSync from './offline-sync';

// Initialize PWA functionality
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // Service worker will be registered by vite-plugin-pwa
        console.log('PWA support enabled');

    });
}

// Setup offline sync event listeners
offlineSync.on('online', () => {
    document.body.classList.remove('is-offline');
    document.body.classList.add('is-online');
    updateConnectionStatus(true);
});

offlineSync.on('offline', () => {
    document.body.classList.remove('is-online');
    document.body.classList.add('is-offline');
    updateConnectionStatus(false);
});

offlineSync.on('syncStart', () => {
    const syncIndicator = document.getElementById('sync-indicator');
    if (syncIndicator) {
        syncIndicator.classList.add('syncing');
    }
});

offlineSync.on('syncComplete', () => {
    const syncIndicator = document.getElementById('sync-indicator');
    if (syncIndicator) {
        syncIndicator.classList.remove('syncing');
    }
});

function updateConnectionStatus(isOnline) {
    const statusIndicator = document.getElementById('connection-status');
    if (statusIndicator) {
        statusIndicator.textContent = isOnline ? 'Online' : 'Offline';
        statusIndicator.className = isOnline
            ? 'badge badge-success'
            : 'badge badge-warning';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    updateConnectionStatus(navigator.onLine);
});

// Alpine.js components (loaded via CDN in layouts)
document.addEventListener('alpine:init', () => {
    Alpine.data('unitForm', (initial = {}) => {
        const normalizeId = (value) => {
            if (value === undefined || value === null || value === '') return null;
            return String(value);
        };

        return {
            provinceId: normalizeId(initial.provinceId),
            cityId: normalizeId(initial.cityId),
            districtId: normalizeId(initial.districtId),
            villageId: normalizeId(initial.villageId),

            cities: [],
            districts: [],
            villages: [],

            async init() {
                if (this.provinceId) {
                    await this.loadCities(true);
                }
            },

            async loadCities(preserveSelection = false) {
                this.cities = [];
                this.districts = [];
                this.villages = [];

                if (!preserveSelection) {
                    this.cityId = null;
                    this.districtId = null;
                    this.villageId = null;
                }

                if (!this.provinceId) return;

                const response = await fetch(`/api/regions/cities?province_id=${this.provinceId}`, {
                    headers: { 'Accept': 'application/json' },
                });

                if (!response.ok) return;

                const data = await response.json();
                this.cities = Array.isArray(data) ? data : (data.data || []);

                if (preserveSelection && this.cityId) {
                    await this.loadDistricts(true);
                }
            },

            async loadDistricts(preserveSelection = false) {
                this.districts = [];
                this.villages = [];

                if (!preserveSelection) {
                    this.districtId = null;
                    this.villageId = null;
                }

                if (!this.cityId) return;

                const response = await fetch(`/api/regions/districts?city_id=${this.cityId}`, {
                    headers: { 'Accept': 'application/json' },
                });

                if (!response.ok) return;

                const data = await response.json();
                this.districts = Array.isArray(data) ? data : (data.data || []);

                if (preserveSelection && this.districtId) {
                    await this.loadVillages(true);
                }
            },

            async loadVillages(preserveSelection = false) {
                this.villages = [];

                if (!preserveSelection) {
                    this.villageId = null;
                }

                if (!this.districtId) return;

                const response = await fetch(`/api/regions/villages?district_id=${this.districtId}`, {
                    headers: { 'Accept': 'application/json' },
                });

                if (!response.ok) return;

                const data = await response.json();
                this.villages = Array.isArray(data) ? data : (data.data || []);
            },
        };
    });
});
