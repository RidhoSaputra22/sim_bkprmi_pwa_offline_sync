<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum RoleType: string implements HasLabel
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case UNIT_ADMIN = 'unit_admin';
    case SANTRI = 'santri';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'Superadmin',
            self::ADMIN => 'Admin',
            self::UNIT_ADMIN => 'Admin Unit',
            self::SANTRI => 'Santri',
        };
    }
}
