<?php

namespace App\Models;

use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitHead extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
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

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
