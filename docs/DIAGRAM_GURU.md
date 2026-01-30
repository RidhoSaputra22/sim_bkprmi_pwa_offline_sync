# Diagram Arsitektur Fitur Guru Mengaji

## 📊 Database Relationship Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                          TEACHERS TABLE                              │
├─────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                              │
│ unit_id (FK) ──────────────┐                                        │
│ nik (UNIQUE)               │                                        │
│ full_name                  │                                        │
│ birth_place                │                                        │
│ birth_date                 │                                        │
│ gender (ENUM)              │                                        │
│ phone                      │                                        │
│ photo_path                 │                                        │
│ education_level_id (FK) ───┼────────────────────┐                   │
│ job_id (FK) ───────────────┼────────────┐       │                   │
│ province_id (FK) ──────────┼────┐       │       │                   │
│ city_id (FK) ──────────────┼────┼───┐   │       │                   │
│ district_id (FK) ──────────┼────┼───┼───┐       │                   │
│ village_id (FK) ───────────┼────┼───┼───┼───┐   │                   │
│ jalan, rt, rw              │    │   │   │   │   │                   │
│ jabatan_utama (ENUM)       │    │   │   │   │   │                   │
│ tugas_tambahan (JSON)      │    │   │   │   │   │                   │
│ level_lmd (ENUM)           │    │   │   │   │   │                   │
│ sertifikat_lmd_path        │    │   │   │   │   │                   │
│ level_pelatihan_guru (ENUM)│    │   │   │   │   │                   │
│ sertifikat_pelatihan_path  │    │   │   │   │   │                   │
│ is_active                  │    │   │   │   │   │                   │
│ created_at, updated_at     │    │   │   │   │   │                   │
│ deleted_at (SOFT DELETE)   │    │   │   │   │   │                   │
└────────────────────────────┼────┼───┼───┼───┼───┼───────────────────┘
                             │    │   │   │   │   │
                    ┌────────┘    │   │   │   │   │
                    ▼             ▼   ▼   ▼   ▼   ▼
            ┌─────────────┐ ┌─────────────────────────────┐
            │   UNITS     │ │    LOCATION TABLES          │
            ├─────────────┤ ├─────────────────────────────┤
            │ id (PK)     │ │ - provinces                 │
            │ name        │ │ - cities                    │
            │ ...         │ │ - districts                 │
            └─────────────┘ │ - villages                  │
                            └─────────────────────────────┘
                                         │
                        ┌────────────────┴────────────────┐
                        ▼                                 ▼
            ┌──────────────────┐              ┌──────────────────┐
            │ EDUCATION_LEVELS │              │      JOBS        │
            ├──────────────────┤              ├──────────────────┤
            │ id (PK)          │              │ id (PK)          │
            │ name             │              │ name             │
            └──────────────────┘              └──────────────────┘
```

## 🔄 MVC Flow Diagram

```
┌───────────────────────────────────────────────────────────────────────┐
│                           USER REQUEST                                │
└───────────────────────────────┬───────────────────────────────────────┘
                                │
                                ▼
                    ┌───────────────────────┐
                    │   ROUTES (web.php)    │
                    │                       │
                    │  /tpa/guru/*          │
                    │  Middleware:          │
                    │  - auth               │
                    │  - CheckRole:admin_tpa│
                    └───────────┬───────────┘
                                │
                                ▼
                ┌───────────────────────────────────────┐
                │     TeacherController                 │
                ├───────────────────────────────────────┤
                │ index()    ─────► Get list + stats   │
                │ create()   ─────► Show form           │
                │ store()    ─────► Validate & Save     │
                │ show()     ─────► Get detail          │
                │ edit()     ─────► Show edit form      │
                │ update()   ─────► Validate & Update   │
                │ destroy()  ─────► Soft Delete         │
                │ getCities() ────► AJAX Response       │
                │ getDistricts() ─► AJAX Response       │
                │ getVillages() ──► AJAX Response       │
                └───────────┬───────────────────────────┘
                            │
          ┌─────────────────┼─────────────────┐
          ▼                 ▼                 ▼
    ┌─────────┐      ┌──────────┐     ┌───────────┐
    │  UNIT   │      │ TEACHER  │     │ LOCATION  │
    │  MODEL  │      │  MODEL   │     │  MODELS   │
    └────┬────┘      └────┬─────┘     └─────┬─────┘
         │                │                  │
         │     ┌──────────┴──────────┐      │
         │     │                     │      │
         ▼     ▼                     ▼      ▼
    ┌────────────────────────────────────────────┐
    │            DATABASE (MySQL)                │
    │  - units                                   │
    │  - teachers (with indexes)                 │
    │  - provinces, cities, districts, villages  │
    │  - education_levels, jobs                  │
    └────────────────┬───────────────────────────┘
                     │
                     ▼
         ┌───────────────────────┐
         │   BLADE VIEWS         │
         ├───────────────────────┤
         │ index.blade.php       │
         │ create.blade.php      │
         │ edit.blade.php        │
         │ show.blade.php        │
         └───────────┬───────────┘
                     │
                     ▼
         ┌───────────────────────┐
         │   USER INTERFACE      │
         └───────────────────────┘
```

## 🎯 CRUD Operations Flow

### CREATE Teacher
```
User → Click "Tambah Guru"
  ↓
TeacherController@create()
  ↓
Load: educationLevels, jobs, provinces, enums
  ↓
View: create.blade.php
  ↓
User fills form & uploads files
  ↓
Submit → TeacherController@store()
  ↓
Validate Input
  ├─ FAIL → Return with errors
  └─ SUCCESS → Continue
      ↓
Upload photo (if exists)
  → storage/teachers/photos/
      ↓
Upload sertifikat_lmd (if exists)
  → storage/teachers/certificates/lmd/
      ↓
Upload sertifikat_pelatihan (if exists)
  → storage/teachers/certificates/teaching/
      ↓
Save to teachers table
  ↓
Redirect to show page
  ↓
Display success message
```

### READ Teacher (Show Detail)
```
User → Click "Detail"
  ↓
TeacherController@show($teacher)
  ↓
Check ownership (teacher.unit_id == user's unit_id)
  ├─ FAIL → Redirect with error
  └─ SUCCESS → Continue
      ↓
Eager load relationships:
  - unit
  - educationLevel
  - job
  - province, city, district, village
      ↓
View: show.blade.php
  ↓
Display:
  - Photo/Avatar
  - Personal Info
  - Address
  - Jabatan
  - Certifications (with download links)
```

### UPDATE Teacher
```
User → Click "Edit"
  ↓
TeacherController@edit($teacher)
  ↓
Check ownership
  ├─ FAIL → Redirect with error
  └─ SUCCESS → Continue
      ↓
Load form data with current values
  ↓
View: edit.blade.php (pre-filled)
  ↓
User updates data & uploads new files (optional)
  ↓
Submit → TeacherController@update($teacher)
  ↓
Validate Input (NIK unique except self)
  ├─ FAIL → Return with errors
  └─ SUCCESS → Continue
      ↓
If new photo uploaded:
  - Delete old photo
  - Upload new photo
      ↓
If new certificates uploaded:
  - Delete old certificates
  - Upload new certificates
      ↓
Update teachers table
  ↓
Redirect to show page
  ↓
Display success message
```

### DELETE Teacher (Soft Delete)
```
User → Click "Hapus" → Confirm
  ↓
TeacherController@destroy($teacher)
  ↓
Check ownership
  ├─ FAIL → Redirect with error
  └─ SUCCESS → Continue
      ↓
Soft delete (set deleted_at timestamp)
  ↓
Files remain in storage (for recovery)
  ↓
Redirect to index page
  ↓
Display success message
```

## 🌐 Cascading Select Flow

```
Page Load
  ↓
Province Select: Enabled with data
City Select: Disabled
District Select: Disabled
Village Select: Disabled
  ↓
User selects Province
  ↓
JavaScript: onChange event
  ↓
AJAX → /tpa/api/cities?province_id={id}
  ↓
TeacherController@getCities()
  ↓
Query: City::where('province_id', $id)->get()
  ↓
Return JSON: [{id, name}, ...]
  ↓
JavaScript: Populate City select
City Select: Enabled with options
  ↓
User selects City
  ↓
AJAX → /tpa/api/districts?city_id={id}
  ↓
TeacherController@getDistricts()
  ↓
Query: District::where('city_id', $id)->get()
  ↓
Return JSON: [{id, name}, ...]
  ↓
JavaScript: Populate District select
District Select: Enabled with options
  ↓
User selects District
  ↓
AJAX → /tpa/api/villages?district_id={id}
  ↓
TeacherController@getVillages()
  ↓
Query: Village::where('district_id', $id)->get()
  ↓
Return JSON: [{id, name}, ...]
  ↓
JavaScript: Populate Village select
Village Select: Enabled with options
  ↓
User selects Village
  ↓
Complete address selected
```

## 📊 Data Structure

### Teacher Model Attributes
```php
[
    'id' => 1,
    'unit_id' => 5,
    'nik' => '3273010101900001',
    'full_name' => 'Ahmad Fauzi',
    'birth_place' => 'Bandung',
    'birth_date' => '1990-01-01',
    'gender' => Gender::LAKI_LAKI,
    'phone' => '081234567890',
    'photo_path' => 'teachers/photos/abc123.jpg',
    'education_level_id' => 5,
    'job_id' => 3,
    'province_id' => 12,
    'city_id' => 78,
    'district_id' => 456,
    'village_id' => 7890,
    'jalan' => 'Jl. Merdeka No. 123',
    'rt' => '001',
    'rw' => '005',
    'jabatan_utama' => JabatanGuru::GURU_IQRA,
    'tugas_tambahan' => [
        'admin_operator',
        'wali_kelas'
    ],
    'level_lmd' => LevelLMD::LMD_2,
    'sertifikat_lmd_path' => 'teachers/certificates/lmd/def456.pdf',
    'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_B,
    'sertifikat_pelatihan_path' => 'teachers/certificates/teaching/ghi789.pdf',
    'is_active' => true,
    'created_at' => '2026-01-30 10:00:00',
    'updated_at' => '2026-01-30 10:00:00',
    'deleted_at' => null
]
```

### Enum Values
```php
// JabatanGuru
[
    'kepala_unit',
    'wakil_kepala_unit',
    'kepala_tata_usaha',
    'bendahara',
    'wali_kelas',
    'guru_iqra',
    'guru_tadarrus',
    'karyawan_tenaga_kependidikan'
]

// TugasTambahan
[
    'admin_operator',
    'guru_iqra',
    'guru_tadarrus'
]

// LevelLMD
[
    'lmd_1',
    'lmd_2',
    'lmd_3',
    'belum_pernah'
]

// LevelPelatihanGuru
[
    'level_a',
    'level_b',
    'level_c',
    'belum_pernah'
]
```

## 🔐 Security Layers

```
┌─────────────────────────────────────┐
│       Authentication Layer          │
│  Middleware: auth                   │
│  Check: User logged in?             │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│       Authorization Layer           │
│  Middleware: CheckRole:admin_tpa    │
│  Check: User is Admin TPA?          │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│       Ownership Validation          │
│  Check: teacher.unit_id ==          │
│         user's unit_id?             │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│       Input Validation              │
│  - Required fields                  │
│  - Data types                       │
│  - Enum values                      │
│  - Unique constraints (NIK)         │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│       File Validation               │
│  - File type (image/pdf)            │
│  - File size (max 1MB)              │
│  - MIME type check                  │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│       Database Constraints          │
│  - Foreign keys                     │
│  - Unique index (NIK)               │
│  - NOT NULL constraints             │
│  - Cascade delete                   │
└─────────────────────────────────────┘
```

## 📈 Performance Optimization

```
┌─────────────────────────────────────┐
│         Database Level              │
├─────────────────────────────────────┤
│ • Indexes on:                       │
│   - (unit_id, is_active)            │
│   - nik                             │
│ • Foreign key indexes (auto)        │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│         Query Level                 │
├─────────────────────────────────────┤
│ • Eager loading relationships       │
│ • Scopes for common queries         │
│ • Pagination (20 per page)          │
│ • Select only needed columns        │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│         Application Level           │
├─────────────────────────────────────┤
│ • Cache static data (enum values)   │
│ • Optimize file storage paths       │
│ • Minimize N+1 queries              │
└───────────┬─────────────────────────┘
            │
            ▼
┌─────────────────────────────────────┐
│         Frontend Level              │
├─────────────────────────────────────┤
│ • Lazy load images                  │
│ • AJAX for cascading selects        │
│ • Client-side validation            │
│ • Responsive lazy rendering         │
└─────────────────────────────────────┘
```

---

**Visual diagrams ini membantu memahami:**
- 🗄️ Struktur database dan relasi
- 🔄 Flow data dari request hingga response
- 🎯 CRUD operations detail
- 🌐 Cascading select mechanism
- 🔐 Multi-layer security
- 📈 Performance optimization strategy
