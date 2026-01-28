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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Upload Arsip
            </x-ui.button>
        </div>
    </x-slot:header>

    <!-- Filter & Search -->
    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.archives.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari arsip..."
                    class="input input-bordered w-full" />
            </div>
            <div class="w-full md:w-48">
                <select name="category" class="select select-bordered w-full">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $value => $label)
                    <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
            <x-ui.button type="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </x-ui.button>
            @if(request('search') || request('category'))
            <a href="{{ route('admin.archives.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </form>
    </x-ui.card>

    <x-ui.card>
        @if($archives->count() > 0)
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>File</th>
                        <th>Ukuran</th>
                        <th>Diupload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archives as $index => $archive)
                    <tr>
                        <td>{{ $archives->firstItem() + $index }}</td>
                        <td>
                            <div class="font-medium">{{ $archive->title }}</div>
                            @if($archive->description)
                            <div class="text-sm text-base-content/60 line-clamp-1">{{ $archive->description }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-outline">{{ $archive->category_label }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                @php
                                $iconClass = match($archive->file_icon) {
                                'document-text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                                01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                'document' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586
                                3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                                'table-cells' => 'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0
                                00-2 2v8a2 2 0 002 2z',
                                'photo' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20
                                14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                                'archive-box' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0
                                002-2V8m-9 4h4',
                                default => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0
                                00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
                                };
                                @endphp
                                <svg class="w-5 h-5 text-base-content/60" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $iconClass }}" />
                                </svg>
                                <span class="text-sm truncate max-w-[150px]">{{ $archive->file_name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ $archive->formatted_file_size }}</td>
                        <td>
                            <div class="text-sm">{{ $archive->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-base-content/60">{{ $archive->uploader?->name ?? '-' }}</div>
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <a href="{{ route('admin.archives.show', $archive) }}" class="btn btn-ghost btn-sm"
                                    title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @if($archive->file_path)
                                <a href="{{ route('admin.archives.download', $archive) }}" class="btn btn-ghost btn-sm"
                                    title="Download">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                @endif
                                <form action="{{ route('admin.archives.destroy', $archive) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm text-error" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $archives->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-12 text-base-content/60">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
            <p>Belum ada arsip dokumen</p>
            <p class="text-sm">Upload arsip pertama Anda untuk memulai</p>
        </div>
        @endif
    </x-ui.card>
</x-layouts.admin>