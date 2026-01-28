<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum StatusBangunan: string implements HasLabel
{
    case MILIK_SENDIRI = 'milik sendiri';
    case SEWA = 'sewa';
    case MENUMPANG = 'menumpang';

    public function getLabel(): string
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'Milik Sendiri',
            self::SEWA => 'Sewa',
            self::MENUMPANG => 'Menumpang',
        };
    }
}
