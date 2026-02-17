<?php

namespace App\Http\Controllers\Tpa;

use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class UnitController extends Controller
{
    /**
     * Tampilkan profil unit TPA milik admin yang login.
     */
    public function show()
    {
        $unit = Auth::user()->managedUnit;

        if (! $unit) {
            return view('tpa.no-unit');
        }

        $unit->load(['village.district.city.province', 'unitHead.person']);

        $stats = [
            'total_santri'  => $unit->santris()->count(),
            'active_santri' => $unit->santris()->where('status_santri', 'aktif')->count(),
            'male_santri'   => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'laki-laki'))->count(),
            'female_santri' => $unit->santris()->whereHas('person', fn ($q) => $q->where('gender', 'perempuan'))->count(),
        ];

        return view('tpa.unit.show', compact('unit', 'stats'));
    }

    /**
     * Form edit profil unit TPA.
     */
    public function edit()
    {
        $unit = Auth::user()->managedUnit;

        if (! $unit) {
            return redirect()->route('tpa.dashboard')->with('error', 'Unit tidak ditemukan.');
        }

        $unit->load(['village.district.city.province']);

        $provinces            = Province::orderBy('name')->get();
        $currentProvinceId    = $unit->village?->district?->city?->province_id;
        $currentCityId        = $unit->village?->district?->city_id;
        $currentDistrictId    = $unit->village?->district_id;

        return view('tpa.unit.edit', [
            'unit'               => $unit,
            'provinces'          => $provinces,
            'currentProvinceId'  => $currentProvinceId,
            'currentCityId'      => $currentCityId,
            'currentDistrictId'  => $currentDistrictId,
            'tipeLokasiOptions'  => TipeLokasi::cases(),
            'statusBangunanOptions' => StatusBangunan::cases(),
            'waktuKegiatanOptions'  => WaktuKegiatan::cases(),
        ]);
    }

    /**
     * Simpan perubahan profil unit TPA.
     */
    public function update(Request $request)
    {
        $unit = Auth::user()->managedUnit;

        if (! $unit) {
            return redirect()->route('tpa.dashboard')->with('error', 'Unit tidak ditemukan.');
        }

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'phone'            => 'nullable|string|max:20',
            'mosque_name'      => 'nullable|string|max:255',
            'founder'          => 'nullable|string|max:255',
            'tipe_lokasi'      => ['nullable', new Enum(TipeLokasi::class)],
            'status_bangunan'  => ['nullable', new Enum(StatusBangunan::class)],
            'waktu_kegiatan'   => ['required', 'array', 'min:1'],
            'waktu_kegiatan.*' => [new Enum(WaktuKegiatan::class)],
            'village_id'       => 'required|exists:villages,id',
            'address'          => 'nullable|string|max:500',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'jumlah_tka'       => 'nullable|integer|min:0',
            'jumlah_tpa'       => 'nullable|integer|min:0',
            'jumlah_tqa'       => 'nullable|integer|min:0',
            'guru_laki'        => 'nullable|integer|min:0',
            'guru_perempuan'   => 'nullable|integer|min:0',
        ]);

        $unit->update([
            'name'            => $validated['name'],
            'email'           => $validated['email']           ?? $unit->email,
            'phone'           => $validated['phone']           ?? $unit->phone,
            'mosque_name'     => $validated['mosque_name']     ?? $unit->mosque_name,
            'founder'         => $validated['founder']         ?? $unit->founder,
            'tipe_lokasi'     => $validated['tipe_lokasi']     ?? $unit->tipe_lokasi,
            'status_bangunan' => $validated['status_bangunan'] ?? $unit->status_bangunan,
            'waktu_kegiatan'  => $validated['waktu_kegiatan'],
            'village_id'      => $validated['village_id'],
            'address'         => $validated['address']         ?? $unit->address,
            'rt'              => $validated['rt']               ?? $unit->rt,
            'rw'              => $validated['rw']               ?? $unit->rw,
            'jumlah_tka'      => $validated['jumlah_tka']      ?? $unit->jumlah_tka,
            'jumlah_tpa'      => $validated['jumlah_tpa']      ?? $unit->jumlah_tpa,
            'jumlah_tqa'      => $validated['jumlah_tqa']      ?? $unit->jumlah_tqa,
            'guru_laki'       => $validated['guru_laki']       ?? $unit->guru_laki,
            'guru_perempuan'  => $validated['guru_perempuan']  ?? $unit->guru_perempuan,
        ]);

        return redirect()->route('tpa.unit.show')
            ->with('success', 'Profil unit berhasil diperbarui.');
    }
}
