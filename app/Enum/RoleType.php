<?php

namespace App\Enum;

enum RoleType: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case UNIT_ADMIN = 'unit_admin';
    case MEMBER = 'member';
    case ANGGOTA = 'anggota';
    case SANTRI = 'santri';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'Superadmin',
            self::ADMIN => 'Admin',
            self::UNIT_ADMIN => 'Admin Unit',
            self::MEMBER => 'Member',
            self::ANGGOTA => 'Anggota',
            self::SANTRI => 'Santri',
        };
    }
}
