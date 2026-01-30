<?php

namespace App\Enum;

enum LevelPelatihanGuru: string
{
    case LEVEL_A = 'level_a';
    case LEVEL_B = 'level_b';
    case LEVEL_C = 'level_c';
    case BELUM_PERNAH = 'belum_pernah';

    public function label(): string
    {
        return match ($this) {
            self::LEVEL_A => 'Pelatihan Guru Mengaji Level A',
            self::LEVEL_B => 'Pelatihan Guru Mengaji Level B',
            self::LEVEL_C => 'Pelatihan Guru Mengaji Level C',
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
