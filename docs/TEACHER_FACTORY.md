# Factory Documentation: TeacherFactory

## Overview
Factory untuk membuat data dummy Teacher dalam testing environment.

## Location
`database/factories/TeacherFactory.php`

## Default State
Factory akan generate teacher dengan:
- NIK: 16 digit random number
- Full Name: Random first + last name (sesuai gender)
- Birth Place: Random city
- Birth Date: Antara 20-60 tahun yang lalu
- Gender: Random (LAKI_LAKI atau PEREMPUAN)
- Phone: Format 08XXXXXXXXXX
- Education Level: Random dari database atau factory baru
- Pekerjaan: 1 random job dari PekerjaanWali enum
- Province: Random dari database (jika ada)
- Address: Random street address, RT, RW
- Jabatan Utama: Random dari JabatanGuru enum
- Tugas Tambahan: Array kosong
- Level LMD: Random level
- Level Pelatihan Guru: Random level
- Is Active: true

## State Methods

### 1. `inactive()`
Membuat teacher dengan status tidak aktif.

```php
Teacher::factory()->inactive()->create();
```

### 2. `withLMD(?LevelLMD $level = LevelLMD::LMD_1)`
Membuat teacher dengan sertifikat LMD pada level tertentu.

```php
Teacher::factory()->withLMD(LevelLMD::LMD_2)->create();
```

### 3. `withTeachingCertification(?LevelPelatihanGuru $level = LevelPelatihanGuru::LEVEL_A)`
Membuat teacher dengan sertifikat pelatihan mengajar pada level tertentu.

```php
Teacher::factory()->withTeachingCertification(LevelPelatihanGuru::LEVEL_B)->create();
```

### 4. `withPhoto()`
Membuat teacher dengan foto.

```php
Teacher::factory()->withPhoto()->create();
```

### 5. `classTeacher()`
Membuat teacher dengan jabatan Wali Kelas.

```php
Teacher::factory()->classTeacher()->create();
```

### 6. `headOfUnit()`
Membuat teacher dengan jabatan Kepala Unit.

```php
Teacher::factory()->headOfUnit()->create();
```

## Usage Examples

### Basic Usage
```php
// Create single teacher
$teacher = Teacher::factory()->create();

// Create multiple teachers
$teachers = Teacher::factory()->count(10)->create();

// Create teacher for specific unit
$teacher = Teacher::factory()->create([
    'unit_id' => $unit->id,
]);
```

### Combining States
```php
// Kepala Unit dengan LMD 3 dan sertifikat mengajar Level A
$headTeacher = Teacher::factory()
    ->headOfUnit()
    ->withLMD(LevelLMD::LMD_3)
    ->withTeachingCertification(LevelPelatihanGuru::LEVEL_A)
    ->withPhoto()
    ->create();

// Inactive teacher
$inactiveTeacher = Teacher::factory()
    ->inactive()
    ->create();
```

### Custom Attributes
```php
// Override specific attributes
$teacher = Teacher::factory()->create([
    'full_name' => 'Ahmad Fauzi',
    'nik' => '3273010101900001',
    'phone' => '081234567890',
    'pekerjaan' => [PekerjaanWali::ASN_PNS->value, PekerjaanWali::GURU->value],
    'tugas_tambahan' => ['admin_operator', 'guru_iqra'],
]);
```

### For Testing Scopes
```php
// Create active and inactive teachers
Teacher::factory()->count(5)->create(['unit_id' => $unit->id]);
Teacher::factory()->count(3)->inactive()->create(['unit_id' => $unit->id]);

// Test active scope
$activeTeachers = Teacher::active()->get();
$this->assertCount(5, $activeTeachers);
```

### For Testing Relationships
```php
$educationLevel = EducationLevel::factory()->create();
$province = Province::create(['name' => 'Sulawesi Selatan']);

$teacher = Teacher::factory()->create([
    'education_level_id' => $educationLevel->id,
    'province_id' => $province->id,
]);

// Test relationships
$this->assertInstanceOf(EducationLevel::class, $teacher->educationLevel);
$this->assertInstanceOf(Province::class, $teacher->province);
```

### For Testing Validation
```php
// Test NIK uniqueness
$existingTeacher = Teacher::factory()->create([
    'unit_id' => $unit->id,
    'nik' => '3273010101900001',
]);

$response = $this->post(route('tpa.teachers.store'), [
    'nik' => '3273010101900001', // Duplicate
    // ... other fields
]);

$response->assertSessionHasErrors('nik');
```

## Dependencies
Factory ini membutuhkan:
- `Unit` model (atau factory)
- `EducationLevel` model (atau factory)
- `Province` model (optional, from database)

## Notes
1. **NIK Generation**: Menggunakan 16 digit random number. Untuk test real data, override dengan NIK valid.
2. **Pekerjaan**: Default 1 pekerjaan, bisa override dengan multiple jobs.
3. **Tugas Tambahan**: Default kosong, bisa ditambahkan sesuai kebutuhan.
4. **Location Data**: Province mengambil dari database jika ada, tidak menggunakan factory (karena tidak ada ProvinceFactory).
5. **File Paths**: State methods `withLMD()`, `withTeachingCertification()`, dan `withPhoto()` hanya set path, tidak create actual file. Untuk testing upload, gunakan `UploadedFile::fake()`.

## Testing Tips

### Speed Optimization
```php
// Use make() instead of create() when you don't need database persistence
$teacher = Teacher::factory()->make();
```

### Seeding Data
```php
// In DatabaseSeeder.php
Teacher::factory()
    ->count(20)
    ->create();

// 5 kepala unit dengan sertifikat lengkap
Teacher::factory()
    ->headOfUnit()
    ->withLMD(LevelLMD::LMD_3)
    ->withTeachingCertification(LevelPelatihanGuru::LEVEL_A)
    ->count(5)
    ->create();
```

### Realistic Test Data
```php
$realTeacher = Teacher::factory()->create([
    'nik' => '7371012505850001',
    'full_name' => 'Ustadz Ahmad Hidayat, S.Pd.I',
    'birth_place' => 'Makassar',
    'birth_date' => '1985-05-25',
    'gender' => Gender::LAKI_LAKI->value,
    'phone' => '082347123456',
    'pekerjaan' => [PekerjaanWali::GURU->value],
    'jabatan_utama' => JabatanGuru::KEPALA_UNIT->value,
    'tugas_tambahan' => ['admin_operator'],
    'level_lmd' => LevelLMD::LMD_3->value,
    'level_pelatihan_guru' => LevelPelatihanGuru::LEVEL_A->value,
]);
```
