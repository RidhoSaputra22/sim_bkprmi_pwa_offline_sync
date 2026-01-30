<?php

namespace App\Http\Controllers\Tpa;

use App\Enum\Gender;
use App\Enum\HubunganWaliSantri;
use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use App\Enum\StatusSantri;
use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\GuardianSantri;
use App\Models\Person;
use App\Models\Region;
use App\Models\Santri;
use App\Models\SantriUnit;
use App\Services\LocationFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class SantriController extends Controller
{
    public function __construct(
        protected LocationFilterService $locationService
    ) {}

    /**
     * Get current user's unit
     */
    protected function getUserUnit()
    {
        $unit = Auth::user()->getUnit();

        if (! $unit) {
            abort(403, 'Anda tidak memiliki akses ke unit manapun.');
        }

        return $unit;
    }

    /**
     * Daftar santri di unit ini
     */
    public function index(Request $request)
    {
        $unit = $this->getUserUnit();

        $query = Santri::whereHas('santriUnits', function ($q) use ($unit) {
            $q->where('unit_id', $unit->id);
        })->with(['person', 'village.district', 'guardianSantris.guardian.person']);

        // Filter by jenjang
        if ($request->filled('jenjang')) {
            $query->where('jenjang_santri', $request->jenjang);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_santri', $request->status);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->whereHas('person', fn ($q) => $q->where('gender', $request->gender));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('person', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $santris = $query->latest()->paginate(15);

        return view('tpa.santri.index', [
            'santris' => $santris,
            'unit' => $unit,
            'jenjangOptions' => JenjangSantri::cases(),
            'statusOptions' => StatusSantri::cases(),
        ]);
    }

    /**
     * Form tambah santri baru
     */
    public function create()
    {
        $unit = $this->getUserUnit();

        // Get districts di Makassar untuk filter lokasi
        $districts = $this->locationService->getDistrictsInMakassar();
        $locationIds = $this->locationService->getAdminTpaLocationIds();

        return view('tpa.santri.create', [
            'unit' => $unit,
            'districts' => $districts,
            'provinceId' => $locationIds['province_id'],
            'cityId' => $locationIds['city_id'],
            'genderOptions' => Gender::cases(),
            'jenjangOptions' => JenjangSantri::cases(),
            'kelasOptions' => KelasMengaji::cases(),
            'statusOptions' => StatusSantri::cases(),
            'hubunganOptions' => HubunganWaliSantri::cases(),
            'pendidikanOptions' => PendidikanTerakhir::cases(),
            'pekerjaanOptions' => PekerjaanWali::cases(),
        ]);
    }

    /**
     * Simpan santri baru
     */
    public function store(Request $request)
    {
        $unit = $this->getUserUnit();

        $validated = $request->validate([
            // Data Santri
            'nik' => 'nullable|string|max:16',
            'full_name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => ['required', new Enum(Gender::class)],
            'child_order' => 'nullable|integer|min:1',
            'siblings_count' => 'nullable|integer|min:0',

            // Keanggotaan Unit
            'joined_at' => 'nullable|date',

            // Alamat - Restricted to Makassar
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',

            // Nama Orang Tua
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',

            // Status Santri
            'jenjang_santri' => ['required', new Enum(JenjangSantri::class)],
            'kelas_mengaji' => ['required', new Enum(KelasMengaji::class)],
            'status_santri' => ['required', new Enum(StatusSantri::class)],

            // Data Wali
            'wali_nik' => 'nullable|string|max:16',
            'wali_full_name' => 'required|string|max:255',
            'wali_birth_place' => 'nullable|string|max:100',
            'wali_birth_date' => 'nullable|date',
            'wali_gender' => ['required', new Enum(Gender::class)],
            'wali_hubungan' => ['required', new Enum(HubunganWaliSantri::class)],
            'wali_pendidikan' => ['nullable', new Enum(PendidikanTerakhir::class)],
            'wali_pekerjaan' => 'nullable|array',
            'wali_pekerjaan.*' => ['nullable', new Enum(PekerjaanWali::class)],
            'wali_phone' => 'nullable|string|max:20',
        ]);

        // Validasi lokasi harus di Makassar
        if (! $this->locationService->isVillageInMakassar($validated['village_id'])) {
            return back()
                ->withInput()
                ->withErrors(['village_id' => 'Lokasi harus berada di wilayah Kota Makassar.']);
        }

        DB::transaction(function () use ($validated, $unit) {
            // Get location IDs for region creation
            $locationIds = $this->locationService->getAdminTpaLocationIds();

            // Create or find Region for santri address
            $region = Region::firstOrCreate([
                'province_id' => $locationIds['province_id'],
                'city_id' => $locationIds['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
            ], [
                'jalan' => $validated['address'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
            ]);

            // Create Person for Santri
            $santriPerson = Person::create([
                'nik' => $validated['nik'] ?? null,
                'full_name' => $validated['full_name'],
                'birth_place' => $validated['birth_place'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'gender' => $validated['gender'],
            ]);

            // Create Santri
            $santri = Santri::create([
                'person_id' => $santriPerson->id,
                'region_id' => $region->id,
                'village_id' => $validated['village_id'],
                'child_order' => $validated['child_order'] ?? null,
                'siblings_count' => $validated['siblings_count'] ?? null,
                'nama_ayah' => $validated['nama_ayah'] ?? null,
                'nama_ibu' => $validated['nama_ibu'] ?? null,
                'address' => $validated['address'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
                'jenjang_santri' => $validated['jenjang_santri'],
                'kelas_mengaji' => $validated['kelas_mengaji'],
                'status_santri' => $validated['status_santri'],
            ]);

            // Link Santri to Unit
            SantriUnit::create([
                'santri_id' => $santri->id,
                'unit_id' => $unit->id,
                'joined_at' => $validated['joined_at'] ?? now()->toDateString(),
            ]);

            // Create Person for Guardian
            $guardianPerson = Person::create([
                'nik' => $validated['wali_nik'] ?? null,
                'full_name' => $validated['wali_full_name'],
                'birth_place' => $validated['wali_birth_place'] ?? null,
                'birth_date' => $validated['wali_birth_date'] ?? null,
                'gender' => $validated['wali_gender'],
                'phone' => $validated['wali_phone'] ?? null,
            ]);

            // Create Guardian
            $guardian = Guardian::create([
                'person_id' => $guardianPerson->id,
                'pendidikan_terakhir' => $validated['wali_pendidikan'] ?? null,
                'pekerjaan' => $validated['wali_pekerjaan'] ?? null,
            ]);

            // Link Guardian to Santri with relationship
            GuardianSantri::create([
                'guardian_id' => $guardian->id,
                'santri_id' => $santri->id,
                'hubungan' => $validated['wali_hubungan'],
            ]);
        });

        return redirect()
            ->route('tpa.santri.index')
            ->with('success', 'Data santri berhasil ditambahkan.');
    }

    /**
     * Detail santri
     */
    public function show(Santri $santri)
    {
        $unit = $this->getUserUnit();

        // Pastikan santri milik unit ini
        if (! $santri->santriUnits()->where('unit_id', $unit->id)->exists()) {
            abort(403, 'Santri tidak terdaftar di unit Anda.');
        }

        $santri->load([
            'person',
            'village.district.city',
            'guardianSantris.guardian.person',
            'santriUnits',
        ]);

        return view('tpa.santri.show', compact('santri', 'unit'));
    }

    /**
     * Form edit santri
     */
    public function edit(Santri $santri)
    {
        $unit = $this->getUserUnit();

        // Pastikan santri milik unit ini
        if (! $santri->santriUnits()->where('unit_id', $unit->id)->exists()) {
            abort(403, 'Santri tidak terdaftar di unit Anda.');
        }

        $santri->load(['person', 'village.district', 'guardianSantris.guardian.person', 'santriUnits']);

        $districts = $this->locationService->getDistrictsInMakassar();
        $locationIds = $this->locationService->getAdminTpaLocationIds();

        return view('tpa.santri.edit', [
            'santri' => $santri,
            'unit' => $unit,
            'districts' => $districts,
            'provinceId' => $locationIds['province_id'],
            'cityId' => $locationIds['city_id'],
            'genderOptions' => Gender::cases(),
            'jenjangOptions' => JenjangSantri::cases(),
            'kelasOptions' => KelasMengaji::cases(),
            'statusOptions' => StatusSantri::cases(),
            'hubunganOptions' => HubunganWaliSantri::cases(),
            'pendidikanOptions' => PendidikanTerakhir::cases(),
            'pekerjaanOptions' => PekerjaanWali::cases(),
        ]);
    }

    /**
     * Update santri
     */
    public function update(Request $request, Santri $santri)
    {
        $unit = $this->getUserUnit();

        // Pastikan santri milik unit ini
        if (! $santri->santriUnits()->where('unit_id', $unit->id)->exists()) {
            abort(403, 'Santri tidak terdaftar di unit Anda.');
        }

        $validated = $request->validate([
            // Data Santri
            'nik' => 'nullable|string|max:16',
            'full_name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => ['required', new Enum(Gender::class)],
            'child_order' => 'nullable|integer|min:1',
            'siblings_count' => 'nullable|integer|min:0',

            // Keanggotaan Unit
            'joined_at' => 'nullable|date',

            // Alamat
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',

            // Nama Orang Tua
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',

            // Status Santri
            'jenjang_santri' => ['required', new Enum(JenjangSantri::class)],
            'kelas_mengaji' => ['required', new Enum(KelasMengaji::class)],
            'status_santri' => ['required', new Enum(StatusSantri::class)],

            // Data Wali
            'wali_nik' => 'nullable|string|max:16',
            'wali_full_name' => 'required|string|max:255',
            'wali_birth_place' => 'nullable|string|max:100',
            'wali_birth_date' => 'nullable|date',
            'wali_gender' => ['required', new Enum(Gender::class)],
            'wali_hubungan' => ['required', new Enum(HubunganWaliSantri::class)],
            'wali_pendidikan' => ['nullable', new Enum(PendidikanTerakhir::class)],
            'wali_pekerjaan' => 'nullable|array',
            'wali_pekerjaan.*' => ['nullable', new Enum(PekerjaanWali::class)],
            'wali_phone' => 'nullable|string|max:20',
        ]);

        // Validasi lokasi harus di Makassar
        if (! $this->locationService->isVillageInMakassar($validated['village_id'])) {
            return back()
                ->withInput()
                ->withErrors(['village_id' => 'Lokasi harus berada di wilayah Kota Makassar.']);
        }

        DB::transaction(function () use ($validated, $santri, $unit) {
            // Get location IDs for region creation
            $locationIds = $this->locationService->getAdminTpaLocationIds();

            // Create or find Region for santri address
            $region = Region::firstOrCreate([
                'province_id' => $locationIds['province_id'],
                'city_id' => $locationIds['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
            ], [
                'jalan' => $validated['address'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
            ]);

            // Update Person
            $santri->person->update([
                'nik' => $validated['nik'] ?? null,
                'full_name' => $validated['full_name'],
                'birth_place' => $validated['birth_place'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'gender' => $validated['gender'],
            ]);

            // Update Santri
            $santri->update([
                'region_id' => $region->id,
                'village_id' => $validated['village_id'],
                'child_order' => $validated['child_order'] ?? null,
                'siblings_count' => $validated['siblings_count'] ?? null,
                'nama_ayah' => $validated['nama_ayah'] ?? null,
                'nama_ibu' => $validated['nama_ibu'] ?? null,
                'address' => $validated['address'] ?? null,
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
                'jenjang_santri' => $validated['jenjang_santri'],
                'kelas_mengaji' => $validated['kelas_mengaji'],
                'status_santri' => $validated['status_santri'],
            ]);

            if (! empty($validated['joined_at'])) {
                $santri->santriUnits()
                    ->where('unit_id', $unit->id)
                    ->update(['joined_at' => $validated['joined_at']]);
            }

            // Update/Create Wali (Guardian)
            $guardianSantri = $santri->guardianSantris()->first();

            if ($guardianSantri) {
                $guardianSantri->guardian->person->update([
                    'nik' => $validated['wali_nik'] ?? null,
                    'full_name' => $validated['wali_full_name'],
                    'birth_place' => $validated['wali_birth_place'] ?? null,
                    'birth_date' => $validated['wali_birth_date'] ?? null,
                    'gender' => $validated['wali_gender'],
                    'phone' => $validated['wali_phone'] ?? null,
                ]);

                $guardianSantri->guardian->update([
                    'pendidikan_terakhir' => $validated['wali_pendidikan'] ?? null,
                    'pekerjaan' => $validated['wali_pekerjaan'] ?? null,
                ]);

                $guardianSantri->update([
                    'hubungan' => $validated['wali_hubungan'],
                ]);
            } else {
                $guardianPerson = Person::create([
                    'nik' => $validated['wali_nik'] ?? null,
                    'full_name' => $validated['wali_full_name'],
                    'birth_place' => $validated['wali_birth_place'] ?? null,
                    'birth_date' => $validated['wali_birth_date'] ?? null,
                    'gender' => $validated['wali_gender'],
                    'phone' => $validated['wali_phone'] ?? null,
                ]);

                $guardian = Guardian::create([
                    'person_id' => $guardianPerson->id,
                    'pendidikan_terakhir' => $validated['wali_pendidikan'] ?? null,
                    'pekerjaan' => $validated['wali_pekerjaan'] ?? null,
                ]);

                GuardianSantri::create([
                    'guardian_id' => $guardian->id,
                    'santri_id' => $santri->id,
                    'hubungan' => $validated['wali_hubungan'],
                ]);
            }
        });

        return redirect()
            ->route('tpa.santri.show', $santri)
            ->with('success', 'Data santri berhasil diperbarui.');
    }

    /**
     * Hapus santri
     */
    public function destroy(Santri $santri)
    {
        $unit = $this->getUserUnit();

        // Pastikan santri milik unit ini
        if (! $santri->santriUnits()->where('unit_id', $unit->id)->exists()) {
            abort(403, 'Santri tidak terdaftar di unit Anda.');
        }

        DB::transaction(function () use ($santri, $unit) {
            // Remove from unit (soft delete - set left_at)
            $santri->santriUnits()
                ->where('unit_id', $unit->id)
                ->update(['left_at' => now()]);
        });

        return redirect()
            ->route('tpa.santri.index')
            ->with('success', 'Santri berhasil dihapus dari unit.');
    }
}
