PERANCANGAN SISTEM INFORMASI MANAJEMEN BKPRMI MAKASSAR BERBASIS PROGRESSIVE WEB APP UNTUK MENINGKATKAN EFISIENSI ADMINISTRASI ORGANISASI

Berikut adalah tree fitur (pohon fitur) yang diturunkan secara langsung dan konsisten dari latar belakang, pokok permasalahan, tujuan, serta batasan penelitian yang Anda sampaikan. Struktur ini disusun hierarkis agar mudah dijadikan dasar perancangan sistem, backlog agile, maupun diagram kebutuhan fungsional.


Tree Fitur
Sistem Informasi Manajemen BKPRMI Kota Makassar
Berbasis Progressive Web App (PWA)

1. Manajemen Pengguna & Hak Akses
Fitur inti untuk memastikan sistem terkontrol dan aman.
1.1 Autentikasi Pengguna
    • Login pengguna
    • Logout pengguna
    • Manajemen sesi pengguna
1.2 Manajemen Peran (Role Management)
    • Admin BKPRMI Kota
    • Pengurus LPPTKA
    • Operator / Petugas Administrasi
1.3 Hak Akses Berbasis Peran
    • Pembatasan akses fitur berdasarkan role
    • Kontrol CRUD (Create, Read, Update, Delete) per modul

2. Manajemen Data Santri
Menjawab kebutuhan pendataan santri yang sebelumnya manual.
2.1 Pendataan Santri
    • Input data santri baru
    • Edit data santri
    • Hapus data santri
    • Detail profil santri
2.2 Klasifikasi & Status Santri
    • Pengelompokan santri (TPA/TPQ)
    • Status aktif / tidak aktif
    • Riwayat data santri
2.3 Pencarian & Filter Data
    • Pencarian santri berdasarkan nama / lembaga
    • Filter berdasarkan status dan kategori

3. Manajemen Lembaga / Unit Pendidikan
Mendukung struktur LPPTKA di bawah BKPRMI.
3.1 Data Lembaga (TPA/TPQ)
    • Input data lembaga
    • Edit dan hapus data lembaga
    • Informasi alamat dan wilayah
3.2 Relasi Lembaga dan Santri
    • Penempatan santri ke lembaga
    • Rekap santri per lembaga

4. Manajemen Kegiatan Organisasi
Mendukung pencatatan dan pelaporan kegiatan BKPRMI.
4.1 Pengelolaan Data Kegiatan
    • Input kegiatan baru
    • Edit dan hapus kegiatan
    • Penjadwalan kegiatan
4.2 Dokumentasi Kegiatan
    • Unggah deskripsi kegiatan
    • Unggah foto atau dokumen pendukung
4.3 Monitoring Kegiatan
    • Daftar kegiatan berjalan
    • Riwayat kegiatan yang telah dilaksanakan

5. Manajemen Laporan Administrasi
Mengatasi masalah pelaporan manual dan tidak terintegrasi.
5.1 Laporan Data Santri
    • Rekap jumlah santri
    • Laporan per lembaga
5.2 Laporan Kegiatan
    • Laporan kegiatan periodik
    • Laporan kegiatan per lembaga
5.3 Ekspor & Cetak Laporan
    • Ekspor laporan ke PDF
    • Cetak laporan administrasi

6. Sistem Informasi Terpusat
Fitur pendukung integrasi dan koordinasi antar bagian.
6.1 Dashboard Administrasi
    • Ringkasan data santri
    • Ringkasan kegiatan
    • Statistik administratif
6.2 Notifikasi Sistem
    • Notifikasi pembaruan data
    • Notifikasi kegiatan baru
6.3 Manajemen Arsip Digital
    • Penyimpanan dokumen administrasi
    • Akses arsip terpusat

7. Fitur Progressive Web App (PWA)
Fitur khusus sesuai fokus penelitian.
7.1 Responsif Multi-Perangkat
    • Tampilan optimal di desktop, tablet, dan mobile
7.2 Offline Capability
    • Akses data terbatas tanpa koneksi internet
    • Sinkronisasi otomatis saat online
7.3 Installable App
    • Add to Home Screen
    • Tampilan seperti aplikasi native
7.4 Push Notification
    • Notifikasi kegiatan dan pembaruan sistem

8. Keamanan & Keandalan Sistem
Menjamin integritas dan keberlanjutan data.
8.1 Validasi Data
    • Validasi input data administrasi
    • Pencegahan data ganda
8.2 Backup Data
    • Backup database berkala
8.3 Logging Aktivitas
    • Pencatatan aktivitas pengguna
    • Audit trail administrasi

9. Dukungan Metode Agile (Non-Fungsional)
Fitur pendukung pengembangan bertahap.
9.1 Modular System
    • Struktur modul terpisah dan fleksibel
9.2 Kemudahan Pengembangan
    • Mudah ditambahkan fitur baru
    • Mudah dilakukan perbaikan iteratif



DATA SANTRI
IDENTITAS


NIK (Nomor Induk Kependudukan)
:

Nama Lengkap Santri
:

Tempat Lahir
:

Tanggal Lahir
:

Jenis Kelamin
:
Laki-laki


Perempuan
Anak Ke-
:

Jumlah Saudara
:




ALAMAT
Provinsi
:

Kab/Kota
:

Kecamatan
:

Kelurahan
:

Jalan
:

RT
:

RW
:




NAMA ORANG TUA
Nama Ayah Kandung
:

Nama Ibu Kandung
:




NAMA PENGAMPU / WALI SANTRI
NIK
:

Nama Lengkap
:

Tempat Lahir
:

Tanggal Lahir
:

Jenis Kelamin
:
Laki-laki


Perempuan
Hubungan Dengan Santri
:
Ayah Kandung


Ibu Kandung


Ayah Tiri


Ibu Tiri


Saudara Kandung


Paman


Bibi


Kakek


Nenek


Lainnya
Pendidikan Terakhir

SD


SMP/ Sederajat


SMA/Sederajat


DI-DIII


DIV/S1


S2


S3
Pekerjaan
:
Belum/Tidak bekerja


Buruh Harian Lepas


Mengurus Rumah Tangga


Karyawan Swasta


Wiraswasta


ASN-Pegawai Negeri Sipil


ASN-PPPK


Tentara Nasional Indonesia


Polisi RI


Lainnya
Nomor HP
:




STATUS SANTRI
Jenjang
:
TKA


TPA


TQA
Kelas Bacaan
:
Iqra (Jilid 1 s/d 3)


Iqra (Jilid 4 s/d 6)


Tadarrus (Juz 1 s/d 15)


Tadarrus (Juz 16 s/d 30)


Kelas Wisuda
Status
:
Masih Aktif


Lulus Wisuda TPA


Lanjut TQA


Keluar >> Pindah Lokasi Belajar


Keluar >> Berhenti

PROFIL UNIT

Identitas Unit
Nomor Unit
:

Nama TK/TP Al Qur’an


Lokasi Kegiatan
:
Masjid


Mushallah


Rumah Biasa


Bangunan Khusus TKA/TP Al-Qur’an


Gedung Sekolah
Status Gedung
:
Waqaf


Sewa


Milik Sendiri
Nama Masjid/Mushallah
:

Lembaga Pendiri/Penyelenggara
:

Mulai Terbentuk pada Tanggal
:

Bergabung Dengan LPPTKA Pada Tahun
:

Jam Kegiatan
:
Pagi


Siang


Sore


Malam
Email
:




Alamat
Provinsi
:

Kab/Kota
:

Kecamatan
:

Kelurahan
:

Jalan
:

RT
:

RW
:




Keadaan Santri
Jumlah TKA (Usia 4-7 Tahun)
:

Jumlah TPA (Usia 7-12 Tahun)
:

Jumlah TQA (Telah Wisuda)
:




Keadaan Guru Mengaji
Laki-laki
:

Perempuan
:





Penanggung Jawab Unit
Nama Kepala Unit
:

NIK
:

Tempat Lahir
:

Tanggal Lahir
:

Jenis Kelamin
:
Laki-laki


Perempuan
Pendidikan Terakhir
:
SD


SMP/ Sederajat


SMA/Sederajat


DI-DIII


DIV/S1


S2


S3
Pekerjaan

Belum/Tidak bekerja


Buruh Harian Lepas


Mengurus Rumah Tangga


Karyawan Swasta


Wiraswasta


ASN-Pegawai Negeri Sipil


ASN-PPPK


Tentara Nasional Indonesia


Polisi RI


Lainnya
Nomor HP
:




Nama Admin
:

Nomor HP
:

email



2. Skema Database (Laravel Migration Schema)
2.1 Users & Roles
roles
id
name                // admin_kota, pengurus_lpptka, operator
description
timestamps
users
id
name
email
password
is_active           // boolean
timestamps
role_user
id
user_id
role_id
timestamps

2.2 Unit / Lembaga (TPA/TPQ)
units
id
unit_number
name
location_type           // masjid, mushallah, rumah, sekolah, dll
building_status         // wakaf, sewa, milik_sendiri
mosque_name
founder
formed_at               // tanggal terbentuk
joined_year              // tahun bergabung LPPTKA
activity_time            // pagi, siang, sore, malam
email

province
city
district
village
street
rt
rw

tka_count
tpa_count
tqa_count

male_teacher_count
female_teacher_count

head_name
head_nik
head_birth_place
head_birth_date
head_gender
head_education
head_job
head_phone

admin_name
admin_phone
admin_email

timestamps

2.3 Santri
santris
id
nik
full_name
birth_place
birth_date
gender

child_order
siblings_count

province
city
district
village
street
rt
rw

father_name
mother_name

level                   // TKA, TPA, TQA
reading_class           // iqra_1_3, iqra_4_6, tadarrus_1_15, tadarrus_16_30
graduation_class        // boolean
status                  // aktif, lulus, lanjut_tqa, pindah, berhenti

timestamps

2.4 Wali / Pengampu Santri
guardians
id
nik
full_name
birth_place
birth_date
gender
relationship            // ayah, ibu, paman, dll
education
job
phone
timestamps
guardian_santri
id
guardian_id
santri_id
timestamps

2.5 Relasi Santri – Unit
santri_unit
id
santri_id
unit_id
joined_at
left_at
timestamps

2.6 Kegiatan
activities
id
title
description
activity_date
unit_id                 // nullable (kegiatan kota / unit)
created_by              // user_id
timestamps
activity_documents
id
activity_id
file_path
file_type
timestamps

2.7 Logging & Sistem
activity_logs
id
user_id
action                  // create, update, delete
module                  // santri, unit, kegiatan
description
ip_address
timestamps

Sistem Informasi BKPRMI
1.	Landing page BKPRMI
2.	SuperAdmin BKPRMI (Dashboard pemantauan Keseluruhan Data)

3.	LPPTKA (Admin LPPTKA) menginput :
	a.	Profil TPA & Akun TPA
	b.	Akun TPA bisa di buat oleh Admin LPPTKA saat Profil TPA sudah lengkap, 			SuperAdmin sudah approve (validasi) data TPA yang di input oleh Admin LPPTKA. 		(Harus Approve dulu baru bisa punya akun) *syarat approve, harus upload sertifikat 		unit ke superadmin

4.	Admin TPA menginput :
	a.	Data santri
	b.	Data TPA
	c.	Penginputan data TPA hanya di Provinsi Sulsel, Kota Makassar, Filter Kecamatan 		yang ada di Kota Makassar secara otomatis, Filter Kelurahan berdasarkan Kecamatan 		yang di pilih.
