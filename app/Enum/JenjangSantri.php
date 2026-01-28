<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum JenjangSantri: string implements HasLabel
{
    case PEMULA = 'pemula';
    case MENENGAH = 'menengah';
    case LANJUTAN = 'lanjutan';

    public function getLabel(): string
    {
        return match ($this) {
            self::PEMULA => 'Pemula',
            self::MENENGAH => 'Menengah',
            self::LANJUTAN => 'Lanjutan',
        };
    }
}
