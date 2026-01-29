<x-layouts.tpa title="Tidak Ada Unit">
    <x-slot:header>
        <h1 class="text-2xl font-bold">Dashboard Admin TPA</h1>
    </x-slot:header>

    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="card bg-base-100 shadow-xl max-w-lg w-full">
            <div class="card-body text-center">
                <div class="py-8">
                    <svg class="w-24 h-24 mx-auto text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold">Tidak Ada Unit Terhubung</h2>

                <p class="text-base-content/60 mt-4">
                    Akun Anda belum terhubung dengan unit TPA manapun.
                    Hal ini mungkin terjadi karena:
                </p>

                <ul class="text-left mt-4 space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-warning shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Akun baru dibuat dan belum dihubungkan dengan unit</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-warning shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Terjadi kesalahan saat pembuatan akun</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-warning shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Unit TPA telah dihapus dari sistem</span>
                    </li>
                </ul>

                <div class="divider my-6"></div>

                <div class="bg-base-200 rounded-lg p-4">
                    <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-base-content/60">
                        Silakan hubungi Admin LPPTKA untuk menghubungkan akun Anda dengan unit TPA yang sesuai.
                    </p>
                </div>

                <div class="card-actions justify-center mt-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.tpa>
