# Fitur Pengguna / Anggota BKPRMI

Dokumentasi fitur untuk role Pengguna/Anggota berdasarkan Use Case Diagram.

## Role Type
- `MEMBER` - Member/Pengguna
- `ANGGOTA` - Anggota

## Fitur yang Tersedia

### 1. Login
- **Route**: `/login` (GET, POST)
- **Controller**: `AuthController`
- **Deskripsi**: Halaman login untuk autentikasi pengguna/anggota
- **Middleware**: `guest`

### 2. Dashboard Member
- **Route**: `/member` (GET)
- **Controller**: `MemberDashboardController@index`
- **Deskripsi**: Dashboard utama untuk member dengan ringkasan informasi
- **Middleware**: `auth`
- **Fitur**:
  - Menampilkan kegiatan terbaru
  - Statistik unit dan kegiatan
  - Quick access ke fitur lain

### 3. Lihat Informasi Organisasi
- **Route Prefix**: `/member/organization`
- **Controller**: `OrganizationController`
- **Middleware**: `auth`

#### Routes:
- `GET /member/organization` - Halaman utama informasi organisasi
  - Menampilkan daftar region dengan unit
  - Statistik organisasi (total unit, santri, guru)
  
- `GET /member/organization/structure` - Struktur organisasi
  - Menampilkan hierarki organisasi
  
- `GET /member/organization/unit/{unit}` - Detail unit
  - Menampilkan informasi lengkap tentang unit tertentu

### 4. Lihat Data Kegiatan
- **Route Prefix**: `/member/activities`
- **Controller**: `ActivityController` (Member)
- **Middleware**: `auth`

#### Routes:
- `GET /member/activities` - Daftar kegiatan
  - Filter: search, start_date, end_date, unit_id
  - Pagination: 15 items per page
  
- `GET /member/activities/{activity}` - Detail kegiatan
  - Menampilkan informasi lengkap kegiatan
  
- `GET /member/activities/{activity}/logs` - Log kegiatan
  - Menampilkan catatan aktivitas kegiatan

### 5. Unduh Laporan
- **Route Prefix**: `/member/reports`
- **Controller**: `ReportController` (Member)
- **Middleware**: `auth`

#### Routes:
- `GET /member/reports` - Halaman laporan
  - Form untuk memilih jenis laporan dan filter
  
- `POST /member/reports/download/santri` - Download laporan santri
  - Parameters: `format` (pdf/excel), `unit_id` (optional)
  
- `POST /member/reports/download/activity` - Download laporan kegiatan
  - Parameters: `format`, `start_date`, `end_date`, `unit_id` (optional)
  
- `POST /member/reports/download/unit` - Download laporan unit
  - Parameters: `format`, `region_id` (optional)

### 6. Cerak Laporan (Print)
- **Route**: `GET /member/reports/print`
- **Controller**: `ReportController@print`
- **Middleware**: `auth`
- **Deskripsi**: Mencetak laporan (extends dari Unduh Laporan)
- **Parameters**: 
  - `type` (required): santri, activity, unit
  - Filter sesuai dengan tipe laporan
- **Output**: Halaman print-friendly yang dapat langsung dicetak

### 7. Logout
- **Route**: `POST /logout`
- **Controller**: `AuthController@logout`
- **Middleware**: `auth`

## Middleware

### CheckRole Middleware
- **File**: `app/Http/Middleware/CheckRole.php`
- **Alias**: `role`
- **Usage**: `->middleware('role:member,anggota')`
- **Deskripsi**: Memvalidasi apakah user memiliki role yang sesuai

## Controllers yang Dibuat

1. **MemberDashboardController**
   - Path: `app/Http/Controllers/Member/MemberDashboardController.php`
   - Method: `index()`

2. **OrganizationController**
   - Path: `app/Http/Controllers/Member/OrganizationController.php`
   - Methods: `index()`, `showUnit()`, `structure()`

3. **ActivityController** (Member)
   - Path: `app/Http/Controllers/Member/ActivityController.php`
   - Methods: `index()`, `show()`, `logs()`

4. **ReportController** (Member)
   - Path: `app/Http/Controllers/Member/ReportController.php`
   - Methods: `index()`, `downloadSantriReport()`, `downloadActivityReport()`, `downloadUnitReport()`, `print()`
   - Private methods untuk generate PDF

## Format Laporan

### PDF
- Menggunakan `barryvdh/laravel-dompdf`
- Template views di `resources/views/member/reports/pdf/`
- File output: `laporan-{type}-{date}.pdf`

### Excel (Future)
- Akan diimplementasikan menggunakan Laravel Excel
- Format: XLSX

## Views yang Perlu Dibuat

### Dashboard
- `resources/views/member/dashboard.blade.php`

### Organization
- `resources/views/member/organization/index.blade.php`
- `resources/views/member/organization/structure.blade.php`
- `resources/views/member/organization/unit-detail.blade.php`

### Activities
- `resources/views/member/activities/index.blade.php`
- `resources/views/member/activities/show.blade.php`
- `resources/views/member/activities/logs.blade.php`

### Reports
- `resources/views/member/reports/index.blade.php`
- `resources/views/member/reports/print.blade.php`
- `resources/views/member/reports/pdf/santri.blade.php`
- `resources/views/member/reports/pdf/activity.blade.php`
- `resources/views/member/reports/pdf/unit.blade.php`

## Penggunaan

### Menambahkan Role ke User
```php
use App\Models\User;
use App\Models\UserRole;
use App\Enum\RoleType;

$user = User::find($userId);
$user->roles()->create([
    'role' => RoleType::MEMBER,
    // atau
    'role' => RoleType::ANGGOTA,
]);
```

### Mengecek Role
```php
// Di controller
if (auth()->user()->hasRole(RoleType::MEMBER)) {
    // ...
}

// Di blade
@if(auth()->user()->hasRole(App\Enum\RoleType::MEMBER))
    <!-- Content for member -->
@endif
```

### Menggunakan Middleware di Route
```php
Route::middleware('role:member,anggota')->group(function () {
    // Routes hanya untuk member/anggota
});
```

## Dependencies

Pastikan package berikut terinstal:
```bash
composer require barryvdh/laravel-dompdf
```

## Testing

Contoh testing route member:
```php
public function test_member_can_access_dashboard()
{
    $user = User::factory()
        ->has(UserRole::factory()->state(['role' => RoleType::MEMBER]))
        ->create();
    
    $response = $this->actingAs($user)
        ->get(route('member.dashboard'));
    
    $response->assertStatus(200);
}
```

## Security

- Semua route member dilindungi dengan middleware `auth`
- Role checking menggunakan middleware `CheckRole`
- Download laporan hanya untuk data yang sesuai dengan hak akses user
- Validasi input pada setiap form

## Catatan

1. Fitur ini mengikuti struktur use case diagram yang diberikan
2. Implementasi menggunakan Laravel best practices
3. Siap untuk dikembangkan lebih lanjut (Excel export, notifikasi, dll)
4. Mendukung offline-first approach untuk PWA (dapat dikembangkan dengan Service Worker)
