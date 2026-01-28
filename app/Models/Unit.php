<?php

namespace App\Models;

use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'name',
        'region_id',
        'village_id',
        'address',
        'rt',
        'rw',
        'tipe_lokasi',
        'status_bangunan',
        'waktu_kegiatan',
        'mosque_name',
        'founder',
        'formed_at',
        'joined_year',
        'email',
        'jumlah_tka_4_7',
        'jumlah_tpa_7_12',
        'jumlah_tqa_wisuda',
        'jumlah_guru_laki_laki',
        'jumlah_guru_perempuan',
    ];

    protected $casts = [
        'formed_at' => 'date',
        'joined_year' => 'integer',
        'tipe_lokasi' => TipeLokasi::class,
        'status_bangunan' => StatusBangunan::class,
        'waktu_kegiatan' => WaktuKegiatan::class,
        'jumlah_tka_4_7' => 'integer',
        'jumlah_tpa_7_12' => 'integer',
        'jumlah_tqa_wisuda' => 'integer',
        'jumlah_guru_laki_laki' => 'integer',
        'jumlah_guru_perempuan' => 'integer',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function unitHead(): HasOne
    {
        return $this->hasOne(UnitHead::class);
    }

    public function unitAdmin(): HasOne
    {
        return $this->hasOne(UnitAdmin::class);
    }
}
