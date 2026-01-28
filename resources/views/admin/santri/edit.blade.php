<x-layouts.admin title="Edit Santri">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.santri.index') }}">Data Santri</a></li>
            <li>Edit Santri</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Edit Data Santri</h1>
        <p class="text-base-content/60">Perbarui data santri: {{ $santri->person->full_name ?? '' }}</p>
    </x-slot:header>

    @if(session('error'))
    <x-ui.alert type="error" class="mb-4">{{ session('error') }}</x-ui.alert>
    @endif

    @php
    $guardian = $santri->guardians->first();
    $guardianPerson = $guardian?->person;
    $guardianSantri = $guardian?->guardianSantri?->where('santri_id', $santri->id)->first();
    @endphp

    <form method="POST" action="{{ route('admin.santri.update', $santri) }}" class="space-y-6" x-data="santriForm()">
        @csrf
        @method('PUT')

        <!-- IDENTITAS SANTRI -->
        <x-ui.card title="IDENTITAS SANTRI" subtitle="Data identitas diri santri">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input name="nik" label="NIK (Nomor Induk Kependudukan)" placeholder="Masukkan 16 digit NIK"
                    :required="true" maxlength="16" pattern="[0-9]{16}"
                    :value="old('nik', $santri->person->nik ?? '')" />

                <x-ui.input name="full_name" label="Nama Lengkap Santri" placeholder="Masukkan nama lengkap"
                    :required="true" :value="old('full_name', $santri->person->full_name ?? '')" />

                <x-ui.input name="birth_place" label="Tempat Lahir" placeholder="Masukkan tempat lahir" :required="true"
                    :value="old('birth_place', $santri->person->birth_place ?? '')" />

                <x-ui.input name="birth_date" type="date" label="Tanggal Lahir" :required="true"
                    :value="old('birth_date', $santri->person->birth_date?->format('Y-m-d') ?? '')" />

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Jenis Kelamin <span class="text-error">*</span></span>
                    </label>
                    <div class="flex gap-6 mt-2">
                        @foreach($genderOptions as $gender)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="{{ $gender->value }}" class="radio radio-primary"
                                {{ old('gender', $santri->person->gender ?? '') == $gender->value ? 'checked' : '' }}
                                required />
                            <span>{{ $gender->getLabel() }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('gender')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-ui.input name="child_order" type="number" label="Anak Ke-" placeholder="1" :required="true"
                        min="1" :value="old('child_order', $santri->child_order ?? 1)" />

                    <x-ui.input name="siblings_count" type="number" label="Jumlah Saudara" placeholder="0"
                        :required="true" min="0" :value="old('siblings_count', $santri->siblings_count ?? 0)" />
                </div>
            </div>
        </x-ui.card>

        <!-- ALAMAT -->
        <x-ui.card title="ALAMAT" subtitle="Alamat tempat tinggal santri">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Provinsi <span class="text-error">*</span></span>
                    </label>
                    <select name="province_id" class="select select-bordered w-full" x-model="provinceId"
                        @change="fetchCities()" required>
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $province)
                        <option value="{{ $province->id }}">
                            {{ $province->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('province_id')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Kab/Kota <span class="text-error">*</span></span>
                    </label>
                    <select name="city_id" class="select select-bordered w-full" x-model="cityId"
                        @change="fetchDistricts()" :disabled="!provinceId" required>
                        <option value="">-- Pilih Kab/Kota --</option>
                        <template x-for="city in cities" :key="city.id">
                            <option :value="city.id" x-text="city.name" :selected="city.id == cityId"></option>
                        </template>
                    </select>
                    @error('city_id')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Kecamatan <span class="text-error">*</span></span>
                    </label>
                    <select name="district_id" class="select select-bordered w-full" x-model="districtId"
                        @change="fetchVillages()" :disabled="!cityId" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        <template x-for="district in districts" :key="district.id">
                            <option :value="district.id" x-text="district.name" :selected="district.id == districtId">
                            </option>
                        </template>
                    </select>
                    @error('district_id')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Kelurahan/Desa <span class="text-error">*</span></span>
                    </label>
                    <select name="village_id" class="select select-bordered w-full" x-model="villageId"
                        :disabled="!districtId" required>
                        <option value="">-- Pilih Kelurahan/Desa --</option>
                        <template x-for="village in villages" :key="village.id">
                            <option :value="village.id" x-text="village.name" :selected="village.id == villageId">
                            </option>
                        </template>
                    </select>
                    @error('village_id')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-ui.textarea name="address" label="Jalan / Alamat Lengkap"
                        placeholder="Masukkan nama jalan dan alamat lengkap" :required="true" rows="2"
                        :value="old('address', $santri->address ?? '')" />
                </div>

                <x-ui.input name="rt" label="RT" placeholder="001" :required="true" maxlength="3"
                    :value="old('rt', $santri->rt ?? '')" />

                <x-ui.input name="rw" label="RW" placeholder="001" :required="true" maxlength="3"
                    :value="old('rw', $santri->rw ?? '')" />
            </div>
        </x-ui.card>

        <!-- NAMA ORANG TUA -->
        <x-ui.card title="NAMA ORANG TUA" subtitle="Data nama orang tua kandung">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input name="nama_ayah" label="Nama Ayah Kandung" placeholder="Masukkan nama ayah kandung"
                    :required="true" :value="old('nama_ayah', $santri->nama_ayah ?? '')" />

                <x-ui.input name="nama_ibu" label="Nama Ibu Kandung" placeholder="Masukkan nama ibu kandung"
                    :required="true" :value="old('nama_ibu', $santri->nama_ibu ?? '')" />
            </div>
        </x-ui.card>

        <!-- PENGAMPU / WALI SANTRI -->
        <x-ui.card title="NAMA PENGAMPU / WALI SANTRI" subtitle="Data wali yang bertanggung jawab atas santri">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input name="wali_nik" label="NIK Wali" placeholder="Masukkan 16 digit NIK wali" :required="true"
                    maxlength="16" pattern="[0-9]{16}" :value="old('wali_nik', $guardianPerson->nik ?? '')" />

                <x-ui.input name="wali_nama" label="Nama Lengkap Wali" placeholder="Masukkan nama lengkap wali"
                    :required="true" :value="old('wali_nama', $guardianPerson->full_name ?? '')" />

                <x-ui.input name="wali_tempat_lahir" label="Tempat Lahir" placeholder="Masukkan tempat lahir wali"
                    :required="true" :value="old('wali_tempat_lahir', $guardianPerson->birth_place ?? '')" />

                <x-ui.input name="wali_tanggal_lahir" type="date" label="Tanggal Lahir" :required="true"
                    :value="old('wali_tanggal_lahir', $guardianPerson?->birth_date?->format('Y-m-d') ?? '')" />

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Jenis Kelamin Wali <span class="text-error">*</span></span>
                    </label>
                    <div class="flex gap-6 mt-2">
                        @foreach($genderOptions as $gender)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="wali_gender" value="{{ $gender->value }}"
                                class="radio radio-primary"
                                {{ old('wali_gender', $guardianPerson->gender ?? '') == $gender->value ? 'checked' : '' }}
                                required />
                            <span>{{ $gender->getLabel() }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('wali_gender')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                @php
                $hubunganOpts = collect($hubunganOptions)->mapWithKeys(fn($h) => [$h->value =>
                $h->getLabel()])->toArray();
                @endphp
                <x-ui.select name="wali_hubungan" label="Hubungan Dengan Santri" :options="$hubunganOpts"
                    :required="true" :selected="old('wali_hubungan', $guardianSantri->hubungan ?? '')" />

                @php
                $pendidikanOpts = collect($pendidikanOptions)->mapWithKeys(fn($p) => [$p->value =>
                $p->getLabel()])->toArray();
                @endphp
                <x-ui.select name="wali_pendidikan" label="Pendidikan Terakhir" :options="$pendidikanOpts"
                    :required="true" :selected="old('wali_pendidikan', $guardian->pendidikan_terakhir ?? '')" />

                @php
                $pekerjaanOpts = collect($pekerjaanOptions)->mapWithKeys(fn($p) => [$p->value =>
                $p->getLabel()])->toArray();
                @endphp
                <x-ui.select name="wali_pekerjaan" label="Pekerjaan" :options="$pekerjaanOpts" :required="true"
                    :selected="old('wali_pekerjaan', $guardian->pekerjaan ?? '')" />

                <x-ui.input name="wali_phone" label="Nomor HP" placeholder="08xxxxxxxxxx" :required="true"
                    :value="old('wali_phone', $guardianPerson->phone ?? '')" />
            </div>
        </x-ui.card>

        <!-- STATUS SANTRI -->
        <x-ui.card title="STATUS SANTRI" subtitle="Status pendidikan santri di TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                $jenjangOpts = collect($jenjangOptions)->mapWithKeys(fn($j) => [$j->value =>
                $j->getLabel()])->toArray();
                $kelasOpts = collect($kelasOptions)->mapWithKeys(fn($k) => [$k->value => $k->getLabel()])->toArray();
                $statusOpts = collect($statusOptions)->mapWithKeys(fn($s) => [$s->value => $s->getLabel()])->toArray();
                @endphp

                <x-ui.select name="jenjang_santri" label="Jenjang" :options="$jenjangOpts" :required="true"
                    :selected="old('jenjang_santri', $santri->jenjang_santri ?? '')" />

                <x-ui.select name="kelas_mengaji" label="Kelas Bacaan" :options="$kelasOpts" :required="true"
                    :selected="old('kelas_mengaji', $santri->kelas_mengaji ?? '')" />

                <x-ui.select name="status_santri" label="Status" :options="$statusOpts" :required="true"
                    :selected="old('status_santri', $santri->status_santri ?? 'aktif')" />
            </div>
        </x-ui.card>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.santri.index') }}" class="btn btn-ghost">Batal</a>
            <x-ui.button type="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Data Santri
            </x-ui.button>
        </div>
    </form>

    @push('scripts')
    <script>
    function santriForm() {
        return {
            provinceId: '{{ old('
            province_id ', $santri->village?->district?->city?->province_id ?? '
            ') }}',
            cityId: '{{ old('
            city_id ', $santri->village?->district?->city_id ?? '
            ') }}',
            districtId: '{{ old('
            district_id ', $santri->village?->district_id ?? '
            ') }}',
            villageId: '{{ old('
            village_id ', $santri->village_id ?? '
            ') }}',
            cities: [],
            districts: [],
            villages: [],
            isInitializing: true,

            init() {
                if (this.provinceId) {
                    this.fetchCities(false).then(() => {
                        if (this.cityId) {
                            this.fetchDistricts(false).then(() => {
                                if (this.districtId) {
                                    this.fetchVillages(false).then(() => {
                                        this.isInitializing = false;
                                    });
                                } else {
                                    this.isInitializing = false;
                                }
                            });
                        } else {
                            this.isInitializing = false;
                        }
                    });
                } else {
                    this.isInitializing = false;
                }
            },

            async fetchCities(resetChild = true) {
                if (!this.provinceId) {
                    this.cities = [];
                    this.cityId = '';
                    this.districts = [];
                    this.districtId = '';
                    this.villages = [];
                    this.villageId = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/regions/cities?province_id=${this.provinceId}`);
                    this.cities = await response.json();
                    if (resetChild) {
                        this.cityId = '';
                        this.districts = [];
                        this.districtId = '';
                        this.villages = [];
                        this.villageId = '';
                    }
                } catch (error) {
                    console.error('Error fetching cities:', error);
                }
            },

            async fetchDistricts(resetChild = true) {
                if (!this.cityId) {
                    this.districts = [];
                    this.districtId = '';
                    this.villages = [];
                    this.villageId = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/regions/districts?city_id=${this.cityId}`);
                    this.districts = await response.json();
                    if (resetChild) {
                        this.districtId = '';
                        this.villages = [];
                        this.villageId = '';
                    }
                } catch (error) {
                    console.error('Error fetching districts:', error);
                }
            },

            async fetchVillages(resetChild = true) {
                if (!this.districtId) {
                    this.villages = [];
                    this.villageId = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/regions/villages?district_id=${this.districtId}`);
                    this.villages = await response.json();
                    if (resetChild) {
                        this.villageId = '';
                    }
                } catch (error) {
                    console.error('Error fetching villages:', error);
                }
            }
        }
    }
    </script>
    @endpush
</x-layouts.admin>