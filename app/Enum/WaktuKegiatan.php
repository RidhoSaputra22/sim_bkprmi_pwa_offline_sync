<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum WaktuKegiatan: string implements HasLabel
{
    case PAGI = 'pagi';
    case SIANG = 'siang';
    case SORE = 'sore';
    case MALAM = 'malam';

    public function getLabel(): string
    {
        return match ($this) {
            self::PAGI => 'Pagi',
            self::SIANG => 'Siang',
            self::SORE => 'Sore',
            self::MALAM => 'Malam',
        };
    }
}
