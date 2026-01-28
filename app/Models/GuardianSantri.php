<?php

namespace App\Models;

use App\Enum\HubunganWaliSantri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuardianSantri extends Model
{
    use HasFactory;

    protected $table = 'guardian_santri';

    public $timestamps = false;

    protected $fillable = [
        'guardian_id',
        'santri_id',
        'hubungan',
    ];

    protected $casts = [
        'hubungan' => HubunganWaliSantri::class,
    ];

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }
}
