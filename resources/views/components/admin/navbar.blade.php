{{-- Admin Navbar Component --}}

<div class="navbar bg-base-100 border-b border-base-300 sticky top-0 z-30">
    <!-- Mobile Menu Toggle -->
    <div class="flex-none lg:hidden">
        <label for="admin-drawer" class="btn btn-square btn-ghost drawer-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </label>
    </div>

    <!-- Page Title / Search -->
    <div class="flex-1 px-4">
        <span class="text-lg font-bold">{{ $title ?? 'Dashboard' }}</span>
    </div>

    <!-- Right Side Items -->
    <div class="flex-none gap-2">
        <!-- Offline Sync Status -->
        <div class="flex items-center gap-2">
            <!-- Online/Offline Indicator -->
            <div id="connection-status" class="hidden items-center gap-1 text-sm">
                <span id="online-indicator" class="flex items-center gap-1 text-success">
                    <span class="w-2 h-2 bg-success rounded-full animate-pulse"></span>
                    Online
                </span>
                <span id="offline-indicator" class="flex items-center gap-1 text-warning hidden">
                    <span class="w-2 h-2 bg-warning rounded-full"></span>
                    Offline
                </span>
            </div>

            <!-- Pending Sync Badge -->
            <button onclick="window.syncManager?.syncAll()" class="btn btn-ghost btn-circle relative" title="Sinkronisasi Data">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span id="offline-sync-badge" class="badge badge-warning badge-xs absolute -top-1 -right-1 hidden">0</span>
            </button>
        </div>

        <!-- Theme Toggle -->



        <!-- User Menu -->
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <div
                        class="w-full h-full bg-primary flex items-center justify-center text-primary-content font-bold">
                        {{ substr(auth()->user()->person->full_name ?? auth()->user()->email ?? 'A', 0, 1) }}
                    </div>
                </div>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li class="menu-title">
                    <span>{{ auth()->user()->person->full_name ?? auth()->user()->email ?? 'Admin' }}</span>
                </li>
                <li>
                    <a href="{{ route('admin.profile') }}" class="justify-between">
                        Profil
                        <span class="badge badge-sm">New</span>
                    </a>
                </li>
                <li><a href="{{ route('admin.settings') }}">Pengaturan</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-error">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
