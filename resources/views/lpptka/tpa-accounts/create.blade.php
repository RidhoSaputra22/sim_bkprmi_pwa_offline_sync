<x-layouts.lpptka title="Buat Akun Admin TPA">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.tpa-accounts.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold">Buat Akun Admin TPA</h1>
                <p class="text-base-content/60">Unit: {{ $unit->name }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Data Akun Admin TPA</h2>

                    <form action="{{ route('lpptka.tpa-accounts.store', $unit) }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <!-- Admin Info -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nama Lengkap Admin <span class="text-error">*</span></span></label>
                                <input type="text" name="full_name" value="{{ old('full_name', $unit->unitHead?->person?->full_name) }}"
                                       class="input input-bordered @error('full_name') input-error @enderror"
                                       placeholder="Nama lengkap admin TPA" required>
                                @error('full_name')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                                <label class="label"><span class="label-text-alt">Bisa menggunakan nama kepala unit atau nama lain</span></label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Jenis Kelamin <span class="text-error">*</span></span></label>
                                    <select name="gender" class="select select-bordered @error('gender') select-error @enderror" required>
                                        <option value="" disabled {{ old('gender', $unit->unitHead?->person?->gender?->value) ? '' : 'selected' }}>Pilih</option>
                                        @foreach($genderOptions as $gender)
                                            <option value="{{ $gender->value }}" @selected(old('gender', $unit->unitHead?->person?->gender?->value) === $gender->value)>
                                                {{ $gender->getLabel() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">NIK (Opsional)</span></label>
                                    <input type="text" name="nik" value="{{ old('nik', $unit->unitHead?->person?->nik) }}"
                                           class="input input-bordered @error('nik') input-error @enderror"
                                           placeholder="16 digit">
                                    @error('nik')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Email <span class="text-error">*</span></span></label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       placeholder="email@example.com" required>
                                @error('email')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                                <label class="label"><span class="label-text-alt">Email ini akan digunakan untuk login</span></label>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">No. HP</span></label>
                                <input type="text" name="phone" value="{{ old('phone', $unit->unitHead?->person?->phone) }}"
                                       class="input input-bordered @error('phone') input-error @enderror"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="divider"></div>

                            <!-- Password -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Password <span class="text-error">*</span></span></label>
                                <input type="password" name="password"
                                       class="input input-bordered @error('password') input-error @enderror"
                                       placeholder="Minimal 8 karakter" required>
                                @error('password')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text">Konfirmasi Password <span class="text-error">*</span></span></label>
                                <input type="password" name="password_confirmation"
                                       class="input input-bordered"
                                       placeholder="Ulangi password" required>
                            </div>

                            <div class="alert alert-info">
                                <svg class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium">Catatan Penting:</p>
                                    <ul class="text-sm list-disc list-inside">
                                        <li>Catat email dan password untuk diberikan ke admin TPA</li>
                                        <li>Admin TPA dapat login setelah akun dibuat</li>
                                        <li>Admin TPA hanya bisa mengelola data di unit ini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('lpptka.tpa-accounts.index') }}" class="btn btn-ghost">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Buat Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Unit Info Sidebar -->
        <div class="space-y-6">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Informasi Unit</h2>

                    <div class="space-y-3 mt-4">
                        <div>
                            <p class="text-sm text-base-content/60">Nama Unit</p>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">No. Unit</p>
                            <p class="font-mono">{{ $unit->unit_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Kepala Unit</p>
                            <p>{{ $unit->unitHead?->person?->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Lokasi</p>
                            <p>{{ $unit->village?->district?->city?->name ?? '-' }}, {{ $unit->village?->district?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">Status Approval</h2>

                    <div class="flex items-center gap-2 mt-4">
                        <span class="badge badge-lg badge-{{ $unit->approval_status->getColor() }}">
                            {{ $unit->approval_status->getLabel() }}
                        </span>
                    </div>

                    @if($unit->approved_at)
                    <p class="text-sm text-base-content/60 mt-2">
                        Disetujui: {{ $unit->approved_at->format('d M Y') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.lpptka>
