<?php

namespace App\Http\Controllers\Lpptka;

use App\Enum\Gender;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Services\UnitApprovalService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TpaAccountController extends Controller
{
    public function __construct(
        protected UnitApprovalService $approvalService
    ) {}

    /**
     * Daftar unit yang siap dibuatkan akun
     */
    public function index()
    {
        // Count for tabs
        $readyCount = Unit::readyForAccount()->count();
        $activeCount = Unit::approved()->whereNotNull('admin_user_id')->count();

        // Unit yang sudah diapprove tapi belum punya akun
        $readyUnits = Unit::readyForAccount()
            ->with(['village.district.city', 'unitHead.person'])
            ->paginate(15);

        // Unit yang sudah punya akun - get users with managed units
        $activeAccounts = \App\Models\User::whereHas('managedUnit', function ($q) {
            $q->whereNotNull('approved_at');
        })
            ->with(['person', 'managedUnit'])
            ->paginate(15, ['*'], 'page_with_account');

        return view('lpptka.tpa-accounts.index', compact(
            'readyCount',
            'activeCount',
            'readyUnits',
            'activeAccounts'
        ));
    }

    /**
     * Form untuk membuat akun Admin TPA
     */
    public function create(Unit $unit)
    {
        // Validasi: unit harus approved dan belum punya akun
        if (! $unit->isApproved()) {
            return back()->with('error', 'Unit harus disetujui terlebih dahulu.');
        }

        if ($unit->hasAdminAccount()) {
            return back()->with('error', 'Unit ini sudah memiliki akun Admin TPA.');
        }

        $unit->load(['village.district.city', 'unitHead.person', 'unitAdmin.person']);

        return view('lpptka.tpa-accounts.create', [
            'unit' => $unit,
            'genderOptions' => Gender::cases(),
        ]);
    }

    /**
     * Buat akun Admin TPA untuk unit
     */
    public function store(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:persons,nik',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => ['required', new Enum(Gender::class)],
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        try {
            $user = $this->approvalService->createAdminTpaAccount(
                $unit,
                $request->user(),
                [
                    'full_name' => $validated['full_name'],
                    'nik' => $validated['nik'] ?? null,
                    'birth_place' => $validated['birth_place'] ?? null,
                    'birth_date' => $validated['birth_date'] ?? null,
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'] ?? null,
                ],
                $validated['email'],
                $validated['password'] ?? null
            );

            // Simpan password untuk ditampilkan
            session()->flash('created_account', [
                'email' => $user->email,
                'password' => $user->plain_password,
                'unit_name' => $unit->name,
            ]);

            return redirect()
                ->route('lpptka.tpa-accounts.success', $unit)
                ->with('success', 'Akun Admin TPA berhasil dibuat.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah buat akun
     */
    public function success(Unit $unit)
    {
        $accountInfo = session('created_account');

        if (! $accountInfo) {
            return redirect()->route('lpptka.tpa-accounts.index');
        }

        return view('lpptka.tpa-accounts.success', [
            'unit' => $unit,
            'accountInfo' => $accountInfo,
            'adminName' => $accountInfo['unit_name'] ?? $unit->name,
            'email' => $accountInfo['email'],
            'password' => $accountInfo['password'],
        ]);
    }

    /**
     * Detail akun Admin TPA
     */
    public function show(Unit $unit)
    {
        if (! $unit->hasAdminAccount()) {
            return back()->with('error', 'Unit ini belum memiliki akun Admin TPA.');
        }

        $unit->load(['village.district.city', 'adminUser.person']);

        return view('lpptka.tpa-accounts.show', compact('unit'));
    }
}
