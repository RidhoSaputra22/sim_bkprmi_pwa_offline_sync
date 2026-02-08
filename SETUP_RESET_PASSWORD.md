# Setup Reset Password via Email - BKPRMI KOTA MAKASSAR

## 📋 Fitur yang Ditambahkan

Fitur reset password menggunakan email telah berhasil ditambahkan untuk **semua role** (SuperAdmin, Admin LPPTKA, Admin TPA, dan Member).

## 🎯 Komponen yang Dibuat

### 1. **Database Migration**
- `database/migrations/2026_01_31_000001_create_password_reset_tokens_table.php`
- Tabel untuk menyimpan token reset password

### 2. **Controllers**
- `app/Http/Controllers/Auth/ForgotPasswordController.php` - Handle forgot password
- `app/Http/Controllers/Auth/ResetPasswordController.php` - Handle reset password

### 3. **Views**
- `resources/views/auth/forgot-password.blade.php` - Form request reset password
- `resources/views/auth/reset-password.blade.php` - Form reset password baru
- `resources/views/emails/reset-password.blade.php` - Email template

### 4. **Mail Class**
- `app/Mail/ResetPasswordMail.php` - Mailable class untuk email

### 5. **Routes**
Routes yang ditambahkan di `routes/web.php`:
```php
Route::get('/password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
```

## 🚀 Setup & Instalasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Konfigurasi Email (.env)

**Untuk Development (menggunakan Mailtrap/MailHog):**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simbkprmi.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Untuk Production (menggunakan Gmail):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@simbkprmi.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Catatan Gmail:** 
- Gunakan App Password, bukan password akun biasa
- Enable 2-factor authentication terlebih dahulu
- Generate App Password di: https://myaccount.google.com/apppasswords

**Untuk Testing (log ke file):**
```env
MAIL_MAILER=log
```

### 3. Test Email Configuration
```bash
php artisan tinker

# Test kirim email
Mail::raw('Test email', function($message) {
    $message->to('test@example.com')->subject('Test');
});
```

## 💡 Cara Penggunaan

### Untuk User:

1. **Lupa Password:**
   - Klik link "Lupa password?" di halaman login
   - Masukkan email terdaftar
   - Klik tombol "Kirim Link Reset Password"
   - Cek email (dan folder spam jika tidak ada di inbox)

2. **Reset Password:**
   - Buka email yang diterima
   - Klik tombol "Reset Password" atau gunakan link alternatif
   - Masukkan password baru (minimal 8 karakter)
   - Konfirmasi password baru
   - Klik "Reset Password"
   - Login dengan password baru

### Fitur Keamanan:

✅ Token berlaku 60 menit  
✅ Token di-hash di database  
✅ Validasi email terdaftar  
✅ Password minimal 8 karakter  
✅ Konfirmasi password  
✅ Token dihapus setelah berhasil reset  
✅ Notifikasi jika email tidak terdaftar  
✅ Rate limiting untuk mencegah spam  

## 📧 Email Template

Email yang dikirim memiliki fitur:
- Design responsif dan profesional
- Gradient button dengan hover effect
- Link alternatif jika button tidak berfungsi
- Informasi waktu expired
- Warning box untuk keamanan
- Footer dengan informasi organisasi

## 🔒 Security Features

1. **Token Expiration:** Token otomatis expired setelah 60 menit
2. **Hashed Token:** Token disimpan dalam bentuk hash di database
3. **Email Verification:** Hanya email terdaftar yang bisa request reset
4. **Rate Limiting:** Mencegah spam request reset password
5. **One-time Use:** Token langsung dihapus setelah digunakan

## 🧪 Testing

### Test Flow:
1. Pastikan ada user dengan email valid di database
2. Klik "Lupa password?" di halaman login
3. Masukkan email user
4. Check log email (jika menggunakan MAIL_MAILER=log):
   ```bash
   tail -f storage/logs/laravel.log
   ```
5. Copy link dari log
6. Buka link di browser
7. Masukkan password baru
8. Login dengan password baru

### Test dengan Artisan Tinker:
```php
php artisan tinker

// Test ForgotPasswordController
$user = App\Models\User::first();
$token = Str::random(64);

DB::table('password_reset_tokens')->insert([
    'email' => $user->email,
    'token' => Hash::make($token),
    'created_at' => now()
]);

// Test kirim email
Mail::to($user->email)->send(new App\Mail\ResetPasswordMail($token, $user));
```

## 🎨 UI/UX

- Consistent design dengan halaman login
- PWA support
- Responsive mobile-friendly
- Loading states
- Clear error messages
- Success notifications
- Password visibility toggle

## 📱 Berlaku untuk Semua Role

Fitur ini otomatis bekerja untuk:
- ✅ SuperAdmin BKPRMI
- ✅ Admin LPPTKA
- ✅ Admin TPA
- ✅ Member

Tidak perlu konfigurasi tambahan per role, sistem akan otomatis redirect ke dashboard sesuai role setelah login dengan password baru.

## 🔧 Troubleshooting

### Email tidak terkirim:
1. Check konfigurasi MAIL_ di .env
2. Check koneksi internet
3. Check spam folder
4. Lihat log: `tail -f storage/logs/laravel.log`
5. Test dengan: `php artisan config:clear && php artisan cache:clear`

### Token invalid:
1. Pastikan token belum expired (60 menit)
2. Pastikan email sesuai
3. Jangan gunakan token yang sama dua kali

### Gmail tidak bisa kirim:
1. Enable 2FA
2. Generate App Password
3. Gunakan App Password, bukan password akun

## 📞 Support

Jika ada masalah atau pertanyaan, hubungi developer atau check dokumentasi Laravel:
- https://laravel.com/docs/mail
- https://laravel.com/docs/passwords
