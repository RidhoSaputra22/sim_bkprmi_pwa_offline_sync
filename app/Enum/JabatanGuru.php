<?php

namespace App\Enum;

enum JabatanGuru: string
{
    case KEPALA_UNIT = 'kepala_unit';
    case WAKIL_KEPALA_UNIT = 'wakil_kepala_unit';
    case KEPALA_TATA_USAHA = 'kepala_tata_usaha';
    case BENDAHARA = 'bendahara';
    case WALI_KELAS = 'wali_kelas';
    case GURU_IQRA = 'guru_iqra';
    case GURU_TADARRUS = 'guru_tadarrus';
    case KARYAWAN_TENAGA_KEPENDIDIKAN = 'karyawan_tenaga_kependidikan';

    public function label(): string
    {
        return match ($this) {
            self::KEPALA_UNIT => 'Kepala Unit',
            self::WAKIL_KEPALA_UNIT => 'Wakil Kepala Unit',
            self::KEPALA_TATA_USAHA => 'Kepala Tata Usaha',
            self::BENDAHARA => 'Bendahara',
            self::WALI_KELAS => 'Wali Kelas',
            self::GURU_IQRA => 'Guru (Kelas Iqra)',
            self::GURU_TADARRUS => 'Guru (Kelas Tadarrus)',
            self::KARYAWAN_TENAGA_KEPENDIDIKAN => 'Karyawan/Tenaga Kependidikan',
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
