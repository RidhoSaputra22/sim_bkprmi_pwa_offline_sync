<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">
    <meta name="description" content="Sistem Informasi Manajemen BKPRMI">

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="BKPRMI KOTA MAKASSAR">

    <title>{{ $title ?? 'BKPRMI KOTA MAKASSAR' }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Service Worker Registration -->
    <script src="{{ asset('register-sw.js') }}"></script>

    <!-- Offline Support Scripts -->
    <script src="{{ asset('js/offline-db.js') }}"></script>
    <script src="{{ asset('js/offline-sync.js') }}"></script>
    <script src="{{ asset('js/offline-form.js') }}"></script>
    <script src="{{ asset('js/pwa-management.js') }}"></script>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-base-200">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <x-admin.navbar />

            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-6">
                <!-- Breadcrumb -->
                @if(isset($breadcrumb))
                <div class="text-sm breadcrumbs mb-4">
                    {{ $breadcrumb }}
                </div>
                @endif

                <!-- Page Header -->
                @if(isset($header))
                <div class="mb-6">
                    {{ $header }}
                </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-base-300 text-base-content">
                <aside>
                    <p>© {{ date('Y') }} BKPRMI - Sistem Informasi Manajemen</p>
                </aside>
            </footer>
        </div>

        <!-- Sidebar -->
        <x-admin.sidebar />
    </div>

    <!-- Toast Container -->
    <x-ui.toast />

    <!-- Offline Indicator -->
    <div id="offline-indicator" class="offline-indicator hidden">
        <div class="alert alert-warning shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Anda sedang offline</span>
        </div>
    </div>

    <script>
    // Show/hide offline indicator
    function updateOfflineIndicator() {
        const indicator = document.getElementById('offline-indicator');
        const onlineIndicator = document.getElementById('online-indicator');
        const connectionStatus = document.getElementById('connection-status');
        const formStatus = document.getElementById('offline-form-status');

        if (connectionStatus) {
            connectionStatus.classList.remove('hidden');
            connectionStatus.classList.add('flex');
        }

        if (navigator.onLine) {
            indicator?.classList.add('hidden');
            onlineIndicator?.classList.remove('hidden');
            formStatus?.classList.add('hidden');
        } else {
            indicator?.classList.remove('hidden');
            onlineIndicator?.classList.add('hidden');
            formStatus?.classList.remove('hidden');
        }
    }

    window.addEventListener('online', updateOfflineIndicator);
    window.addEventListener('offline', updateOfflineIndicator);
    document.addEventListener('DOMContentLoaded', updateOfflineIndicator);
    </script>

    @stack('scripts')
</body>

</html>
