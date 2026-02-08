// Service Worker Registration for BKPRMI KOTA MAKASSAR PWA
(function() {
    'use strict';

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', async () => {
            try {
                // Unregister old service workers first
                const registrations = await navigator.serviceWorker.getRegistrations();
                for (const registration of registrations) {
                    if (registration.scope !== window.location.origin + '/') {
                        await registration.unregister();
                        console.log('Unregistered old SW:', registration.scope);
                    }
                }

                const registration = await navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });

                console.log('✅ Service Worker registered successfully!');
                console.log('   Scope:', registration.scope);

                // Handle updates
                registration.addEventListener('updatefound', () => {
                    const newWorker = registration.installing;
                    console.log('🔄 New Service Worker found, installing...');

                    newWorker.addEventListener('statechange', () => {
                        console.log('   SW State:', newWorker.state);
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New content available
                            console.log('📦 New content available!');
                            if (confirm('Versi baru tersedia! Muat ulang untuk update?')) {
                                window.location.reload();
                            }
                        }
                    });
                });

                // Check if SW is active
                if (registration.active) {
                    console.log('✅ Service Worker is active');
                }

            } catch (error) {
                console.error('❌ Service Worker registration failed:', error);
            }
        });

        // Listen for controller change
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            console.log('🔄 Service Worker controller changed');
        });
    } else {
        console.warn('⚠️ Service Workers not supported in this browser');
    }

    // Listen for online/offline events
    window.addEventListener('online', () => {
        console.log('🌐 Back online');
        document.body.classList.remove('offline');
    });

    window.addEventListener('offline', () => {
        console.log('📴 Gone offline');
        document.body.classList.add('offline');
    });
})();
