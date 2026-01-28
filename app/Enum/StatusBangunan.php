<?php

namespace App\Enum;

enum StatusBangunan: string
{
    case WAQAF = 'waqaf';
    case SEWA = 'sewa';
    case MILIK_SENDIRI = 'milik_sendiri';

    public function getLabel(): string
    {
        return match ($this) {
            self::WAQAF => 'Waqaf',
            self::SEWA => 'Sewa',
            self::MILIK_SENDIRI => 'Milik Sendiri',
        };
    }
}
