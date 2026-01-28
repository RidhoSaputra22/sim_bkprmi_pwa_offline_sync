<?php

namespace App\Enum;

enum PekerjaanWali: string
{
    case TIDAK_BEKERJA = 'tidak_bekerja';
    case BURUH_HARIAN = 'buruh_harian';
    case IRT = 'irt';
    case KARYAWAN_SWASTA = 'karyawan_swasta';
    case WIRASWASTA = 'wiraswasta';
    case ASN_PNS = 'asn_pns';
    case ASN_PPPK = 'asn_pppk';
    case TNI = 'tni';
    case POLRI = 'polri';
    case LAINNYA = 'lainnya';

    public function getLabel(): string
    {
        return match ($this) {
            self::TIDAK_BEKERJA => 'Belum/Tidak bekerja',
            self::BURUH_HARIAN => 'Buruh Harian Lepas',
            self::IRT => 'Mengurus Rumah Tangga',
            self::KARYAWAN_SWASTA => 'Karyawan Swasta',
            self::WIRASWASTA => 'Wiraswasta',
            self::ASN_PNS => 'ASN-Pegawai Negeri Sipil',
            self::ASN_PPPK => 'ASN-PPPK',
            self::TNI => 'Tentara Nasional Indonesia',
            self::POLRI => 'Polisi RI',
            self::LAINNYA => 'Lainnya',
        };
    }
}
