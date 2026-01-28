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
        'pekerjaan' => PekerjaanWali::class,
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
