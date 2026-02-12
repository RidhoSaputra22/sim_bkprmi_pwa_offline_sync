<?php

namespace App\Http\Controllers\Lpptka;

use App\Enum\Gender;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use App\Enum\StatusApprovalUnit;
use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Province;
use App\Models\Region;
use App\Models\Unit;
use App\Models\UnitAdmin;
use App\Models\UnitHead;
use App\Services\UnitApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;

class UnitController extends Controller
{
    public function __construct(
        protected UnitApprovalService $approvalService
    ) {}

    /**
     * Daftar semua unit
     */
    public function index(Request $request)
    {
        $query = Unit::with(['village.district.city.province', 'unitHead.person']);

        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
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

        return view('lpptka.units.index', [
            'units' => $units,
            'statusOptions' => StatusApprovalUnit::cases(),
        ]);
    }

    /**
     * Form untuk membuat unit baru
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        return view('lpptka.units.create', [
            'provinces' => $provinces,
            'tipeLokasiOptions' => TipeLokasi::cases(),
            'statusBangunanOptions' => StatusBangunan::cases(),
            'waktuKegiatanOptions' => WaktuKegiatan::cases(),
            'genderOptions' => Gender::cases(),
            'pendidikanOptions' => PendidikanTerakhir::cases(),
            'pekerjaanOptions' => PekerjaanWali::cases(),
        ]);
    }

    /**
     * Simpan unit baru
     */
    public function store(Request $request)
    {
        // dd('validated');

        $validated = $request->validate([
            // Identitas Unit
            'unit_number' => 'required|string|max:50|unique:units,unit_number',
            'name' => 'required|string|max:255',
            'tipe_lokasi' => ['required', new Enum(TipeLokasi::class)],
            'status_bangunan' => ['required', new Enum(StatusBangunan::class)],
            'mosque_name' => 'nullable|string|max:255',
            'founder' => 'nullable|string|max:255',
            'formed_at' => 'nullable|date',
            'joined_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'waktu_kegiatan' => ['required', new Enum(WaktuKegiatan::class)],
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'jalan' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',

            // Keadaan Santri
            'jumlah_tka' => 'nullable|integer|min:0',
            'jumlah_tpa' => 'nullable|integer|min:0',
            'jumlah_tqa' => 'nullable|integer|min:0',

            // Keadaan Guru
            'guru_laki' => 'nullable|integer|min:0',
            'guru_perempuan' => 'nullable|integer|min:0',

            // Kepala Unit
            'head_nik' => 'nullable|string|max:16',
            'head_name' => 'required|string|max:255',
            'head_birth_place' => 'required|string|max:100',
            'head_birth_date' => 'required|date',
            'head_gender' => ['required', new Enum(Gender::class)],
            'head_education' => ['nullable', new Enum(PendidikanTerakhir::class)],
            'head_job' => ['nullable', new Enum(PekerjaanWali::class)],
            'head_phone' => 'nullable|string|max:20',

            // Admin Unit
            'admin_name' => 'nullable|string|max:255',
            'admin_phone' => 'nullable|string|max:20',
            'admin_email' => 'nullable|email|max:255',

            // Sertifikat (opsional saat create)
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Create or find Region for address
            $region = Region::firstOrCreate([
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
            ], [
                'jalan' => $validated['jalan'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
            ]);

            // Create Unit
            $unit = Unit::create([
                'unit_number' => $validated['unit_number'],
                'name' => $validated['name'],
                'region_id' => $region->id,
                'village_id' => $validated['village_id'],
                'tipe_lokasi' => $validated['tipe_lokasi'],
                'status_bangunan' => $validated['status_bangunan'],
                'waktu_kegiatan' => $validated['waktu_kegiatan'],
                'mosque_name' => $validated['mosque_name'] ?? null,
                'founder' => $validated['founder'] ?? null,
                'formed_at' => $validated['formed_at'] ?? null,
                'joined_year' => $validated['joined_year'] ?? null,
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'jumlah_tka' => $validated['jumlah_tka'] ?? 0,
                'jumlah_tpa' => $validated['jumlah_tpa'] ?? 0,
                'jumlah_tqa' => $validated['jumlah_tqa'] ?? 0,
                'guru_laki' => $validated['guru_laki'] ?? 0,
                'guru_perempuan' => $validated['guru_perempuan'] ?? 0,
                'approval_status' => StatusApprovalUnit::PENDING,
            ]);

            // Create Person for Unit Head
            $headPerson = Person::create([
                'nik' => $validated['head_nik'] ?? null,
                'full_name' => $validated['head_name'],
                'birth_place' => $validated['head_birth_place'],
                'birth_date' => $validated['head_birth_date'],
                'gender' => $validated['head_gender'],
                'phone' => $validated['head_phone'] ?? null,
            ]);

            // Create Unit Head
            UnitHead::create([
                'unit_id' => $unit->id,
                'person_id' => $headPerson->id,
                'pendidikan_terakhir' => $validated['head_education'] ?? null,
                'pekerjaan' => $validated['head_job'] ? [$validated['head_job']] : null,
            ]);

            // Create Admin if provided
            if (! empty($validated['admin_name'])) {
                $adminPerson = Person::create([
                    'full_name' => $validated['admin_name'],
                    'phone' => $validated['admin_phone'] ?? null,
                    'email' => $validated['admin_email'] ?? null,
                ]);

                UnitAdmin::create([
                    'unit_id' => $unit->id,
                    'person_id' => $adminPerson->id,
                ]);
            }

            // Upload certificate if provided
            if ($request->hasFile('certificate')) {
                $path = $request->file('certificate')->store('certificates', 'public');
                $unit->update([
                    'certificate_path' => $path,
                    'certificate_uploaded_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('lpptka.units.index')
            ->with('success', 'Unit berhasil ditambahkan. Menunggu approval dari SuperAdmin.');
    }

    /**
     * Detail unit
     */
    public function show(Unit $unit)
    {
        $unit->load([
            'village.district.city.province',
            'unitHead.person',
            'unitAdmin.person',
            'approvedByUser.person',
            'adminUser.person',
        ]);

        return view('lpptka.units.show', compact('unit'));
    }

    /**
     * Form edit unit
     */
    public function edit(Unit $unit)
    {
        $unit->load(['village.district.city.province', 'unitHead.person', 'unitAdmin.person']);
        $provinces = Province::orderBy('name')->get();

        // Get current location IDs for edit form
        $currentProvinceId = $unit->village?->district?->city?->province_id;
        $currentCityId = $unit->village?->district?->city_id;
        $currentDistrictId = $unit->village?->district_id;

        return view('lpptka.units.edit', [
            'unit' => $unit,
            'provinces' => $provinces,
            'currentProvinceId' => $currentProvinceId,
            'currentCityId' => $currentCityId,
            'currentDistrictId' => $currentDistrictId,
            'tipeLokasiOptions' => TipeLokasi::cases(),
            'statusBangunanOptions' => StatusBangunan::cases(),
            'waktuKegiatanOptions' => WaktuKegiatan::cases(),
            'genderOptions' => Gender::cases(),
            'pendidikanOptions' => PendidikanTerakhir::cases(),
            'pekerjaanOptions' => PekerjaanWali::cases(),
        ]);
    }

    /**
     * Update unit
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mosque_name' => 'nullable|string|max:255',
            'tipe_lokasi' => ['nullable', new Enum(TipeLokasi::class)],
            'status_bangunan' => ['nullable', new Enum(StatusBangunan::class)],
            'waktu_kegiatan' => ['nullable', new Enum(WaktuKegiatan::class)],
            'founder' => 'nullable|string|max:255',
            'formed_at' => 'nullable|date',
            'joined_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'jalan' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',

            // Keadaan Santri
            'jumlah_tka' => 'nullable|integer|min:0',
            'jumlah_tpa' => 'nullable|integer|min:0',
            'jumlah_tqa' => 'nullable|integer|min:0',

            // Keadaan Guru
            'guru_laki' => 'nullable|integer|min:0',
            'guru_perempuan' => 'nullable|integer|min:0',

            // Kepala Unit
            'head_name' => 'required|string|max:255',
            'head_nik' => 'nullable|string|max:16',
            'head_birth_place' => 'required|string|max:100',
            'head_birth_date' => 'required|date',
            'head_gender' => ['required', new Enum(Gender::class)],
            'head_education' => ['nullable', new Enum(PendidikanTerakhir::class)],
            'head_job' => ['nullable', new Enum(PekerjaanWali::class)],
            'head_phone' => 'nullable|string|max:20',

            // Admin Unit
            'admin_name' => 'nullable|string|max:255',
            'admin_phone' => 'nullable|string|max:20',
            'admin_email' => 'nullable|email|max:255',

            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        DB::transaction(function () use ($validated, $request, $unit) {
            // Update or create Region
            $region = Region::updateOrCreate([
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
            ], [
                'jalan' => $validated['jalan'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
            ]);

            // Update Unit
            $unit->update([
                'name' => $validated['name'],
                'mosque_name' => $validated['mosque_name'] ?? null,
                'tipe_lokasi' => $validated['tipe_lokasi'] ?? null,
                'status_bangunan' => $validated['status_bangunan'] ?? null,
                'waktu_kegiatan' => $validated['waktu_kegiatan'] ?? null,
                'founder' => $validated['founder'] ?? null,
                'formed_at' => $validated['formed_at'] ?? null,
                'joined_year' => $validated['joined_year'] ?? null,
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'village_id' => $validated['village_id'],
                'region_id' => $region->id,
                'jumlah_tka' => $validated['jumlah_tka'] ?? 0,
                'jumlah_tpa' => $validated['jumlah_tpa'] ?? 0,
                'jumlah_tqa' => $validated['jumlah_tqa'] ?? 0,
                'guru_laki' => $validated['guru_laki'] ?? 0,
                'guru_perempuan' => $validated['guru_perempuan'] ?? 0,
            ]);

            // Update Unit Head Person
            if ($unit->unitHead?->person) {
                $unit->unitHead->person->update([
                    'full_name' => $validated['head_name'],
                    'nik' => $validated['head_nik'] ?? null,
                    'birth_place' => $validated['head_birth_place'],
                    'birth_date' => $validated['head_birth_date'],
                    'gender' => $validated['head_gender'],
                    'phone' => $validated['head_phone'] ?? null,
                ]);

                // Update Unit Head
                $unit->unitHead->update([
                    'pendidikan_terakhir' => $validated['head_education'] ?? null,
                    'pekerjaan' => $validated['head_job'] ? [$validated['head_job']] : null,
                ]);
            }

            // Update or create Admin
            if (! empty($validated['admin_name'])) {
                if ($unit->unitAdmin?->person) {
                    // Update existing admin
                    $unit->unitAdmin->person->update([
                        'full_name' => $validated['admin_name'],
                        'phone' => $validated['admin_phone'] ?? null,
                        'email' => $validated['admin_email'] ?? null,
                    ]);
                } else {
                    // Create new admin
                    $adminPerson = Person::create([
                        'full_name' => $validated['admin_name'],
                        'phone' => $validated['admin_phone'] ?? null,
                        'email' => $validated['admin_email'] ?? null,
                    ]);

                    UnitAdmin::create([
                        'unit_id' => $unit->id,
                        'person_id' => $adminPerson->id,
                    ]);
                }
            }

            // Upload certificate if provided
            if ($request->hasFile('certificate')) {
                if ($unit->certificate_path) {
                    Storage::disk('public')->delete($unit->certificate_path);
                }
                $path = $request->file('certificate')->store('certificates', 'public');
                $unit->update([
                    'certificate_path' => $path,
                    'certificate_uploaded_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('lpptka.units.show', $unit)
            ->with('success', 'Unit berhasil diperbarui.');
    }

    /**
     * Upload sertifikat unit
     */
    public function uploadCertificate(Request $request, Unit $unit)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'certificate.required' => 'File sertifikat harus diupload.',
            'certificate.mimes' => 'File harus berformat PDF, JPG, atau PNG.',
            'certificate.max' => 'Ukuran file maksimal 5MB.',
        ]);

        // Delete old certificate if exists
        if ($unit->certificate_path) {
            Storage::disk('public')->delete($unit->certificate_path);
        }

        $path = $request->file('certificate')->store('certificates', 'public');

        $this->approvalService->uploadCertificate($unit, $path);

        return back()->with('success', 'Sertifikat berhasil diupload.');
    }

    /**
     * Resubmit unit yang ditolak
     */
    public function resubmit(Unit $unit)
    {
        if (! $unit->isRejected()) {
            return back()->with('error', 'Hanya unit yang ditolak yang dapat diajukan ulang.');
        }

        try {
            $this->approvalService->resetToPending($unit);

            return back()->with('success', 'Unit berhasil diajukan ulang untuk approval.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
