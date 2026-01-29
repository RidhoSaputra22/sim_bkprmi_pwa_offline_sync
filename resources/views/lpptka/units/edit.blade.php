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

    <form action="{{ route('lpptka.units.update', $unit) }}" method="POST" enctype="multipart/form-data"
        x-data="unitForm({
            provinceId: @js(old('province_id', $currentProvinceId ?? null)),
            cityId: @js(old('city_id', $currentCityId ?? null)),
            districtId: @js(old('district_id', $currentDistrictId ?? null)),
            villageId: @js(old('village_id', $unit->village_id ?? null)),
        })">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Identitas Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Identitas Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Unit TPA <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="name" value="{{ old('name', $unit->name) }}"
                                class="input input-bordered @error('name') input-error @enderror" required>
                            @error('name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Masjid/Mushalla</span></label>
                            <input type="text" name="mosque_name" value="{{ old('mosque_name', $unit->mosque_name) }}"
                                class="input input-bordered @error('mosque_name') input-error @enderror">
                            @error('mosque_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tipe Lokasi</span></label>
                            <select name="tipe_lokasi"
                                class="select select-bordered @error('tipe_lokasi') select-error @enderror">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach(\App\Enum\TipeLokasi::cases() as $tipe)
                                <option value="{{ $tipe->value }}"
                                    {{ old('tipe_lokasi', $unit->tipe_lokasi?->value) == $tipe->value ? 'selected' : '' }}>
                                    {{ $tipe->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('tipe_lokasi')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Status Bangunan</span></label>
                            <select name="status_bangunan"
                                class="select select-bordered @error('status_bangunan') select-error @enderror">
                                <option value="">-- Pilih Status --</option>
                                @foreach(\App\Enum\StatusBangunan::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status_bangunan', $unit->status_bangunan?->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('status_bangunan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Waktu Kegiatan</span></label>
                            <select name="waktu_kegiatan"
                                class="select select-bordered @error('waktu_kegiatan') select-error @enderror">
                                <option value="">-- Pilih Waktu --</option>
                                @foreach(\App\Enum\WaktuKegiatan::cases() as $waktu)
                                <option value="{{ $waktu->value }}"
                                    {{ old('waktu_kegiatan', $unit->waktu_kegiatan?->value) == $waktu->value ? 'selected' : '' }}>
                                    {{ $waktu->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('waktu_kegiatan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Lembaga Pendiri</span></label>
                            <input type="text" name="founder" value="{{ old('founder', $unit->founder) }}"
                                class="input input-bordered @error('founder') input-error @enderror">
                            @error('founder')
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

                        <div class="form-control">
                            <label class="label"><span class="label-text">No. Telepon</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $unit->phone) }}"
                                class="input input-bordered @error('phone') input-error @enderror">
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
                            <select name="province_id" x-model="provinceId" @change="loadCities()"
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
                            <label class="label"><span class="label-text">Kota/Kabupaten <span
                                        class="text-error">*</span></span></label>
                            <select name="city_id" x-model="cityId" @change="loadDistricts()"
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
                            <select name="district_id" x-model="districtId" @change="loadVillages()"
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
                    </div>
                </div>
            </div>

            <!-- Kepala Unit -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Kepala Unit</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Lengkap <span
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
                            <label class="label"><span class="label-text">Jenis Kelamin</span></label>
                            <select name="head_gender"
                                class="select select-bordered @error('head_gender') select-error @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Enum\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ old('head_gender', $unit->unitHead?->person?->gender?->value) == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('head_gender')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">No. HP</span></label>
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