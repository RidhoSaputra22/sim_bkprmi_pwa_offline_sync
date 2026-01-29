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
