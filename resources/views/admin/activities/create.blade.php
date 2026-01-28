<x-layouts.admin title="Tambah Kegiatan">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.activities.index') }}">Kegiatan</a></li>
            <li>Tambah Kegiatan</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Tambah Kegiatan Baru</h1>
    </x-slot:header>

    <x-ui.card>
        <form method="POST" action="{{ route('admin.activities.store') }}" class="space-y-4">
            @csrf

            <x-ui.input
                name="title"
                label="Judul Kegiatan"
                placeholder="Masukkan judul kegiatan"
                :required="true"
            />

            <x-ui.textarea
                name="description"
                label="Deskripsi"
                placeholder="Deskripsi kegiatan..."
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input
                    name="activity_date"
                    type="date"
                    label="Tanggal Kegiatan"
                    :required="true"
                />

                @php
                    $unitOptions = $units->pluck('name', 'id')->toArray();
                @endphp

                <x-ui.select
                    name="unit_id"
                    label="Unit"
                    :options="$unitOptions"
                    :required="true"
                />
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.activities.index') }}" class="btn btn-ghost">Batal</a>
                <x-ui.button type="primary">Simpan</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.admin>
