<?php

namespace App\Enum;

enum TipeLokasi: string
{
    case MASJID = 'masjid';
    case MUSHALLAH = 'mushallah';
    case RUMAH_BIASA = 'rumah_biasa';
    case BANGUNAN_KHUSUS = 'bangunan_khusus';
    case GEDUNG_SEKOLAH = 'gedung_sekolah';

    public function getLabel(): string
    {
        return match ($this) {
            self::MASJID => 'Masjid',
            self::MUSHALLAH => 'Mushallah',
            self::RUMAH_BIASA => 'Rumah Biasa',
            self::BANGUNAN_KHUSUS => 'Bangunan Khusus TKA/TP Al-Qur\'an',
            self::GEDUNG_SEKOLAH => 'Gedung Sekolah',
        };
    }
}
