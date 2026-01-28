<?php

namespace App\Enum;


enum Gender: string
{
    case LAKI_LAKI = 'laki-laki';
    case PEREMPUAN = 'perempuan';

    public function getLabel(): string
    {
        return match ($this) {
            self::LAKI_LAKI => 'Laki-Laki',
            self::PEREMPUAN => 'Perempuan',
        };
    }
}
