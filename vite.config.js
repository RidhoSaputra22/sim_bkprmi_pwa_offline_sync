import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
            // Simple Vite plugin to remove @property at-rules from CSS to avoid
            // unknown at-rule warnings during esbuild CSS optimization.
            function stripPropertyAtRule() {
                return {
                    name: 'strip-property-at-rule',
                    enforce: 'post',
                    transform(code, id) {
                        if (typeof code !== 'string') return null;

                        // Only act if CSS @property appears in the code
                        if (!code.includes('@property')) return null;

                        // Remove any @property { ... } blocks
                        const cleaned = code.replace(/@property\s+[^{]+\{[^}]*\}/g, '');
                        if (cleaned === code) return null;
                        return {
                            code: cleaned,
                            map: null,
                        };
                    },
                };
            }(),
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: false, // We'll manually register with custom scope
            strategies: 'injectManifest',
            srcDir: 'resources/js',
            filename: 'sw.js',
            injectManifest: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg,woff,woff2}'],
            },
            manifest: {
                name: 'SIM BKPRMI',
                short_name: 'BKPRMI',
                description: 'Sistem Informasi Manajemen BKPRMI',
                theme_color: '#1e40af',
                background_color: '#ffffff',
                display: 'standalone',
                scope: '/',
                start_url: '/',
                icons: [
                    {
                        src: '/icons/icon-72x72.png',
                        sizes: '72x72',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-96x96.png',
                        sizes: '96x96',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-128x128.png',
                        sizes: '128x128',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-144x144.png',
                        sizes: '144x144',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-152x152.png',
                        sizes: '152x152',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-384x384.png',
                        sizes: '384x384',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    },
                    {
                        src: '/icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'maskable'
                    }
                ],
                screenshots: [
                    {
                        src: '/icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        form_factor: 'wide',
                        label: 'SIM BKPRMI Dashboard'
                    },
                    {
                        src: '/icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        form_factor: 'narrow',
                        label: 'SIM BKPRMI Mobile'
                    }
                ]
            }
        })
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
