<?php

namespace App\Enum;

enum WaktuKegiatan: string
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

    /**
     * Get comma-separated labels from an array of waktu_kegiatan values.
     */
    public static function getLabelsFromArray(?array $values): string
    {
        if (empty($values)) {
            return '-';
        }

        return collect($values)
            ->map(fn($v) => self::tryFrom($v)?->getLabel())
            ->filter()
            ->implode(', ');
    }
}
