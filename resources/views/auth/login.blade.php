<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">

    <title>Login - SIM BKPRMI</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SIM BKPRMI">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Service Worker Registration -->
    <script src="{{ asset('register-sw.js') }}"></script>
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <!-- Logo -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-xl bg-primary flex items-center justify-center text-primary-content font-bold text-2xl mx-auto mb-4">
                    B
                </div>
                <h1 class="text-2xl font-bold">SIM BKPRMI</h1>
                <p class="text-base-content/60">Sistem Informasi Manajemen</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <x-ui.alert type="error" :dismissible="true">
                    {{ $errors->first() }}
                </x-ui.alert>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <x-ui.input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="admin@example.com"
                    :required="true"
                />

                <x-ui.input
                    name="password"
                    type="password"
                    label="Password"
                    placeholder="••••••••"
                    :required="true"
                />

                <div class="flex items-center justify-between">
                    <label class="label cursor-pointer gap-2">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm" />
                        <span class="label-text">Ingat saya</span>
                    </label>

                    <a href="#" class="link link-primary text-sm">Lupa password?</a>
                </div>

                <x-ui.button type="primary" class="w-full">
                    Login
                </x-ui.button>
            </form>

            <!-- Divider -->
            <div class="divider text-sm text-base-content/50">atau</div>

            <!-- Info -->
            <p class="text-center text-sm text-base-content/60">
                Belum punya akun?
                <a href="#" class="link link-primary">Hubungi Admin</a>
            </p>
        </div>
    </div>

    <!-- PWA Install Prompt -->
    <div id="pwa-install-prompt" class="fixed bottom-4 left-4 right-4 max-w-md mx-auto hidden">
        <div class="alert shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-bold">Install Aplikasi</h3>
                <div class="text-xs">Install SIM BKPRMI untuk akses lebih cepat</div>
            </div>
            <button class="btn btn-sm btn-primary" id="pwa-install-btn">Install</button>
            <button class="btn btn-sm btn-ghost" id="pwa-dismiss-btn">Nanti</button>
        </div>
    </div>

    <script>
        let deferredPrompt;
        const installPrompt = document.getElementById('pwa-install-prompt');
        const installBtn = document.getElementById('pwa-install-btn');
        const dismissBtn = document.getElementById('pwa-dismiss-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installPrompt.classList.remove('hidden');
        });

        installBtn?.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
                installPrompt.classList.add('hidden');
            }
        });

        dismissBtn?.addEventListener('click', () => {
            installPrompt.classList.add('hidden');
        });
    </script>
</body>
</html>
