<?php

namespace App\Enum;

enum TugasTambahan: string
{
    case ADMIN_OPERATOR = 'admin_operator';
    case GURU_IQRA = 'guru_iqra';
    case GURU_TADARRUS = 'guru_tadarrus';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN_OPERATOR => 'Admin (Operator) TPA',
            self::GURU_IQRA => 'Guru (Kelas Iqra)',
            self::GURU_TADARRUS => 'Guru (Kelas Tadarrus)',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
