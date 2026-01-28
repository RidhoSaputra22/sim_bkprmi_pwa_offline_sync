<?php

namespace App\Models;

use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'pekerjaan' => PekerjaanWali::class,
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function guardianSantri(): HasMany
    {
        return $this->hasMany(GuardianSantri::class);
    }

    public function santris()
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
