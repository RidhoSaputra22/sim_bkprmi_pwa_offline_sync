<x-layouts.tpa title="Edit Santri - {{ $santri->person?->full_name }}">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('tpa.santri.show', $santri) }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Edit Santri</h1>
                <p class="text-base-content/60">{{ $santri->person?->full_name ?? 'Santri' }}</p>
            </div>
        </div>
    </x-slot:header>

    <form action="{{ route('tpa.santri.update', $santri) }}" method="POST" x-data="santriForm()">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Data Santri -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Data Santri</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Lengkap <span class="text-error">*</span></span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $santri->person?->full_name) }}"
                                   class="input input-bordered @error('nama_lengkap') input-error @enderror"
                                   placeholder="Nama lengkap santri" required>
                            @error('nama_lengkap')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Nama Panggilan</span></label>
                            <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $santri->person?->nickname) }}"
                                   class="input input-bordered @error('nama_panggilan') input-error @enderror"
                                   placeholder="Nama panggilan">
                            @error('nama_panggilan')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">NIK</span></label>
                            <input type="text" name="nik" value="{{ old('nik', $santri->person?->nik) }}"
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
                                <option value="{{ $gender->value }}" {{ old('gender', $santri->person?->gender?->value) == $gender->value ? 'selected' : '' }}>
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
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->person?->birth_place) }}"
                                   class="input input-bordered @error('tempat_lahir') input-error @enderror"
                                   placeholder="Kota tempat lahir">
                            @error('tempat_lahir')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Tanggal Lahir</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->person?->birth_date?->format('Y-m-d')) }}"
                                   class="input input-bordered @error('tanggal_lahir') input-error @enderror">
                            @error('tanggal_lahir')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Anak Ke</span></label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke', $santri->person?->child_order) }}" min="1"
                                   class="input input-bordered @error('anak_ke') input-error @enderror">
                            @error('anak_ke')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text">Jumlah Saudara</span></label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $santri->person?->siblings_count) }}" min="0"
                                   class="input input-bordered @error('jumlah_saudara') input-error @enderror">
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
                                <option value="{{ $jenjang->value }}" {{ old('jenjang', $santri->jenjang?->value) == $jenjang->value ? 'selected' : '' }}>
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
                                <option value="{{ $kelas->value }}" {{ old('kelas', $santri->kelas?->value) == $kelas->value ? 'selected' : '' }}>
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
                                <option value="{{ $status->value }}" {{ old('status', $santri->status?->value) == $status->value ? 'selected' : '' }}>
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
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $santri->tanggal_masuk?->format('Y-m-d')) }}"
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text">Kecamatan <span class="text-error">*</span></span></label>
                            <select name="district_id" x-model="districtId" @change="loadVillages()"
                                    class="select select-bordered @error('district_id') select-error @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id', $santri->person?->village?->district_id) == $district->id ? 'selected' : '' }}>
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
                                    <option :value="village.id" x-text="village.name" :selected="village.id == initialVillageId"></option>
                                </template>
                            </select>
                            @error('village_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label"><span class="label-text">Alamat Lengkap</span></label>
                            <textarea name="alamat" class="textarea textarea-bordered @error('alamat') textarea-error @enderror"
                                      rows="2" placeholder="Jalan, RT/RW, dll">{{ old('alamat', $santri->person?->address) }}</textarea>
                            @error('alamat')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('tpa.santri.show', $santri) }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    function santriForm() {
        return {
            districtId: '{{ old('district_id', $santri->person?->village?->district_id) }}',
            villageId: '{{ old('village_id', $santri->person?->village_id) }}',
            initialVillageId: '{{ old('village_id', $santri->person?->village_id) }}',
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

                // Set the selected village after loading
                this.$nextTick(() => {
                    if (this.initialVillageId) {
                        this.villageId = this.initialVillageId;
                    }
                });
            }
        }
    }
    </script>
    @endpush
</x-layouts.tpa>
