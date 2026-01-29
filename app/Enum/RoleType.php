<?php

namespace App\Enum;

enum RoleType: string
{
    /**
     * SuperAdmin BKPRMI - Dashboard pemantauan keseluruhan data
     * Dapat approve/validasi TPA yang diinput oleh Admin LPPTKA
     */
    case SUPERADMIN = 'superadmin';

    /**
     * Admin LPPTKA - Menginput profil TPA & membuat akun TPA
     * Dapat membuat akun TPA setelah SuperAdmin approve profil TPA
     */
    case ADMIN_LPPTKA = 'admin_lpptka';

    /**
     * Admin TPA - Menginput data santri & data TPA
     * Terbatas pada Provinsi Sulsel, Kota Makassar
     */
    case ADMIN_TPA = 'admin_tpa';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'SuperAdmin BKPRMI',
            self::ADMIN_LPPTKA => 'Admin LPPTKA',
            self::ADMIN_TPA => 'Admin TPA',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::SUPERADMIN => 'Dashboard pemantauan keseluruhan data dan approval TPA',
            self::ADMIN_LPPTKA => 'Menginput profil TPA dan membuat akun TPA',
            self::ADMIN_TPA => 'Menginput data santri dan data TPA',
        };
    }

    /**
     * Get permissions for each role
     */
    public function getPermissions(): array
    {
        return match ($this) {
            self::SUPERADMIN => [
                'dashboard.view',
                'unit.view', 'unit.approve', 'unit.reject',
                'santri.view',
                'activity.view',
                'user.view', 'user.manage',
                'report.view', 'report.export',
            ],
            self::ADMIN_LPPTKA => [
                'unit.view', 'unit.create', 'unit.edit',
                'unit.upload_certificate',
                'unit_account.create', // Hanya jika sudah diapprove SuperAdmin
                'santri.view',
                'report.view',
            ],
            self::ADMIN_TPA => [
                'santri.view', 'santri.create', 'santri.edit', 'santri.delete',
                'unit.view', 'unit.edit_own', // Hanya unit sendiri
                'guardian.view', 'guardian.create', 'guardian.edit',
            ],
        };
    }

    /**
     * Check if role can manage units
     */
    public function canManageUnit(): bool
    {
        return in_array($this, [self::SUPERADMIN, self::ADMIN_LPPTKA]);
    }

    /**
     * Check if role can approve units
     */
    public function canApproveUnit(): bool
    {
        return $this === self::SUPERADMIN;
    }

    /**
     * Check if role can create TPA account
     */
    public function canCreateTpaAccount(): bool
    {
        return $this === self::ADMIN_LPPTKA;
    }

    /**
     * Check if role can manage santri
     */
    public function canManageSantri(): bool
    {
        return $this === self::ADMIN_TPA;
    }
}
