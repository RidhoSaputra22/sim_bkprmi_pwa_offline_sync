<x-layouts.admin title="Detail Arsip">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.archives.index') }}">Arsip</a></li>
            <li>Detail</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Detail Arsip</h1>
            <div class="flex gap-2">
                @if($archive->file_path)
                    <a href="{{ route('admin.archives.download', $archive) }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download
                    </a>
                @endif
                <form action="{{ route('admin.archives.destroy', $archive) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <h2 class="text-xl font-semibold mb-4">{{ $archive->title }}</h2>

                @if($archive->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-base-content/60 mb-2">Deskripsi</h3>
                        <p class="text-base-content">{{ $archive->description }}</p>
                    </div>
                @endif

                <div class="divider"></div>

                <!-- File Preview -->
                @if($archive->file_path)
                    @php
                        $extension = pathinfo($archive->file_name ?? '', PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isPdf = strtolower($extension) === 'pdf';
                    @endphp

                    @if($isImage)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-base-content/60 mb-2">Preview</h3>
                            <img src="{{ $archive->file_url }}" alt="{{ $archive->title }}"
                                class="max-w-full h-auto rounded-lg shadow-md max-h-96 object-contain" />
                        </div>
                    @elseif($isPdf)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-base-content/60 mb-2">Preview</h3>
                            <iframe src="{{ $archive->file_url }}"
                                class="w-full h-96 rounded-lg border"
                                title="{{ $archive->title }}"></iframe>
                        </div>
                    @else
                        <div class="text-center py-8 bg-base-200 rounded-lg">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-base-content/60">Preview tidak tersedia untuk tipe file ini</p>
                            <a href="{{ route('admin.archives.download', $archive) }}" class="btn btn-primary btn-sm mt-4">
                                Download untuk melihat
                            </a>
                        </div>
                    @endif
                @endif
            </x-ui.card>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <x-ui.card>
                <h3 class="font-semibold mb-4">Informasi File</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-base-content/60">Nama File</span>
                        <p class="font-medium break-all">{{ $archive->file_name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Kategori</span>
                        <p><span class="badge badge-outline">{{ $archive->category_label }}</span></p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Ukuran</span>
                        <p class="font-medium">{{ $archive->formatted_file_size }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Tipe File</span>
                        <p class="font-medium">{{ $archive->file_type ?? '-' }}</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h3 class="font-semibold mb-4">Upload Info</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-base-content/60">Diupload oleh</span>
                        <p class="font-medium">{{ $archive->uploader?->name ?? 'Tidak diketahui' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-base-content/60">Tanggal Upload</span>
                        <p class="font-medium">{{ $archive->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    @if($archive->updated_at->gt($archive->created_at))
                        <div>
                            <span class="text-sm text-base-content/60">Terakhir Diperbarui</span>
                            <p class="font-medium">{{ $archive->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    @endif
                </div>
            </x-ui.card>

            <a href="{{ route('admin.archives.index') }}" class="btn btn-ghost w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-layouts.admin>
