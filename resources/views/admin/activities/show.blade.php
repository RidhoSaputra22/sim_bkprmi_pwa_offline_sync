<x-layouts.admin title="Detail Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.activities.index') }}">Kegiatan</a></li>
            <li>Detail</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">{{ $activity->title }}</h1>
                <p class="text-base-content/60">{{ $activity->activity_date?->format('d F Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.activities.index') }}" class="btn btn-ghost">Kembali</a>
                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-ui.card title="Detail Kegiatan">
                <div class="prose max-w-none">
                    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card title="Informasi">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-base-content/60">Unit</label>
                        <p class="font-medium">{{ $activity->unit?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Tanggal</label>
                        <p class="font-medium">{{ $activity->activity_date?->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-base-content/60">Dibuat Oleh</label>
                        <p class="font-medium">{{ $activity->createdBy?->person?->full_name ?? $activity->createdBy?->email ?? '-' }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-layouts.admin>
