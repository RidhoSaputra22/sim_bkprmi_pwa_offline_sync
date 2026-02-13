<x-layouts.lpptka title="Buat Akun Admin TPA">
    <x-slot:header>
        <div class="flex items-center gap-4">
            <a href="{{ route('lpptka.tpa-accounts.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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

                        <div class="space-y-4">
                            <!-- Admin Info -->
                            <x-ui.input name="full_name" label="Nama Lengkap Admin"
                                :value="old('full_name', $unit->unitHead?->person?->full_name)"
                                placeholder="Nama lengkap admin TPA" :required="true"
                                helpText="Bisa menggunakan nama kepala unit atau nama lain" />

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-ui.select name="gender" label="Jenis Kelamin"
                                    :options="collect($genderOptions)->map(fn($g) => ['value' => $g->value, 'label' => $g->getLabel()])->toArray()"
                                    :value="old('gender', $unit->unitHead?->person?->gender?->value)"
                                    placeholder="Pilih" :required="true" />

                                <x-ui.input name="nik" label="NIK (Opsional)"
                                    :value="old('nik', $unit->unitHead?->person?->nik)" placeholder="16 digit"
                                    maxlength="16" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-ui.input name="birth_place" label="Tempat Lahir"
                                    :value="old('birth_place', $unit->unitHead?->person?->birth_place)"
                                    placeholder="Tempat lahir" :required="true" />

                                <x-ui.input name="birth_date" type="date" label="Tanggal Lahir"
                                    :value="old('birth_date', $unit->unitHead?->person?->birth_date?->format('Y-m-d'))"
                                    :required="true" />
                            </div>

                            <x-ui.input name="email" type="email" label="Email"
                                :value="old('email', $unit->unitAdmin?->person?->email ?? '')"
                                placeholder="email@example.com" :required="true"
                                helpText="Email ini akan digunakan untuk login" />

                            <x-ui.input name="phone" label="No. HP"
                                :value="old('phone', $unit->unitHead?->person?->phone)" placeholder="08xxxxxxxxxx" />

                            <div class="divider"></div>

                            <!-- Password -->
                            <x-ui.input name="password" type="password" label="Password"
                                placeholder="Minimal 8 karakter" :required="true" />

                            <x-ui.input name="password_confirmation" type="password" label="Konfirmasi Password"
                                placeholder="Ulangi password" :required="true" />

                            <div class="alert alert-info">
                                <svg class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
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
                            <p>{{ $unit->village?->district?->city?->name ?? '-' }},
                                {{ $unit->village?->district?->name ?? '-' }}</p>
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
