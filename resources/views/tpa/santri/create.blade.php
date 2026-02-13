<x-layouts.tpa title="Tambah Santri Baru">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Tambah Santri Baru</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('tpa.santri.store') }}" method="POST" x-data="santriForm()">
        @csrf

        <div class="space-y-6">
            <!-- Data Santri -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Santri</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Lengkap <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                class="input input-bordered @error('full_name') input-error @enderror"
                                placeholder="Nama lengkap santri" required>
                            @error('full_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>


                        <div class="form-control">
                            <label class="label"><span class="label-text">NIK</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}"
                                class="input input-bordered @error('nik') input-error @enderror"
                                placeholder="16 digit NIK" maxlength="16">
                            @error('nik')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jenis Kelamin <span
                                        class="text-error">*</span></span></label>
                            <select name="gender" class="select select-bordered @error('gender') select-error @enderror"
                                required>
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Enum\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('gender')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tempat Lahir</span></label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                                class="input input-bordered @error('birth_place') input-error @enderror"
                                placeholder="Kota tempat lahir">
                            @error('birth_place')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir</span></label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                class="input input-bordered @error('birth_date') input-error @enderror">
                            @error('birth_date')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Anak Ke</span></label>
                            <input type="number" name="child_order" value="{{ old('child_order') }}" min="1"
                                class="input input-bordered @error('child_order') input-error @enderror"
                                placeholder="1">
                            @error('child_order')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah Saudara</span></label>
                            <input type="number" name="siblings_count" value="{{ old('siblings_count') }}" min="0"
                                class="input input-bordered @error('siblings_count') input-error @enderror"
                                placeholder="0">
                            @error('siblings_count')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pendidikan -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Pendidikan di TPA</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Jenjang <span
                                        class="text-error">*</span></span></label>
                            <select name="jenjang_santri"
                                class="select select-bordered @error('jenjang_santri') select-error @enderror" required>
                                <option value="">-- Pilih Jenjang --</option>
                                @foreach(\App\Enum\JenjangSantri::cases() as $jenjang)
                                <option value="{{ $jenjang->value }}"
                                    {{ old('jenjang_santri') == $jenjang->value ? 'selected' : '' }}>
                                    {{ $jenjang->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenjang_santri')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kelas Mengaji</span></label>
                            <select name="kelas_mengaji"
                                class="select select-bordered @error('kelas_mengaji') select-error @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach(\App\Enum\KelasMengaji::cases() as $kelas)
                                <option value="{{ $kelas->value }}"
                                    {{ old('kelas_mengaji') == $kelas->value ? 'selected' : '' }}>
                                    {{ $kelas->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('kelas_mengaji')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Status <span
                                        class="text-error">*</span></span></label>
                            <select name="status_santri"
                                class="select select-bordered @error('status_santri') select-error @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach(\App\Enum\StatusSantri::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status_santri', 'aktif') == $status->value ? 'selected' : '' }}>
                                    {{ $status->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('status_santri')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Masuk</span></label>
                            <input type="date" name="joined_at" value="{{ old('joined_at', date('Y-m-d')) }}"
                                class="input input-bordered @error('joined_at') input-error @enderror">
                            @error('joined_at')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat Santri -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Alamat</h2>
                    <p class="text-sm text-base-content/60 mb-4">
                        Lokasi dibatasi hanya untuk wilayah Kota Makassar
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Kecamatan <span
                                        class="text-error">*</span></span></label>
                            <select name="district_id" x-model="districtId" @change="loadVillages()"
                                class="select select-bordered @error('district_id') select-error @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                                @endforeach
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
                            <label class="label"><span class="label-text">Alamat Lengkap</span></label>
                            <textarea name="address"
                                class="textarea textarea-bordered @error('address') textarea-error @enderror" rows="2"
                                placeholder="Jalan, dll">{{ old('address') }}</textarea>
                            @error('address')
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

            <!-- Data Wali -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Wali/Orang Tua</h2>

                    <!-- Nama Orang Tua -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-4">NAMA ORANG TUA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nama Ayah Kandung</span></label>
                                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                    class="input input-bordered @error('nama_ayah') input-error @enderror"
                                    placeholder="Nama lengkap ayah kandung">
                                @error('nama_ayah')
                                <label class="label"><span
                                        class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Nama Ibu Kandung</span></label>
                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                    class="input input-bordered @error('nama_ibu') input-error @enderror"
                                    placeholder="Nama lengkap ibu kandung">
                                @error('nama_ibu')
                                <label class="label"><span
                                        class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Wali -->
                    <div class="divider"></div>
                    <h3 class="font-semibold text-lg mb-4">DATA WALI</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Wali <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="wali_full_name" value="{{ old('wali_full_name') }}"
                                class="input input-bordered @error('wali_full_name') input-error @enderror"
                                placeholder="Nama lengkap wali" required>
                            @error('wali_full_name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jenis Kelamin Wali <span
                                        class="text-error">*</span></span></label>
                            <select name="wali_gender"
                                class="select select-bordered @error('wali_gender') select-error @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Enum\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}"
                                    {{ old('wali_gender') == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('wali_gender')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Hubungan dengan Santri <span
                                        class="text-error">*</span></span></label>
                            <select name="wali_hubungan"
                                class="select select-bordered @error('wali_hubungan') select-error @enderror" required>
                                <option value="">-- Pilih Hubungan --</option>
                                @foreach(\App\Enum\HubunganWaliSantri::cases() as $hubungan)
                                <option value="{{ $hubungan->value }}"
                                    {{ old('wali_hubungan') == $hubungan->value ? 'selected' : '' }}>
                                    {{ $hubungan->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('wali_hubungan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">NIK Wali</span></label>
                            <input type="text" name="wali_nik" value="{{ old('wali_nik') }}"
                                class="input input-bordered @error('wali_nik') input-error @enderror"
                                placeholder="16 digit NIK" maxlength="16">
                            @error('wali_nik')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">No. HP Wali <span
                                        class="text-error">*</span></span></label>
                            <input type="text" name="wali_phone" value="{{ old('wali_phone') }}"
                                class="input input-bordered @error('wali_phone') input-error @enderror"
                                placeholder="08xxxxxxxxxx" required>
                            @error('wali_phone')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tempat Lahir Wali</span></label>
                            <input type="text" name="wali_birth_place" value="{{ old('wali_birth_place') }}"
                                class="input input-bordered @error('wali_birth_place') input-error @enderror"
                                placeholder="Kota tempat lahir">
                            @error('wali_birth_place')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir Wali</span></label>
                            <input type="date" name="wali_birth_date" value="{{ old('wali_birth_date') }}"
                                class="input input-bordered @error('wali_birth_date') input-error @enderror">
                            @error('wali_birth_date')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <x-ui.multi-select
                            name="wali_pekerjaan"
                            label="Pekerjaan Wali"
                            :options="array_map(fn($job) => ['value' => $job->value, 'label' => $job->getLabel()], \App\Enum\PekerjaanWali::cases())"
                            :selected="old('wali_pekerjaan', [])"
                            placeholder="-- Pilih Pekerjaan --"
                            searchPlaceholder="Cari pekerjaan..."
                        />

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pendidikan Wali</span></label>
                            <select name="wali_pendidikan"
                                class="select select-bordered @error('wali_pendidikan') select-error @enderror">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach(\App\Enum\PendidikanTerakhir::cases() as $pendidikan)
                                <option value="{{ $pendidikan->value }}"
                                    {{ old('wali_pendidikan') == $pendidikan->value ? 'selected' : '' }}>
                                    {{ $pendidikan->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('wali_pendidikan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Santri
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function santriForm() {
        return {
            districtId: "{{ old('district_id', '') }}",
            villageId: "{{ old('village_id', '') }}",
            villages: [],

            init() {
                if (this.districtId) this.loadVillages();
            },

            async loadVillages() {
                if (!this.districtId) {
                    this.villages = [];
                    return;
                }
                try {
                    const response = await fetch(`/api/location/villages?district_id=${this.districtId}`);
                    const result = await response.json();
                    this.villages = result.success ? result.data : [];
                } catch (error) {
                    console.error('Failed to load villages:', error);
                    this.villages = [];
                }
            }
        }
    }
    </script>
    @endpush
</x-layouts.tpa>
