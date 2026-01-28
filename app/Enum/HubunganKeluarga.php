<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum HubunganKeluarga: string implements HasLabel
{
    case AYAH = 'ayah';
    case IBU = 'ibu';
    case ANAK = 'anak';
    case KAKAK = 'kakak';
    case ADIK = 'adik';
    case PAMAN = 'paman';
    case BIBI = 'bibi';
    case WALI = 'wali';

    public function getLabel(): string
    {
        return match ($this) {
            self::AYAH => 'Ayah',
            self::IBU => 'Ibu',
            self::ANAK => 'Anak',
            self::KAKAK => 'Kakak',
            self::ADIK => 'Adik',
            self::PAMAN => 'Paman',
            self::BIBI => 'Bibi',
            self::WALI => 'Wali',
        };
    }
}
