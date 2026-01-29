<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    /**
     * Display a listing of archives.
     */
    public function index(Request $request)
    {
        $query = Archive::with('uploader')->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $archives = $query->paginate(15);

        $categories = [
            'dokumen' => 'Dokumen',
            'foto' => 'Foto',
            'laporan' => 'Laporan',
            'sertifikat' => 'Sertifikat',
            'lainnya' => 'Lainnya',
        ];

        return view('admin.archives.index', [
            'archives' => $archives,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new archive.
     */
    public function create()
    {
        $categories = [
            'dokumen' => 'Dokumen',
            'foto' => 'Foto',
            'laporan' => 'Laporan',
            'sertifikat' => 'Sertifikat',
            'lainnya' => 'Lainnya',
        ];

        return view('admin.archives.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created archive in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|in:dokumen,foto,laporan,sertifikat,lainnya',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,webp,zip,rar',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('archives', 'public');

        $archive = Archive::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
        ]);

        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Arsip berhasil diupload.',
                'archive' => $archive,
                'redirect' => route('admin.archives.index'),
            ]);
        }

        return redirect()
            ->route('admin.archives.index')
            ->with('success', 'Arsip berhasil diupload.');
    }

    /**
     * Display the specified archive.
     */
    public function show(Archive $archive)
    {
        $archive->load('uploader');

        return view('admin.archives.show', [
            'archive' => $archive,
        ]);
    }

    /**
     * Remove the specified archive from storage.
     */
    public function destroy(Archive $archive)
    {
        // Delete file from storage
        if ($archive->file_path && Storage::disk('public')->exists($archive->file_path)) {
            Storage::disk('public')->delete($archive->file_path);
        }

        $archive->delete();

        return redirect()
            ->route('admin.archives.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    /**
     * Download archive file.
     */
    public function download(Archive $archive)
    {
        if (!$archive->file_path || !Storage::disk('public')->exists($archive->file_path)) {
            return redirect()
                ->route('admin.archives.index')
                ->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $archive->file_path,
            $archive->file_name ?? 'download'
        );
    }
}
