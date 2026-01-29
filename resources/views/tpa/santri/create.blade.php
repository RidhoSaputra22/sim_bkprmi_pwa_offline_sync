<x-layouts.tpa title="Tambah Santri Baru">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.santri.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                            <label class="label"><span class="label-text">Nama Lengkap <span class="text-error">*</span></span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                   class="input input-bordered @error('nama_lengkap') input-error @enderror"
                                   placeholder="Nama lengkap santri" required>
                            @error('nama_lengkap')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Panggilan</span></label>
                            <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}"
                                   class="input input-bordered @error('nama_panggilan') input-error @enderror"
                                   placeholder="Nama panggilan">
                            @error('nama_panggilan')
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
                            <label class="label"><span class="label-text">Jenis Kelamin <span class="text-error">*</span></span></label>
                            <select name="gender" class="select select-bordered @error('gender') select-error @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach(\App\Enum\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>
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
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                   class="input input-bordered @error('tempat_lahir') input-error @enderror"
                                   placeholder="Kota tempat lahir">
                            @error('tempat_lahir')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                   class="input input-bordered @error('tanggal_lahir') input-error @enderror">
                            @error('tanggal_lahir')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Anak Ke</span></label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" min="1"
                                   class="input input-bordered @error('anak_ke') input-error @enderror"
                                   placeholder="1">
                            @error('anak_ke')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah Saudara</span></label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" min="0"
                                   class="input input-bordered @error('jumlah_saudara') input-error @enderror"
                                   placeholder="0">
                            @error('jumlah_saudara')
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
                            <label class="label"><span class="label-text">Jenjang <span class="text-error">*</span></span></label>
                            <select name="jenjang" class="select select-bordered @error('jenjang') select-error @enderror" required>
                                <option value="">-- Pilih Jenjang --</option>
                                @foreach(\App\Enum\JenjangSantri::cases() as $jenjang)
                                <option value="{{ $jenjang->value }}" {{ old('jenjang') == $jenjang->value ? 'selected' : '' }}>
                                    {{ $jenjang->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenjang')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kelas Mengaji</span></label>
                            <select name="kelas" class="select select-bordered @error('kelas') select-error @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach(\App\Enum\KelasMengaji::cases() as $kelas)
                                <option value="{{ $kelas->value }}" {{ old('kelas') == $kelas->value ? 'selected' : '' }}>
                                    {{ $kelas->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('kelas')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Status <span class="text-error">*</span></span></label>
                            <select name="status" class="select select-bordered @error('status') select-error @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach(\App\Enum\StatusSantri::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', 'aktif') == $status->value ? 'selected' : '' }}>
                                    {{ $status->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Masuk</span></label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                                   class="input input-bordered @error('tanggal_masuk') input-error @enderror">
                            @error('tanggal_masuk')
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
                            <label class="label"><span class="label-text">Kecamatan <span class="text-error">*</span></span></label>
                            <select name="district_id" x-model="districtId" @change="loadVillages()"
                                    class="select select-bordered @error('district_id') select-error @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('district_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Kelurahan <span class="text-error">*</span></span></label>
                            <select name="village_id" x-model="villageId"
                                    class="select select-bordered @error('village_id') select-error @enderror" required :disabled="!villages.length">
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
                            <textarea name="alamat" class="textarea textarea-bordered @error('alamat') textarea-error @enderror"
                                      rows="2" placeholder="Jalan, RT/RW, dll">{{ old('alamat') }}</textarea>
                            @error('alamat')
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Wali <span class="text-error">*</span></span></label>
                            <input type="text" name="wali_nama" value="{{ old('wali_nama') }}"
                                   class="input input-bordered @error('wali_nama') input-error @enderror"
                                   placeholder="Nama lengkap wali" required>
                            @error('wali_nama')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Hubungan dengan Santri <span class="text-error">*</span></span></label>
                            <select name="wali_hubungan" class="select select-bordered @error('wali_hubungan') select-error @enderror" required>
                                <option value="">-- Pilih Hubungan --</option>
                                @foreach(\App\Enum\HubunganWaliSantri::cases() as $hubungan)
                                <option value="{{ $hubungan->value }}" {{ old('wali_hubungan') == $hubungan->value ? 'selected' : '' }}>
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
                            <label class="label"><span class="label-text">No. HP Wali <span class="text-error">*</span></span></label>
                            <input type="text" name="wali_phone" value="{{ old('wali_phone') }}"
                                   class="input input-bordered @error('wali_phone') input-error @enderror"
                                   placeholder="08xxxxxxxxxx" required>
                            @error('wali_phone')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pekerjaan Wali</span></label>
                            <select name="wali_pekerjaan" class="select select-bordered @error('wali_pekerjaan') select-error @enderror">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach(\App\Enum\PekerjaanWali::cases() as $pekerjaan)
                                <option value="{{ $pekerjaan->value }}" {{ old('wali_pekerjaan') == $pekerjaan->value ? 'selected' : '' }}>
                                    {{ $pekerjaan->getLabel() }}
                                </option>
                                @endforeach
                            </select>
                            @error('wali_pekerjaan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Pendidikan Wali</span></label>
                            <select name="wali_pendidikan" class="select select-bordered @error('wali_pendidikan') select-error @enderror">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach(\App\Enum\PendidikanTerakhir::cases() as $pendidikan)
                                <option value="{{ $pendidikan->value }}" {{ old('wali_pendidikan') == $pendidikan->value ? 'selected' : '' }}>
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
            districtId: '{{ old('district_id', '') }}',
            villageId: '{{ old('village_id', '') }}',
            villages: [],

            init() {
                if (this.districtId) this.loadVillages();
            },

            async loadVillages() {
                if (!this.districtId) {
                    this.villages = [];
                    return;
                }
                const response = await fetch(`/api/location/villages/${this.districtId}`);
                this.villages = await response.json();
            }
        }
    }
    </script>
    @endpush
</x-layouts.tpa>
