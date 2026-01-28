<?php

namespace App\Models;

use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\StatusSantri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Santri extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'region_id',
        'village_id',
        'child_order',
        'siblings_count',
        'nama_ayah',
        'nama_ibu',
        'address',
        'rt',
        'rw',
        'jenjang_santri',
        'kelas_mengaji',
        'status_santri',
        'graduated',
    ];

    protected $casts = [
        'jenjang_santri' => JenjangSantri::class,
        'kelas_mengaji' => KelasMengaji::class,
        'status_santri' => StatusSantri::class,
        'graduated' => 'boolean',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function guardians(): HasManyThrough
    {
        return $this->hasManyThrough(
            Guardian::class,
            GuardianSantri::class,
            'santri_id',
            'id',
            'id',
            'guardian_id'
        );
    }

    public function guardianSantris()
    {
        return $this->hasMany(GuardianSantri::class);
    }
}
