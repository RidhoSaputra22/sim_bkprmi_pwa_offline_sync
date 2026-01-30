# Dokumentasi Fitur Manajemen Guru Mengaji

## Overview
Fitur manajemen guru mengaji adalah sistem untuk mengelola data guru dan tenaga pendidik di unit TPA/TPQ yang terintegrasi dengan sistem BKPRMI.

## Struktur Database

### Tabel: `teachers`
Menyimpan data lengkap guru/tenaga pendidik di unit TPA.

**Kolom Utama:**
- `id`: Primary key
- `unit_id`: Foreign key ke tabel units
- `nik`: NIK (16 digit, unique)
- `full_name`: Nama lengkap
- `birth_place`: Tempat lahir
- `birth_date`: Tanggal lahir
- `gender`: Enum (laki_laki, perempuan)
- `phone`: Nomor HP
- `photo_path`: Path foto 1/2 badan
- `education_level_id`: Foreign key ke education_levels
- `job_id`: Foreign key ke jobs
- `province_id`, `city_id`, `district_id`, `village_id`: Alamat
- `jalan`, `rt`, `rw`: Detail alamat
- `jabatan_utama`: Enum jabatan utama
- `tugas_tambahan`: JSON array tugas tambahan
- `level_lmd`: Enum level LMD
- `sertifikat_lmd_path`: Path sertifikat LMD (PDF)
- `level_pelatihan_guru`: Enum level pelatihan
- `sertifikat_pelatihan_path`: Path sertifikat pelatihan (PDF)
- `is_active`: Status aktif (boolean)
- `created_at`, `updated_at`, `deleted_at`: Timestamps

## Enum Classes

### JabatanGuru
Jabatan utama guru di TPA:
- `kepala_unit`: Kepala Unit
- `wakil_kepala_unit`: Wakil Kepala Unit
- `kepala_tata_usaha`: Kepala Tata Usaha
- `bendahara`: Bendahara
- `wali_kelas`: Wali Kelas
- `guru_iqra`: Guru (Kelas Iqra)
- `guru_tadarrus`: Guru (Kelas Tadarrus)
- `karyawan_tenaga_kependidikan`: Karyawan/Tenaga Kependidikan

### TugasTambahan
Tugas tambahan guru (bisa multiple):
- `admin_operator`: Admin (Operator) TPA
- `guru_iqra`: Guru (Kelas Iqra)
- `guru_tadarrus`: Guru (Kelas Tadarrus)

### LevelLMD
Level Latihan Mujahid Dakwah:
- `lmd_1`: LMD 1
- `lmd_2`: LMD 2
- `lmd_3`: LMD 3
- `belum_pernah`: Belum Pernah

### LevelPelatihanGuru
Level Pelatihan Guru Mengaji:
- `level_a`: Pelatihan Guru Mengaji Level A
- `level_b`: Pelatihan Guru Mengaji Level B
- `level_c`: Pelatihan Guru Mengaji Level C
- `belum_pernah`: Belum Pernah

## Model: Teacher

### Relationships
- `unit()`: BelongsTo - Unit tempat guru mengajar
- `educationLevel()`: BelongsTo - Tingkat pendidikan terakhir
- `job()`: BelongsTo - Pekerjaan utama
- `province()`, `city()`, `district()`, `village()`: BelongsTo - Data alamat

### Accessor Methods
- `getFullAddressAttribute()`: Menggabungkan seluruh komponen alamat
- `getAgeAttribute()`: Menghitung usia dari tanggal lahir
- `getTugasTambahanLabelsAttribute()`: Mendapatkan label tugas tambahan

### Helper Methods
- `hasLMDCertification()`: Cek apakah punya sertifikat LMD
- `hasTeachingCertification()`: Cek apakah punya sertifikat mengajar
- `isClassroomTeacher()`: Cek apakah guru kelas
- `isAdministrator()`: Cek apakah staf administrasi

### Scopes
- `active()`: Filter guru aktif
- `byUnit($unitId)`: Filter by unit ID
- `byJabatan(JabatanGuru $jabatan)`: Filter by jabatan
- `classroomTeachers()`: Hanya guru kelas
- `administrators()`: Hanya staf administrasi
- `withLMD()`: Yang punya sertifikat LMD
- `withTeachingCertification()`: Yang punya sertifikat mengajar

## Controller: TeacherController

### Methods

#### `index()`
Menampilkan daftar guru di unit admin TPA yang login.
- **Route:** `GET /tpa/guru`
- **Permission:** Admin TPA
- **View:** `tpa.teachers.index`

#### `create()`
Menampilkan form tambah guru baru.
- **Route:** `GET /tpa/guru/create`
- **Permission:** Admin TPA
- **View:** `tpa.teachers.create`

#### `store(Request $request)`
Menyimpan data guru baru.
- **Route:** `POST /tpa/guru`
- **Permission:** Admin TPA
- **Validation:**
  - NIK: required, 16 karakter, unique
  - Nama lengkap: required
  - Tempat/tanggal lahir: required
  - Jenis kelamin: required
  - Nomor HP: required
  - Foto: optional, max 1MB (jpg, jpeg, png)
  - Jabatan utama: required
  - Level LMD & Pelatihan: required
  - Sertifikat: optional, max 1MB (PDF)

#### `show(Teacher $teacher)`
Menampilkan detail guru.
- **Route:** `GET /tpa/guru/{teacher}`
- **Permission:** Admin TPA (owner)
- **View:** `tpa.teachers.show`

#### `edit(Teacher $teacher)`
Menampilkan form edit guru.
- **Route:** `GET /tpa/guru/{teacher}/edit`
- **Permission:** Admin TPA (owner)
- **View:** `tpa.teachers.edit`

#### `update(Request $request, Teacher $teacher)`
Update data guru.
- **Route:** `PUT /tpa/guru/{teacher}`
- **Permission:** Admin TPA (owner)
- **Validation:** Sama seperti store, tapi NIK unique kecuali untuk record sendiri

#### `destroy(Teacher $teacher)`
Soft delete guru.
- **Route:** `DELETE /tpa/guru/{teacher}`
- **Permission:** Admin TPA (owner)

#### AJAX Methods
- `getCities(Request $request)`: Get cities by province
- `getDistricts(Request $request)`: Get districts by city
- `getVillages(Request $request)`: Get villages by district

## Routes

```php
// Teacher/Guru Management
Route::get('/guru', [TeacherController::class, 'index'])->name('teachers.index');
Route::get('/guru/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::post('/guru', [TeacherController::class, 'store'])->name('teachers.store');
Route::resource('teachers', TeacherController::class)->except(['index', 'create', 'store']);

// AJAX routes for location cascading
Route::get('/api/cities', [TeacherController::class, 'getCities'])->name('api.cities');
Route::get('/api/districts', [TeacherController::class, 'getDistricts'])->name('api.districts');
Route::get('/api/villages', [TeacherController::class, 'getVillages'])->name('api.villages');
```

## Views

### `tpa.teachers.index`
Daftar guru dengan:
- Stats cards (total, aktif, bersertifikat LMD, bersertifikat mengajar)
- Tabel dengan foto, nama, NIK, jabatan, status, sertifikat
- Aksi: Detail, Edit, Hapus
- Pagination

### `tpa.teachers.create`
Form input guru dengan sections:
1. **IDENTITAS** - Data pribadi
2. **ALAMAT** - Alamat lengkap dengan cascading select
3. **JABATAN** - Tugas utama dan tambahan
4. **RIWAYAT PELATIHAN** - LMD dan Pelatihan Guru

**Fitur:**
- Upload foto (max 1MB)
- Cascading select untuk wilayah (Provinsi → Kab/Kota → Kecamatan → Kelurahan)
- Multiple checkbox untuk tugas tambahan
- Upload sertifikat PDF (max 1MB)

### `tpa.teachers.show`
Detail lengkap guru dengan:
- Foto profil
- Badge status dan sertifikasi
- Info identitas lengkap
- Alamat lengkap
- Jabatan dan tugas
- Link download sertifikat
- Tombol edit

### `tpa.teachers.edit`
Form edit dengan:
- Pre-filled data
- Preview foto dan sertifikat yang ada
- Option untuk tidak mengubah file
- Toggle status aktif
- Cascading select dengan data tersimpan

## File Storage

### Upload Locations
- **Photos:** `storage/app/public/teachers/photos/`
- **LMD Certificates:** `storage/app/public/teachers/certificates/lmd/`
- **Teaching Certificates:** `storage/app/public/teachers/certificates/teaching/`

### Storage Configuration
Pastikan symbolic link storage sudah dibuat:
```bash
php artisan storage:link
```

## Validasi & Security

### File Upload
- **Foto:** JPG, JPEG, PNG (max 1MB)
- **Sertifikat:** PDF (max 1MB)

### Access Control
- Hanya Admin TPA yang bisa akses
- Admin hanya bisa kelola guru di unit sendiri
- Validasi ownership di setiap method

### Data Integrity
- NIK unique
- Soft delete untuk menjaga history
- Foreign key constraints
- Cascade delete jika unit dihapus

## Contoh Penggunaan

### Menambah Guru Baru
```php
// Di controller
$teacher = Teacher::create([
    'unit_id' => $unit->id,
    'nik' => '3273010101900001',
    'full_name' => 'Ahmad Fauzi',
    'birth_place' => 'Bandung',
    'birth_date' => '1990-01-01',
    'gender' => Gender::LAKI_LAKI,
    'phone' => '081234567890',
    'jabatan_utama' => JabatanGuru::GURU_IQRA,
    'tugas_tambahan' => [TugasTambahan::WALI_KELAS->value],
    'level_lmd' => LevelLMD::LMD_2,
    'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_B,
    'is_active' => true,
]);
```

### Query Guru
```php
// Semua guru aktif di unit
$teachers = Teacher::active()
    ->byUnit($unitId)
    ->get();

// Guru dengan sertifikasi lengkap
$certifiedTeachers = Teacher::withLMD()
    ->withTeachingCertification()
    ->get();

// Hanya guru kelas
$classroomTeachers = Teacher::classroomTeachers()
    ->active()
    ->get();
```

### Relasi dari Unit
```php
// Dari model Unit
$unit = Unit::find(1);

// Semua guru
$allTeachers = $unit->teachers;

// Hanya guru aktif
$activeTeachers = $unit->activeTeachers;

// Count
$teacherCount = $unit->teachers()->count();
$certifiedCount = $unit->teachers()->withLMD()->count();
```

## Maintenance

### Backup Data
```bash
# Backup database
php artisan db:backup

# Backup storage files
tar -czf teachers_storage_backup.tar.gz storage/app/public/teachers/
```

### Migration
```bash
# Run migration
php artisan migrate --path=database/migrations/2026_01_30_100000_create_teachers_table.php

# Rollback
php artisan migrate:rollback --step=1
```

## Scalability

Sistem ini scalable dengan:
1. **Soft Deletes** - Menjaga history data
2. **JSON Storage** - Tugas tambahan bisa berkembang
3. **Indexes** - Optimasi query (unit_id, is_active, nik)
4. **Eager Loading** - Menghindari N+1 problem
5. **Pagination** - 20 items per page
6. **File Storage** - Terorganisir dengan path struktur

## Future Enhancements

Potensi pengembangan:
1. Export data guru ke Excel/PDF
2. Bulk import dari CSV
3. Riwayat pelatihan multiple dengan tabel terpisah
4. Jadwal mengajar guru
5. Penilaian kinerja guru
6. Presensi guru
7. Penugasan kelas otomatis
8. Notifikasi sertifikat expired
9. Dashboard analitik guru
10. Integrasi dengan sistem penggajian
