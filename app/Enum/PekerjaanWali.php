<?php

namespace App\Enum;

enum PekerjaanWali: string
{
    case TIDAK_BEKERJA = 'tidak_bekerja';
    case MENGURUS_RUMAH_TANGGA = 'mengurus_rumah_tangga';
    case PELAJAR_MAHASISWA = 'pelajar_mahasiswa';
    case PENSIUNAN = 'pensiunan';

    // ASN / Aparat
    case PEGAWAI_NEGERI_SIPIL = 'pegawai_negeri_sipil';
    case ASN_PNS = 'asn_pns';
    case ASN_PPPK = 'asn_pppk';
    case TNI = 'tni';
    case POLRI = 'polri';

    // Sektor ekonomi
    case PERDAGANGAN = 'perdagangan';
    case PEDAGANG = 'pedagang';
    case PETANI_PEBEBUN = 'petani_pekebun';
    case PETERNAK = 'peternak';
    case NELAYAN_PERIKANAN = 'nelayan_perikanan';
    case INDUSTRI = 'industri';
    case KONSTRUKSI = 'konstruksi';
    case TRANSPORTASI = 'transportasi';

    // Pegawai / Buruh
    case KARYAWAN_SWASTA = 'karyawan_swasta';
    case KARYAWAN_BUMN = 'karyawan_bumn';
    case KARYAWAN_BUMD = 'karyawan_bumd';
    case KARYAWAN_HONORER = 'karyawan_honorer';

    case BURUH_HARIAN_LEPAS = 'buruh_harian_lepas';
    case BURUH_TANI_PERKEBUNAN = 'buruh_tani_perkebunan';
    case BURUH_NELAYAN_PERIKANAN = 'buruh_nelayan_perikanan';
    case BURUH_PETERNAKAN = 'buruh_peternakan';

    case PEMBANTU_RUMAH_TANGGA = 'pembantu_rumah_tangga';

    // Tukang / Keahlian
    case TUKANG_CUKUR = 'tukang_cukur';
    case TUKANG_LISTRIK = 'tukang_listrik';
    case TUKANG_BATU = 'tukang_batu';
    case TUKANG_KAYU = 'tukang_kayu';
    case TUKANG_SOL_SEPATU = 'tukang_sol_sepatu';
    case TUKANG_LAS_PANDAI_BESI = 'tukang_las_pandai_besi';
    case TUKANG_JAHIT = 'tukang_jahit';
    case PENATA_RAMBUT = 'penata_rambut';
    case PENATA_RIAS = 'penata_rias';
    case PENATA_BUSANA = 'penata_busana';
    case MEKANIK = 'mekanik';
    case TUKANG_GIGI = 'tukang_gigi';

    // Seni / Budaya / Kepercayaan
    case SENIMAN = 'seniman';
    case TABIB = 'tabib';
    case PARAJI = 'paraji';
    case PARANORMAL = 'paranormal';
    case PERANCANG_BUSANA = 'perancang_busana';

    // Bahasa / Media / Event
    case PENERJEMAH = 'penerjemah';
    case WARTAWAN = 'wartawan';
    case PENYIAR_TELEVISI = 'penyiar_televisi';
    case PENYIAR_RADIO = 'penyiar_radio';
    case PROMOTOR_ACARA = 'promotor_acara';

    // Keagamaan
    case IMAM_MASJID = 'imam_masjid';
    case USTADZ_MUBALIGH = 'ustadz_mubaligh';
    case PENDETA = 'pendeta';
    case PASTUR = 'pastur';
    case BIARAWATI = 'biarawati';

    // Pemerintahan / Politik
    case ANGGOTA_DPR_RI = 'anggota_dpr_ri';
    case ANGGOTA_DPD = 'anggota_dpd';
    case ANGGOTA_BPK = 'anggota_bpk';
    case PRESIDEN = 'presiden';
    case WAKIL_PRESIDEN = 'wakil_presiden';
    case ANGGOTA_MAHKAMAH_KONSTITUSI = 'anggota_mahkamah_konstitusi';
    case ANGGOTA_KABINET_KEMENTERIAN = 'anggota_kabinet_kementerian';
    case DUTA_BESAR = 'duta_besar';

    case GUBERNUR = 'gubernur';
    case WAKIL_GUBERNUR = 'wakil_gubernur';
    case BUPATI = 'bupati';
    case WAKIL_BUPATI = 'wakil_bupati';
    case WALIKOTA = 'walikota';
    case WAKIL_WALIKOTA = 'wakil_walikota';
    case ANGGOTA_DPRD_PROPINSI = 'anggota_dprd_propinsi';
    case ANGGOTA_DPRD_KABUPATEN_KOTA = 'anggota_dprd_kabupaten_kota';

    case PERANGKAT_DESA = 'perangkat_desa';
    case KEPALA_DESA = 'kepala_desa';
    case ANGGOTA_LEMBAGA_TINGGI = 'anggota_lembaga_tinggi';

    // Pendidikan / Profesi
    case DOSEN = 'dosen';
    case GURU = 'guru';
    case PILOT = 'pilot';
    case PENGACARA = 'pengacara';
    case NOTARIS = 'notaris';
    case ARSITEK = 'arsitek';
    case AKUNTAN = 'akuntan';
    case KONSULTAN = 'konsultan';

    // Kesehatan
    case DOKTER = 'dokter';
    case BIDAN = 'bidan';
    case PERAWAT = 'perawat';
    case APOTEKER = 'apoteker';
    case PSIKIATER_PSIKOLOG = 'psikiater_psikolog';

    // Transport / Laut
    case PELAUT = 'pelaut';
    case SOPIR = 'sopir';

    // Riset / Bisnis
    case PENELITI = 'peneliti';
    case PIALANG = 'pialang';
    case WIRASWASTA = 'wiraswasta';

    // Lain-lain pekerjaan
    case JURU_MASAK = 'juru_masak';
    case CHEF = 'chef';
    case MANAJER = 'manajer';
    case TENAGA_TATA_USAHA = 'tenaga_tata_usaha';
    case OPERATOR = 'operator';
    case PEKERJA_PENGOLAHAN_KERAJINAN = 'pekerja_pengolahan_kerajinan';
    case TEKNISI = 'teknisi';
    case ASISTEN_AHLI = 'asisten_ahli';

    // Hiburan / Olahraga
    case ARTIS = 'artis';
    case ATLIT = 'atlit';

    case LAINNYA = 'lainnya';

    public function getLabel(): string
    {
        return match ($this) {
            self::TIDAK_BEKERJA => 'Belum/Tidak Bekerja',
            self::MENGURUS_RUMAH_TANGGA => 'Mengurus Rumah Tangga',
            self::PELAJAR_MAHASISWA => 'Pelajar / Mahasiswa',
            self::PENSIUNAN => 'Pensiunan',

            self::PEGAWAI_NEGERI_SIPIL => 'Pegawai Negeri Sipil',
            self::ASN_PNS => 'ASN-Pegawai Negeri Sipil',
            self::ASN_PPPK => 'ASN-PPPK',
            self::TNI => 'Tentara Nasional Indonesia',
            self::POLRI => 'Kepolisian RI',

            self::PERDAGANGAN => 'Perdagangan',
            self::PEDAGANG => 'Pedagang',
            self::PETANI_PEBEBUN => 'Petani / Pekebun',
            self::PETERNAK => 'Peternak',
            self::NELAYAN_PERIKANAN => 'Nelayan / Perikanan',
            self::INDUSTRI => 'Industri',
            self::KONSTRUKSI => 'Konstruksi',
            self::TRANSPORTASI => 'Transportasi',

            self::KARYAWAN_SWASTA => 'Karyawan Swasta',
            self::KARYAWAN_BUMN => 'Karyawan BUMN',
            self::KARYAWAN_BUMD => 'Karyawan BUMD',
            self::KARYAWAN_HONORER => 'Karyawan Honorer',

            self::BURUH_HARIAN_LEPAS => 'Buruh Harian Lepas',
            self::BURUH_TANI_PERKEBUNAN => 'Buruh Tani / Perkebunan',
            self::BURUH_NELAYAN_PERIKANAN => 'Buruh Nelayan / Perikanan',
            self::BURUH_PETERNAKAN => 'Buruh Peternakan',

            self::PEMBANTU_RUMAH_TANGGA => 'Pembantu Rumah Tangga',

            self::TUKANG_CUKUR => 'Tukang Cukur',
            self::TUKANG_LISTRIK => 'Tukang Listrik',
            self::TUKANG_BATU => 'Tukang Batu',
            self::TUKANG_KAYU => 'Tukang Kayu',
            self::TUKANG_SOL_SEPATU => 'Tukang Sol Sepatu',
            self::TUKANG_LAS_PANDAI_BESI => 'Tukang Las / Pandai Besi',
            self::TUKANG_JAHIT => 'Tukang Jahit',
            self::PENATA_RAMBUT => 'Penata Rambut',
            self::PENATA_RIAS => 'Penata Rias',
            self::PENATA_BUSANA => 'Penata Busana',
            self::MEKANIK => 'Mekanik',
            self::TUKANG_GIGI => 'Tukang Gigi',

            self::SENIMAN => 'Seniman',
            self::TABIB => 'Tabib',
            self::PARAJI => 'Paraji',
            self::PARANORMAL => 'Paranormal',
            self::PERANCANG_BUSANA => 'Perancang Busana',

            self::PENERJEMAH => 'Penterjemah',
            self::WARTAWAN => 'Wartawan',
            self::PENYIAR_TELEVISI => 'Penyiar Televisi',
            self::PENYIAR_RADIO => 'Penyiar Radio',
            self::PROMOTOR_ACARA => 'Promotor Acara',

            self::IMAM_MASJID => 'Imam Masjid',
            self::USTADZ_MUBALIGH => 'Ustadz / Mubaligh',
            self::PENDETA => 'Pendeta',
            self::PASTUR => 'Pastur',
            self::BIARAWATI => 'Biarawati',

            self::ANGGOTA_DPR_RI => 'Anggota DPR-RI',
            self::ANGGOTA_DPD => 'Anggota DPD',
            self::ANGGOTA_BPK => 'Anggota BPK',
            self::PRESIDEN => 'Presiden',
            self::WAKIL_PRESIDEN => 'Wakil Presiden',
            self::ANGGOTA_MAHKAMAH_KONSTITUSI => 'Anggota Mahkamah Konstitusi',
            self::ANGGOTA_KABINET_KEMENTERIAN => 'Anggota Kabinet / Kementerian',
            self::DUTA_BESAR => 'Duta Besar',
            self::GUBERNUR => 'Gubernur',
            self::WAKIL_GUBERNUR => 'Wakil Gubernur',
            self::BUPATI => 'Bupati',
            self::WAKIL_BUPATI => 'Wakil Bupati',
            self::WALIKOTA => 'Walikota',
            self::WAKIL_WALIKOTA => 'Wakil Walikota',
            self::ANGGOTA_DPRD_PROPINSI => 'Anggota DPRD Propinsi',
            self::ANGGOTA_DPRD_KABUPATEN_KOTA => 'Anggota DPRD Kabupaten/Kota',
            self::PERANGKAT_DESA => 'Perangkat Desa',
            self::KEPALA_DESA => 'Kepala Desa',
            self::ANGGOTA_LEMBAGA_TINGGI => 'Anggota Lembaga Tinggi',

            self::DOSEN => 'Dosen',
            self::GURU => 'Guru',
            self::PILOT => 'Pilot',
            self::PENGACARA => 'Pengacara',
            self::NOTARIS => 'Notaris',
            self::ARSITEK => 'Arsitek',
            self::AKUNTAN => 'Akuntan',
            self::KONSULTAN => 'Konsultan',

            self::DOKTER => 'Dokter',
            self::BIDAN => 'Bidan',
            self::PERAWAT => 'Perawat',
            self::APOTEKER => 'Apoteker',
            self::PSIKIATER_PSIKOLOG => 'Psikiater / Psikolog',

            self::PELAUT => 'Pelaut',
            self::SOPIR => 'Sopir',

            self::PENELITI => 'Peneliti',
            self::PIALANG => 'Pialang',
            self::WIRASWASTA => 'Wiraswasta',

            self::JURU_MASAK => 'Juru Masak',
            self::CHEF => 'Cheff',
            self::MANAJER => 'Manajer',
            self::TENAGA_TATA_USAHA => 'Tenaga Tata Usaha',
            self::OPERATOR => 'Operator',
            self::PEKERJA_PENGOLAHAN_KERAJINAN => 'Pekerja Pengolahan, Kerajinan',
            self::TEKNISI => 'Teknisi',
            self::ASISTEN_AHLI => 'Asisten Ahli',

            self::ARTIS => 'Artis',
            self::ATLIT => 'Atlit',

            self::LAINNYA => 'Lainnya.',
        };
    }
}
