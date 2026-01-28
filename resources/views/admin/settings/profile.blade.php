<x-layouts.admin title="Profil">
    <x-slot:breadcrumb>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.settings') }}">Pengaturan</a></li>
            <li>Profil</li>
        </ul>
    </x-slot:breadcrumb>

    <x-slot:header>
        <h1 class="text-2xl font-bold">Profil Saya</h1>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <x-ui.card>
                <div class="text-center">
                    <div class="avatar placeholder mb-4">
                        <div class="bg-primary text-primary-content rounded-full w-24">
                            <span class="text-3xl">{{ substr($user->person->full_name ?? $user->email ?? 'A', 0, 1) }}</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-lg">{{ $user->person->full_name ?? 'Admin' }}</h3>
                    <p class="text-sm text-base-content/60">{{ $user->email }}</p>

                    @if($user->roles && $user->roles->count() > 0)
                        <div class="mt-4">
                            @foreach($user->roles as $role)
                                <x-ui.badge type="primary">{{ $role->role_type?->getLabel() ?? $role->role_type }}</x-ui.badge>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-ui.card>
        </div>

        <!-- Edit Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile -->
            <x-ui.card title="Informasi Profil">
                <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.input
                        name="full_name"
                        label="Nama Lengkap"
                        :value="$user->person->full_name ?? ''"
                        :required="true"
                    />

                    <x-ui.input
                        name="email"
                        type="email"
                        label="Email"
                        :value="$user->email ?? ''"
                        :required="true"
                    />

                    <x-ui.input
                        name="phone"
                        label="No. Telepon"
                        :value="$user->person->phone ?? ''"
                    />

                    <div class="flex justify-end">
                        <x-ui.button type="primary">Simpan Perubahan</x-ui.button>
                    </div>
                </form>
            </x-ui.card>

            <!-- Update Password -->
            <x-ui.card title="Ubah Password">
                <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-ui.input
                        name="current_password"
                        type="password"
                        label="Password Saat Ini"
                        :required="true"
                    />

                    <x-ui.input
                        name="password"
                        type="password"
                        label="Password Baru"
                        :required="true"
                        helpText="Minimal 8 karakter"
                    />

                    <x-ui.input
                        name="password_confirmation"
                        type="password"
                        label="Konfirmasi Password Baru"
                        :required="true"
                    />

                    <div class="flex justify-end">
                        <x-ui.button type="primary">Ubah Password</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-layouts.admin>
