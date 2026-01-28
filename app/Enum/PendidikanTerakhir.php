<?php

namespace App\Enum;

enum PendidikanTerakhir: string
{
    case SD = 'sd';
    case SMP = 'smp';
    case SMA = 'sma';
    case D1_D3 = 'd1_d3';
    case D4_S1 = 'd4_s1';
    case S2 = 's2';
    case S3 = 's3';

    public function getLabel(): string
    {
        return match ($this) {
            self::SD => 'SD',
            self::SMP => 'SMP/Sederajat',
            self::SMA => 'SMA/Sederajat',
            self::D1_D3 => 'DI-DIII',
            self::D4_S1 => 'DIV/S1',
            self::S2 => 'S2',
            self::S3 => 'S3',
        };
    }
}
