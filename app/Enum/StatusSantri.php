<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum StatusSantri: string implements HasLabel
{
    case AKTIF = 'aktif';
    case NONAKTIF = 'nonaktif';

    public function getLabel(): string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::NONAKTIF => 'Nonaktif',
        };
    }
}
