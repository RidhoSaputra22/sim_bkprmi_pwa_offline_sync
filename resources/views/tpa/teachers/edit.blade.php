<x-layouts.tpa title="Edit Data Guru">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.teachers.show', $teacher) }}" class="btn btn-circle btn-ghost">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Data Guru</h1>
                <p class="text-base-content/60">{{ $teacher->full_name }}</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('tpa.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

        <!-- IDENTITAS -->
        <div class="card bg-base-100 shadow mb-6">
            <div class="card-body">
                <h2 class="card-title mb-4 text-primary">IDENTITAS</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIK -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">NIK <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="nik" value="{{ old('nik', $teacher->nik) }}" maxlength="16"
                            class="input input-bordered @error('nik') input-error @enderror" required>
                        @error('nik')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Nama Lengkap <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $teacher->full_name) }}"
                            class="input input-bordered @error('full_name') input-error @enderror" required>
                        @error('full_name')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Tempat Lahir <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $teacher->birth_place) }}"
                            class="input input-bordered @error('birth_place') input-error @enderror" required>
                        @error('birth_place')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Tanggal Lahir <span
                                    class="text-error">*</span></span></label>
                        <input type="date" name="birth_date"
                            value="{{ old('birth_date', $teacher->birth_date->format('Y-m-d')) }}"
                            class="input input-bordered @error('birth_date') input-error @enderror" required>
                        @error('birth_date')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Jenis Kelamin <span
                                    class="text-error">*</span></span></label>
                        <div class="flex gap-4">
                            @foreach($genders as $gender)
                            <label class="label cursor-pointer gap-2">
                                <input type="radio" name="gender" value="{{ $gender->value }}"
                                    class="radio radio-primary" {{ old('gender', $teacher->gender->value) ==
                                    $gender->value ? 'checked' : '' }} required>
                                <span class="label-text">{{ $gender->getLabel() }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('gender')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Pendidikan Terakhir -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Pendidikan Terakhir</span></label>
                        <select name="education_level_id"
                            class="select select-bordered @error('education_level_id') select-error @enderror">
                            <option value="">Pilih Pendidikan</option>
                            @foreach($educationLevels as $level)
                            <option value="{{ $level->id }}" {{ old('education_level_id',
                                $teacher->education_level_id)==$level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('education_level_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Pekerjaan Utama -->
                    <div class="col-span-full">
                        <x-ui.select name="pekerjaan" label="Pekerjaan Utama Sesuai KK"
                            :options="array_map(fn($job) => ['value' => $job->value, 'label' => $job->getLabel()], $pekerjaanOptions)"
                            :value="old('pekerjaan', $teacher->pekerjaan[0] ?? null)"
                            placeholder="-- Pilih Pekerjaan --" searchPlaceholder="Cari pekerjaan..." />
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Nomor HP <span
                                    class="text-error">*</span></span></label>
                        <input type="tel" name="phone" value="{{ old('phone', $teacher->phone) }}"
                            class="input input-bordered @error('phone') input-error @enderror" required>
                        @error('phone')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Upload Foto ½ Badan (Max 1 MB)</span></label>
                        @if($teacher->photo_path)
                        <div class="mb-2">
                            <img src="{{ Storage::url($teacher->photo_path) }}" alt="Current photo"
                                class="w-32 h-32 object-cover rounded">
                            <p class="text-sm text-base-content/60 mt-1">Foto saat ini</p>
                        </div>
                        @endif
                        <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png"
                            class="file-input file-input-bordered @error('photo') file-input-error @enderror">
                        <label class="label"><span class="label-text-alt">Format: JPG, JPEG, PNG. Kosongkan jika tidak
                                ingin mengubah.</span></label>
                        @error('photo')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-primary" {{
                                old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                            <span class="label-text">Guru Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ALAMAT -->
        <div class="card bg-base-100 shadow mb-6">
            <div class="card-body">
                <h2 class="card-title mb-4 text-primary">ALAMAT</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Provinsi -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Provinsi</span></label>
                        <select name="province_id" id="province_id"
                            class="select select-bordered @error('province_id') select-error @enderror">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id',
                                $teacher->province_id)==$province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('province_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Kab/Kota -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Kab/Kota</span></label>
                        <select name="city_id" id="city_id"
                            class="select select-bordered @error('city_id') select-error @enderror">
                            <option value="">Pilih Kab/Kota</option>
                            @if($teacher->city_id)
                            <option value="{{ $teacher->city_id }}" selected>{{ $teacher->city->name }}</option>
                            @endif
                        </select>
                        @error('city_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Kecamatan</span></label>
                        <select name="district_id" id="district_id"
                            class="select select-bordered @error('district_id') select-error @enderror">
                            <option value="">Pilih Kecamatan</option>
                            @if($teacher->district_id)
                            <option value="{{ $teacher->district_id }}" selected>{{ $teacher->district->name }}
                            </option>
                            @endif
                        </select>
                        @error('district_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Kelurahan -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Kelurahan/Desa</span></label>
                        <select name="village_id" id="village_id"
                            class="select select-bordered @error('village_id') select-error @enderror">
                            <option value="">Pilih Kelurahan/Desa</option>
                            @if($teacher->village_id)
                            <option value="{{ $teacher->village_id }}" selected>{{ $teacher->village->name }}</option>
                            @endif
                        </select>
                        @error('village_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Jalan -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Jalan</span></label>
                        <input type="text" name="jalan" value="{{ old('jalan', $teacher->jalan) }}"
                            class="input input-bordered @error('jalan') input-error @enderror">
                        @error('jalan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- RT -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">RT</span></label>
                        <input type="text" name="rt" value="{{ old('rt', $teacher->rt) }}"
                            class="input input-bordered @error('rt') input-error @enderror">
                        @error('rt')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- RW -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">RW</span></label>
                        <input type="text" name="rw" value="{{ old('rw', $teacher->rw) }}"
                            class="input input-bordered @error('rw') input-error @enderror">
                        @error('rw')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- JABATAN -->
        <div class="card bg-base-100 shadow mb-6">
            <div class="card-body">
                <h2 class="card-title mb-4 text-primary">JABATAN</h2>

                <!-- Tugas Utama -->
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Tugas Utama di TK/TPA <span
                                class="text-error">*</span></span></label>
                    <select name="jabatan_utama"
                        class="select select-bordered @error('jabatan_utama') select-error @enderror" required>
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatanOptions as $jabatan)
                        <option value="{{ $jabatan->value }}" {{ old('jabatan_utama',
                            $teacher->jabatan_utama->value)==$jabatan->value ? 'selected' : '' }}>
                            {{ $jabatan->label() }}
                        </option>
                        @endforeach
                    </select>
                    @error('jabatan_utama')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <!-- Tugas Tambahan -->
                <div class="form-control">
                    <label class="label"><span class="label-text">Tugas Tambahan</span></label>
                    <div class="space-y-2">
                        @foreach($tugasTambahanOptions as $tugas)
                        <label class="label cursor-pointer justify-start gap-2">
                            <input type="checkbox" name="tugas_tambahan[]" value="{{ $tugas->value }}"
                                class="checkbox checkbox-primary" {{ in_array($tugas->value, old('tugas_tambahan',
                                $teacher->tugas_tambahan ?? [])) ? 'checked' : '' }}>
                            <span class="label-text">{{ $tugas->label() }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('tugas_tambahan')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>
        </div>

        <!-- RIWAYAT PELATIHAN -->
        <div class="card bg-base-100 shadow mb-6">
            <div class="card-body">
                <h2 class="card-title mb-4 text-primary">RIWAYAT PELATIHAN (BKPRMI)</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- LMD -->
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Latihan Mujahid Dakwah <span
                                        class="text-error">*</span></span></label>
                            <select name="level_lmd"
                                class="select select-bordered @error('level_lmd') select-error @enderror" required>
                                @foreach($levelLMDOptions as $level)
                                <option value="{{ $level->value }}" {{ old('level_lmd',
                                    $teacher->level_lmd->value)==$level->value ? 'selected' : '' }}>
                                    {{ $level->label() }}
                                </option>
                                @endforeach
                            </select>
                            @error('level_lmd')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            @if($teacher->sertifikat_lmd_path)
                            <div class="mb-2">
                                <a href="{{ Storage::url($teacher->sertifikat_lmd_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline btn-info">
                                    Lihat Sertifikat Saat Ini
                                </a>
                            </div>
                            @endif
                            <label class="label"><span class="label-text">Upload Sertifikat Kelulusan (PDF, Max 1
                                    MB)</span></label>
                            <input type="file" name="sertifikat_lmd" accept="application/pdf"
                                class="file-input file-input-bordered @error('sertifikat_lmd') file-input-error @enderror">
                            <label class="label"><span class="label-text-alt">Kosongkan jika tidak ingin
                                    mengubah.</span></label>
                            @error('sertifikat_lmd')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>

                    <!-- Pelatihan Guru Mengaji -->
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Pelatihan Guru Mengaji <span
                                        class="text-error">*</span></span></label>
                            <select name="level_pelatihan_guru"
                                class="select select-bordered @error('level_pelatihan_guru') select-error @enderror"
                                required>
                                @foreach($levelPelatihanOptions as $level)
                                <option value="{{ $level->value }}" {{ old('level_pelatihan_guru',
                                    $teacher->level_pelatihan_guru->value)==$level->value ? 'selected' : '' }}>
                                    {{ $level->label() }}
                                </option>
                                @endforeach
                            </select>
                            @error('level_pelatihan_guru')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            @if($teacher->sertifikat_pelatihan_path)
                            <div class="mb-2">
                                <a href="{{ Storage::url($teacher->sertifikat_pelatihan_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline btn-warning">
                                    Lihat Sertifikat Saat Ini
                                </a>
                            </div>
                            @endif
                            <label class="label"><span class="label-text">Upload Sertifikat (PDF, Max 1
                                    MB)</span></label>
                            <input type="file" name="sertifikat_pelatihan" accept="application/pdf"
                                class="file-input file-input-bordered @error('sertifikat_pelatihan') file-input-error @enderror">
                            <label class="label"><span class="label-text-alt">Kosongkan jika tidak ingin
                                    mengubah.</span></label>
                            @error('sertifikat_pelatihan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('tpa.teachers.show', $teacher) }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Update Data Guru</button>
        </div>
    </form>

    @push('scripts')
    <script>
    // Location cascading select
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province_id');
        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('district_id');
        const villageSelect = document.getElementById('village_id');

        // Load cities on page load if province is selected
        if (provinceSelect.value) {
            loadCities(provinceSelect.value, '{{ old('
                city_id ', $teacher->city_id) }}');
        }

        // Load districts on page load if city is selected
        if (citySelect.value) {
            loadDistricts(citySelect.value, '{{ old('
                district_id ', $teacher->district_id) }}');
        }

        // Load villages on page load if district is selected
        if (districtSelect.value) {
            loadVillages(districtSelect.value, '{{ old('
                village_id ', $teacher->village_id) }}');
        }

        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            districtSelect.innerHTML = '<option value="">Pilih Kab/Kota dulu</option>';
            districtSelect.disabled = true;
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan dulu</option>';
            villageSelect.disabled = true;

            if (provinceId) {
                loadCities(provinceId);
            } else {
                citySelect.innerHTML = '<option value="">Pilih Provinsi dulu</option>';
                citySelect.disabled = true;
            }
        });

        citySelect.addEventListener('change', function() {
            const cityId = this.value;
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan dulu</option>';
            villageSelect.disabled = true;

            if (cityId) {
                loadDistricts(cityId);
            } else {
                districtSelect.innerHTML = '<option value="">Pilih Kab/Kota dulu</option>';
                districtSelect.disabled = true;
            }
        });

        districtSelect.addEventListener('change', function() {
            const districtId = this.value;

            if (districtId) {
                loadVillages(districtId);
            } else {
                villageSelect.innerHTML = '<option value="">Pilih Kecamatan dulu</option>';
                villageSelect.disabled = true;
            }
        });

        function loadCities(provinceId, selectedId = null) {
            citySelect.innerHTML = '<option value="">Loading...</option>';
            citySelect.disabled = true;

            fetch(`{{ route('tpa.api.cities') }}?province_id=${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
                    data.forEach(city => {
                        const selected = selectedId && city.id == selectedId ? 'selected' : '';
                        citySelect.innerHTML +=
                            `<option value="${city.id}" ${selected}>${city.name}</option>`;
                    });
                    citySelect.disabled = false;
                });
        }

        function loadDistricts(cityId, selectedId = null) {
            districtSelect.innerHTML = '<option value="">Loading...</option>';
            districtSelect.disabled = true;

            fetch(`{{ route('tpa.api.districts') }}?city_id=${cityId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(district => {
                        const selected = selectedId && district.id == selectedId ? 'selected' : '';
                        districtSelect.innerHTML +=
                            `<option value="${district.id}" ${selected}>${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                });
        }

        function loadVillages(districtId, selectedId = null) {
            villageSelect.innerHTML = '<option value="">Loading...</option>';
            villageSelect.disabled = true;

            fetch(`{{ route('tpa.api.villages') }}?district_id=${districtId}`)
                .then(response => response.json())
                .then(data => {
                    villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
                    data.forEach(village => {
                        const selected = selectedId && village.id == selectedId ? 'selected' : '';
                        villageSelect.innerHTML +=
                            `<option value="${village.id}" ${selected}>${village.name}</option>`;
                    });
                    villageSelect.disabled = false;
                });
        }
    });
    </script>
    @endpush
</x-layouts.tpa>
