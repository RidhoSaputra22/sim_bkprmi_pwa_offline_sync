<x-layouts.tpa title="Edit Profil Unit - {{ $unit->name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.unit.show') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Profil Unit</h1>
                <p class="text-base-content/60">{{ $unit->name }} &bull; {{ $unit->unit_number }}</p>
            </div>
        </div>
    </x-slot:header>

    @if(session('success'))
    <div class="alert alert-success mb-4">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-error mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('tpa.unit.update') }}" method="POST" x-data="{
        provinceId: @js(old('province_id', $currentProvinceId ?? null)),
        cityId: @js(old('city_id', $currentCityId ?? null)),
        districtId: @js(old('district_id', $currentDistrictId ?? null)),
        villageId: @js(old('village_id', $unit->village_id ?? null)),
        cities: [],
        districts: [],
        villages: [],
        isInitializing: true,

        init() {
            if (this.provinceId) {
                this.fetchCities(false).then(() => {
                    setTimeout(() => {
                        this.cityId = @js(old('city_id', $currentCityId ?? null));
                        if (this.cityId) {
                            this.fetchDistricts(false).then(() => {
                                setTimeout(() => {
                                    this.districtId = @js(old('district_id', $currentDistrictId ?? null));
                                    if (this.districtId) {
                                        this.fetchVillages(false).then(() => {
                                            setTimeout(() => {
                                                this.villageId = @js(old('village_id', $unit->village_id ?? null));
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
            if (!this.provinceId) { this.cities = []; this.cityId = ''; this.districts = []; this.districtId = ''; this.villages = []; this.villageId = ''; return; }
            const res = await fetch(`{{ route('tpa.api.cities') }}?province_id=${this.provinceId}`);
            this.cities = await res.json();
            if (resetChild) { this.cityId = ''; this.districts = []; this.districtId = ''; this.villages = []; this.villageId = ''; }
        },

        async fetchDistricts(resetChild = true) {
            if (!this.cityId) { this.districts = []; this.districtId = ''; this.villages = []; this.villageId = ''; return; }
            const res = await fetch(`{{ route('tpa.api.districts') }}?city_id=${this.cityId}`);
            this.districts = await res.json();
            if (resetChild) { this.districtId = ''; this.villages = []; this.villageId = ''; }
        },

        async fetchVillages(resetChild = true) {
            if (!this.districtId) { this.villages = []; this.villageId = ''; return; }
            const res = await fetch(`{{ route('tpa.api.villages') }}?district_id=${this.districtId}`);
            this.villages = await res.json();
            if (resetChild) { this.villageId = ''; }
        }
    }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ============ MAIN COLUMN ============ -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Identitas Unit -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-2">Identitas Unit</h2>

                        <div class="form-control mb-3">
                            <label class="label"><span class="label-text font-medium">Nama Unit <span class="text-error">*</span></span></label>
                            <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                                class="input input-bordered @error('name') input-error @enderror"
                                placeholder="Nama TPA/TPQ" required />
                            @error('name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Email</span></label>
                                <input type="email" name="email" value="{{ old('email', $unit->email) }}"
                                    class="input input-bordered @error('email') input-error @enderror"
                                    placeholder="email@unit.com" />
                                @error('email') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">No. Telepon</span></label>
                                <input type="text" name="phone" value="{{ old('phone', $unit->phone) }}"
                                    class="input input-bordered @error('phone') input-error @enderror"
                                    placeholder="08xxxxxxxxxx" />
                                @error('phone') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Nama Masjid/Mushalla</span></label>
                                <input type="text" name="mosque_name" value="{{ old('mosque_name', $unit->mosque_name) }}"
                                    class="input input-bordered @error('mosque_name') input-error @enderror"
                                    placeholder="Masjid Al-..." />
                                @error('mosque_name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Lembaga Pendiri</span></label>
                                <input type="text" name="founder" value="{{ old('founder', $unit->founder) }}"
                                    class="input input-bordered @error('founder') input-error @enderror"
                                    placeholder="Nama lembaga pendiri" />
                                @error('founder') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Tipe Lokasi</span></label>
                                <select name="tipe_lokasi" class="select select-bordered @error('tipe_lokasi') select-error @enderror">
                                    <option value="">-- Pilih Tipe Lokasi --</option>
                                    @foreach($tipeLokasiOptions as $opt)
                                    <option value="{{ $opt->value }}" {{ old('tipe_lokasi', $unit->tipe_lokasi?->value) === $opt->value ? 'selected' : '' }}>
                                        {{ $opt->getLabel() }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tipe_lokasi') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Status Bangunan</span></label>
                                <select name="status_bangunan" class="select select-bordered @error('status_bangunan') select-error @enderror">
                                    <option value="">-- Pilih Status Bangunan --</option>
                                    @foreach($statusBangunanOptions as $opt)
                                    <option value="{{ $opt->value }}" {{ old('status_bangunan', $unit->status_bangunan?->value) === $opt->value ? 'selected' : '' }}>
                                        {{ $opt->getLabel() }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status_bangunan') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Waktu Kegiatan -->
                        <div class="form-control mt-3">
                            <label class="label"><span class="label-text font-medium">Waktu Kegiatan <span class="text-error">*</span></span></label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                @foreach($waktuKegiatanOptions as $opt)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="waktu_kegiatan[]" value="{{ $opt->value }}"
                                        class="checkbox checkbox-primary"
                                        {{ in_array($opt->value, old('waktu_kegiatan', $unit->waktu_kegiatan ?? [])) ? 'checked' : '' }} />
                                    <span>{{ $opt->getLabel() }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('waktu_kegiatan') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-2">Alamat</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Provinsi -->
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Provinsi <span class="text-error">*</span></span></label>
                                <select name="province_id" class="select select-bordered"
                                    x-model="provinceId" @change="fetchCities()">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kota/Kabupaten <span class="text-error">*</span></span></label>
                                <select name="city_id" class="select select-bordered"
                                    x-model="cityId" @change="fetchDistricts()" :disabled="cities.length === 0">
                                    <option value="">-- Pilih Kota --</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kecamatan <span class="text-error">*</span></span></label>
                                <select name="district_id" class="select select-bordered"
                                    x-model="districtId" @change="fetchVillages()" :disabled="districts.length === 0">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="district in districts" :key="district.id">
                                        <option :value="district.id" x-text="district.name"></option>
                                    </template>
                                </select>
                            </div>

                            <!-- Kelurahan -->
                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">Kelurahan <span class="text-error">*</span></span></label>
                                <select name="village_id" class="select select-bordered @error('village_id') select-error @enderror"
                                    x-model="villageId" :disabled="villages.length === 0">
                                    <option value="">-- Pilih Kelurahan --</option>
                                    <template x-for="village in villages" :key="village.id">
                                        <option :value="village.id" x-text="village.name"></option>
                                    </template>
                                </select>
                                @error('village_id') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Alamat Detail -->
                            <div class="form-control md:col-span-2">
                                <label class="label"><span class="label-text font-medium">Alamat / Jalan</span></label>
                                <input type="text" name="address" value="{{ old('address', $unit->address) }}"
                                    class="input input-bordered"
                                    placeholder="Nama jalan, nomor rumah, dll." />
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">RT</span></label>
                                <input type="text" name="rt" value="{{ old('rt', $unit->rt) }}"
                                    class="input input-bordered" placeholder="001" maxlength="5" />
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-medium">RW</span></label>
                                <input type="text" name="rw" value="{{ old('rw', $unit->rw) }}"
                                    class="input input-bordered" placeholder="001" maxlength="5" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============ SIDEBAR COLUMN ============ -->
            <div class="space-y-6">

                <!-- Jumlah Santri -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title text-base mb-2">Jumlah Santri</h2>

                        <div class="form-control mb-3">
                            <label class="label"><span class="label-text font-medium">TKA</span></label>
                            <input type="number" name="jumlah_tka" value="{{ old('jumlah_tka', $unit->jumlah_tka ?? 0) }}"
                                class="input input-bordered @error('jumlah_tka') input-error @enderror"
                                min="0" placeholder="0" />
                            @error('jumlah_tka') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control mb-3">
                            <label class="label"><span class="label-text font-medium">TPA</span></label>
                            <input type="number" name="jumlah_tpa" value="{{ old('jumlah_tpa', $unit->jumlah_tpa ?? 0) }}"
                                class="input input-bordered @error('jumlah_tpa') input-error @enderror"
                                min="0" placeholder="0" />
                            @error('jumlah_tpa') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">TQA</span></label>
                            <input type="number" name="jumlah_tqa" value="{{ old('jumlah_tqa', $unit->jumlah_tqa ?? 0) }}"
                                class="input input-bordered @error('jumlah_tqa') input-error @enderror"
                                min="0" placeholder="0" />
                            @error('jumlah_tqa') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Jumlah Guru -->
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title text-base mb-2">Jumlah Guru Mengaji</h2>

                        <div class="form-control mb-3">
                            <label class="label"><span class="label-text font-medium">Laki-laki</span></label>
                            <input type="number" name="guru_laki" value="{{ old('guru_laki', $unit->guru_laki ?? 0) }}"
                                class="input input-bordered @error('guru_laki') input-error @enderror"
                                min="0" placeholder="0" />
                            @error('guru_laki') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Perempuan</span></label>
                            <input type="number" name="guru_perempuan" value="{{ old('guru_perempuan', $unit->guru_perempuan ?? 0) }}"
                                class="input input-bordered @error('guru_perempuan') input-error @enderror"
                                min="0" placeholder="0" />
                            @error('guru_perempuan') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Unit (read-only) -->
                <div class="card bg-base-200 shadow">
                    <div class="card-body">
                        <h2 class="card-title text-base mb-2">Info Unit</h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-base-content/60">Nomor Unit</span>
                                <span class="font-mono font-medium">{{ $unit->unit_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-base-content/60">Status</span>
                                <span class="badge badge-{{ $unit->approval_status->getColor() }} badge-sm">
                                    {{ $unit->approval_status->getLabel() }}
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-base-content/40 mt-3">Nomor unit dan status tidak dapat diubah melalui halaman ini.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-full gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>

                <a href="{{ route('tpa.unit.show') }}" class="btn btn-ghost w-full">Batal</a>
            </div>

        </div>
    </form>
</x-layouts.tpa>
