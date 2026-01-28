<?php

namespace App\Enum;


enum HubunganWaliSantri: string
{
    case AYAH_KANDUNG = 'ayah_kandung';
    case IBU_KANDUNG = 'ibu_kandung';
    case AYAH_TIRI = 'ayah_tiri';
    case IBU_TIRI = 'ibu_tiri';
    case KAKAK = 'kakak';
    case ADIK = 'adik';
    case SAUDARA_KANDUNG = 'saudara_kandung';
    case PAMAN = 'paman';
    case BIBI = 'bibi';
    case KAKEK = 'kakek';
    case NENEK = 'nenek';
    case LAINNYA = 'lainnya';

    public function getLabel(): string
    {
        return match ($this) {
            self::AYAH_KANDUNG => 'Ayah Kandung',
            self::IBU_KANDUNG => 'Ibu Kandung',
            self::AYAH_TIRI => 'Ayah Tiri',
            self::IBU_TIRI => 'Ibu Tiri',
            self::KAKAK => 'Kakak',
            self::ADIK => 'Adik',
            self::SAUDARA_KANDUNG => 'Saudara Kandung',
            self::PAMAN => 'Paman',
            self::BIBI => 'Bibi',
            self::KAKEK => 'Kakek',
            self::NENEK => 'Nenek',
            self::LAINNYA => 'Lainnya',
        };
    }
}
