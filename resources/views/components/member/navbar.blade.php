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
    <div class="flex-1">
        <div class="form-control hidden sm:block">
            <div class="input-group">
                <input type="text" placeholder="Cari..." class="input input-bordered input-sm w-64" />
                <button class="btn btn-sm btn-square">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Side Items -->
    <div class="flex-none gap-2">
        <!-- Theme Toggle -->
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a onclick="document.documentElement.setAttribute('data-theme', 'light')">Light</a></li>
                <li><a onclick="document.documentElement.setAttribute('data-theme', 'dark')">Dark</a></li>
                <li><a onclick="document.documentElement.setAttribute('data-theme', 'cupcake')">Cupcake</a></li>
                <li><a onclick="document.documentElement.setAttribute('data-theme', 'corporate')">Corporate</a></li>
            </ul>
        </div>

        <!-- Notifications -->
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </label>
            <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="font-bold text-lg">Notifikasi</h3>
                    <div class="space-y-2">
                        <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-base-200">
                            <div class="avatar placeholder">
                                <div
                                    class="bg-primary text-primary-content rounded-full w-10 flex items-center justify-center">
                                    <span class="text-xs">N</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Data santri baru menunggu validasi</p>
                                <p class="text-xs text-base-content/60">5 menit yang lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="#" class="btn btn-primary btn-block btn-sm">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>

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