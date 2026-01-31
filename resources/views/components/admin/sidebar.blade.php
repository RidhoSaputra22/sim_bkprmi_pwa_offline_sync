{{-- Admin Sidebar Component --}}

<div class="drawer-side z-40">
    <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

    <aside class="bg-base-100 min-h-screen w-64 border-r border-base-300">
        <!-- Logo/Brand -->
        <div class="p-4 border-b border-base-300">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-primary-content font-bold">
                    B
                </div>
                <div>
                    <h1 class="font-bold text-lg">BKPRMI</h1>
                    <p class="text-xs text-base-content/60">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <ul class="menu p-4 w-full">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <li class="menu-title mt-4">
                <span>Data Master</span>
            </li>

            <!-- Kelola Data Santri -->
            <li>
                <a href="{{ route('admin.santri.index') }}"
                    class="{{ request()->routeIs('admin.santri.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Data Santri
                </a>
            </li>

            <!-- Kelola Data Kegiatan -->
            <li>
                <a href="{{ route('admin.activities.index') }}"
                    class="{{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kegiatan
                </a>
            </li>

            <!-- Unit/TPA -->
            <li>
                <a href="{{ route('admin.units.index') }}"
                    class="{{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Unit TPA/TPQ
                </a>
            </li>

            <li class="menu-title mt-4">
                <span>Laporan & Arsip</span>
            </li>

            <!-- Kelola Laporan -->
            <li>
                <details {{ request()->routeIs('admin.reports.*') ? 'open' : '' }}>
                    <summary>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.reports.santri') }}">Laporan Santri</a></li>
                        <li><a href="{{ route('admin.reports.activities') }}">Laporan Kegiatan</a></li>
                        <li><a href="{{ route('admin.reports.units') }}">Laporan Unit</a></li>
                    </ul>
                </details>
            </li>

            <!-- Kelola Arsip -->
            <li>
                <a href="{{ route('admin.archives.index') }}"
                    class="{{ request()->routeIs('admin.archives.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    Arsip
                </a>
            </li>

            <li class="menu-title mt-4">
                <span>Validasi</span>
            </li>

            <!-- Validasi Data -->
            <li>
                <a href="{{ route('admin.validation.index') }}"
                    class="{{ request()->routeIs('admin.validation.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Validasi Data
                    @if(($pendingValidation ?? 0) > 0)
                    <span class="badge badge-error badge-sm">{{ $pendingValidation }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-title mt-4">
                <span>PWA & Offline</span>
            </li>

            <!-- PWA Status -->
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

            <li class="menu-title mt-4">
                <span>Pengaturan</span>
            </li>

            <!-- Settings -->
            <li>
                <a href="{{ route('admin.settings') }}"
                    class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            </li>
        </ul>

        <!-- Sync Status -->
        <div class="p-4 border-t border-base-300 mt-auto">
            <div class="flex items-center gap-2 text-sm">
                <div id="sync-indicator" class="w-3 h-3 rounded-full bg-success"></div>
                <span id="connection-status" class="badge badge-success badge-sm">Online</span>
            </div>
        </div>
    </aside>
</div>
