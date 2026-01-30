<?php

namespace App\Models;

use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'pendidikan_terakhir',
        'pekerjaan',
    ];

    protected $casts = [
        'pendidikan_terakhir' => PendidikanTerakhir::class,
        'pekerjaan' => 'array',
    ];

    /**
     * Get pekerjaan as enum instances
     */
    public function getPekerjaanEnumsAttribute()
    {
        if (!$this->pekerjaan) {
            return [];
        }

        return collect($this->pekerjaan)
            ->map(fn($value) => PekerjaanWali::tryFrom($value))
            ->filter()
            ->toArray();
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function guardianSantri(): HasMany
    {
        return $this->hasMany(GuardianSantri::class);
    }

    public function santris(): HasManyThrough
    {
        return $this->hasManyThrough(
            Santri::class,
            GuardianSantri::class,
            'guardian_id',
            'id',
            'id',
            'santri_id'
        );
    }
}
