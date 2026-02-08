<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">

    <title>Lupa Password - BKPRMI KOTA MAKASSAR</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="BKPRMI KOTA MAKASSAR">

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
                <h1 class="text-2xl font-bold">Lupa Password</h1>
                <p class="text-base-content/60">Masukkan email Anda untuk reset password</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <x-ui.alert type="success" :dismissible="true">
                    {{ session('success') }}
                </x-ui.alert>
            @endif

            <!-- Info Message -->
            @if(session('info'))
                <x-ui.alert type="info" :dismissible="true">
                    {{ session('info') }}
                </x-ui.alert>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <x-ui.alert type="error" :dismissible="true">
                    {{ $errors->first() }}
                </x-ui.alert>
            @endif

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <x-ui.input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="admin@example.com"
                    :required="true"
                    value="{{ old('email') }}"
                />

                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">Link reset password akan dikirim ke email Anda.</span>
                </div>

                <x-ui.button type="primary" class="w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim Link Reset Password
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
</body>
</html>
