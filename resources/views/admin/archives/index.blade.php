<x-layouts.admin title="Arsip">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>Arsip</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Arsip Dokumen</h1>
                <p class="text-base-content/60">Kelola arsip dan dokumen organisasi</p>
            </div>
            <x-ui.button type="primary" href="{{ route('admin.archives.create') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Upload Arsip
            </x-ui.button>
        </div>
    </x-slot:header>

    <x-ui.card>
        <div class="text-center py-12 text-base-content/60">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <p>Belum ada arsip dokumen</p>
            <p class="text-sm">Upload arsip pertama Anda untuk memulai</p>
        </div>
    </x-ui.card>
</x-layouts.admin>
