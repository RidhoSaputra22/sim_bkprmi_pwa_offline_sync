<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1e40af">
    <meta name="description"
        content="Sistem Informasi Manajemen BKPRMI - Badan Komunikasi Pemuda Remaja Masjid Indonesia">

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="BKPRMI KOTA MAKASSAR">

    <title>BKPRMI KOTA MAKASSAR - Sistem Informasi Manajemen BKPRMI</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Service Worker Registration -->
    <script src="{{ asset('register-sw.js') }}"></script>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
    /* Custom animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .animate-slideIn {
        animation: slideIn 0.6s ease-out forwards;
    }

    .hero-gradient {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .news-ticker {
        animation: ticker 20s linear infinite;
    }

    @keyframes ticker {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Swiper Custom Styles */
    .swiper {
        width: 100%;
        height: 500px;
    }

    @media (min-width: 1024px) {
        .swiper {
            height: 600px;
        }
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
    }

    .swiper-pagination-bullet {
        background: white;
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        background: #fbbf24;
    }
    </style>
</head>

<body class="min-h-screen bg-base-100">
    <!-- News Ticker -->
    <div class="bg-primary text-primary-content py-2 overflow-hidden">
        <div class="flex items-center max-w-7xl mx-auto px-4">
            <span class="badge badge-warning mr-4 shrink-0">TERBARU</span>
            <div class="overflow-hidden whitespace-nowrap flex-1">
                <div class="news-ticker inline-block">
                    <span class="mx-8">🕌 Selamat Datang di Sistem Informasi Manajemen BKPRMI</span>
                    <span class="mx-8">📢 Ayo Kembali Ke Masjid - Makmurkan Masjid dengan Kegiatan Positif</span>
                    <span class="mx-8">🤲 BKPRMI: Wadah Pembinaan Generasi Muda Muslim Indonesia</span>
                    <span class="mx-8">📚 LPPTKA-BKPRMI: Lembaga Pendidikan Al-Qur'an Terbesar di Indonesia</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="navbar bg-base-100 shadow-lg sticky top-0 z-50">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow">
                    <li><a href="/#beranda">Beranda</a></li>
                    <li>
                        <a>Tentang</a>
                        <ul class="p-2">
                            <li><a href="/#tentang">Tentang BKPRMI</a></li>
                            <li><a href="/#visi-misi">Visi & Misi</a></li>
                            <li><a href="/#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Lembaga</a>
                        <ul class="p-2">
                            <li><a href="/#lpptka">LPPTKA-BKPRMI</a></li>
                            <li><a href="/#lppsdm">LPPSDM</a></li>
                        </ul>
                    </li>
                    <li><a href="/#berita">Berita</a></li>
                    <li><a href="/#kontak">Kontak</a></li>
                </ul>
            </div>
            <a href="/" class="btn btn-ghost text-xl">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo BKPRMI" class="h-10 w-10">
                <span class="hidden md:inline font-bold text-primary">BKPRMI KOTA MAKASSAR</span>
            </a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="/#beranda" class="font-medium">Beranda</a></li>
                <li>
                    <details>
                        <summary class="font-medium">Tentang</summary>
                        <ul class="p-2 bg-base-100 rounded-box shadow-lg w-48 z-50">
                            <li><a href="/#tentang">Tentang BKPRMI</a></li>
                            <li><a href="/#visi-misi">Visi & Misi</a></li>
                            <li><a href="/#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary class="font-medium">Lembaga</summary>
                        <ul class="p-2 bg-base-100 rounded-box shadow-lg w-48 z-50">
                            <li><a href="/#lpptka">LPPTKA-BKPRMI</a></li>
                            <li><a href="/#lppsdm">LPPSDM</a></li>
                        </ul>
                    </details>
                </li>
                <li><a href="/#berita" class="font-medium">Berita</a></li>
                <li><a href="/#kontak" class="font-medium">Kontak</a></li>
            </ul>
        </div>

        <div class="navbar-end gap-2">
            @auth
            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
            @endif
            @endauth
        </div>
    </div>


    <!-- Content -->
    <main class="bg-base-200 py-10">
        <div class="max-w-4xl mx-auto px-4">
            <div class="card bg-base-100 shadow-xl overflow-hidden">
                <figure class="w-full">
                    <img src="{{ isset($berita['thumbnail']) ? asset('images/' . $berita['thumbnail']) : asset('images/default-news.jpg') }}"
                        alt="{{ $berita['title'] ?? 'Berita' }}" class="w-full h-[240px] md:h-[360px] object-cover">
                </figure>

                <div class="card-body">
                    <div class="prose-reset text-base-content/90 space-y-5">
                        {!! $berita['content'] ?? '' !!}
                    </div>

                    <div class="divider my-8"></div>

                    <div class="flex flex-col md:flex-row gap-3 justify-between">

                    </div>
                </div>
            </div>
        </div>
    </main>



    <!-- Footer -->
    <footer class="footer footer-center bg-primary text-primary-content p-10">
        <aside>
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo BKPRMI" class="h-10 w-10">

            <p class="font-bold text-lg">
                BKPRMI KOTA MAKASSAR
            </p>
            <p>Sistem Informasi Manajemen<br>Badan Komunikasi Pemuda Remaja Masjid Indonesia</p>
            <p class="mt-4 text-sm opacity-80">
                Copyright © {{ date('Y') }} - BKPRMI. All rights reserved.
            </p>
        </aside>
        <nav>
            <div class="grid grid-flow-col gap-4">
                <a href="#beranda">Beranda</a>
                <a href="#tentang">Tentang</a>
                <a href="#berita">Berita</a>
                <a href="#kontak">Kontak</a>
            </div>
        </nav>
    </footer>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn btn-circle btn-primary fixed bottom-6 right-6 shadow-lg z-50 opacity-0 transition-opacity duration-300"
        id="backToTop">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>

    </script>
</body>

</html>