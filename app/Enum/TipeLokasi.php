<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum TipeLokasi: string implements HasLabel
{
    case PERKOTAAN = 'perkotaan';
    case PEDESAAN = 'pedesaan';

    public function getLabel(): string
    {
        return match ($this) {
            self::PERKOTAAN => 'Perkotaan',
            self::PEDESAAN => 'Pedesaan',
        };
    }
}
