<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">

    <title>Reset Password - SIM BKPRMI</title>

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
                <h1 class="text-2xl font-bold">Reset Password</h1>
                <p class="text-base-content/60">Masukkan password baru Anda</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <x-ui.alert type="error" :dismissible="true">
                    {{ $errors->first() }}
                </x-ui.alert>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Email</span>
                    </label>
                    <input type="email" value="{{ $email }}" class="input input-bordered" disabled readonly />
                </div>

                <x-ui.input
                    name="password"
                    type="password"
                    label="Password Baru"
                    placeholder="Minimal 8 karakter"
                    :required="true"
                />

                <x-ui.input
                    name="password_confirmation"
                    type="password"
                    label="Konfirmasi Password Baru"
                    placeholder="Ketik ulang password"
                    :required="true"
                />

                <div class="alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-sm">
                        <div class="font-semibold">Ketentuan Password:</div>
                        <ul class="list-disc ml-4 mt-1">
                            <li>Minimal 8 karakter</li>
                            <li>Gunakan kombinasi huruf dan angka</li>
                            <li>Pastikan password mudah diingat</li>
                        </ul>
                    </div>
                </div>

                <x-ui.button type="primary" class="w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Reset Password
                </x-ui.button>
            </form>

            <!-- Divider -->
            <div class="divider text-sm text-base-content/50">atau</div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="btn btn-ghost btn-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.querySelectorAll('input[type="password"]').forEach(input => {
            const wrapper = input.parentElement;
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-base-content/50 hover:text-base-content';
            toggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>';

            wrapper.style.position = 'relative';
            wrapper.appendChild(toggleBtn);

            toggleBtn.addEventListener('click', () => {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
            });
        });
    </script>
</body>
</html>
