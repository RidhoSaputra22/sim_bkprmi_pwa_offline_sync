<?php

namespace App\Enum;

enum StatusSantri: string
{
    case AKTIF = 'aktif';
    case LULUS_WISUDA = 'lulus_wisuda';
    case LANJUT_TQA = 'lanjut_tqa';
    case PINDAH = 'pindah';
    case BERHENTI = 'berhenti';

    public function getLabel(): string
    {
        return match ($this) {
            self::AKTIF => 'Masih Aktif',
            self::LULUS_WISUDA => 'Lulus Wisuda TPA',
            self::LANJUT_TQA => 'Lanjut TQA',
            self::PINDAH => 'Keluar >> Pindah Lokasi Belajar',
            self::BERHENTI => 'Keluar >> Berhenti',
        };
    }
}
