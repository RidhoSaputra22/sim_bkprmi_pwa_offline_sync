<x-layouts.lpptka title="Edit Unit - {{ $unit->name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.units.show', $unit) }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Unit TPA</h1>
                <p class="text-base-content/60">{{ $unit->name }} - {{ $unit->unit_number }}</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('lpptka.units.update', $unit) }}" method="POST" enctype="multipart/form-data" x-data="{
        provinceId: @js(old('province_id', $currentProvinceId ?? null)),
        cityId: @js(old('city_id', $currentCityId ?? null)),
        districtId: @js(old('district_id', $currentDistrictId ?? null)),
        villageId: @js(old('village_id', $unit->village_id ?? null)),
        cities: [],
        districts: [],
        villages: [],
        isInitializing: true,
        initialCityId: @js(old('city_id', $currentCityId ?? null)),
        initialDistrictId: @js(old('district_id', $currentDistrictId ?? null)),
        initialVillageId: @js(old('village_id', $unit->village_id ?? null)),

        init() {
            console.log('Init data:', {
                provinceId: this.provinceId,
                cityId: this.initialCityId,
                districtId: this.initialDistrictId,
                villageId: this.initialVillageId
            });

            if (this.provinceId) {
                this.fetchCities(false).then(() => {
                    console.log('Cities fetched:', this.cities.length, 'cities');

                    // Wait for Alpine to render the options
                    setTimeout(() => {
                        this.cityId = this.initialCityId;
                        console.log('City ID set to:', this.cityId);

                        if (this.initialCityId) {
                            this.fetchDistricts(false).then(() => {
                                console.log('Districts fetched:', this.districts.length, 'districts');

                                setTimeout(() => {
                                    this.districtId = this.initialDistrictId;
                                    console.log('District ID set to:', this.districtId);

                                    if (this.initialDistrictId) {
                                        this.fetchVillages(false).then(() => {
                                            console.log('Villages fetched:', this.villages.length, 'villages');

                                            setTimeout(() => {
                                                this.villageId = this.initialVillageId;
                                                console.log('Village ID set to:', this.villageId);
                                                this.isInitializing = false;
                                            }, 100);
                                        });
                                    } else {
                                        this.isInitializing = false;
                                    }
                                }, 100);
                            });
                        } else {
                            this.isInitializing = false;
                        }
                    }, 100);
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
    }">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Identitas Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Identitas Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor Unit</span></label>
                            <input type="text" value="{{ $unit->unit_number }}" class="input input-bordered" readonly
                                disabled>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama TK/TP Al Qur'an <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                                class="input input-bordered @error('name') input-error @enderror" required>
                            @error('name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Lokasi Kegiatan</span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\TipeLokasi::cases() as $tipe)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tipe_lokasi" value="{{ $tipe->value }}"
                                        class="radio radio-primary @error('tipe_lokasi') radio-error @enderror"
                                        {{ old('tipe_lokasi', $unit->tipe_lokasi?->value) == $tipe->value ? 'checked' : '' }}>
                                    <span>{{ $tipe->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('tipe_lokasi')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Status Gedung</span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\StatusBangunan::cases() as $status)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_bangunan" value="{{ $status->value }}"
                                        class="radio radio-primary @error('status_bangunan') radio-error @enderror"
                                        {{ old('status_bangunan', $unit->status_bangunan?->value) == $status->value ? 'checked' : '' }}>
                                    <span>{{ $status->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('status_bangunan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Masjid/Mushallah</span></label>
                            <input type="text" name="mosque_name" value="{{ old('mosque_name', $unit->mosque_name) }}"
                                class="input input-bordered @error('mosque_name') input-error @enderror">
                            @error('mosque_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Lembaga Pendiri/Penyelenggara</span></label>
                            <input type="text" name="founder" value="{{ old('founder', $unit->founder) }}"
                                class="input input-bordered @error('founder') input-error @enderror">
                            @error('founder')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Mulai Terbentuk pada Tanggal</span></label>
                            <input type="date" name="formed_at"
                                value="{{ old('formed_at', $unit->formed_at?->format('Y-m-d')) }}"
                                class="input input-bordered @error('formed_at') input-error @enderror">
                            @error('formed_at')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Bergabung Dengan LPPTKA Pada
                                    Tahun</span></label>
                            <input type="number" name="joined_year" value="{{ old('joined_year', $unit->joined_year) }}"
                                class="input input-bordered @error('joined_year') input-error @enderror" min="1900"
                                max="2100">
                            @error('joined_year')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Jam Kegiatan</span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\WaktuKegiatan::cases() as $waktu)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="waktu_kegiatan" value="{{ $waktu->value }}"
                                        class="radio radio-primary @error('waktu_kegiatan') radio-error @enderror"
                                        {{ old('waktu_kegiatan', $unit->waktu_kegiatan?->value) == $waktu->value ? 'checked' : '' }}>
                                    <span>{{ $waktu->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('waktu_kegiatan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Email</span></label>
                            <input type="email" name="email" value="{{ old('email', $unit->email) }}"
                                class="input input-bordered @error('email') input-error @enderror">
                            @error('email')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>


                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Alamat</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Provinsi <span
                                        class="text-error">*</span></span></label>
                            <select name="province_id" x-model="provinceId" @change="fetchCities()"
                                class="select select-bordered @error('province_id') select-error @enderror" required>
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ old('province_id', $currentProvinceId) == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kab/Kota <span
                                        class="text-error">*</span></span></label>
                            <select name="city_id" x-model="cityId" @change="fetchDistricts()"
                                class="select select-bordered @error('city_id') select-error @enderror" required
                                :disabled="!cities.length">
                                <option value="">-- Pilih Kota --</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option :value="city.id" x-text="city.name" :selected="city.id == cityId"></option>
                                </template>
                            </select>
                            @error('city_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kecamatan <span
                                        class="text-error">*</span></span></label>
                            <select name="district_id" x-model="districtId" @change="fetchVillages()"
                                class="select select-bordered @error('district_id') select-error @enderror" required
                                :disabled="!districts.length">
                                <option value="">-- Pilih Kecamatan --</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option :value="district.id" x-text="district.name"
                                        :selected="district.id == districtId"></option>
                                </template>
                            </select>
                            @error('district_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kelurahan <span
                                        class="text-error">*</span></span></label>
                            <select name="village_id" x-model="villageId"
                                class="select select-bordered @error('village_id') select-error @enderror" required
                                :disabled="!villages.length">
                                <option value="">-- Pilih Kelurahan --</option>
                                <template x-for="village in villages" :key="village.id">
                                    <option :value="village.id" x-text="village.name"
                                        :selected="village.id == villageId"></option>
                                </template>
                            </select>
                            @error('village_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Jalan</span></label>
                            <textarea name="jalan" rows="2"
                                class="textarea textarea-bordered @error('jalan') textarea-error @enderror"
                                placeholder="Alamat jalan lengkap">{{ old('jalan', $unit->region?->jalan) }}</textarea>
                            @error('jalan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">RT</span></label>
                            <input type="text" name="rt" value="{{ old('rt', $unit->region?->rt) }}"
                                class="input input-bordered @error('rt') input-error @enderror" placeholder="001"
                                maxlength="5">
                            @error('rt')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">RW</span></label>
                            <input type="text" name="rw" value="{{ old('rw', $unit->region?->rw) }}"
                                class="input input-bordered @error('rw') input-error @enderror" placeholder="001"
                                maxlength="5">
                            @error('rw')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keadaan Santri -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Keadaan Santri</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah TKA (Usia 4-7 Tahun)</span></label>
                            <input type="number" name="jumlah_tka"
                                value="{{ old('jumlah_tka', $unit->jumlah_tka ?? 0) }}"
                                class="input input-bordered @error('jumlah_tka') input-error @enderror" placeholder="0"
                                min="0">
                            @error('jumlah_tka')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah TPA (Usia 7-12 Tahun)</span></label>
                            <input type="number" name="jumlah_tpa"
                                value="{{ old('jumlah_tpa', $unit->jumlah_tpa ?? 0) }}"
                                class="input input-bordered @error('jumlah_tpa') input-error @enderror" placeholder="0"
                                min="0">
                            @error('jumlah_tpa')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah TQA (Telah Wisuda)</span></label>
                            <input type="number" name="jumlah_tqa"
                                value="{{ old('jumlah_tqa', $unit->jumlah_tqa ?? 0) }}"
                                class="input input-bordered @error('jumlah_tqa') input-error @enderror" placeholder="0"
                                min="0">
                            @error('jumlah_tqa')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keadaan Guru Mengaji -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Keadaan Guru Mengaji</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Laki-laki</span></label>
                            <input type="number" name="guru_laki" value="{{ old('guru_laki', $unit->guru_laki ?? 0) }}"
                                class="input input-bordered @error('guru_laki') input-error @enderror" placeholder="0"
                                min="0">
                            @error('guru_laki')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Perempuan</span></label>
                            <input type="number" name="guru_perempuan"
                                value="{{ old('guru_perempuan', $unit->guru_perempuan ?? 0) }}"
                                class="input input-bordered @error('guru_perempuan') input-error @enderror"
                                placeholder="0" min="0">
                            @error('guru_perempuan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penanggung Jawab Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Penanggung Jawab Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Kepala Unit <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="head_name"
                                value="{{ old('head_name', $unit->unitHead?->person?->full_name) }}"
                                class="input input-bordered @error('head_name') input-error @enderror" required>
                            @error('head_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">NIK</span></label>
                            <input type="text" name="head_nik"
                                value="{{ old('head_nik', $unit->unitHead?->person?->nik) }}"
                                class="input input-bordered @error('head_nik') input-error @enderror" maxlength="16">
                            @error('head_nik')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tempat Lahir <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="head_birth_place"
                                value="{{ old('head_birth_place', $unit->unitHead?->person?->birth_place) }}"
                                class="input input-bordered @error('head_birth_place') input-error @enderror" required>
                            @error('head_birth_place')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir <span
                                        class="text-error">*</span></span></label>
                            <input type="date" name="head_birth_date"
                                value="{{ old('head_birth_date', $unit->unitHead?->person?->birth_date?->format('Y-m-d')) }}"
                                class="input input-bordered @error('head_birth_date') input-error @enderror" required>
                            @error('head_birth_date')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Jenis Kelamin <span
                                        class="text-error">*</span></span></label>
                            <div class="flex gap-6">
                                @foreach(\App\Enum\Gender::cases() as $gender)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="head_gender" value="{{ $gender->value }}"
                                        class="radio radio-primary @error('head_gender') radio-error @enderror"
                                        {{ old('head_gender', $unit->unitHead?->person?->gender?->value) == $gender->value ? 'checked' : '' }}
                                        required>
                                    <span>{{ $gender->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('head_gender')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pendidikan Terakhir</span></label>
                            <select name="head_education"
                                class="select select-bordered @error('head_education') select-error @enderror">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach(\App\Enum\PendidikanTerakhir::cases() as $education)
                                <option value="{{ $education->value }}"
                                    {{ old('head_education', $unit->unitHead?->pendidikan_terakhir?->value) == $education->value ? 'selected' : '' }}>
                                    {{ $education->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('head_education')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pekerjaan</span></label>
                            <div
                                class="grid grid-cols-3 gap-2 p-4 border border-base-300 rounded-lg @error('head_job') border-error @enderror">
                                @foreach(\App\Enum\PekerjaanWali::cases() as $pekerjaan)
                                <label class="flex items-center gap-2 cursor-pointer hover:bg-base-200 p-2 rounded">
                                    <input type="checkbox" name="head_job[]" value="{{ $pekerjaan->value }}"
                                        class="checkbox checkbox-sm"
                                        {{ (is_array(old('head_job', $unit->unitHead?->pekerjaan ?? [])) && in_array($pekerjaan->value, old('head_job', $unit->unitHead?->pekerjaan ?? []))) ? 'checked' : '' }}>
                                    <span class="label-text">{{ $pekerjaan->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            <label class="label"><span class="label-text-alt">Pilih satu atau lebih
                                    pekerjaan</span></label>
                            @error('head_job')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>


                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor HP</span></label>
                            <input type="text" name="head_phone"
                                value="{{ old('head_phone', $unit->unitHead?->person?->phone) }}"
                                class="input input-bordered @error('head_phone') input-error @enderror">
                            @error('head_phone')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Admin Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Admin Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Admin</span></label>
                            <input type="text" name="admin_name"
                                value="{{ old('admin_name', $unit->unitAdmin?->person?->full_name) }}"
                                class="input input-bordered @error('admin_name') input-error @enderror">
                            @error('admin_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor HP Admin</span></label>
                            <input type="text" name="admin_phone"
                                value="{{ old('admin_phone', $unit->unitAdmin?->person?->phone) }}"
                                class="input input-bordered @error('admin_phone') input-error @enderror">
                            @error('admin_phone')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Email Admin</span></label>
                            <input type="email" name="admin_email"
                                value="{{ old('admin_email', $unit->unitAdmin?->person?->email) }}"
                                class="input input-bordered @error('admin_email') input-error @enderror">
                            @error('admin_email')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sertifikat -->
            @if(!$unit->hasCertificate())
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Sertifikat Unit</h2>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Upload Sertifikat (PDF/JPG/PNG, max
                                2MB)</span></label>
                        <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png"
                            class="file-input file-input-bordered w-full @error('certificate') file-input-error @enderror">
                        @error('certificate')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('lpptka.units.show', $unit) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

</x-layouts.lpptka>
