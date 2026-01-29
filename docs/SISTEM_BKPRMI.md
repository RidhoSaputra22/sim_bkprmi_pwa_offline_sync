# Struktur Sistem Informasi BKPRMI

## Ringkasan Peran (Roles)

### 1. SuperAdmin BKPRMI
- **Akses:** Dashboard pemantauan keseluruhan data
- **Fungsi Utama:**
  - Melihat dashboard dengan statistik keseluruhan
  - Approve/Reject TPA yang diinput oleh Admin LPPTKA
  - Melihat semua data santri dan unit
  - Export dan cetak laporan
- **Login:** `superadmin@bkprmi.com` / `superadmin`

### 2. Admin LPPTKA
- **Akses:** Manajemen profil TPA dan pembuatan akun TPA
- **Fungsi Utama:**
  - Input profil TPA baru
  - Upload sertifikat unit (syarat wajib untuk approval)
  - Membuat akun Admin TPA (hanya setelah unit diapprove SuperAdmin)
  - Melihat status approval unit
- **Login:** `admin.lpptka@bkprmi.com` / `adminlpptka`

### 3. Admin TPA
- **Akses:** Input data santri dan data TPA milik sendiri
- **Fungsi Utama:**
  - Input data santri baru
  - Edit data santri
  - Update data TPA (hanya unit sendiri)
  - Melihat laporan unit sendiri
- **Batasan Lokasi:** Hanya Provinsi Sulawesi Selatan, Kota Makassar
- **Login:** Dibuat oleh Admin LPPTKA setelah unit diapprove

---

## Alur Kerja Sistem

### A. Alur Pendaftaran Unit TPA Baru

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│  Admin LPPTKA   │────▶│   SuperAdmin    │────▶│  Admin LPPTKA   │
│  Input Profil   │     │   Approval      │     │  Buat Akun TPA  │
│  + Sertifikat   │     │                 │     │                 │
└─────────────────┘     └─────────────────┘     └─────────────────┘
```

1. **Admin LPPTKA** input profil TPA:
   - Data unit (nama, lokasi, dll)
   - Data kepala unit
   - Upload sertifikat unit

2. **SuperAdmin** menerima notifikasi & review:
   - Melihat profil TPA lengkap
   - Memeriksa sertifikat
   - **Approve** atau **Reject** dengan alasan

3. **Jika Diapprove:**
   - Admin LPPTKA dapat membuat akun Admin TPA
   - Unit status berubah ke "Approved"
   
4. **Jika Ditolak:**
   - Admin LPPTKA menerima notifikasi dengan alasan
   - Admin LPPTKA dapat memperbaiki dan submit ulang

### B. Alur Input Data Santri (Admin TPA)

```
┌─────────────────┐     ┌─────────────────┐
│    Admin TPA    │────▶│   Data Santri   │
│  Input Santri   │     │   Tersimpan     │
│  (Makassar)     │     │                 │
└─────────────────┘     └─────────────────┘
```

1. Admin TPA login ke sistem
2. Pilih menu "Input Data Santri"
3. Lokasi otomatis di-filter:
   - Provinsi: Sulawesi Selatan (locked)
   - Kota: Makassar (locked)
   - Kecamatan: Pilih dari daftar kecamatan di Makassar
   - Kelurahan: Otomatis filter berdasarkan kecamatan
4. Input data santri sesuai form
5. Data tersimpan dan terkait dengan unit TPA

---

## Struktur Database

### Tabel Units (Perubahan)

| Field | Tipe | Keterangan |
|-------|------|------------|
| approval_status | enum | pending, approved, rejected |
| approved_at | timestamp | Tanggal approval |
| approved_by | foreignId | User SuperAdmin yang approve |
| approval_notes | text | Catatan approval/rejection |
| certificate_path | string | Path file sertifikat |
| certificate_uploaded_at | timestamp | Tanggal upload sertifikat |
| admin_user_id | foreignId | User Admin TPA untuk unit ini |

### Enum StatusApprovalUnit

```php
enum StatusApprovalUnit: string
{
    case PENDING = 'pending';    // Menunggu Persetujuan
    case APPROVED = 'approved';  // Disetujui
    case REJECTED = 'rejected';  // Ditolak
}
```

### Enum RoleType (Updated)

```php
enum RoleType: string
{
    case SUPERADMIN = 'superadmin';     // SuperAdmin BKPRMI
    case ADMIN_LPPTKA = 'admin_lpptka'; // Admin LPPTKA
    case ADMIN_TPA = 'admin_tpa';       // Admin TPA
}
```

---

## Services

### LocationFilterService
Menangani filtering lokasi khusus untuk Admin TPA:
- `getProvinceSulsel()` - Get Provinsi Sulsel
- `getCityMakassar()` - Get Kota Makassar
- `getDistrictsInMakassar()` - Get semua kecamatan di Makassar
- `getVillagesByDistrict($id)` - Get kelurahan by kecamatan
- `validateAdminTpaLocation($villageId)` - Validasi lokasi untuk Admin TPA

### UnitApprovalService
Menangani alur approval unit:
- `uploadCertificate($unit, $path)` - Upload sertifikat
- `approveUnit($unit, $approver, $notes)` - Approve unit
- `rejectUnit($unit, $approver, $notes)` - Reject unit
- `createAdminTpaAccount(...)` - Buat akun Admin TPA
- `getPendingUnits()` - Get unit yang menunggu approval
- `getApprovalStats()` - Get statistik untuk dashboard

---

## Catatan Implementasi

### Filter Lokasi Admin TPA
Admin TPA hanya dapat menginput data dengan lokasi:
- **Provinsi:** Sulawesi Selatan (otomatis, tidak bisa diubah)
- **Kota:** Makassar (otomatis, tidak bisa diubah)
- **Kecamatan:** Pilih dari dropdown (hanya kecamatan di Makassar)
- **Kelurahan:** Otomatis filter berdasarkan kecamatan yang dipilih

### Syarat Approval Unit
1. Profil TPA lengkap (semua field wajib terisi)
2. Sertifikat unit sudah diupload
3. SuperAdmin melakukan review dan approval

### Pembuatan Akun Admin TPA
1. Unit harus sudah di-approve oleh SuperAdmin
2. Hanya Admin LPPTKA yang dapat membuat akun
3. Satu unit = satu akun Admin TPA
4. Password awal digenerate otomatis dan dikirim ke admin

---

## File yang Dimodifikasi/Ditambahkan

### Enum
- `app/Enum/RoleType.php` - Updated roles
- `app/Enum/StatusApprovalUnit.php` - **NEW**

### Models
- `app/Models/Unit.php` - Added approval system
- `app/Models/User.php` - Added role checks

### Services
- `app/Services/LocationFilterService.php` - **NEW**
- `app/Services/UnitApprovalService.php` - **NEW**

### Controllers

#### SuperAdmin
- `app/Http/Controllers/SuperAdmin/DashboardController.php` - **NEW**
- `app/Http/Controllers/SuperAdmin/UnitApprovalController.php` - **NEW**

#### Admin LPPTKA
- `app/Http/Controllers/Lpptka/DashboardController.php` - **NEW**
- `app/Http/Controllers/Lpptka/UnitController.php` - **NEW**
- `app/Http/Controllers/Lpptka/TpaAccountController.php` - **NEW**

#### Admin TPA
- `app/Http/Controllers/Tpa/DashboardController.php` - **NEW**
- `app/Http/Controllers/Tpa/SantriController.php` - **NEW**

#### API
- `app/Http/Controllers/Api/LocationController.php` - **NEW**

### Migrations
- `database/migrations/2026_01_30_000001_add_approval_system_to_units_table.php` - **NEW**

### Routes
- `routes/web.php` - Updated with new role routes
- `routes/api.php` - Added location API

### Middleware
- `app/Http/Middleware/CheckRole.php` - Updated for new roles

### Seeders
- `database/seeders/DatabaseSeeder.php` - Updated roles

---

## Routes Summary

### SuperAdmin BKPRMI (`/superadmin`)
| Route | Method | Description |
|-------|--------|-------------|
| `/superadmin` | GET | Dashboard |
| `/superadmin/units/approval` | GET | Daftar unit pending approval |
| `/superadmin/units/approval/{unit}` | GET | Detail unit untuk review |
| `/superadmin/units/approval/{unit}/approve` | POST | Approve unit |
| `/superadmin/units/approval/{unit}/reject` | POST | Reject unit |
| `/superadmin/units/approval/{unit}/certificate` | GET | Lihat sertifikat |

### Admin LPPTKA (`/lpptka`)
| Route | Method | Description |
|-------|--------|-------------|
| `/lpptka` | GET | Dashboard |
| `/lpptka/units` | GET | Daftar semua unit |
| `/lpptka/units/create` | GET | Form tambah unit |
| `/lpptka/units` | POST | Simpan unit baru |
| `/lpptka/units/{unit}` | GET | Detail unit |
| `/lpptka/units/{unit}/edit` | GET | Form edit unit |
| `/lpptka/units/{unit}/certificate` | POST | Upload sertifikat |
| `/lpptka/units/{unit}/resubmit` | POST | Ajukan ulang unit ditolak |
| `/lpptka/tpa-accounts` | GET | Daftar akun TPA |
| `/lpptka/tpa-accounts/{unit}/create` | GET | Form buat akun TPA |
| `/lpptka/tpa-accounts/{unit}` | POST | Simpan akun TPA |

### Admin TPA (`/tpa`)
| Route | Method | Description |
|-------|--------|-------------|
| `/tpa` | GET | Dashboard |
| `/tpa/santri` | GET | Daftar santri unit |
| `/tpa/santri/create` | GET | Form tambah santri |
| `/tpa/santri` | POST | Simpan santri baru |
| `/tpa/santri/{santri}` | GET | Detail santri |
| `/tpa/santri/{santri}/edit` | GET | Form edit santri |
| `/tpa/unit` | GET | Lihat profil unit |

### API Lokasi (`/api/location`)
| Route | Method | Description |
|-------|--------|-------------|
| `/api/location/makassar-info` | GET | Info Sulsel & Makassar |
| `/api/location/districts-makassar` | GET | Daftar kecamatan Makassar |
| `/api/location/villages?district_id={id}` | GET | Kelurahan per kecamatan |
