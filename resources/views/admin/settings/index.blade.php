<x-layouts.admin title="Pengaturan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Pengaturan</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Pengaturan</h1>
    </x-slot:header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.profile') }}" class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <div class="bg-primary/10 text-primary rounded-lg p-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold">Profil</h3>
                        <p class="text-sm text-base-content/60">Kelola informasi profil Anda</p>
                    </div>
                </div>
            </div>
        </a>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <div class="bg-secondary/10 text-secondary rounded-lg p-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold">Sistem</h3>
                        <p class="text-sm text-base-content/60">Pengaturan aplikasi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    <div class="bg-accent/10 text-accent rounded-lg p-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold">Data & Sinkronisasi</h3>
                        <p class="text-sm text-base-content/60">Kelola data offline</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
