<x-layouts.lpptka title="Daftar Unit TPA Baru">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.units.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Daftar Unit TPA Baru</h1>
                <p class="text-base-content/60">Isi data profil TPA baru</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('lpptka.units.store') }}" method="POST" enctype="multipart/form-data" x-data="{
        provinceId: @js(old('province_id')),
        cityId: @js(old('city_id')),
        districtId: @js(old('district_id')),
        villageId: @js(old('village_id')),
        cities: [],
        districts: [],
        villages: [],
        isInitializing: true,
        initialCityId: @js(old('city_id')),
        initialDistrictId: @js(old('district_id')),
        initialVillageId: @js(old('village_id')),

        init() {
            if (this.provinceId) {
                this.fetchCities(false).then(() => {
                    this.$nextTick(() => {
                        this.cityId = this.initialCityId;
                    });

                    if (this.initialCityId) {
                        this.fetchDistricts(false).then(() => {
                            this.$nextTick(() => {
                                this.districtId = this.initialDistrictId;
                            });

                            if (this.initialDistrictId) {
                                this.fetchVillages(false).then(() => {
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
    }">
        @csrf

        @if ($errors->any())
        <div class="alert alert-error shadow mb-6">
            <div>
                <div class="font-semibold">Form belum valid</div>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="space-y-6">
            <!-- Identitas Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Identitas Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor Unit <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="unit_number" value="{{ old('unit_number') }}"
                                class="input input-bordered @error('unit_number') input-error @enderror"
                                placeholder="Contoh: 001/TPA/2026" required>
                            @error('unit_number')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama TK/TP Al Qur'an <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="input input-bordered @error('name') input-error @enderror"
                                placeholder="Contoh: TPA Al-Ikhlas" required>
                            @error('name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Lokasi Kegiatan <span
                                        class="text-error">*</span></span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\TipeLokasi::cases() as $tipe)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tipe_lokasi" value="{{ $tipe->value }}"
                                        class="radio radio-primary @error('tipe_lokasi') radio-error @enderror"
                                        {{ old('tipe_lokasi') == $tipe->value ? 'checked' : '' }} required>
                                    <span>{{ $tipe->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('tipe_lokasi')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Status Gedung <span
                                        class="text-error">*</span></span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\StatusBangunan::cases() as $status)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_bangunan" value="{{ $status->value }}"
                                        class="radio radio-primary @error('status_bangunan') radio-error @enderror"
                                        {{ old('status_bangunan') == $status->value ? 'checked' : '' }} required>
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
                            <input type="text" name="mosque_name" value="{{ old('mosque_name') }}"
                                class="input input-bordered @error('mosque_name') input-error @enderror"
                                placeholder="Contoh: Masjid Al-Ikhlas">
                            @error('mosque_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Lembaga Pendiri/Penyelenggara</span></label>
                            <input type="text" name="founder" value="{{ old('founder') }}"
                                class="input input-bordered @error('founder') input-error @enderror"
                                placeholder="Contoh: Yayasan Al-Ikhlas">
                            @error('founder')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Mulai Terbentuk pada Tanggal</span></label>
                            <input type="date" name="founded_date" value="{{ old('founded_date') }}"
                                class="input input-bordered @error('founded_date') input-error @enderror">
                            @error('founded_date')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Bergabung Dengan LPPTKA Pada
                                    Tahun</span></label>
                            <input type="number" name="joined_lpptka_year" value="{{ old('joined_lpptka_year') }}"
                                class="input input-bordered @error('joined_lpptka_year') input-error @enderror"
                                placeholder="Contoh: 2026" min="1900" max="2100">
                            @error('joined_lpptka_year')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Jam Kegiatan <span
                                        class="text-error">*</span></span></label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(\App\Enum\WaktuKegiatan::cases() as $waktu)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="waktu_kegiatan" value="{{ $waktu->value }}"
                                        class="radio radio-primary @error('waktu_kegiatan') radio-error @enderror"
                                        {{ old('waktu_kegiatan') == $waktu->value ? 'checked' : '' }} required>
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
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="input input-bordered @error('email') input-error @enderror"
                                placeholder="email@example.com">
                            @error('email')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">No. Telepon</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="input input-bordered @error('phone') input-error @enderror"
                                placeholder="08xxxxxxxxxx">
                            @error('phone')
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
                                    {{ old('province_id') == $province->id ? 'selected' : '' }}>
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
                                    <option :value="city.id" x-text="city.name"></option>
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
                                    <option :value="district.id" x-text="district.name"></option>
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
                                    <option :value="village.id" x-text="village.name"></option>
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
                                placeholder="Alamat jalan lengkap">{{ old('jalan') }}</textarea>
                            @error('jalan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">RT</span></label>
                            <input type="text" name="rt" value="{{ old('rt') }}"
                                class="input input-bordered @error('rt') input-error @enderror" placeholder="001"
                                maxlength="5">
                            @error('rt')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">RW</span></label>
                            <input type="text" name="rw" value="{{ old('rw') }}"
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
                            <input type="number" name="jumlah_tka" value="{{ old('jumlah_tka', 0) }}"
                                class="input input-bordered @error('jumlah_tka') input-error @enderror" placeholder="0"
                                min="0">
                            @error('jumlah_tka')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah TPA (Usia 7-12 Tahun)</span></label>
                            <input type="number" name="jumlah_tpa" value="{{ old('jumlah_tpa', 0) }}"
                                class="input input-bordered @error('jumlah_tpa') input-error @enderror" placeholder="0"
                                min="0">
                            @error('jumlah_tpa')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah TQA (Telah Wisuda)</span></label>
                            <input type="number" name="jumlah_tqa" value="{{ old('jumlah_tqa', 0) }}"
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
                            <input type="number" name="guru_laki" value="{{ old('guru_laki', 0) }}"
                                class="input input-bordered @error('guru_laki') input-error @enderror" placeholder="0"
                                min="0">
                            @error('guru_laki')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Perempuan</span></label>
                            <input type="number" name="guru_perempuan" value="{{ old('guru_perempuan', 0) }}"
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
                            <input type="text" name="head_name" value="{{ old('head_name') }}"
                                class="input input-bordered @error('head_name') input-error @enderror"
                                placeholder="Nama lengkap kepala unit" required>
                            @error('head_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">NIK</span></label>
                            <input type="text" name="head_nik" value="{{ old('head_nik') }}"
                                class="input input-bordered @error('head_nik') input-error @enderror"
                                placeholder="16 digit NIK" maxlength="16">
                            @error('head_nik')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tempat Lahir <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="head_birth_place" value="{{ old('head_birth_place') }}"
                                class="input input-bordered @error('head_birth_place') input-error @enderror"
                                placeholder="Contoh: Jakarta" required>
                            @error('head_birth_place')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir <span
                                        class="text-error">*</span></span></label>
                            <input type="date" name="head_birth_date" value="{{ old('head_birth_date') }}"
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
                                        {{ old('head_gender') == $gender->value ? 'checked' : '' }} required>
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
                                    {{ old('head_education') == $education->value ? 'selected' : '' }}>
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
                            <div class="grid grid-cols-3 gap-2 p-4 border border-base-300 rounded-lg @error('head_job') border-error @enderror">
                                @foreach(\App\Enum\PekerjaanWali::cases() as $pekerjaan)
                                <label class="flex items-center gap-2 cursor-pointer hover:bg-base-200 p-2 rounded">
                                    <input type="checkbox" name="head_job[]" value="{{ $pekerjaan->value }}"
                                        class="checkbox checkbox-sm"
                                        {{ (is_array(old('head_job')) && in_array($pekerjaan->value, old('head_job'))) ? 'checked' : '' }}>
                                    <span class="label-text">{{ $pekerjaan->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            <label class="label"><span class="label-text-alt">Pilih satu atau lebih pekerjaan</span></label>
                            @error('head_job')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor HP</span></label>
                            <input type="text" name="head_phone" value="{{ old('head_phone') }}"
                                class="input input-bordered @error('head_phone') input-error @enderror"
                                placeholder="08xxxxxxxxxx">
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
                            <input type="text" name="admin_name" value="{{ old('admin_name') }}"
                                class="input input-bordered @error('admin_name') input-error @enderror"
                                placeholder="Nama lengkap admin">
                            @error('admin_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nomor HP Admin</span></label>
                            <input type="text" name="admin_phone" value="{{ old('admin_phone') }}"
                                class="input input-bordered @error('admin_phone') input-error @enderror"
                                placeholder="08xxxxxxxxxx">
                            @error('admin_phone')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Email Admin</span></label>
                            <input type="email" name="admin_email" value="{{ old('admin_email') }}"
                                class="input input-bordered @error('admin_email') input-error @enderror"
                                placeholder="admin@example.com">
                            @error('admin_email')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sertifikat -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Sertifikat Unit</h2>
                    <p class="text-sm text-base-content/60 mb-4">
                        Upload sertifikat unit TPA. Sertifikat diperlukan untuk proses approval oleh SuperAdmin.
                    </p>

                    <div class="form-control">
                        <label class="label"><span class="label-text">File Sertifikat (PDF/JPG/PNG, max
                                2MB)</span></label>
                        <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png"
                            class="file-input file-input-bordered w-full @error('certificate') file-input-error @enderror">
                        @error('certificate')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('lpptka.units.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Unit
                </button>
            </div>
        </div>
    </form>

</x-layouts.lpptka>
