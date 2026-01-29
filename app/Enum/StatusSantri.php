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

    public function getShortLabel(): string
    {
        return match ($this) {
            self::AKTIF => 'AK',
            self::LULUS_WISUDA => 'LTA',
            self::LANJUT_TQA => 'LTQA',
            self::PINDAH => 'PNDH',
            self::BERHENTI => 'BRH',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::LULUS_WISUDA => 'primary',
            self::LANJUT_TQA => 'info',
            self::PINDAH => 'warning',
            self::BERHENTI => 'error',
        };
    }
}
