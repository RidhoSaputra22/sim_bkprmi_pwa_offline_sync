<?php

namespace App\Http\Controllers\Admin;

use App\Enum\Gender;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Unit::with(['village.district.city.province', 'unitHead.person', 'unitAdmin.person']);

        // Filter by tipe lokasi
        if ($request->filled('tipe_lokasi')) {
            $query->where('tipe_lokasi', $request->tipe_lokasi);
        }

        // Filter by status bangunan
        if ($request->filled('status_bangunan')) {
            $query->where('status_bangunan', $request->status_bangunan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('unit_number', 'like', "%{$search}%")
                    ->orWhere('mosque_name', 'like', "%{$search}%");
            });
        }

        $units = $query->latest()->paginate(15);

        return view('admin.units.index', [
            'units' => $units,
            'tipeLokasiOptions' => TipeLokasi::cases(),
            'statusBangunanOptions' => StatusBangunan::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        return view('admin.units.create', [
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',

            // Keadaan Santri
            'jumlah_tka_4_7' => 'nullable|integer|min:0',
            'jumlah_tpa_7_12' => 'nullable|integer|min:0',
            'jumlah_tqa_wisuda' => 'nullable|integer|min:0',

            // Keadaan Guru
            'jumlah_guru_laki_laki' => 'nullable|integer|min:0',
            'jumlah_guru_perempuan' => 'nullable|integer|min:0',

            // Kepala Unit
            'kepala_nama' => 'required|string|max:255',
            'kepala_nik' => 'required|string|size:16',
            'kepala_tempat_lahir' => 'required|string|max:255',
            'kepala_tanggal_lahir' => 'required|date',
            'kepala_gender' => ['required', new Enum(Gender::class)],
            'kepala_pendidikan' => ['required', new Enum(PendidikanTerakhir::class)],
            'kepala_pekerjaan' => ['required', new Enum(PekerjaanWali::class)],
            'kepala_phone' => 'required|string|max:20',

            // Admin Unit
            'admin_nama' => 'nullable|string|max:255',
            'admin_phone' => 'nullable|string|max:20',
            'admin_email' => 'nullable|email|max:255',
        ]);

        DB::beginTransaction();

        try {
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

            // Create Unit
            $unit = Unit::create([
                'unit_number' => $validated['unit_number'],
                'name' => $validated['name'],
                'region_id' => $region->id,
                'village_id' => $validated['village_id'],
                'address' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'tipe_lokasi' => $validated['tipe_lokasi'],
                'status_bangunan' => $validated['status_bangunan'],
                'waktu_kegiatan' => $validated['waktu_kegiatan'],
                'mosque_name' => $validated['mosque_name'],
                'founder' => $validated['founder'],
                'formed_at' => $validated['formed_at'],
                'joined_year' => $validated['joined_year'],
                'email' => $validated['email'],
                'jumlah_tka_4_7' => $validated['jumlah_tka_4_7'] ?? 0,
                'jumlah_tpa_7_12' => $validated['jumlah_tpa_7_12'] ?? 0,
                'jumlah_tqa_wisuda' => $validated['jumlah_tqa_wisuda'] ?? 0,
                'jumlah_guru_laki_laki' => $validated['jumlah_guru_laki_laki'] ?? 0,
                'jumlah_guru_perempuan' => $validated['jumlah_guru_perempuan'] ?? 0,
            ]);

            // Create or find Person for Kepala Unit
            $kepalaPerson = Person::firstOrCreate(
                ['nik' => $validated['kepala_nik']],
                [
                    'full_name' => $validated['kepala_nama'],
                    'birth_place' => $validated['kepala_tempat_lahir'],
                    'birth_date' => $validated['kepala_tanggal_lahir'],
                    'gender' => $validated['kepala_gender'],
                    'phone' => $validated['kepala_phone'],
                ]
            );

            // Create UnitHead
            UnitHead::create([
                'unit_id' => $unit->id,
                'person_id' => $kepalaPerson->id,
                'pendidikan_terakhir' => $validated['kepala_pendidikan'],
                'pekerjaan' => [$validated['kepala_pekerjaan']],
            ]);

            // Create Admin if provided
            if (! empty($validated['admin_nama'])) {
                $adminPerson = Person::create([
                    'full_name' => $validated['admin_nama'],
                    'phone' => $validated['admin_phone'],
                    'email' => $validated['admin_email'],
                ]);

                UnitAdmin::create([
                    'unit_id' => $unit->id,
                    'person_id' => $adminPerson->id,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.units.index')
                ->with('success', 'Unit TPA/TPQ berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        $unit->load(['village.district.city.province', 'unitHead.person', 'unitAdmin.person']);

        $unitHead = $unit->unitHead;
        $unitAdmin = $unit->unitAdmin;

        return view('admin.units.show', compact('unit', 'unitHead', 'unitAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $unit->load(['village.district.city.province', 'unitHead.person', 'unitAdmin.person', 'region']);
        $provinces = Province::orderBy('name')->get();

        $unitHead = $unit->unitHead;
        $unitAdmin = $unit->unitAdmin;

        return view('admin.units.edit', [
            'unit' => $unit,
            'unitHead' => $unitHead,
            'unitAdmin' => $unitAdmin,
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            // Identitas Unit
            'unit_number' => 'required|string|max:50|unique:units,unit_number,'.$unit->id,
            'name' => 'required|string|max:255',
            'tipe_lokasi' => ['required', new Enum(TipeLokasi::class)],
            'status_bangunan' => ['required', new Enum(StatusBangunan::class)],
            'mosque_name' => 'nullable|string|max:255',
            'founder' => 'nullable|string|max:255',
            'formed_at' => 'nullable|date',
            'joined_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'waktu_kegiatan' => ['required', new Enum(WaktuKegiatan::class)],
            'email' => 'nullable|email|max:255',

            // Alamat
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'address' => 'required|string|max:500',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',

            // Keadaan Santri
            'jumlah_tka_4_7' => 'nullable|integer|min:0',
            'jumlah_tpa_7_12' => 'nullable|integer|min:0',
            'jumlah_tqa_wisuda' => 'nullable|integer|min:0',

            // Keadaan Guru
            'jumlah_guru_laki_laki' => 'nullable|integer|min:0',
            'jumlah_guru_perempuan' => 'nullable|integer|min:0',

            // Kepala Unit
            'kepala_nama' => 'required|string|max:255',
            'kepala_nik' => 'required|string|size:16',
            'kepala_tempat_lahir' => 'required|string|max:255',
            'kepala_tanggal_lahir' => 'required|date',
            'kepala_gender' => ['required', new Enum(Gender::class)],
            'kepala_pendidikan' => ['required', new Enum(PendidikanTerakhir::class)],
            'kepala_pekerjaan' => ['required', new Enum(PekerjaanWali::class)],
            'kepala_phone' => 'required|string|max:20',

            // Admin Unit
            'admin_nama' => 'nullable|string|max:255',
            'admin_phone' => 'nullable|string|max:20',
            'admin_email' => 'nullable|email|max:255',
        ]);

        DB::beginTransaction();

        try {
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

            // Update Unit
            $unit->update([
                'unit_number' => $validated['unit_number'],
                'name' => $validated['name'],
                'village_id' => $validated['village_id'],
                'region_id' => $region->id,
                'tipe_lokasi' => $validated['tipe_lokasi'],
                'status_bangunan' => $validated['status_bangunan'],
                'waktu_kegiatan' => $validated['waktu_kegiatan'],
                'mosque_name' => $validated['mosque_name'],
                'founder' => $validated['founder'],
                'formed_at' => $validated['formed_at'],
                'joined_year' => $validated['joined_year'],
                'email' => $validated['email'],
                'jumlah_tka_4_7' => $validated['jumlah_tka_4_7'] ?? 0,
                'jumlah_tpa_7_12' => $validated['jumlah_tpa_7_12'] ?? 0,
                'jumlah_tqa_wisuda' => $validated['jumlah_tqa_wisuda'] ?? 0,
                'jumlah_guru_laki_laki' => $validated['jumlah_guru_laki_laki'] ?? 0,
                'jumlah_guru_perempuan' => $validated['jumlah_guru_perempuan'] ?? 0,
            ]);

            // Update or create Kepala Unit
            $kepalaPerson = Person::updateOrCreate(
                ['nik' => $validated['kepala_nik']],
                [
                    'full_name' => $validated['kepala_nama'],
                    'birth_place' => $validated['kepala_tempat_lahir'],
                    'birth_date' => $validated['kepala_tanggal_lahir'],
                    'gender' => $validated['kepala_gender'],
                    'phone' => $validated['kepala_phone'],
                ]
            );

            UnitHead::updateOrCreate(
                ['unit_id' => $unit->id],
                [
                    'person_id' => $kepalaPerson->id,
                    'pendidikan_terakhir' => $validated['kepala_pendidikan'],
                    'pekerjaan' => [$validated['kepala_pekerjaan']],
                ]
            );

            // Update or create Admin
            if (! empty($validated['admin_nama'])) {
                $existingAdmin = $unit->unitAdmin;

                if ($existingAdmin) {
                    $existingAdmin->person->update([
                        'full_name' => $validated['admin_nama'],
                        'phone' => $validated['admin_phone'],
                        'email' => $validated['admin_email'],
                    ]);
                } else {
                    $adminPerson = Person::create([
                        'full_name' => $validated['admin_nama'],
                        'phone' => $validated['admin_phone'],
                        'email' => $validated['admin_email'],
                    ]);

                    UnitAdmin::create([
                        'unit_id' => $unit->id,
                        'person_id' => $adminPerson->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.units.index')
                ->with('success', 'Unit TPA/TPQ berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit TPA/TPQ berhasil dihapus.');
    }
}
