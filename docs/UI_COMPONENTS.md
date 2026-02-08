# UI Components Documentation

Dokumentasi lengkap untuk semua komponen UI yang tersedia di BKPRMI KOTA MAKASSAR.

## 📋 Daftar Komponen

1. [Input](#input)
2. [Textarea](#textarea)
3. [Select](#select)
4. [Radio](#radio)
5. [Checkbox](#checkbox)
6. [File Upload](#file-upload)
7. [Button](#button)
8. [Card](#card)
9. [Alert](#alert)
10. [Badge](#badge)
11. [Table](#table)
12. [Modal](#modal)

---

## Input

Komponen input text dengan dukungan berbagai tipe termasuk password dengan toggle visibility.

### Props
- `name` (required): Nama input
- `label`: Label text
- `type`: Tipe input (text, email, password, number, date, etc.)
- `placeholder`: Placeholder text
- `value`: Nilai awal
- `required`: Boolean untuk field required
- `helpText`: Teks bantuan di bawah input

### Contoh Penggunaan

```blade
<x-ui.input 
    name="full_name" 
    label="Nama Lengkap" 
    :value="old('full_name', $user->name ?? '')"
    :required="true"
    placeholder="Masukkan nama lengkap"
/>

<x-ui.input 
    name="email" 
    type="email" 
    label="Email" 
    :value="old('email')"
    :required="true"
/>

<x-ui.input 
    name="password" 
    type="password" 
    label="Password" 
    :required="true"
    helpText="Minimal 8 karakter"
/>
```

---

## Textarea

Komponen textarea untuk input text panjang.

### Props
- `name` (required): Nama textarea
- `label`: Label text
- `placeholder`: Placeholder text
- `value`: Nilai awal
- `rows`: Jumlah baris (default: 4)
- `required`: Boolean untuk field required
- `helpText`: Teks bantuan

### Contoh Penggunaan

```blade
<x-ui.textarea 
    name="description" 
    label="Deskripsi" 
    :value="old('description')"
    :rows="6"
    placeholder="Masukkan deskripsi..."
/>
```

---

## Select

Komponen dropdown select yang mendukung dua format options.

### Props
- `name` (required): Nama select
- `label`: Label text
- `options`: Array options (support 2 format - lihat contoh)
- `value`: Nilai terpilih (gunakan ini, bukan 'selected')
- `placeholder`: Text untuk option pertama
- `required`: Boolean untuk field required
- `helpText`: Teks bantuan

### Format Options

Komponen ini mendukung **dua format** untuk flexibility:

**Format 1: Array of Arrays (Recommended)**
```php
[
    ['value' => '1', 'label' => 'Option 1'],
    ['value' => '2', 'label' => 'Option 2'],
]
```

**Format 2: Associative Array (Legacy)**
```php
[
    '1' => 'Option 1',
    '2' => 'Option 2',
]
```

### Contoh Penggunaan

```blade
{{-- Format 1: Array of Arrays --}}
<x-ui.select 
    name="province_id" 
    label="Provinsi"
    :options="$provinces->map(fn($p) => ['value' => $p->id, 'label' => $p->name])->toArray()"
    :value="old('province_id')"
    placeholder="Pilih Provinsi"
    :required="true"
/>

{{-- Format 2: Associative Array --}}
<x-ui.select 
    name="status" 
    label="Status"
    :options="['active' => 'Aktif', 'inactive' => 'Nonaktif']"
    :value="old('status')"
/>

{{-- Dengan Enum --}}
<x-ui.select 
    name="gender"
    label="Jenis Kelamin"
    :options="collect(App\Enum\Gender::cases())->map(fn($g) => [
        'value' => $g->value,
        'label' => $g->getLabel()
    ])->toArray()"
    :value="old('gender')"
    :required="true"
/>
```

---

## Radio

Komponen radio button group.

### Props
- `name` (required): Nama radio group
- `label`: Label untuk group
- `options`: Array options dengan format:
  ```php
  [
      ['value' => 'val1', 'label' => 'Label 1', 'disabled' => false],
      ['value' => 'val2', 'label' => 'Label 2', 'disabled' => true],
  ]
  ```
- `value`: Nilai terpilih
- `required`: Boolean untuk field required
- `layout`: 'horizontal' atau 'vertical'
- `helpText`: Teks bantuan

### Contoh Penggunaan

```blade
@php
$genderOptions = [
    ['value' => 'laki-laki', 'label' => 'Laki-laki'],
    ['value' => 'perempuan', 'label' => 'Perempuan'],
];
@endphp

<x-ui.radio 
    name="gender" 
    label="Jenis Kelamin"
    :options="$genderOptions"
    :value="old('gender')"
    :required="true"
    layout="horizontal"
/>

{{-- Dengan Enum --}}
<x-ui.radio 
    name="tipe_lokasi" 
    label="Lokasi Kegiatan"
    :options="collect(App\Enum\TipeLokasi::cases())->map(fn($e) => [
        'value' => $e->value,
        'label' => $e->getLabel()
    ])->toArray()"
    :value="old('tipe_lokasi')"
    :required="true"
/>

{{-- Dengan option disabled --}}
<x-ui.radio 
    name="format" 
    label="Format Export"
    :options="[
        ['value' => 'pdf', 'label' => 'PDF'],
        ['value' => 'excel', 'label' => 'Excel (Coming Soon)', 'disabled' => true]
    ]"
    value="pdf"
/>
```

---

## Checkbox

Komponen checkbox untuk single atau multiple selection.

### Props
- `name` (required): Nama checkbox
- `label`: Label untuk group
- `options`: Array options dengan format:
  ```php
  [
      ['value' => 'val1', 'label' => 'Label 1', 'disabled' => false],
      ['value' => 'val2', 'label' => 'Label 2', 'disabled' => true],
  ]
  ```
- `checked`: Array nilai yang checked
- `required`: Boolean untuk field required
- `layout`: 'horizontal' atau 'vertical'
- `single`: Boolean untuk single checkbox
- `helpText`: Teks bantuan

### Contoh Penggunaan

```blade
{{-- Multiple Checkboxes --}}
<x-ui.checkbox 
    name="pekerjaan[]" 
    label="Pekerjaan"
    :options="collect(App\Enum\PekerjaanWali::cases())->map(fn($e) => [
        'value' => $e->value,
        'label' => $e->getLabel()
    ])->toArray()"
    :checked="old('pekerjaan', [])"
    layout="vertical"
/>

{{-- Single Checkbox --}}
<x-ui.checkbox 
    name="is_active" 
    label="Status Aktif"
    :options="[['value' => '1', 'label' => 'Aktif']]"
    :checked="old('is_active', $user->is_active ? ['1'] : [])"
    :single="true"
/>

{{-- Dengan option disabled --}}
<x-ui.checkbox 
    name="features[]" 
    label="Fitur"
    :options="[
        ['value' => 'feature1', 'label' => 'Feature 1'],
        ['value' => 'feature2', 'label' => 'Feature 2 (Coming Soon)', 'disabled' => true]
    ]"
    :checked="['feature1']"
/>
```

---

## File Upload

Komponen upload file dengan preview untuk gambar.

### Props
- `name` (required): Nama file input
- `label`: Label text
- `accept`: File types yang diterima
- `required`: Boolean untuk field required
- `preview`: Boolean untuk show preview (khusus gambar)
- `currentFile`: URL file saat ini (untuk edit form)
- `helpText`: Teks bantuan

### Contoh Penggunaan

```blade
{{-- Upload Gambar dengan Preview --}}
<x-ui.file 
    name="photo" 
    label="Foto Profil"
    accept="image/jpeg,image/jpg,image/png"
    :preview="true"
    :currentFile="$user->photo_url ?? null"
    helpText="Format: JPG, PNG. Max: 2MB"
/>

{{-- Upload PDF --}}
<x-ui.file 
    name="sertifikat_lmd" 
    label="Sertifikat LMD"
    accept="application/pdf"
    :currentFile="$teacher->sertifikat_lmd_url ?? null"
    helpText="Format: PDF. Max: 5MB"
/>
```

---

## Button

Komponen button dengan berbagai varian.

### Props
- `type`: primary, secondary, accent, success, warning, error, ghost, outline
- `size`: xs, sm, md, lg
- `disabled`: Boolean
- `loading`: Boolean untuk loading state

### Contoh Penggunaan

```blade
<x-ui.button type="primary">
    Simpan Data
</x-ui.button>

<x-ui.button type="error" class="btn-outline">
    Hapus
</x-ui.button>

<x-ui.button type="ghost">
    Batal
</x-ui.button>
```

---

## Card

Komponen card container.

### Props
- `title`: Judul card
- `subtitle`: Subjudul card

### Contoh Penggunaan

```blade
<x-ui.card title="Informasi Profil" subtitle="Update data profil Anda">
    <form method="POST">
        <!-- Form content -->
    </form>
</x-ui.card>
```

---

## Alert

Komponen alert message.

### Props
- `type`: success, error, warning, info
- `dismissible`: Boolean untuk close button

### Contoh Penggunaan

```blade
<x-ui.alert type="success" :dismissible="true">
    Data berhasil disimpan!
</x-ui.alert>

<x-ui.alert type="error">
    Terjadi kesalahan saat menyimpan data.
</x-ui.alert>
```

---

## Badge

Komponen badge untuk label.

### Props
- `type`: primary, secondary, accent, success, warning, error, ghost

### Contoh Penggunaan

```blade
<x-ui.badge type="success">Aktif</x-ui.badge>
<x-ui.badge type="warning">Pending</x-ui.badge>
<x-ui.badge type="error">Nonaktif</x-ui.badge>
```

---

## Best Practices

### 1. Konsistensi
Gunakan komponen UI di semua form untuk menjaga konsistensi tampilan.

### 2. Validasi
Komponen sudah support Laravel validation error messages dengan `@error()` directive.

### 3. Old Input
Gunakan `old()` helper untuk preserve input saat validation error:
```blade
:value="old('field_name', $model->field_name ?? '')"
```

### 4. Enum Integration
Gunakan Enum untuk dropdown/radio options:
```blade
:options="collect(App\Enum\YourEnum::cases())->map(fn($e) => [
    'value' => $e->value,
    'label' => $e->getLabel()
])->toArray()"
```

### 5. Required Fields
Tambahkan `:required="true"` untuk menampilkan tanda asterisk (*):
```blade
<x-ui.input name="name" label="Nama" :required="true" />
```

---

## Migration Guide

### Dari Hardcode ke Komponen

**Before:**
```blade
<div class="form-control">
    <label class="label">
        <span class="label-text">Nama <span class="text-error">*</span></span>
    </label>
    <input type="text" name="name" class="input input-bordered" required>
    @error('name')
    <label class="label">
        <span class="label-text-alt text-error">{{ $message }}</span>
    </label>
    @enderror
</div>
```

**After:**
```blade
<x-ui.input name="name" label="Nama" :required="true" />
```

---

## Troubleshooting

### Komponen tidak muncul
Pastikan Alpine.js sudah ter-load untuk komponen yang menggunakan `x-data`.

### Style tidak sesuai
Pastikan DaisyUI theme sudah di-set di config TailwindCSS.

### Validation error tidak muncul
Pastikan attribute `name` pada komponen sama dengan key validation di controller.
