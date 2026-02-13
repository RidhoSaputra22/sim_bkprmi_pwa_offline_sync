# Fitur Manajemen Guru Mengaji - Quick Guide

## 🎯 Overview
Sistem manajemen data guru dan tenaga pendidik di unit TPA/TPQ BKPRMI dengan fitur:
- ✅ Data identitas lengkap (NIK, biodata, pendidikan, pekerjaan)
- ✅ Alamat dengan cascading select (Provinsi → Kab/Kota → Kecamatan → Kelurahan)
- ✅ Jabatan utama dan tugas tambahan
- ✅ Riwayat pelatihan LMD dan Pelatihan Guru Mengaji
- ✅ Upload foto dan sertifikat
- ✅ Status aktif/non-aktif
- ✅ Soft delete untuk history

## 📁 File Structure

```
app/
├── Enum/
│   ├── JabatanGuru.php          # 8 jabatan utama
│   ├── TugasTambahan.php        # 3 tugas tambahan
│   ├── LevelLMD.php             # 4 level LMD
│   └── LevelPelatihanGuru.php   # 4 level pelatihan
├── Models/
│   ├── Teacher.php              # Model guru dengan relasi & scopes
│   └── Unit.php                 # Updated dengan relasi teachers
├── Http/Controllers/
│   └── TeacherController.php    # CRUD + AJAX cascading
database/migrations/
└── 2026_01_30_100000_create_teachers_table.php
resources/views/tpa/teachers/
├── index.blade.php              # Daftar guru + stats
├── create.blade.php             # Form tambah guru
├── edit.blade.php               # Form edit guru
└── show.blade.php               # Detail guru
docs/
└── DOKUMENTASI_GURU.md          # Dokumentasi lengkap
```

## 🚀 Installation

### 1. Run Migration
```bash
php artisan migrate --path=database/migrations/2026_01_30_100000_create_teachers_table.php
```

### 2. Create Storage Link (if not exists)
```bash
php artisan storage:link
```

### 3. Set Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 🔗 Routes

| Method | URI | Action | Name |
|--------|-----|--------|------|
| GET | `/tpa/guru` | List teachers | `tpa.teachers.index` |
| GET | `/tpa/guru/create` | Create form | `tpa.teachers.create` |
| POST | `/tpa/guru` | Store teacher | `tpa.teachers.store` |
| GET | `/tpa/teachers/{teacher}` | Show details | `tpa.teachers.show` |
| GET | `/tpa/teachers/{teacher}/edit` | Edit form | `tpa.teachers.edit` |
| PUT | `/tpa/teachers/{teacher}` | Update teacher | `tpa.teachers.update` |
| DELETE | `/tpa/teachers/{teacher}` | Delete teacher | `tpa.teachers.destroy` |

**AJAX Routes:**
- `GET /tpa/api/cities?province_id={id}` - Get cities
- `GET /tpa/api/districts?city_id={id}` - Get districts  
- `GET /tpa/api/villages?district_id={id}` - Get villages

## 📝 Form Fields

### IDENTITAS
- NIK (16 digit, unique) *required
- Nama Lengkap *required
- Tempat Lahir *required
- Tanggal Lahir *required
- Jenis Kelamin (Laki-laki/Perempuan) *required
- Pendidikan Terakhir
- Pekerjaan Utama
- Nomor HP *required
- Foto ½ Badan (JPG/PNG, max 1MB)

### ALAMAT
- Provinsi (cascading)
- Kab/Kota (cascading)
- Kecamatan (cascading)
- Kelurahan (cascading)
- Jalan
- RT / RW

### JABATAN
- Tugas Utama *required (radio)
  - Kepala Unit
  - Wakil Kepala Unit
  - Kepala Tata Usaha
  - Bendahara
  - Wali Kelas
  - Guru (Kelas Iqra)
  - Guru (Kelas Tadarrus)
  - Karyawan/Tenaga Kependidikan
  
- Tugas Tambahan (checkbox, multiple)
  - Admin (Operator) TPA
  - Guru (Kelas Iqra)
  - Guru (Kelas Tadarrus)

### RIWAYAT PELATIHAN
- **LMD** *required
  - LMD 1 / LMD 2 / LMD 3 / Belum Pernah
  - Upload Sertifikat (PDF, max 1MB)

- **Pelatihan Guru Mengaji** *required
  - Level A / Level B / Level C / Belum Pernah
  - Upload Sertifikat (PDF, max 1MB)

## 🔍 Query Examples

### Basic Queries
```php
// Semua guru di unit
$teachers = Teacher::where('unit_id', $unitId)->get();

// Guru aktif saja
$activeTeachers = Teacher::active()->get();

// Guru dengan sertifikat LMD
$withLMD = Teacher::withLMD()->get();

// Guru kelas saja
$classroomTeachers = Teacher::classroomTeachers()->get();
```

### From Unit Model
```php
$unit = Unit::find(1);

// Semua guru
$unit->teachers;

// Guru aktif
$unit->activeTeachers;

// Count
$unit->teachers()->count();
$unit->teachers()->withLMD()->count();
```

### Complex Queries
```php
// Guru dengan pendidikan S1 ke atas
Teacher::whereHas('educationLevel', function($q) {
    $q->whereIn('name', ['DIV/S1', 'S2', 'S3']);
})->get();

// Guru yang sudah LMD 3 dan punya sertifikat mengajar
Teacher::where('level_lmd', LevelLMD::LMD_3)
    ->where('level_pelatihan_guru', '!=', LevelPelatihanGuru::BELUM_PERNAH)
    ->get();
```

## 🛡️ Security & Validation

### Access Control
- ✅ Only Admin TPA can manage teachers
- ✅ Admin can only manage teachers in their unit
- ✅ Ownership validation in every method

### File Upload Validation
```php
'photo' => 'required|image|mimes:jpg,jpeg,png|max:1024', // 1MB
'sertifikat_lmd' => 'required|file|mimes:pdf|max:1024',
'sertifikat_pelatihan' => 'required|file|mimes:pdf|max:1024',
```

### Data Validation
- NIK: 16 characters, unique
- Phone: max 15 characters
- All enum values validated against case values

## 📊 Database Schema

```sql
CREATE TABLE teachers (
    id BIGINT UNSIGNED PRIMARY KEY,
    unit_id BIGINT UNSIGNED,
    nik VARCHAR(16) UNIQUE,
    full_name VARCHAR(255),
    birth_place VARCHAR(255),
    birth_date DATE,
    gender ENUM('laki_laki', 'perempuan'),
    phone VARCHAR(15),
    photo_path VARCHAR(255),
    education_level_id BIGINT UNSIGNED,
    job_id BIGINT UNSIGNED,
    province_id, city_id, district_id, village_id BIGINT UNSIGNED,
    jalan VARCHAR(255),
    rt VARCHAR(5),
    rw VARCHAR(5),
    jabatan_utama ENUM(...),
    tugas_tambahan JSON,
    level_lmd ENUM(...),
    sertifikat_lmd_path VARCHAR(255),
    level_pelatihan_guru ENUM(...),
    sertifikat_pelatihan_path VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at, updated_at, deleted_at TIMESTAMP,
    INDEX(unit_id, is_active),
    INDEX(nik),
    FOREIGN KEY(unit_id) REFERENCES units(id) ON DELETE CASCADE
);
```

## 🎨 UI Features

### Index Page
- Stats cards: Total, Aktif, Bersertifikat LMD, Bersertifikat Mengajar
- Table with avatar, name, NIK, jabatan, status, certificates
- Actions: Detail, Edit, Delete (with confirmation)
- Pagination (20 per page)

### Create/Edit Form
- Multi-section card layout
- Cascading select for location (Province → City → District → Village)
- File preview for existing photos/certificates
- Radio for gender and jabatan utama
- Checkbox for tugas tambahan (multiple)
- Responsive grid layout

### Show Page
- 3-column layout (photo + info cards)
- Photo/avatar with status badges
- Certificate download links
- Full address display
- Tugas tambahan as badges
- Edit button

## 🔧 Troubleshooting

### Storage link not working?
```bash
php artisan storage:link
```

### Migration failed?
```bash
# Check existing tables
php artisan migrate:status

# Rollback and retry
php artisan migrate:rollback --step=1
php artisan migrate
```

### Cascading select not loading?
- Check AJAX routes are registered
- Verify location data exists in database
- Check browser console for errors

### File upload failed?
- Check storage permissions: `chmod -R 775 storage`
- Verify max upload size in php.ini
- Check disk space

## 📚 Documentation

Untuk dokumentasi lengkap, lihat: [docs/DOKUMENTASI_GURU.md](docs/DOKUMENTASI_GURU.md)

## ✨ Features Highlight

1. **Scalable Design** - JSON untuk tugas tambahan, soft deletes, indexed
2. **Security** - Ownership validation, file validation, enum validation
3. **User Friendly** - Cascading selects, file previews, responsive UI
4. **Complete CRUD** - Create, Read, Update, Delete with validation
5. **Relationship Ready** - Connected to Unit, Education, Job, Location
6. **Query Optimized** - Scopes, indexes, eager loading support

---

**🎓 Developed for BKPRMI Information System**  
**📅 January 2026**
