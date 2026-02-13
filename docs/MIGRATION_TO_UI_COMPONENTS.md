# Panduan Migrasi Form ke UI Components

Dokumen ini berisi contoh migrasi form dari hardcode HTML ke UI Components.

## 🔄 Contoh Migrasi Form Login

### ✅ Sudah Menggunakan Komponen
File: `resources/views/auth/login.blade.php`

Form login sudah menggunakan komponen UI dengan baik:
```blade
<x-ui.input
    name="email"
    type="email"
    label="Email"
    placeholder="admin@example.com"
    :required="true"
/>

<x-ui.input
    name="password"
    type="password"
    label="Password"
    placeholder="••••••••"
    :required="true"
/>
```

---

## 🔄 Form yang Perlu Dimigrasi

### 1. Form Teacher Create/Edit
File: `resources/views/tpa/teachers/create.blade.php` & `edit.blade.php`

#### Before (Hardcode):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">NIK <span class="text-error">*</span></span></label>
    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
        class="input input-bordered @error('nik') input-error @enderror" required>
    @error('nik')
    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>
```

#### After (Komponen):
```blade
<x-ui.input 
    name="nik" 
    label="NIK" 
    :value="old('nik')"
    :required="true"
    maxlength="16"
    placeholder="Masukkan NIK"
/>
```

#### Gender Radio (Before):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">Jenis Kelamin <span class="text-error">*</span></span></label>
    <div class="flex gap-4">
        @foreach(\App\Enum\Gender::cases() as $gender)
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="gender" value="{{ $gender->value }}"
                class="radio radio-primary" {{ old('gender') == $gender->value ? 'checked' : '' }} required>
            <span>{{ $gender->getLabel() }}</span>
        </label>
        @endforeach
    </div>
</div>
```

#### Gender Radio (After):
```blade
<x-ui.radio 
    name="gender" 
    label="Jenis Kelamin"
    :options="collect(App\Enum\Gender::cases())->map(fn($e) => [
        'value' => $e->value,
        'label' => $e->getLabel()
    ])->toArray()"
    :value="old('gender')"
    :required="true"
/>
```

#### File Upload (Before):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">Foto</span></label>
    <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png"
        class="file-input file-input-bordered @error('photo') file-input-error @enderror">
    @error('photo')
    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>
```

#### File Upload (After):
```blade
<x-ui.file 
    name="photo" 
    label="Foto"
    accept="image/jpeg,image/jpg,image/png"
    :preview="true"
    helpText="Format: JPG, PNG. Max: 10MB"
/>
```

---

### 2. Form Unit Create (LPPTKA)
File: `resources/views/lpptka/units/create.blade.php`

#### Tipe Lokasi Radio (Before):
```blade
<div class="form-control md:col-span-2">
    <label class="label"><span class="label-text">Lokasi Kegiatan <span class="text-error">*</span></span></label>
    <div class="flex flex-wrap gap-4">
        @foreach(\App\Enum\TipeLokasi::cases() as $tipe)
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="tipe_lokasi" value="{{ $tipe->value }}"
                class="radio radio-primary" {{ old('tipe_lokasi') == $tipe->value ? 'checked' : '' }} required>
            <span>{{ $tipe->getLabel() }}</span>
        </label>
        @endforeach
    </div>
</div>
```

#### Tipe Lokasi Radio (After):
```blade
<x-ui.radio 
    name="tipe_lokasi" 
    label="Lokasi Kegiatan"
    :options="collect(App\Enum\TipeLokasi::cases())->map(fn($e) => [
        'value' => $e->value,
        'label' => $e->getLabel()
    ])->toArray()"
    :value="old('tipe_lokasi')"
    :required="true"
    layout="horizontal"
    class="md:col-span-2"
/>
```

---

### 3. Form dengan Select (Dynamic Dropdown)
File: `resources/views/tpa/teachers/create.blade.php`

#### Province Select (Before):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">Provinsi <span class="text-error">*</span></span></label>
    <select name="province_id" id="province_id"
        class="select select-bordered @error('province_id') select-error @enderror"
        x-model="provinceId" @change="fetchCities" required>
        <option value="">Pilih Provinsi</option>
        @foreach($provinces as $province)
        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
            {{ $province->name }}
        </option>
        @endforeach
    </select>
    @error('province_id')
    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>
```

#### Province Select (After):
```blade
<x-ui.select 
    name="province_id" 
    label="Provinsi"
    :options="$provinces->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray()"
    :value="old('province_id')"
    placeholder="Pilih Provinsi"
    :required="true"
    x-model="provinceId" 
    @change="fetchCities"
/>
```

---

### 4. Form dengan Checkbox Multiple
File: `resources/views/tpa/teachers/create.blade.php`

#### Pekerjaan Checkbox (Before):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">Pekerjaan</span></label>
    <div class="flex flex-wrap gap-4">
        @foreach(\App\Enum\PekerjaanWali::cases() as $pekerjaan)
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="pekerjaan[]" value="{{ $pekerjaan->value }}"
                class="checkbox checkbox-primary"
                {{ in_array($pekerjaan->value, old('pekerjaan', [])) ? 'checked' : '' }}>
            <span>{{ $pekerjaan->getLabel() }}</span>
        </label>
        @endforeach
    </div>
</div>
```

#### Pekerjaan Checkbox (After):
```blade
<x-ui.checkbox 
    name="pekerjaan[]" 
    label="Pekerjaan"
    :options="collect(App\Enum\PekerjaanWali::cases())->map(fn($e) => [
        'value' => $e->value,
        'label' => $e->getLabel()
    ])->toArray()"
    :checked="old('pekerjaan', [])"
    layout="horizontal"
/>
```

---

### 5. Form dengan Textarea
File: `resources/views/admin/activities/create.blade.php`

#### Description Textarea (Before):
```blade
<div class="form-control">
    <label class="label"><span class="label-text">Deskripsi</span></label>
    <textarea name="description" rows="4"
        class="textarea textarea-bordered @error('description') textarea-error @enderror"
        placeholder="Masukkan deskripsi kegiatan...">{{ old('description') }}</textarea>
    @error('description')
    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>
```

#### Description Textarea (After):
```blade
<x-ui.textarea 
    name="description" 
    label="Deskripsi"
    :value="old('description')"
    :rows="4"
    placeholder="Masukkan deskripsi kegiatan..."
/>
```

---

## 📝 Checklist Migrasi

### Form Views yang Perlu Diupdate:

- [ ] `/tpa/teachers/create.blade.php`
- [ ] `/tpa/teachers/edit.blade.php`
- [ ] `/tpa/santri/create.blade.php`
- [ ] `/tpa/santri/edit.blade.php`
- [ ] `/lpptka/units/create.blade.php`
- [ ] `/lpptka/units/edit.blade.php`
- [ ] `/lpptka/tpa-accounts/create.blade.php`
- [ ] `/admin/activities/create.blade.php`
- [ ] `/admin/activities/edit.blade.php`
- [ ] `/admin/archives/create.blade.php`
- [ ] `/admin/settings/profile.blade.php` ✅ (Sudah menggunakan komponen)
- [ ] `/superadmin/profile.blade.php` ✅ (Sudah menggunakan komponen)

### Report Views (Filter Forms):
- [ ] `/admin/reports/santri.blade.php`
- [ ] `/admin/reports/activities.blade.php`
- [ ] `/admin/reports/units.blade.php`
- [ ] `/member/reports/index.blade.php`
- [ ] `/superadmin/reports/index.blade.php`

---

## 🎯 Prioritas Migrasi

### High Priority:
1. Form Teacher (Create/Edit) - Banyak field hardcode
2. Form Unit (Create/Edit) - Form panjang dengan banyak input
3. Form Santri (Create/Edit) - Form kompleks

### Medium Priority:
4. Filter forms di Reports
5. Form Activities
6. Form Archives

### Low Priority:
7. Simple search forms
8. Single field forms

---

## 💡 Tips Migrasi

1. **Test setelah migrasi**: Pastikan validation dan old input masih berfungsi
2. **Preserve Alpine.js**: Jika ada `x-model` atau Alpine directive, tetap pertahankan
3. **Check error messages**: Pastikan error validation muncul dengan benar
4. **Maintain layout**: Gunakan class tambahan jika perlu (md:col-span-2, dll)
5. **Update documentation**: Update dokumentasi jika ada perubahan behavior

---

## 🔍 Review Points

Setelah migrasi, pastikan:
- ✅ Form submit berfungsi normal
- ✅ Validation error muncul di tempat yang benar
- ✅ Old input preserved saat ada error
- ✅ Required field ditandai dengan asterisk (*)
- ✅ Tampilan konsisten dengan design system
- ✅ Alpine.js integration masih berfungsi
- ✅ File upload dengan preview berfungsi (untuk image)
- ✅ Dynamic dropdown (province > city > district) masih berfungsi
