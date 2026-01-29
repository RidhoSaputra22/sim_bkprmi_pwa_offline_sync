<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Province;
use App\Models\Santri;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Santri::with(['person', 'region']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_santri', $request->status);
        }

        // Filter by jenjang
        if ($request->filled('jenjang')) {
            $query->where('jenjang_santri', $request->jenjang);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('person', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $santri = $query->latest()->paginate(15);

        return view('admin.santri.index', [
            'santri' => $santri,
            'statusOptions' => StatusSantri::cases(),
            'jenjangOptions' => JenjangSantri::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        return view('admin.santri.create', [
            'provinces' => $provinces,
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Identitas Santri
            'nik' => 'required|string|size:16|unique:persons,nik',
            'full_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => ['required', new Enum(Gender::class)],
            'child_order' => 'required|integer|min:1',
            'siblings_count' => 'required|integer|min:0',

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',

            // Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',

            // Wali Santri
            'wali_nik' => 'required|string|size:16',
            'wali_nama' => 'required|string|max:255',
            'wali_tempat_lahir' => 'required|string|max:255',
            'wali_tanggal_lahir' => 'required|date',
            'wali_gender' => ['required', new Enum(Gender::class)],
            'wali_hubungan' => ['required', new Enum(HubunganWaliSantri::class)],
            'wali_pendidikan' => ['required', new Enum(PendidikanTerakhir::class)],
            'wali_pekerjaan' => ['required', new Enum(PekerjaanWali::class)],
            'wali_phone' => 'required|string|max:20',

            // Status Santri
            'jenjang_santri' => ['required', new Enum(JenjangSantri::class)],
            'kelas_mengaji' => ['required', new Enum(KelasMengaji::class)],
            'status_santri' => ['required', new Enum(StatusSantri::class)],
        ]);

        DB::beginTransaction();

        try {
            // Create person for santri
            $person = Person::create([
                'nik' => $validated['nik'],
                'full_name' => $validated['full_name'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
            ]);

            // Create or find Region for address
            $region = Region::firstOrCreate([
                'province_id' => $validated['province_id'],
                'city_id' => $validated['city_id'],
                'district_id' => $validated['district_id'],
                'village_id' => $validated['village_id'],
            ], [
                'jalan' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
            ]);

            // Create santri
            $santri = Santri::create([
                'person_id' => $person->id,
                'region_id' => $region->id,
                'village_id' => $validated['village_id'],
                'child_order' => $validated['child_order'],
                'siblings_count' => $validated['siblings_count'],
                'nama_ayah' => $validated['nama_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'address' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'jenjang_santri' => $validated['jenjang_santri'],
                'kelas_mengaji' => $validated['kelas_mengaji'],
                'status_santri' => $validated['status_santri'],
                'graduated' => false,
            ]);

            // Create or find guardian person
            $waliPerson = Person::firstOrCreate(
                ['nik' => $validated['wali_nik']],
                [
                    'full_name' => $validated['wali_nama'],
                    'birth_place' => $validated['wali_tempat_lahir'],
                    'birth_date' => $validated['wali_tanggal_lahir'],
                    'gender' => $validated['wali_gender'],
                    'phone' => $validated['wali_phone'],
                ]
            );

            // Create guardian
            $guardian = Guardian::create([
                'person_id' => $waliPerson->id,
                'pendidikan_terakhir' => $validated['wali_pendidikan'],
                'pekerjaan' => $validated['wali_pekerjaan'],
            ]);

            // Link guardian to santri
            GuardianSantri::create([
                'guardian_id' => $guardian->id,
                'santri_id' => $santri->id,
                'hubungan' => $validated['wali_hubungan'],
            ]);

            DB::commit();

            // Return JSON response for AJAX/offline requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data santri berhasil ditambahkan.',
                    'data' => $santri->load('person'),
                    'redirect' => route('admin.santri.index'),
                ]);
            }

            return redirect()
                ->route('admin.santri.index')
                ->with('success', 'Data santri berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Return JSON error for AJAX/offline requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Santri $santri)
    {
        $santri->load(['person', 'village.district.city.province', 'guardians.person', 'guardians.guardianSantri']);

        return view('admin.santri.show', compact('santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $santri->load(['person', 'village.district.city.province', 'guardians.person']);
        $provinces = Province::orderBy('name')->get();

        return view('admin.santri.edit', [
            'santri' => $santri,
            'provinces' => $provinces,
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            // Identitas Santri
            'nik' => 'required|string|size:16|unique:persons,nik,' . $santri->person_id,
            'full_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => ['required', new Enum(Gender::class)],
            'child_order' => 'required|integer|min:1',
            'siblings_count' => 'required|integer|min:0',

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',

            // Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',

            // Wali Santri
            'wali_nik' => 'required|string|size:16',
            'wali_nama' => 'required|string|max:255',
            'wali_tempat_lahir' => 'required|string|max:255',
            'wali_tanggal_lahir' => 'required|date',
            'wali_gender' => ['required', new Enum(Gender::class)],
            'wali_hubungan' => ['required', new Enum(HubunganWaliSantri::class)],
            'wali_pendidikan' => ['required', new Enum(PendidikanTerakhir::class)],
            'wali_pekerjaan' => ['required', new Enum(PekerjaanWali::class)],
            'wali_phone' => 'required|string|max:20',

            // Status Santri
            'jenjang_santri' => ['required', new Enum(JenjangSantri::class)],
            'kelas_mengaji' => ['required', new Enum(KelasMengaji::class)],
            'status_santri' => ['required', new Enum(StatusSantri::class)],
        ]);

        DB::beginTransaction();

        try {
            // Update person
            $santri->person->update([
                'nik' => $validated['nik'],
                'full_name' => $validated['full_name'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
            ]);

            // Update santri
            $santri->update([
                'village_id' => $validated['village_id'],
                'child_order' => $validated['child_order'],
                'siblings_count' => $validated['siblings_count'],
                'nama_ayah' => $validated['nama_ayah'],
                'nama_ibu' => $validated['nama_ibu'],
                'address' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'jenjang_santri' => $validated['jenjang_santri'],
                'kelas_mengaji' => $validated['kelas_mengaji'],
                'status_santri' => $validated['status_santri'],
            ]);

            // Update or create guardian
            $waliPerson = Person::updateOrCreate(
                ['nik' => $validated['wali_nik']],
                [
                    'full_name' => $validated['wali_nama'],
                    'birth_place' => $validated['wali_tempat_lahir'],
                    'birth_date' => $validated['wali_tanggal_lahir'],
                    'gender' => $validated['wali_gender'],
                    'phone' => $validated['wali_phone'],
                ]
            );

            // Update or create guardian
            $guardian = Guardian::updateOrCreate(
                ['person_id' => $waliPerson->id],
                [
                    'pendidikan_terakhir' => $validated['wali_pendidikan'],
                    'pekerjaan' => $validated['wali_pekerjaan'],
                ]
            );

            // Update guardian-santri relationship
            GuardianSantri::updateOrCreate(
                ['santri_id' => $santri->id],
                [
                    'guardian_id' => $guardian->id,
                    'hubungan' => $validated['wali_hubungan'],
                ]
            );

            DB::commit();

            return redirect()
                ->route('admin.santri.index')
                ->with('success', 'Data santri berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()
            ->route('admin.santri.index')
            ->with('success', 'Data santri berhasil dihapus.');
    }
}
