<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum KelasMengaji: string implements HasLabel
{
    case IQRO_1 = 'Iqro 1';
    case IQRO_2 = 'Iqro 2';
    case IQRO_3 = 'Iqro 3';
    case IQRO_4 = 'Iqro 4';
    case IQRO_5 = 'Iqro 5';
    case IQRO_6 = 'Iqro 6';
    case AL_QURAN = "Al-Qur'an";

    public function getLabel(): string
    {
        return $this->value;
    }
}
