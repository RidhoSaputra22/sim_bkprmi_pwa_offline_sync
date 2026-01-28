<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'jalan',
        'rt',
        'rw',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function getFullLabelAttribute(): string
    {
        return trim(implode(', ', array_filter([
            $this->village?->name,
            $this->district?->name,
            $this->city?->name,
            $this->province?->name,
        ])));
    }
}
