<?php

namespace App\Http\Controllers;

use App\Enum\Gender;
use App\Enum\JabatanGuru;
use App\Enum\LevelLMD;
use App\Enum\LevelPelatihanGuru;
use App\Enum\PekerjaanWali;
use App\Enum\TugasTambahan;
use App\Models\City;
use App\Models\District;
use App\Models\EducationLevel;
use App\Models\Job;
use App\Models\Province;
use App\Models\Teacher;
use App\Models\Unit;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers for TPA admin's unit
     */
    public function index()
    {
        $user = Auth::user();

        // Get unit from TPA admin
        $unit = Unit::where('admin_user_id', $user->id)->first();

        if (!$unit) {
            return redirect()->route('tpa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke unit TPA.');
        }

        $teachers = Teacher::with([
            'educationLevel',
            'province',
            'city',
            'district',
            'village'
        ])
            ->where('unit_id', $unit->id)
            ->orderBy('jabatan_utama')
            ->orderBy('full_name')
            ->paginate(20);

        return view('tpa.teachers.index', compact('teachers', 'unit'));
    }

    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        if (!$unit) {
            return redirect()->route('tpa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke unit TPA.');
        }

        $data = $this->getFormData();

        return view('tpa.teachers.create', compact('unit') + $data);
    }

    /**
     * Store a newly created teacher in storage
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        if (!$unit) {
            return redirect()->route('tpa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke unit TPA.');
        }

        $validated = $request->validate([
            // Identitas
            'nik' => ['required', 'string', 'size:16', 'unique:teachers,nik'],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(array_column(Gender::cases(), 'value'))],
            'phone' => ['required', 'string', 'max:15'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'], // Max 1MB

            // Pendidikan & Pekerjaan
            'education_level_id' => ['nullable', 'exists:education_levels,id'],
            'pekerjaan' => ['nullable', new Enum(PekerjaanWali::class)],

            // Alamat
            'province_id' => ['nullable', 'exists:provinces,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'jalan' => ['nullable', 'string', 'max:255'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],

            // Jabatan
            'jabatan_utama' => ['required', Rule::in(array_column(JabatanGuru::cases(), 'value'))],
            'tugas_tambahan' => ['nullable', 'array'],
            'tugas_tambahan.*' => [Rule::in(array_column(TugasTambahan::cases(), 'value'))],

            // Pelatihan
            'level_lmd' => ['required', Rule::in(array_column(LevelLMD::cases(), 'value'))],
            'sertifikat_lmd' => ['nullable', 'file', 'mimes:pdf', 'max:1024'], // Max 1MB
            'level_pelatihan_guru' => ['required', Rule::in(array_column(LevelPelatihanGuru::cases(), 'value'))],
            'sertifikat_pelatihan' => ['nullable', 'file', 'mimes:pdf', 'max:1024'], // Max 1MB
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        // Handle LMD certificate upload
        if ($request->hasFile('sertifikat_lmd')) {
            $validated['sertifikat_lmd_path'] = $request->file('sertifikat_lmd')->store('teachers/certificates/lmd', 'public');
        }

        // Handle teaching certificate upload
        if ($request->hasFile('sertifikat_pelatihan')) {
            $validated['sertifikat_pelatihan_path'] = $request->file('sertifikat_pelatihan')->store('teachers/certificates/teaching', 'public');
        }

        // Add unit_id
        $validated['unit_id'] = $unit->id;
        $validated['is_active'] = true;
        
        // Wrap pekerjaan in array if present
        if (!empty($validated['pekerjaan'])) {
            $validated['pekerjaan'] = [$validated['pekerjaan']];
        }

        $teacher = Teacher::create($validated);

        return redirect()->route('tpa.teachers.show', $teacher)
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified teacher
     */
    public function show(Teacher $teacher)
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        // Check if teacher belongs to admin's unit
        if (!$unit || $teacher->unit_id !== $unit->id) {
            return redirect()->route('tpa.teachers.index')
                ->with('error', 'Anda tidak memiliki akses ke data guru ini.');
        }

        $teacher->load([
            'unit',
            'educationLevel',
            'province',
            'city',
            'district',
            'village'
        ]);

        return view('tpa.teachers.show', compact('teacher', 'unit'));
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit(Teacher $teacher)
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        // Check if teacher belongs to admin's unit
        if (!$unit || $teacher->unit_id !== $unit->id) {
            return redirect()->route('tpa.teachers.index')
                ->with('error', 'Anda tidak memiliki akses ke data guru ini.');
        }

        $data = $this->getFormData();

        return view('tpa.teachers.edit', compact('teacher', 'unit') + $data);
    }

    /**
     * Update the specified teacher in storage
     */
    public function update(Request $request, Teacher $teacher)
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        // Check if teacher belongs to admin's unit
        if (!$unit || $teacher->unit_id !== $unit->id) {
            return redirect()->route('tpa.teachers.index')
                ->with('error', 'Anda tidak memiliki akses ke data guru ini.');
        }

        $validated = $request->validate([
            // Identitas
            'nik' => ['required', 'string', 'size:16', Rule::unique('teachers', 'nik')->ignore($teacher->id)],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(array_column(Gender::cases(), 'value'))],
            'phone' => ['required', 'string', 'max:15'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],

            // Pendidikan & Pekerjaan
            'education_level_id' => ['nullable', 'exists:education_levels,id'],
            'pekerjaan' => ['nullable', new Enum(PekerjaanWali::class)],

            // Alamat
            'province_id' => ['nullable', 'exists:provinces,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'jalan' => ['nullable', 'string', 'max:255'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],

            // Jabatan
            'jabatan_utama' => ['required', Rule::in(array_column(JabatanGuru::cases(), 'value'))],
            'tugas_tambahan' => ['nullable', 'array'],
            'tugas_tambahan.*' => [Rule::in(array_column(TugasTambahan::cases(), 'value'))],

            // Pelatihan
            'level_lmd' => ['required', Rule::in(array_column(LevelLMD::cases(), 'value'))],
            'sertifikat_lmd' => ['nullable', 'file', 'mimes:pdf', 'max:1024'],
            'level_pelatihan_guru' => ['required', Rule::in(array_column(LevelPelatihanGuru::cases(), 'value'))],
            'sertifikat_pelatihan' => ['nullable', 'file', 'mimes:pdf', 'max:1024'],

            // Status
            'is_active' => ['sometimes', 'boolean'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teacher->photo_path) {
                Storage::disk('public')->delete($teacher->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('teachers/photos', 'public');
        }

        // Handle LMD certificate upload
        if ($request->hasFile('sertifikat_lmd')) {
            // Delete old certificate
            if ($teacher->sertifikat_lmd_path) {
                Storage::disk('public')->delete($teacher->sertifikat_lmd_path);
            }
            $validated['sertifikat_lmd_path'] = $request->file('sertifikat_lmd')->store('teachers/certificates/lmd', 'public');
        }

        // Handle teaching certificate upload
        if ($request->hasFile('sertifikat_pelatihan')) {
            // Delete old certificate
            if ($teacher->sertifikat_pelatihan_path) {
                Storage::disk('public')->delete($teacher->sertifikat_pelatihan_path);
            }
            $validated['sertifikat_pelatihan_path'] = $request->file('sertifikat_pelatihan')->store('teachers/certificates/teaching', 'public');
        }

        // Wrap pekerjaan in array if present
        if (!empty($validated['pekerjaan'])) {
            $validated['pekerjaan'] = [$validated['pekerjaan']];
        }

        $teacher->update($validated);

        return redirect()->route('tpa.teachers.show', $teacher)
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified teacher from storage (soft delete)
     */
    public function destroy(Teacher $teacher)
    {
        $user = Auth::user();
        $unit = Unit::where('admin_user_id', $user->id)->first();

        // Check if teacher belongs to admin's unit
        if (!$unit || $teacher->unit_id !== $unit->id) {
            return redirect()->route('tpa.teachers.index')
                ->with('error', 'Anda tidak memiliki akses ke data guru ini.');
        }

        $teacher->delete();

        return redirect()->route('tpa.teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Get form data (options for selects)
     */
    private function getFormData(): array
    {
        return [
            'genders' => Gender::cases(),
            'jabatanOptions' => JabatanGuru::cases(),
            'tugasTambahanOptions' => TugasTambahan::cases(),
            'levelLMDOptions' => LevelLMD::cases(),
            'levelPelatihanOptions' => LevelPelatihanGuru::cases(),
            'pekerjaanOptions' => PekerjaanWali::cases(),
            'educationLevels' => EducationLevel::orderBy('name')->get(),
            'provinces' => Province::orderBy('name')->get(),
        ];
    }

    /**
     * AJAX: Get cities by province
     */
    public function getCities(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    /**
     * AJAX: Get districts by city
     */
    public function getDistricts(Request $request)
    {
        $districts = District::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($districts);
    }

    /**
     * AJAX: Get villages by district
     */
    public function getVillages(Request $request)
    {
        $villages = Village::where('district_id', $request->district_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($villages);
    }
}
