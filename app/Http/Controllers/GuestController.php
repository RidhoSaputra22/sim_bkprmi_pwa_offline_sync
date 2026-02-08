<?php

namespace App\Http\Controllers;

class GuestController extends Controller
{
    //

    public function getBeritas()
    {
        $beritas = [
            [
                'id' => 1,
                'slug' => 'kawal-perwali-baca-tulis-al-quran-dprd-dan-bkprmi-makassar-dorong-ijazah-munaqasah-jadi-syarat-masuk-smp',
                'title' => 'Kawal Perwali Baca Tulis Al-Qur’an, DPRD dan BKPRMI Makassar Dorong Ijazah Munaqasah Jadi Syarat Masuk SMP',
                'content' => "<p><strong>MAKASSAR, 8 FEBRUARI 2026</strong> – Dewan Perwakilan Rakyat Daerah (DPRD) Kota Makassar bersama DPD Badan Komunikasi Pemuda Remaja Masjid Indonesia (BKPRMI) Kota Makassar memperkuat sinergi untuk mengawal implementasi Peraturan Daerah (Perda) Baca Tulis Al-Qur’an. Langkah strategis ini bertujuan untuk meningkatkan standar kualitas pendidikan religi serta menjamin kesejahteraan guru mengaji di Kota Makassar.</p><p>Bertempat di Aula MAN 3 Makassar, Minggu (08/02), Anggota DPRD Kota Makassar, Andi Hadi Ibrahim Baso, SS. MA, membuka secara resmi Pelatihan Guru Mengaji Level A. Dalam sambutannya, ia menegaskan komitmen legislatif dalam mendorong percepatan terbitnya Peraturan Walikota (Perwali).</p><p>“BKPRMI adalah pemegang sejarah lahirnya Perda ini. Kita harus kawal agar segera lahir Perwalinya, sehingga ijazah munaqasah dari TPA resmi dapat menjadi syarat masuk jenjang SMP. Ini bukan sekadar urusan administratif, tapi soal menjaga kualitas spiritual generasi kita,” tegas legislator yang akrab disapa Ustaz Hadi tersebut.</p><h3>Jaminan Hari Tua dan Kesejahteraan Guru</h3>
                <p>Dukungan penuh juga datang dari Pemerintah Kota Makassar. Kepala Bagian Kesejahteraan Rakyat (Kabag Kesra) Kota Makassar, Bapak Mohammad Syarief, menyampaikan bahwa pemerintah telah menyiapkan skema Jaminan Hari Tua (JHT) bagi sekitar 5.000 pekerja keagamaan pada tahun 2026.</p><p>“Pemerintah ingin memastikan para guru mengaji tidak lagi merasa berjuang sendirian. Sinergi ini adalah bentuk kehadiran pemerintah dalam memuliakan tugas mulia para pendidik Al-Qur'an,” ungkap Mohammad Syarief di hadapan ratusan peserta.</p><h3>Digitalisasi Data dan Transparansi Insentif</h3><p>Terkait tata kelola, Ustaz Hadi menyarankan penerapan Nomor Induk Guru agar penyaluran insentif dari APBD tepat sasaran. Ia juga membocorkan rencana peningkatan tunjangan pada tahun 2027 serta upaya perbaikan sistem perbankan untuk menghapus potongan administrasi yang selama ini memberatkan para guru.</p><p>Sekretaris Umum DPD BKPRMI Kota Makassar, Ichwan, S.Sos, menyatakan kesiapannya untuk merapikan database guru di bawah naungan BKPRMI agar sinkron dengan program jaminan sosial pemerintah. 'Dengan dukungan dari Bapak Wali Kota Makassar melalui Kabag Kesra dan pengawalan dari DPRD, kami optimis marwah guru mengaji di Makassar akan semakin terangkat,' tegas Ichwan.</p><h3>Pelatihan Standarisasi</h3><p>Kegiatan pelatihan ini diikuti oleh ratusan ustadz dan ustadzah, serta dihadiri jajaran pengurus LPPTKA BKPRMI Makassar, termasuk Direktur Daerah Yanuar, S.Pd.I., Gr, dan Sekretaris Daerah Darul Aksah, ST. Melalui pelatihan Level A ini, BKPRMI menargetkan standarisasi pengajaran Al-Qur’an di seluruh unit TPA di Makassar agar terjadi keseimbangan antara kualitas ilmu yang diberikan dengan kesejahteraan yang diterima.</p><p><strong>PELATIHAN GURU MENGAJI LEVEL A BKPRMI MAKASSAR</strong></p>",

                'subtitle' => 'Dewan Perwakilan Rakyat Daerah (DPRD) Kota Makassar bersama DPD Badan Komunikasi Pemuda Remaja Masjid Indonesia (BKPRMI) Kota Makassar memperkuat sinergi untuk mengawal implementasi Peraturan Daerah (Perda) Baca Tulis Al-Qur’an',
                'thumbnail' => 'berita/perwali-baca-tulis-quran.jpg',
                'date' => '8 Februari 2026',

            ],
            [
                'id' => 2,
                'slug' => 'pelatihan-guru-mengaji-level-a-bkprmi-makassar',
                'title' => 'Pelatihan Guru Mengaji Level A BKPRMI Makassar',
                'content' => "<p><strong>MAKASSAR, 8 FEBRUARI 2026</strong> – DPD Badan Komunikasi Pemuda Remaja Masjid Indonesia (BKPRMI) Kota Makassar menggelar Pelatihan Guru Mengaji Level A yang bertempat di Aula MAN 3 Makassar, Minggu (08/02). Kegiatan ini menjadi momentum krusial dalam memperkuat regulasi keagamaan serta standarisasi kualitas pengajar Al-Qur'an di Kota Makassar.</p><p>Hadir membuka acara secara resmi, Anggota DPRD Kota Makassar, Andi Hadi Ibrahim Baso, SS. MA, menegaskan komitmen legislatif untuk terus mengawal keberlanjutan Perda Baca Tulis Al-Qur’an hingga terbitnya Peraturan Walikota (Perwal).</p><p>'BKPRMI adalah pemegang sejarah lahirnya Perda ini. Kita harus terus kawal agar segera lahir Perwalnya, sehingga ijazah munaqasah dari TPA resmi bisa menjadi syarat masuk jenjang SMP. Ini soal menjaga kualitas generasi kita,' tegas legislator yang akrab disapa Ustaz Hadi tersebut.</p><h3>Materi Berbobot dari Tokoh Nasional dan Wilayah</h3><p>Pelatihan ini menghadirkan jajaran pemateri berkompeten untuk memastikan standarisasi pengajaran. Di antaranya adalah Wakil Sekretaris Nasional LPPTKA BKPRMI Pusat, Yusuf Sewang, S.Th.I; Direktur Wilayah LPPTKA BKPRMI Sulawesi Selatan, Hendra Muhammad Ismail, S.Pd.I; Sekretaris Wilayah LPPTKA BKPRMI Sulawesi Selatan, Suardi, S.Pd.I., M.Pd.I., Gr; serta Direktur Daerah LPPTKA BKPRMI Kota Makassar, Yanuar, S.Pd.I., Gr.</p><p>Ketua Panitia Pelaksana, Madina, S.Ag, melaporkan bahwa kegiatan ini diikuti oleh ratusan ustadz dan ustadzah yang antusias mengikuti setiap sesi materi demi meningkatkan mutu pendidikan Al-Qur'an di unit TPA masing-masing.</p><h3>Jaminan Hari Tua dan Kesejahteraan Guru</h3><p>Kepala Bagian Kesejahteraan Rakyat (Kabag Kesra) Kota Makassar, Bapak Mohammad Syarief, turut menyampaikan kabar gembira mengenai skema Jaminan Hari Tua (JHT) bagi sekitar 5.000 pekerja keagamaan pada tahun 2026. Sementara itu, Ustaz Hadi juga membocorkan rencana peningkatan tunjangan insentif pada tahun 2027 serta perbaikan sistem administrasi perbankan agar tidak memberatkan para guru.</p><p>Sekretaris Umum DPD BKPRMI Kota Makassar, Ichwan, S.Sos, menyatakan kesiapannya untuk merapikan database guru mengaji agar sinkron dengan program pemerintah. 'Dengan dukungan dari Pak Wali Kota melalui Kabag Kesra dan pengawalan Ustaz Hadi di DPRD, kami optimis marwah guru mengaji akan semakin terangkat,' ungkapnya.</p><p>Melalui Pelatihan Level A ini, BKPRMI menargetkan terciptanya standarisasi pengajaran yang mumpuni, sehingga terjadi keseimbangan antara kualitas ilmu yang diberikan dengan kesejahteraan yang diterima oleh para pendidik Al-Qur'an.</p>",

                'subtitle' => "Badan Komunikasi Pemuda Remaja Masjid Indonesia (BKPRMI) Kota Makassar menggelar Pelatihan Guru Mengaji Level A yang bertempat di Aula MAN 3 Makassar, Minggu (08/02). Kegiatan ini menjadi momentum krusial dalam memperkuat regulasi keagamaan serta standarisasi kualitas pengajar Al-Qur'an di Kota Makassar.",
                'thumbnail' => 'berita/pelatihan-guru-mengaji-level-a.jpg',
                'date' => '8 Februari 2026',

            ],
        ];

        return $beritas;
    }

    public function index()
    {
        $beritas = $this->getBeritas();

        return view('welcome', compact('beritas'));
    }

    public function berita($slug)
    {

        $beritas = $this->getBeritas();

        // dd($beritas);

        $berita = [];

        foreach ($beritas as $key => $value) {
            if ($value['slug'] == $slug) {
                $berita = $value;
                break;
            }
        }

        // dd($berita);

        return view('berita', compact('berita'));

    }
}
