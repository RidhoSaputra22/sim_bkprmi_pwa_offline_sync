const CACHE_NAME = 'sim-bkprmi-v4';
const OFFLINE_URL = '/offline.html';

// Assets to precache
const PRECACHE_ASSETS = [
    '/offline.html',
    '/login',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/manifest.webmanifest',
    '/register-sw.js',
];

// Install - cache assets
self.addEventListener('install', (event) => {
    console.log('[SW] Installing v4...');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Precaching assets');
                // Cache what we can, don't fail if some fail
                return Promise.allSettled(
                    PRECACHE_ASSETS.map(url =>
                        cache.add(url).catch(err => console.log('[SW] Failed to cache:', url, err))
                    )
                );
            })
            .then(() => {
                console.log('[SW] Precaching complete');
                return self.skipWaiting();
            })
    );
});

// Activate - cleanup and take control
self.addEventListener('activate', (event) => {
    console.log('[SW] Activating v4...');
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name !== CACHE_NAME)
                        .map((name) => {
                            console.log('[SW] Deleting old cache:', name);
                            return caches.delete(name);
                        })
                );
            })
            .then(() => {
                console.log('[SW] Taking control of clients');
                return self.clients.claim();
            })
    );
});

// Fetch - Network first, fallback to cache, then offline page
self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // Only handle GET requests
    if (request.method !== 'GET') return;

    // Skip non-http(s)
    if (!url.protocol.startsWith('http')) return;

    // Handle navigation (HTML pages)
    if (request.mode === 'navigate') {
        event.respondWith(handleNavigation(request));
        return;
    }

    // Handle other requests (assets, etc)
    event.respondWith(handleAsset(request));
});

// Handle navigation requests
async function handleNavigation(request) {
    try {
        // Try network first
        const response = await fetch(request);

        // Cache successful response
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }

        return response;
    } catch (error) {
        console.log('[SW] Navigation failed, trying cache:', request.url);

        // Try cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Return offline page
        console.log('[SW] Returning offline page');
        const offlinePage = await caches.match(OFFLINE_URL);
        if (offlinePage) {
            return offlinePage;
        }

        // Last resort - return a simple offline response
        return new Response(
            `<!DOCTYPE html>
            <html>
            <head><title>Offline</title><meta name="viewport" content="width=device-width,initial-scale=1"></head>
            <body style="font-family:sans-serif;text-align:center;padding:50px;background:#1e40af;color:white;min-height:100vh;margin:0;display:flex;flex-direction:column;justify-content:center;">
                <h1>📴 Anda Offline</h1>
                <p>Halaman ini belum tersimpan di cache.</p>
                <p>Kunjungi halaman ini saat online terlebih dahulu.</p>
                <button onclick="location.reload()" style="padding:12px 24px;font-size:16px;cursor:pointer;background:white;color:#1e40af;border:none;border-radius:8px;margin-top:20px;">Coba Lagi</button>
            </body>
            </html>`,
            {
                status: 503,
                headers: { 'Content-Type': 'text/html; charset=utf-8' }
            }
        );
    }
}

// Handle asset requests
async function handleAsset(request) {
    // Try cache first for assets
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        // Update cache in background
        fetch(request)
            .then(response => {
                if (response.ok) {
                    caches.open(CACHE_NAME).then(cache => cache.put(request, response));
                }
            })
            .catch(() => {});
        return cachedResponse;
    }

    // Not in cache, fetch from network
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        // Return empty response for failed assets
        return new Response('', { status: 408 });
    }
}
