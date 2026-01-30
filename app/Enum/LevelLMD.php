<?php

namespace App\Enum;

enum LevelLMD: string
{
    case LMD_1 = 'lmd_1';
    case LMD_2 = 'lmd_2';
    case LMD_3 = 'lmd_3';
    case BELUM_PERNAH = 'belum_pernah';

    public function label(): string
    {
        return match ($this) {
            self::LMD_1 => 'LMD 1',
            self::LMD_2 => 'LMD 2',
            self::LMD_3 => 'LMD 3',
            self::BELUM_PERNAH => 'Belum Pernah',
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
