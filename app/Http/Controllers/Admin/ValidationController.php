<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    /**
     * Display a listing of pending validations.
     */
    public function index(Request $request)
    {
        // Get data that needs validation
        // This can be extended based on specific requirements

        $pendingSantri = Santri::with(['person'])
            ->where('status_santri', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.validation.index', [
            'pendingSantri' => $pendingSantri,
        ]);
    }

    /**
     * Approve a validation request.
     */
    public function approve(Request $request, $type, $id)
    {
        if ($type === 'santri') {
            $santri = Santri::findOrFail($id);
            $santri->update(['status_santri' => 'active']);

            return redirect()
                ->back()
                ->with('success', 'Data santri berhasil divalidasi.');
        }

        return redirect()
            ->back()
            ->with('error', 'Tipe validasi tidak valid.');
    }

    /**
     * Reject a validation request.
     */
    public function reject(Request $request, $type, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($type === 'santri') {
            $santri = Santri::findOrFail($id);
            $santri->update(['status_santri' => 'rejected']);

            // Optionally store rejection reason

            return redirect()
                ->back()
                ->with('success', 'Data santri ditolak.');
        }

        return redirect()
            ->back()
            ->with('error', 'Tipe validasi tidak valid.');
    }

    /**
     * Bulk approve validations.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'type' => 'required|string',
        ]);

        if ($request->type === 'santri') {
            Santri::whereIn('id', $request->ids)
                ->update(['status_santri' => 'active']);

            return redirect()
                ->back()
                ->with('success', count($request->ids) . ' data berhasil divalidasi.');
        }

        return redirect()
            ->back()
            ->with('error', 'Tipe validasi tidak valid.');
    }
}
