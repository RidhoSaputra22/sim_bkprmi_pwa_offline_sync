<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enum\StatusApprovalUnit;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Services\UnitApprovalService;
use Illuminate\Http\Request;

class UnitApprovalController extends Controller
{
    public function __construct(
        protected UnitApprovalService $approvalService
    ) {}

    /**
     * Daftar unit yang perlu diapprove
     */
    public function index(Request $request)
    {
        $query = Unit::with(['village.district.city.province', 'unitHead.person']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        } else {
            // Default: tampilkan yang pending
            $query->pending();
        }

        // Filter yang sudah upload sertifikat
        if ($request->boolean('with_certificate')) {
            $query->withCertificate();
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('unit_number', 'like', "%{$search}%");
            });
        }

        $units = $query->latest()->paginate(15);

        $statusOptions = StatusApprovalUnit::cases();

        return view('superadmin.units.approval-index', compact('units', 'statusOptions'));
    }

    /**
     * Detail unit untuk review approval
     */
    public function show(Unit $unit)
    {
        $unit->load([
            'village.district.city.province',
            'unitHead.person',
            'unitAdmin.person',
            'approvedByUser.person',
        ]);

        return view('superadmin.units.approval-show', compact('unit'));
    }

    /**
     * Approve unit
     */
    public function approve(Request $request, Unit $unit)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $this->approvalService->approveUnit(
                $unit,
                $request->user(),
                $request->notes
            );

            return redirect()
                ->route('superadmin.units.approval.index')
                ->with('success', "Unit '{$unit->name}' berhasil disetujui.");

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reject unit
     */
    public function reject(Request $request, Unit $unit)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ], [
            'notes.required' => 'Alasan penolakan harus diisi.',
        ]);

        try {
            $this->approvalService->rejectUnit(
                $unit,
                $request->user(),
                $request->notes
            );

            return redirect()
                ->route('superadmin.units.approval.index')
                ->with('success', "Unit '{$unit->name}' ditolak.");

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Download/view certificate
     */
    public function viewCertificate(Unit $unit)
    {
        if (! $unit->hasCertificate()) {
            return back()->with('error', 'Unit ini belum memiliki sertifikat.');
        }

        $path = storage_path('app/public/' . $unit->certificate_path);

        if (! file_exists($path)) {
            return back()->with('error', 'File sertifikat tidak ditemukan.');
        }

        return response()->file($path);
    }
}
