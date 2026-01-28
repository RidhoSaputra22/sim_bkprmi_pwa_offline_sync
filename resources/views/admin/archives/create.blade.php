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

            <x-ui.textarea name="description" label="Deskripsi" placeholder="Deskripsi arsip (opsional)..." />

            <x-ui.select
                name="category"
                label="Kategori"
                :options="$categories"
                :required="true"
                placeholder="Pilih kategori"
            />

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">File <span class="text-error">*</span></span>
                </label>
                <input type="file" name="file"
                    class="file-input file-input-bordered w-full @error('file') file-input-error @enderror"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.zip,.rar"
                    required />
                @error('file')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @else
                    <label class="label">
                        <span class="label-text-alt">Maksimal 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, ZIP, RAR</span>
                    </label>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t">
                <a href="{{ route('admin.archives.index') }}" class="btn btn-ghost">Batal</a>
                <x-ui.button type="primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Upload
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-layouts.admin>
