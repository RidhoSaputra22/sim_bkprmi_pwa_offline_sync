<x-layouts.lpptka title="Akun Berhasil Dibuat">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Akun Admin TPA Berhasil Dibuat</h1>
    </x-slot:header>

    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body text-center">
                <div class="py-6">
                    <svg class="w-20 h-20 mx-auto text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold mt-4 text-success">Berhasil!</h2>
                    <p class="text-base-content/60 mt-2">Akun admin TPA telah berhasil dibuat</p>
                </div>

                <div class="divider"></div>

                <!-- Credential Info -->
                <div class="bg-base-200 rounded-lg p-6 text-left">
                    <h3 class="font-semibold mb-4">Informasi Login</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-base-content/60">Unit TPA</p>
                            <p class="font-medium">{{ $unit->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Nama Admin</p>
                            <p class="font-medium">{{ $adminName }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Email Login</p>
                            <p class="font-mono bg-base-100 p-2 rounded">{{ $email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-base-content/60">Password</p>
                            <p class="font-mono bg-base-100 p-2 rounded">{{ $password }}</p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-6">
                    <svg class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-left">
                        <p class="font-medium">Penting!</p>
                        <p class="text-sm">Catat atau simpan informasi login di atas. Password tidak akan ditampilkan lagi setelah meninggalkan halaman ini.</p>
                    </div>
                </div>

                <div class="flex justify-center gap-4 mt-6">
                    <button onclick="printCredentials()" class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                    <a href="{{ route('lpptka.tpa-accounts.index') }}" class="btn btn-primary">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function printCredentials() {
        const content = `
            <html>
            <head>
                <title>Kredensial Admin TPA - {{ $unit->name }}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .info { margin: 10px 0; }
                    .label { color: #666; font-size: 12px; }
                    .value { font-size: 16px; font-weight: bold; margin-top: 5px; }
                    .mono { font-family: monospace; background: #f5f5f5; padding: 8px; }
                    .warning { background: #fff3cd; padding: 15px; margin-top: 30px; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Kredensial Login Admin TPA</h1>
                    <p>BKPRMI - Sistem Informasi</p>
                </div>
                <div class="info">
                    <div class="label">Unit TPA</div>
                    <div class="value">{{ $unit->name }}</div>
                </div>
                <div class="info">
                    <div class="label">Nama Admin</div>
                    <div class="value">{{ $adminName }}</div>
                </div>
                <div class="info">
                    <div class="label">Email Login</div>
                    <div class="value mono">{{ $email }}</div>
                </div>
                <div class="info">
                    <div class="label">Password</div>
                    <div class="value mono">{{ $password }}</div>
                </div>
                <div class="warning">
                    <strong>Penting:</strong> Simpan informasi ini dengan aman. Disarankan untuk mengganti password setelah login pertama.
                </div>
            </body>
            </html>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(content);
        printWindow.document.close();
        printWindow.print();
    }
    </script>
    @endpush
</x-layouts.lpptka>
