<x-layouts.admin title="Edit Unit">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.units.index') }}">Data Unit</a></li>
            <li>Edit Unit</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Edit Unit: {{ $unit->name }}</h1>
        <p class="text-base-content/60">Perbarui data unit TPA/TPQ</p>
    </x-slot:header>

    @if(session('error'))
        <x-ui.alert type="error" class="mb-4">{{ session('error') }}</x-ui.alert>
    @endif

    <form method="POST" action="{{ route('admin.units.update', $unit) }}" class="space-y-6" x-data="unitForm()">
        @csrf
        @method('PUT')

        <!-- IDENTITAS UNIT -->
        <x-ui.card title="IDENTITAS UNIT" subtitle="Data identitas unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input
                    name="unit_number"
                    label="Nomor Unit"
                    placeholder="Masukkan nomor unit"
                    :required="true"
                    :value="old('unit_number', $unit->unit_number)"
                />

                <x-ui.input
                    name="name"
                    label="Nama TK/TP Al Qur'an"
                    placeholder="Masukkan nama unit"
                    :required="true"
                    :value="old('name', $unit->name)"
                />

                <div class="md:col-span-2">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Lokasi Kegiatan <span class="text-error">*</span></span>
                        </label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach($tipeLokasiOptions as $tipe)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="tipe_lokasi"
                                        value="{{ $tipe->value }}"
                                        class="radio radio-primary"
                                        {{ old('tipe_lokasi', $unit->tipe_lokasi?->value) == $tipe->value ? 'checked' : '' }}
                                        required
                                    />
                                    <span>{{ $tipe->getLabel() }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tipe_lokasi')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Status Gedung <span class="text-error">*</span></span>
                        </label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach($statusBangunanOptions as $status)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="status_bangunan"
                                        value="{{ $status->value }}"
                                        class="radio radio-primary"
                                        {{ old('status_bangunan', $unit->status_bangunan?->value) == $status->value ? 'checked' : '' }}
                                        required
                                    />
                                    <span>{{ $status->getLabel() }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('status_bangunan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <x-ui.input
                    name="mosque_name"
                    label="Nama Masjid/Mushallah"
                    placeholder="Masukkan nama masjid/mushallah (jika ada)"
                    :value="old('mosque_name', $unit->mosque_name)"
                />

                <x-ui.input
                    name="founder"
                    label="Lembaga Pendiri/Penyelenggara"
                    placeholder="Masukkan nama lembaga pendiri"
                    :value="old('founder', $unit->founder)"
                />

                <x-ui.input
                    name="formed_at"
                    type="date"
                    label="Mulai Terbentuk pada Tanggal"
                    :value="old('formed_at', $unit->formed_at?->format('Y-m-d'))"
                />

                <x-ui.input
                    name="joined_year"
                    type="number"
                    label="Bergabung Dengan LPPTKA Pada Tahun"
                    placeholder="Contoh: 2020"
                    min="1900"
                    max="{{ date('Y') }}"
                    :value="old('joined_year', $unit->joined_year)"
                />

                <div class="md:col-span-2">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Jam Kegiatan <span class="text-error">*</span></span>
                        </label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach($waktuKegiatanOptions as $waktu)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="waktu_kegiatan"
                                        value="{{ $waktu->value }}"
                                        class="radio radio-primary"
                                        {{ old('waktu_kegiatan', $unit->waktu_kegiatan?->value) == $waktu->value ? 'checked' : '' }}
                                        required
                                    />
                                    <span>{{ $waktu->getLabel() }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('waktu_kegiatan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <x-ui.input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="email@example.com"
                    :value="old('email', $unit->email)"
                />
            </div>
        </x-ui.card>

        <!-- ALAMAT -->
        <x-ui.card title="ALAMAT" subtitle="Alamat lokasi unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Provinsi <span class="text-error">*</span></span>
                    </label>
                    <select
                        name="province_id"
                        class="select select-bordered w-full"
                        x-model="provinceId"
                        @change="fetchCities()"
                        required
                    >
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
                    <select
                        name="city_id"
                        class="select select-bordered w-full"
                        x-model="cityId"
                        @change="fetchDistricts()"
                        :disabled="!provinceId"
                        required
                    >
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
                    <select
                        name="district_id"
                        class="select select-bordered w-full"
                        x-model="districtId"
                        @change="fetchVillages()"
                        :disabled="!cityId"
                        required
                    >
                        <option value="">-- Pilih Kecamatan --</option>
                        <template x-for="district in districts" :key="district.id">
                            <option :value="district.id" x-text="district.name" :selected="district.id == districtId"></option>
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
                    <select
                        name="village_id"
                        class="select select-bordered w-full"
                        x-model="villageId"
                        :disabled="!districtId"
                        required
                    >
                        <option value="">-- Pilih Kelurahan/Desa --</option>
                        <template x-for="village in villages" :key="village.id">
                            <option :value="village.id" x-text="village.name" :selected="village.id == villageId"></option>
                        </template>
                    </select>
                    @error('village_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-ui.textarea
                        name="address"
                        label="Jalan / Alamat Lengkap"
                        placeholder="Masukkan nama jalan dan alamat lengkap"
                        :required="true"
                        rows="2"
                        :value="old('address', $unit->address)"
                    />
                </div>

                <x-ui.input
                    name="rt"
                    label="RT"
                    placeholder="001"
                    :required="true"
                    maxlength="3"
                    :value="old('rt', $unit->rt)"
                />

                <x-ui.input
                    name="rw"
                    label="RW"
                    placeholder="001"
                    :required="true"
                    maxlength="3"
                    :value="old('rw', $unit->rw)"
                />
            </div>
        </x-ui.card>

        <!-- KEADAAN SANTRI -->
        <x-ui.card title="KEADAAN SANTRI" subtitle="Jumlah santri berdasarkan jenjang">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-ui.input
                    name="jumlah_tka_4_7"
                    type="number"
                    label="Jumlah TKA (Usia 4-7 Tahun)"
                    placeholder="0"
                    min="0"
                    :value="old('jumlah_tka_4_7', $unit->jumlah_tka_4_7 ?? 0)"
                />

                <x-ui.input
                    name="jumlah_tpa_7_12"
                    type="number"
                    label="Jumlah TPA (Usia 7-12 Tahun)"
                    placeholder="0"
                    min="0"
                    :value="old('jumlah_tpa_7_12', $unit->jumlah_tpa_7_12 ?? 0)"
                />

                <x-ui.input
                    name="jumlah_tqa_wisuda"
                    type="number"
                    label="Jumlah TQA (Telah Wisuda)"
                    placeholder="0"
                    min="0"
                    :value="old('jumlah_tqa_wisuda', $unit->jumlah_tqa_wisuda ?? 0)"
                />
            </div>
        </x-ui.card>

        <!-- KEADAAN GURU MENGAJI -->
        <x-ui.card title="KEADAAN GURU MENGAJI" subtitle="Jumlah guru mengaji berdasarkan jenis kelamin">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input
                    name="jumlah_guru_laki_laki"
                    type="number"
                    label="Laki-laki"
                    placeholder="0"
                    min="0"
                    :value="old('jumlah_guru_laki_laki', $unit->jumlah_guru_laki_laki ?? 0)"
                />

                <x-ui.input
                    name="jumlah_guru_perempuan"
                    type="number"
                    label="Perempuan"
                    placeholder="0"
                    min="0"
                    :value="old('jumlah_guru_perempuan', $unit->jumlah_guru_perempuan ?? 0)"
                />
            </div>
        </x-ui.card>

        <!-- PENANGGUNG JAWAB UNIT -->
        <x-ui.card title="PENANGGUNG JAWAB UNIT" subtitle="Data kepala unit TPA/TPQ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input
                    name="kepala_nama"
                    label="Nama Kepala Unit"
                    placeholder="Masukkan nama kepala unit"
                    :required="true"
                    :value="old('kepala_nama', $unitHead?->person?->full_name)"
                />

                <x-ui.input
                    name="kepala_nik"
                    label="NIK"
                    placeholder="Masukkan 16 digit NIK"
                    :required="true"
                    maxlength="16"
                    pattern="[0-9]{16}"
                    :value="old('kepala_nik', $unitHead?->person?->nik)"
                />

                <x-ui.input
                    name="kepala_tempat_lahir"
                    label="Tempat Lahir"
                    placeholder="Masukkan tempat lahir"
                    :required="true"
                    :value="old('kepala_tempat_lahir', $unitHead?->person?->birth_place)"
                />

                <x-ui.input
                    name="kepala_tanggal_lahir"
                    type="date"
                    label="Tanggal Lahir"
                    :required="true"
                    :value="old('kepala_tanggal_lahir', $unitHead?->person?->birth_date?->format('Y-m-d'))"
                />

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Jenis Kelamin <span class="text-error">*</span></span>
                    </label>
                    <div class="flex gap-6 mt-2">
                        @foreach($genderOptions as $gender)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="radio"
                                    name="kepala_gender"
                                    value="{{ $gender->value }}"
                                    class="radio radio-primary"
                                    {{ old('kepala_gender', $unitHead?->person?->gender?->value) == $gender->value ? 'checked' : '' }}
                                    required
                                />
                                <span>{{ $gender->getLabel() }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('kepala_gender')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                @php
                    $pendidikanOpts = collect($pendidikanOptions)->mapWithKeys(fn($p) => [$p->value => $p->getLabel()])->toArray();
                @endphp
                <x-ui.select
                    name="kepala_pendidikan"
                    label="Pendidikan Terakhir"
                    :options="$pendidikanOpts"
                    :required="true"
                    :selected="old('kepala_pendidikan', $unitHead?->pendidikan_terakhir?->value)"
                />

                @php
                    $pekerjaanOpts = collect($pekerjaanOptions)->mapWithKeys(fn($p) => [$p->value => $p->getLabel()])->toArray();
                @endphp
                <x-ui.select
                    name="kepala_pekerjaan"
                    label="Pekerjaan"
                    :options="$pekerjaanOpts"
                    :required="true"
                    :selected="old('kepala_pekerjaan', $unitHead?->pekerjaan?->value)"
                />

                <x-ui.input
                    name="kepala_phone"
                    label="Nomor HP"
                    placeholder="08xxxxxxxxxx"
                    :required="true"
                    :value="old('kepala_phone', $unitHead?->person?->phone)"
                />
            </div>
        </x-ui.card>

        <!-- ADMIN UNIT -->
        <x-ui.card title="ADMIN UNIT" subtitle="Data admin unit (opsional)">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-ui.input
                    name="admin_nama"
                    label="Nama Admin"
                    placeholder="Masukkan nama admin"
                    :value="old('admin_nama', $unitAdmin?->person?->full_name)"
                />

                <x-ui.input
                    name="admin_phone"
                    label="Nomor HP"
                    placeholder="08xxxxxxxxxx"
                    :value="old('admin_phone', $unitAdmin?->person?->phone)"
                />

                <x-ui.input
                    name="admin_email"
                    type="email"
                    label="Email"
                    placeholder="email@example.com"
                    :value="old('admin_email', $unitAdmin?->person?->email)"
                />
            </div>
        </x-ui.card>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.units.index') }}" class="btn btn-ghost">Batal</a>
            <x-ui.button type="primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Data Unit
            </x-ui.button>
        </div>
    </form>

    @push('scripts')
    <script>
        function unitForm() {
            return {
                provinceId: '{{ old('province_id', $unit->village?->district?->city?->province_id ?? '') }}',
                cityId: '{{ old('city_id', $unit->village?->district?->city_id ?? '') }}',
                districtId: '{{ old('district_id', $unit->village?->district_id ?? '') }}',
                villageId: '{{ old('village_id', $unit->village_id ?? '') }}',
                cities: [],
                districts: [],
                villages: [],
                isInitializing: true,

                // Store initial values
                initialCityId: '{{ old('city_id', $unit->village?->district?->city_id ?? '') }}',
                initialDistrictId: '{{ old('district_id', $unit->village?->district_id ?? '') }}',
                initialVillageId: '{{ old('village_id', $unit->village_id ?? '') }}',

                init() {
                    if (this.provinceId) {
                        this.fetchCities(false).then(() => {
                            // Restore city after fetch
                            this.$nextTick(() => {
                                this.cityId = this.initialCityId;
                            });

                            if (this.initialCityId) {
                                this.fetchDistricts(false).then(() => {
                                    // Restore district after fetch
                                    this.$nextTick(() => {
                                        this.districtId = this.initialDistrictId;
                                    });

                                    if (this.initialDistrictId) {
                                        this.fetchVillages(false).then(() => {
                                            // Restore village after fetch
                                            this.$nextTick(() => {
                                                this.villageId = this.initialVillageId;
                                                this.isInitializing = false;
                                            });
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
