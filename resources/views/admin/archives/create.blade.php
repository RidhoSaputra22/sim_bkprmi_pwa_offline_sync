<x-layouts.admin title="Upload Arsip">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.archives.index') }}">Arsip</a></li>
            <li>Upload</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Upload Arsip Baru</h1>
    </x-slot:header>

    <x-ui.card>
        <form method="POST" action="{{ route('admin.archives.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <x-ui.input name="title" label="Judul Arsip" placeholder="Masukkan judul arsip" :required="true" />

            <x-ui.textarea name="description" label="Deskripsi" placeholder="Deskripsi arsip..." />

            <x-ui.select
                name="category"
                label="Kategori"
                :options="['dokumen' => 'Dokumen', 'foto' => 'Foto', 'laporan' => 'Laporan', 'sertifikat' => 'Sertifikat', 'lainnya' => 'Lainnya']"
                :required="true"
            />

            <div class="form-control">
                <label class="label">
                    <span class="label-text">File</span>
                </label>
                <input type="file" name="file" class="file-input file-input-bordered w-full" />
                <label class="label">
                    <span class="label-text-alt">Maksimal 10MB (PDF, DOC, DOCX, JPG, PNG)</span>
                </label>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.archives.index') }}" class="btn btn-ghost">Batal</a>
                <x-ui.button type="primary">Upload</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.admin>
