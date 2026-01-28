<?php

namespace App\Enum;

enum JenjangSantri: string
{
    case TKA = 'tka';
    case TPA = 'tpa';
    case TQA = 'tqa';

    public function getLabel(): string
    {
        return match ($this) {
            self::TKA => 'TKA',
            self::TPA => 'TPA',
            self::TQA => 'TQA',
        };
    }
}
