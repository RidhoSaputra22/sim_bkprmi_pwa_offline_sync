<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
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
