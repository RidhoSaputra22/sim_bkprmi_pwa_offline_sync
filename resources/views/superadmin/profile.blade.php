<x-layouts.superadmin title="Profil">
    <x-slot:header>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Profil SuperAdmin</h1>
                <p class="text-base-content/60">Kelola informasi profil dan keamanan akun Anda</p>
            </div>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Summary Card -->
        <div class="lg:col-span-1">
            <x-ui.card>
                <div class="text-center space-y-4">
                    <!-- Avatar -->
                    <div class="avatar placeholder">
                        <div
                            class="bg-error text-error-content rounded-full w-24 h-24 flex items-center justify-center text-4xl mx-auto">
                            <span class="text-3xl font-bold">{{ substr($user->person->full_name ?? 'SA', 0, 2) }}</span>
                        </div>
                    </div>

                    <!-- Name & Email -->
                    <div>
                        <h3 class="font-bold text-xl">{{ $user->person->full_name ?? 'SuperAdmin' }}</h3>
                        <p class="text-sm text-base-content/60">{{ $user->email }}</p>
                    </div>

                    <!-- Role Badge -->
                    @if($user->roles && $user->roles->count() > 0)
                    <div class="flex flex-wrap gap-2 justify-center">
                        @foreach($user->roles as $role)
                        <div class="badge badge-error badge-lg">
                            {{ $role->role_type?->getLabel() ?? 'SuperAdmin BKPRMI' }}
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Statistics -->
                    <div class="divider my-4"></div>

                    <div class="stats stats-vertical shadow w-full">
                        <div class="stat">
                            <div class="stat-figure text-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="stat-title">Total Approval</div>
                            <div class="stat-value text-primary text-2xl">{{ number_format($stats['total_approvals']) }}</div>
                            <div class="stat-desc">Unit yang disetujui</div>
                        </div>

                        <div class="stat">
                            <div class="stat-figure text-warning">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="stat-title">Pending</div>
                            <div class="stat-value text-warning text-2xl">{{ number_format($stats['pending_approvals']) }}</div>
                            <div class="stat-desc">Menunggu approval</div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="divider my-4"></div>

                    <div class="text-left space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-base-content/60">Total Unit TPA</span>
                            <span class="font-semibold">{{ number_format($stats['total_units']) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-base-content/60">Total Santri</span>
                            <span class="font-semibold">{{ number_format($stats['total_santri']) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-base-content/60">Status Akun</span>
                            <span class="badge badge-success badge-sm">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Edit Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <x-ui.card title="Informasi Profil">
                <form method="POST" action="{{ route('superadmin.profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.input
                        name="full_name"
                        label="Nama Lengkap"
                        :value="old('full_name', $user->person->full_name ?? '')"
                        :required="true"
                        placeholder="Masukkan nama lengkap"
                    />

                    <x-ui.input
                        name="email"
                        type="email"
                        label="Email"
                        :value="old('email', $user->email ?? '')"
                        :required="true"
                        placeholder="Masukkan email"
                    />

                    <x-ui.input
                        name="phone"
                        label="No. Telepon"
                        :value="old('phone', $user->person->phone ?? '')"
                        placeholder="Masukkan nomor telepon"
                    />

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </x-ui.card>

            <!-- Update Password -->
            <x-ui.card title="Ubah Password">
                <p class="text-sm text-base-content/60 mb-4">
                    Pastikan akun Anda menggunakan password yang kuat dan aman untuk menjaga keamanan data.
                </p>

                <form method="POST" action="{{ route('superadmin.password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.input
                        name="current_password"
                        type="password"
                        label="Password Saat Ini"
                        :required="true"
                        placeholder="Masukkan password saat ini"
                    />

                    <x-ui.input
                        name="password"
                        type="password"
                        label="Password Baru"
                        :required="true"
                        placeholder="Minimal 8 karakter"
                    />

                    <x-ui.input
                        name="password_confirmation"
                        type="password"
                        label="Konfirmasi Password Baru"
                        :required="true"
                        placeholder="Ulangi password baru"
                    />

                    <div class="alert alert-info">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">Password harus minimal 8 karakter dan mengandung kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</span>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="reset" class="btn btn-ghost">Reset</button>
                        <button type="submit" class="btn btn-warning">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </x-ui.card>

            <!-- Account Security Info -->
            <x-ui.card title="Keamanan Akun">
                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-4 bg-base-200 rounded-lg">
                        <svg class="w-6 h-6 text-success flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold">Akun Terverifikasi</h4>
                            <p class="text-sm text-base-content/60">Akun SuperAdmin Anda telah diverifikasi dan memiliki akses penuh ke sistem BKPRMI.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 bg-base-200 rounded-lg">
                        <svg class="w-6 h-6 text-info flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold">Informasi Penting</h4>
                            <p class="text-sm text-base-content/60">Jangan pernah membagikan password Anda kepada siapapun. Tim BKPRMI tidak akan pernah meminta password Anda.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-4 bg-base-200 rounded-lg">
                        <svg class="w-6 h-6 text-warning flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold">Rekomendasi Keamanan</h4>
                            <p class="text-sm text-base-content/60">Ubah password Anda secara berkala dan gunakan kombinasi yang kuat untuk menjaga keamanan sistem.</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-layouts.superadmin>
