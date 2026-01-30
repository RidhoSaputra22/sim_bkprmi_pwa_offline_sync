<x-layouts.tpa title="Tambah Data Guru">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.teachers.index') }}" class="btn btn-circle btn-ghost">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Tambah Data Guru</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('tpa.teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- IDENTITAS -->
        <div class="card bg-base-100 shadow mb-6">
            <div class="card-body">
                <h2 class="card-title mb-4 text-primary">IDENTITAS</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIK -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">NIK <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                            class="input input-bordered @error('nik') input-error @enderror" required>
                        @error('nik')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Nama Lengkap <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                            class="input input-bordered @error('full_name') input-error @enderror" required>
                        @error('full_name')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Tempat Lahir <span
                                    class="text-error">*</span></span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                            class="input input-bordered @error('birth_place') input-error @enderror" required>
                        @error('birth_place')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Tanggal Lahir <span
                                    class="text-error">*</span></span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
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
                                    class="radio radio-primary" {{ old('gender')==$gender->value ? 'checked' : '' }}
                                    required>
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
                            <option value="{{ $level->id }}" {{ old('education_level_id')==$level->id ? 'selected' : ''
                                }}>
                                {{ $level->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('education_level_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Pekerjaan Utama (Multi-Select) -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Pekerjaan Utama Sesuai KK</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 border border-base-300 rounded-lg p-4">
                            @foreach($pekerjaanOptions as $pekerjaan)
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="checkbox" name="pekerjaan[]" value="{{ $pekerjaan->value }}"
                                    class="checkbox checkbox-primary" {{ in_array($pekerjaan->value, old('pekerjaan', [])) ? 'checked' : '' }}>
                                <span class="label-text">{{ $pekerjaan->getLabel() }}</span>
                            </label>
                            @endforeach
                        </div>
                        <label class="label"><span class="label-text-alt">Dapat memilih lebih dari satu</span></label>
                        @error('pekerjaan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Nomor HP <span
                                    class="text-error">*</span></span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="input input-bordered @error('phone') input-error @enderror" required>
                        @error('phone')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Upload Foto ½ Badan (Max 1 MB)</span></label>
                        <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png"
                            class="file-input file-input-bordered @error('photo') file-input-error @enderror">
                        <label class="label"><span class="label-text-alt">Format: JPG, JPEG, PNG</span></label>
                        @error('photo')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
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
                            <option value="{{ $province->id }}" {{ old('province_id')==$province->id ? 'selected' : ''
                                }}>
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
                            class="select select-bordered @error('city_id') select-error @enderror" disabled>
                            <option value="">Pilih Provinsi dulu</option>
                        </select>
                        @error('city_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Kecamatan</span></label>
                        <select name="district_id" id="district_id"
                            class="select select-bordered @error('district_id') select-error @enderror" disabled>
                            <option value="">Pilih Kab/Kota dulu</option>
                        </select>
                        @error('district_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Kelurahan -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">Kelurahan/Desa</span></label>
                        <select name="village_id" id="village_id"
                            class="select select-bordered @error('village_id') select-error @enderror" disabled>
                            <option value="">Pilih Kecamatan dulu</option>
                        </select>
                        @error('village_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Jalan -->
                    <div class="form-control col-span-full">
                        <label class="label"><span class="label-text">Jalan</span></label>
                        <input type="text" name="jalan" value="{{ old('jalan') }}"
                            class="input input-bordered @error('jalan') input-error @enderror">
                        @error('jalan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- RT -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">RT</span></label>
                        <input type="text" name="rt" value="{{ old('rt') }}"
                            class="input input-bordered @error('rt') input-error @enderror">
                        @error('rt')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- RW -->
                    <div class="form-control">
                        <label class="label"><span class="label-text">RW</span></label>
                        <input type="text" name="rw" value="{{ old('rw') }}"
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
                        <option value="{{ $jabatan->value }}" {{ old('jabatan_utama')==$jabatan->value ? 'selected' :
                            '' }}>
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
                                [])) ? 'checked' : '' }}>
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
                                <option value="{{ $level->value }}" {{ old('level_lmd')==$level->value ? 'selected' :
                                    '' }}>
                                    {{ $level->label() }}
                                </option>
                                @endforeach
                            </select>
                            @error('level_lmd')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Upload Sertifikat Kelulusan (PDF, Max 1
                                    MB)</span></label>
                            <input type="file" name="sertifikat_lmd" accept="application/pdf"
                                class="file-input file-input-bordered @error('sertifikat_lmd') file-input-error @enderror">
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
                                <option value="{{ $level->value }}" {{ old('level_pelatihan_guru')==$level->value ?
                                    'selected' : '' }}>
                                    {{ $level->label() }}
                                </option>
                                @endforeach
                            </select>
                            @error('level_pelatihan_guru')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Upload Sertifikat (PDF, Max 1
                                    MB)</span></label>
                            <input type="file" name="sertifikat_pelatihan" accept="application/pdf"
                                class="file-input file-input-bordered @error('sertifikat_pelatihan') file-input-error @enderror">
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
            <a href="{{ route('tpa.teachers.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Data Guru</button>
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

            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                citySelect.innerHTML = '<option value="">Loading...</option>';
                citySelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Pilih Kab/Kota dulu</option>';
                districtSelect.disabled = true;
                villageSelect.innerHTML = '<option value="">Pilih Kecamatan dulu</option>';
                villageSelect.disabled = true;

                if (provinceId) {
                    fetch(`{{ route('tpa.api.cities') }}?province_id=${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
                            data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                            });
                            citySelect.disabled = false;
                        });
                }
            });

            citySelect.addEventListener('change', function() {
                const cityId = this.value;
                districtSelect.innerHTML = '<option value="">Loading...</option>';
                districtSelect.disabled = true;
                villageSelect.innerHTML = '<option value="">Pilih Kecamatan dulu</option>';
                villageSelect.disabled = true;

                if (cityId) {
                    fetch(`{{ route('tpa.api.districts') }}?city_id=${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                            data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        });
                }
            });

            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                villageSelect.innerHTML = '<option value="">Loading...</option>';
                villageSelect.disabled = true;

                if (districtId) {
                    fetch(`{{ route('tpa.api.villages') }}?district_id=${districtId}`)
                        .then(response => response.json())
                        .then(data => {
                            villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
                            data.forEach(village => {
                                villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
                            });
                            villageSelect.disabled = false;
                        });
                }
            });
        });
    </script>
    @endpush
</x-layouts.tpa>
