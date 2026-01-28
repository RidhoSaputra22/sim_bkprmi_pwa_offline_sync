<?php

namespace App\Enum;

enum KelasMengaji: string
{
    case IQRA_1_3 = 'iqra_1_3';
    case IQRA_4_6 = 'iqra_4_6';
    case TADARRUS_1_15 = 'tadarrus_1_15';
    case TADARRUS_16_30 = 'tadarrus_16_30';
    case KELAS_WISUDA = 'kelas_wisuda';

    public function getLabel(): string
    {
        return match ($this) {
            self::IQRA_1_3 => 'Iqra (Jilid 1 s/d 3)',
            self::IQRA_4_6 => 'Iqra (Jilid 4 s/d 6)',
            self::TADARRUS_1_15 => 'Tadarrus (Juz 1 s/d 15)',
            self::TADARRUS_16_30 => 'Tadarrus (Juz 16 s/d 30)',
            self::KELAS_WISUDA => 'Kelas Wisuda',
        };
    }
}
