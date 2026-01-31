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
    <meta name="apple-mobile-web-app-title" content="SIM BKPRMI">

    <title>{{ $title ?? 'SIM BKPRMI' }} - SuperAdmin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('register-sw.js') }}"></script>
    <script src="{{ asset('js/pwa-management.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-base-200">
    <div class="drawer lg:drawer-open">
        <input id="superadmin-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 border-b border-base-300 sticky top-0 z-30">
                <div class="flex-none lg:hidden">
                    <label for="superadmin-drawer" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <span class="text-lg font-semibold">{{ $title ?? 'SuperAdmin BKPRMI' }}</span>
                </div>
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                            <div
                                class="bg-primary text-primary-content rounded-full w-10 flex items-center justify-center font-bold">
                                <span>{{ substr(auth()->user()->person->full_name ?? 'S', 0, 1) }}</span>
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li class="menu-title">
                                <span>{{ auth()->user()->person->full_name ?? 'SuperAdmin' }}</span>
                            </li>

                            <li>
                                <a href="{{ route('superadmin.profile') }}" class="{{ request()->routeIs('superadmin.profile') ? 'active' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil
                                </a>
                            </li>

                            <div class="divider my-1"></div>

                            <li>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-6">
                @if(isset($header))
                <div class="mb-6">
                    {{ $header }}
                </div>
                @endif

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="footer footer-center p-4 bg-base-300 text-base-content">
                <aside>
                    <p>© {{ date('Y') }} BKPRMI - SuperAdmin Panel</p>
                </aside>
            </footer>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-40">
            <label for="superadmin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside class="bg-base-100 min-h-screen w-64 border-r border-base-300">
                <div class="p-4 border-b border-base-300">
                    <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-error flex items-center justify-center text-error-content font-bold">
                            SA
                        </div>
                        <div>
                            <h1 class="font-bold text-lg">BKPRMI</h1>
                            <p class="text-xs text-base-content/60">SuperAdmin</p>
                        </div>
                    </a>
                </div>

                <ul class="menu p-4 w-full">
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li class="menu-title mt-4">
                        <span>Approval TPA</span>
                    </li>

                    <li>
                        <a href="{{ route('superadmin.units.approval.index') }}"
                            class="{{ request()->routeIs('superadmin.units.approval.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Approval Unit
                        </a>
                    </li>

                    <li class="menu-title mt-4">
                        <span>Data</span>
                    </li>

                    <li>
                        <a href="{{ route('superadmin.units.index') }}"
                            class="{{ request()->routeIs('superadmin.units.index') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Semua Unit
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('superadmin.santri.index') }}"
                            class="{{ request()->routeIs('superadmin.santri.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Semua Santri
                        </a>
                    </li>

                    <li class="menu-title mt-4">
                        <span>Laporan</span>
                    </li>

                    <li>
                        <a href="{{ route('superadmin.reports.index') }}"
                            class="{{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Laporan
                        </a>
                    </li>

                    <li class="menu-title mt-4">
                        <span>PWA & Offline</span>
                    </li>

                    <li>
                        <details>
                            <summary>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                </svg>
                                PWA Management
                            </summary>
                            <ul>
                                <li><a href="#" onclick="checkPWAStatus(); return false;">Status PWA</a></li>
                                <li><a href="#" onclick="clearOfflineCache(); return false;">Clear Cache</a></li>
                                <li><a href="#" onclick="syncOfflineData(); return false;">Sync Data</a></li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </aside>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
