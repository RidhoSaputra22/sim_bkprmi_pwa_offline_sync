<?php

namespace App\Models;

use App\Enum\Gender;
use App\Enum\JabatanGuru;
use App\Enum\LevelLMD;
use App\Enum\LevelPelatihanGuru;
use App\Enum\PekerjaanWali;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unit_id',
        // Identitas
        'nik',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'phone',
        'photo_path',
        // Pendidikan & Pekerjaan
        'education_level_id',
        'pekerjaan',
        // Alamat
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'jalan',
        'rt',
        'rw',
        // Jabatan
        'jabatan_utama',
        'tugas_tambahan',
        // Pelatihan
        'level_lmd',
        'sertifikat_lmd_path',
        'level_pelatihan_guru',
        'sertifikat_pelatihan_path',
        // Status
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gender' => Gender::class,
        'jabatan_utama' => JabatanGuru::class,
        'tugas_tambahan' => 'array', // JSON array
        'pekerjaan' => 'array', // JSON array of PekerjaanWali
        'level_lmd' => LevelLMD::class,
        'level_pelatihan_guru' => LevelPelatihanGuru::class,
        'is_active' => 'boolean',
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Unit tempat guru mengajar
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Tingkat pendidikan terakhir
     */
    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }



    /**
     * Provinsi tempat tinggal
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Kota/Kabupaten tempat tinggal
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Kecamatan tempat tinggal
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Kelurahan/Desa tempat tinggal
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    // ========================================
    // ACCESSOR & HELPER METHODS
    // ========================================

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->jalan,
            $this->rt ? "RT {$this->rt}" : null,
            $this->rw ? "RW {$this->rw}" : null,
            $this->village?->name,
            $this->district?->name,
            $this->city?->name,
            $this->province?->name,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get age from birth date
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date?->age ?? 0;
    }

    /**
     * Check if teacher has LMD certification
     */
    public function hasLMDCertification(): bool
    {
        return $this->level_lmd !== LevelLMD::BELUM_PERNAH
            && !empty($this->sertifikat_lmd_path);
    }

    /**
     * Check if teacher has teaching training certification
     */
    public function hasTeachingCertification(): bool
    {
        return $this->level_pelatihan_guru !== LevelPelatihanGuru::BELUM_PERNAH
            && !empty($this->sertifikat_pelatihan_path);
    }

    /**
     * Get tugas tambahan as labels
     */
    public function getTugasTambahanLabelsAttribute(): array
    {
        if (empty($this->tugas_tambahan)) {
            return [];
        }

        return collect($this->tugas_tambahan)
            ->map(function ($tugas) {
                try {
                    return \App\Enum\TugasTambahan::from($tugas)->label();
                } catch (\Exception $e) {
                    return $tugas;
                }
            })
            ->toArray();
    }

    /**
     * Get pekerjaan as labels
     */
    public function getPekerjaanLabelsAttribute(): array
    {
        if (empty($this->pekerjaan)) {
            return [];
        }

        return collect($this->pekerjaan)
            ->map(function ($pekerjaan) {
                try {
                    return PekerjaanWali::from($pekerjaan)->getLabel();
                } catch (\Exception $e) {
                    return $pekerjaan;
                }
            })
            ->toArray();
    }

    /**
     * Check if teacher is a classroom teacher (Guru)
     */
    public function isClassroomTeacher(): bool
    {
        return in_array($this->jabatan_utama, [
            JabatanGuru::GURU_IQRA,
            JabatanGuru::GURU_TADARRUS,
            JabatanGuru::WALI_KELAS,
        ]);
    }

    /**
     * Check if teacher is administrator
     */
    public function isAdministrator(): bool
    {
        return in_array($this->jabatan_utama, [
            JabatanGuru::KEPALA_UNIT,
            JabatanGuru::WAKIL_KEPALA_UNIT,
            JabatanGuru::KEPALA_TATA_USAHA,
            JabatanGuru::BENDAHARA,
        ]);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope: Only active teachers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by unit
     */
    public function scopeByUnit($query, $unitId)
    {
        return $query->where('unit_id', $unitId);
    }

    /**
     * Scope: Filter by jabatan utama
     */
    public function scopeByJabatan($query, JabatanGuru $jabatan)
    {
        return $query->where('jabatan_utama', $jabatan);
    }

    /**
     * Scope: Only classroom teachers
     */
    public function scopeClassroomTeachers($query)
    {
        return $query->whereIn('jabatan_utama', [
            JabatanGuru::GURU_IQRA->value,
            JabatanGuru::GURU_TADARRUS->value,
            JabatanGuru::WALI_KELAS->value,
        ]);
    }

    /**
     * Scope: Only administrators
     */
    public function scopeAdministrators($query)
    {
        return $query->whereIn('jabatan_utama', [
            JabatanGuru::KEPALA_UNIT->value,
            JabatanGuru::WAKIL_KEPALA_UNIT->value,
            JabatanGuru::KEPALA_TATA_USAHA->value,
            JabatanGuru::BENDAHARA->value,
        ]);
    }

    /**
     * Scope: Teachers with LMD certification
     */
    public function scopeWithLMD($query)
    {
        return $query->where('level_lmd', '!=', LevelLMD::BELUM_PERNAH->value)
            ->whereNotNull('sertifikat_lmd_path');
    }

    /**
     * Scope: Teachers with teaching certification
     */
    public function scopeWithTeachingCertification($query)
    {
        return $query->where('level_pelatihan_guru', '!=', LevelPelatihanGuru::BELUM_PERNAH->value)
            ->whereNotNull('sertifikat_pelatihan_path');
    }
}
