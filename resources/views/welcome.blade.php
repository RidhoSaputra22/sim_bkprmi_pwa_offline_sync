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
    <meta name="apple-mobile-web-app-title" content="SIM BKPRMI">

    <title>SIM BKPRMI - Sistem Informasi Manajemen BKPRMI</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Service Worker Registration -->
    <script src="{{ asset('register-sw.js') }}"></script>

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                    <li><a href="#beranda">Beranda</a></li>
                    <li>
                        <a>Tentang</a>
                        <ul class="p-2">
                            <li><a href="#tentang">Tentang BKPRMI</a></li>
                            <li><a href="#visi-misi">Visi & Misi</a></li>
                            <li><a href="#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Lembaga</a>
                        <ul class="p-2">
                            <li><a href="#lpptka">LPPTKA-BKPRMI</a></li>
                            <li><a href="#lppsdm">LPPSDM</a></li>
                        </ul>
                    </li>
                    <li><a href="#berita">Berita</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            <a href="/" class="btn btn-ghost text-xl">
                <img src="/icons/icon-72x72.png" alt="Logo BKPRMI" class="h-10 w-10">
                <span class="hidden md:inline font-bold text-primary">SIM BKPRMI</span>
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="#beranda" class="font-medium">Beranda</a></li>
                <li>
                    <details>
                        <summary class="font-medium">Tentang</summary>
                        <ul class="p-2 bg-base-100 rounded-box shadow-lg w-48 z-50">
                            <li><a href="#tentang">Tentang BKPRMI</a></li>
                            <li><a href="#visi-misi">Visi & Misi</a></li>
                            <li><a href="#struktur">Struktur Organisasi</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary class="font-medium">Lembaga</summary>
                        <ul class="p-2 bg-base-100 rounded-box shadow-lg w-48 z-50">
                            <li><a href="#lpptka">LPPTKA-BKPRMI</a></li>
                            <li><a href="#lppsdm">LPPSDM</a></li>
                        </ul>
                    </details>
                </li>
                <li><a href="#berita" class="font-medium">Berita</a></li>
                <li><a href="#kontak" class="font-medium">Kontak</a></li>
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

    <!-- Hero Section with Carousel -->
    <section id="beranda" class="relative">
        <div class="carousel w-full h-[500px] lg:h-[600px]">
            <div id="slide1" class="carousel-item relative w-full">
                <div class="hero-gradient w-full flex items-center">
                    <div class="hero-content text-center text-neutral-content w-full">
                        <div class="max-w-4xl animate-fadeInUp">
                            <h1 class="mb-5 text-4xl lg:text-6xl font-bold text-white">
                                Sistem Informasi Manajemen
                                <span class="text-yellow-300">BKPRMI</span>
                            </h1>
                            <p class="mb-8 text-lg lg:text-xl text-blue-100">
                                Badan Komunikasi Pemuda Remaja Masjid Indonesia
                                <br>Wadah Pembinaan Generasi Muda Muslim Indonesia
                            </p>
                            <div class="flex flex-wrap gap-4 justify-center">
                                <a href="#tentang" class="btn btn-warning btn-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tentang Kami
                                </a>
                                <a href="{{ route('login') }}"
                                    class="btn btn-outline btn-lg text-white border-white hover:bg-white hover:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Masuk Sistem
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide3" class="btn btn-circle glass">❮</a>
                    <a href="#slide2" class="btn btn-circle glass">❯</a>
                </div>
            </div>
            <div id="slide2" class="carousel-item relative w-full">
                <div class="w-full bg-gradient-to-r from-emerald-600 to-teal-500 flex items-center">
                    <div class="hero-content text-center text-neutral-content w-full">
                        <div class="max-w-4xl animate-fadeInUp">
                            <div class="badge badge-warning badge-lg mb-4">LPPTKA-BKPRMI</div>
                            <h1 class="mb-5 text-4xl lg:text-5xl font-bold text-white">
                                Lembaga Pendidikan & Pengembangan
                                <br>Tilawatil Qur'an & Anak
                            </h1>
                            <p class="mb-8 text-lg lg:text-xl text-emerald-100">
                                Mengelola TPA/TPQ, TKA/TKQ, dan TQA di seluruh Indonesia
                                <br>Membina generasi Qur'ani untuk Indonesia Emas
                            </p>
                            <a href="#lpptka" class="btn btn-warning btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide1" class="btn btn-circle glass">❮</a>
                    <a href="#slide3" class="btn btn-circle glass">❯</a>
                </div>
            </div>
            <div id="slide3" class="carousel-item relative w-full">
                <div class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 flex items-center">
                    <div class="hero-content text-center text-neutral-content w-full">
                        <div class="max-w-4xl animate-fadeInUp">
                            <div class="badge badge-warning badge-lg mb-4">AYO KEMBALI KE MASJID</div>
                            <h1 class="mb-5 text-4xl lg:text-5xl font-bold text-white">
                                Makmurkan Masjid
                                <br>Bangun Peradaban
                            </h1>
                            <p class="mb-8 text-lg lg:text-xl text-purple-100">
                                Masjid adalah pusat kegiatan umat Islam
                                <br>Mari bersama makmurkan masjid dengan kegiatan positif
                            </p>
                            <a href="#program" class="btn btn-warning btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Lihat Program
                            </a>
                        </div>
                    </div>
                </div>
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide2" class="btn btn-circle glass">❮</a>
                    <a href="#slide1" class="btn btn-circle glass">❯</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-8 bg-base-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="stats stats-vertical lg:stats-horizontal shadow w-full bg-base-100">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="stat-title">TPA/TPQ Terdaftar</div>
                    <div class="stat-value text-primary">250K+</div>
                    <div class="stat-desc">Di seluruh Indonesia</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Santri Aktif</div>
                    <div class="stat-value text-secondary">8M+</div>
                    <div class="stat-desc">Generasi Qur'ani Indonesia</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Guru/Ustadz</div>
                    <div class="stat-value text-accent">500K+</div>
                    <div class="stat-desc">Tenaga Pengajar Berkualitas</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Provinsi</div>
                    <div class="stat-value text-warning">34</div>
                    <div class="stat-desc">Tersebar di seluruh Indonesia</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-16 bg-base-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">Tentang BKPRMI</h2>
                <div class="w-24 h-1 bg-warning mx-auto"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <h3 class="text-2xl font-bold mb-4">Badan Komunikasi Pemuda Remaja Masjid Indonesia</h3>
                    <p class="text-base-content/80 mb-4 leading-relaxed">
                        BKPRMI adalah organisasi kemasyarakatan yang bergerak di bidang dakwah, pendidikan,
                        dan pembinaan generasi muda muslim Indonesia. Didirikan untuk menjadi wadah bagi
                        pemuda-pemudi masjid dalam mengembangkan potensi dan berkontribusi bagi umat.
                    </p>
                    <p class="text-base-content/80 mb-6 leading-relaxed">
                        Dengan semangat "Ayo Kembali ke Masjid", BKPRMI terus berupaya memakmurkan masjid
                        melalui berbagai program kegiatan yang melibatkan seluruh elemen masyarakat,
                        khususnya generasi muda.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <div class="badge badge-primary badge-lg">Dakwah</div>
                        <div class="badge badge-secondary badge-lg">Pendidikan</div>
                        <div class="badge badge-accent badge-lg">Sosial</div>
                        <div class="badge badge-warning badge-lg">Kepemudaan</div>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="mockup-window bg-primary border border-base-300">
                            <div class="bg-base-200 flex justify-center px-4 py-16">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-primary mb-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h4 class="text-xl font-bold">SIM BKPRMI</h4>
                                    <p class="text-sm text-base-content/70">Sistem Informasi Terpadu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section id="visi-misi" class="py-16 bg-base-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">Visi & Misi</h2>
                <div class="w-24 h-1 bg-warning mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="card bg-primary text-primary-content shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-warning/20 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-warning" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-2xl">VISI</h3>
                        </div>
                        <p class="text-lg leading-relaxed">
                            "Terwujudnya Generasi Muda Islam yang Beriman, Bertakwa, Berilmu, Berakhlak Mulia,
                            dan Berdaya Saing untuk Indonesia Emas 2045"
                        </p>
                    </div>
                </div>

                <!-- Misi -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="bg-primary/10 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="card-title text-2xl text-primary">MISI</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="badge badge-primary badge-sm mt-1">1</span>
                                <span>Memakmurkan masjid sebagai pusat kegiatan umat</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="badge badge-primary badge-sm mt-1">2</span>
                                <span>Membina dan mengembangkan pendidikan Al-Qur'an</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="badge badge-primary badge-sm mt-1">3</span>
                                <span>Meningkatkan kualitas SDM pemuda masjid</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="badge badge-primary badge-sm mt-1">4</span>
                                <span>Membangun jaringan dakwah yang kuat dan terstruktur</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lembaga Section -->
    <section id="lpptka" class="py-16 bg-base-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">Lembaga BKPRMI</h2>
                <div class="w-24 h-1 bg-warning mx-auto mb-4"></div>
                <p class="text-base-content/70 max-w-2xl mx-auto">
                    BKPRMI memiliki beberapa lembaga yang bergerak di berbagai bidang untuk
                    mendukung visi dan misi organisasi
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- LPPTKA -->
                <div class="card bg-base-100 shadow-xl border border-base-200 card-hover transition-all duration-300">
                    <figure class="bg-gradient-to-br from-emerald-500 to-teal-600 px-6 pt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title text-emerald-600">LPPTKA-BKPRMI</h3>
                        <p class="text-sm text-base-content/70">
                            Lembaga Pendidikan dan Pengembangan Tilawatil Qur'an dan Anak.
                            Mengelola TPA/TPQ di seluruh Indonesia.
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline btn-success">
                                Masuk Portal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- LPPSDM -->
                <div class="card bg-base-100 shadow-xl border border-base-200 card-hover transition-all duration-300">
                    <figure class="bg-gradient-to-br from-blue-500 to-indigo-600 px-6 pt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title text-blue-600">LPPSDM</h3>
                        <p class="text-sm text-base-content/70">
                            Lembaga Pengembangan Pendidikan Sumber Daya Manusia.
                            Pelatihan dan sertifikasi guru ngaji.
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-sm btn-outline btn-primary" disabled>
                                Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>

                <!-- UPZ -->
                <div class="card bg-base-100 shadow-xl border border-base-200 card-hover transition-all duration-300">
                    <figure class="bg-gradient-to-br from-amber-500 to-orange-600 px-6 pt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title text-amber-600">UPZ BKPRMI</h3>
                        <p class="text-sm text-base-content/70">
                            Unit Pengumpul Zakat BKPRMI.
                            Mengelola zakat, infaq, dan sedekah umat.
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <button class="btn btn-sm btn-outline btn-warning" disabled>
                                Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-16 bg-gradient-to-br from-primary to-primary-focus text-primary-content">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Program Unggulan</h2>
                <div class="w-24 h-1 bg-warning mx-auto mb-4"></div>
                <p class="text-primary-content/80 max-w-2xl mx-auto">
                    Program-program strategis BKPRMI dalam memakmurkan masjid dan membina generasi muda
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card glass">
                    <div class="card-body items-center text-center">
                        <div class="bg-warning/20 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="card-title text-lg">Pendidikan Al-Qur'an</h3>
                        <p class="text-sm opacity-80">TPA/TPQ, TKA/TKQ, TQA di seluruh Indonesia</p>
                    </div>
                </div>

                <div class="card glass">
                    <div class="card-body items-center text-center">
                        <div class="bg-warning/20 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="card-title text-lg">Sertifikasi Guru</h3>
                        <p class="text-sm opacity-80">Pelatihan dan sertifikasi guru ngaji</p>
                    </div>
                </div>

                <div class="card glass">
                    <div class="card-body items-center text-center">
                        <div class="bg-warning/20 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="card-title text-lg">Masjid Binaan</h3>
                        <p class="text-sm opacity-80">Pembinaan dan pendampingan masjid</p>
                    </div>
                </div>

                <div class="card glass">
                    <div class="card-body items-center text-center">
                        <div class="bg-warning/20 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <h3 class="card-title text-lg">Digitalisasi</h3>
                        <p class="text-sm opacity-80">Sistem informasi manajemen terpadu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="berita" class="py-16 bg-base-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-2">Berita & Kegiatan</h2>
                    <div class="w-24 h-1 bg-warning"></div>
                </div>
                <a href="#" class="btn btn-outline btn-primary mt-4 md:mt-0">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- News Card 1 -->
                <div class="card bg-base-100 shadow-xl card-hover transition-all duration-300">
                    <figure class="relative">
                        <div
                            class="bg-gradient-to-br from-primary to-primary-focus w-full h-48 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <div class="badge badge-primary absolute top-4 left-4">BERITA</div>
                    </figure>
                    <div class="card-body">
                        <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>28 Januari 2026</span>
                        </div>
                        <h3 class="card-title text-lg line-clamp-2">
                            Pelaksanaan Musyawarah Wilayah BKPRMI
                        </h3>
                        <p class="text-sm text-base-content/70 line-clamp-3">
                            Musyawarah wilayah BKPRMI dilaksanakan untuk membahas program kerja dan konsolidasi
                            organisasi...
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <a href="#" class="btn btn-ghost btn-sm text-primary">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News Card 2 -->
                <div class="card bg-base-100 shadow-xl card-hover transition-all duration-300">
                    <figure class="relative">
                        <div
                            class="bg-gradient-to-br from-emerald-500 to-teal-600 w-full h-48 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="badge badge-success absolute top-4 left-4">LPPTKA</div>
                    </figure>
                    <div class="card-body">
                        <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>25 Januari 2026</span>
                        </div>
                        <h3 class="card-title text-lg line-clamp-2">
                            Pelatihan Guru TPA/TPQ Tingkat Nasional
                        </h3>
                        <p class="text-sm text-base-content/70 line-clamp-3">
                            LPPTKA-BKPRMI mengadakan pelatihan peningkatan kapasitas guru TPA/TPQ secara nasional...
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <a href="#" class="btn btn-ghost btn-sm text-primary">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- News Card 3 -->
                <div class="card bg-base-100 shadow-xl card-hover transition-all duration-300">
                    <figure class="relative">
                        <div
                            class="bg-gradient-to-br from-amber-500 to-orange-600 w-full h-48 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white/50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="badge badge-warning absolute top-4 left-4">SOSIAL</div>
                    </figure>
                    <div class="card-body">
                        <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>20 Januari 2026</span>
                        </div>
                        <h3 class="card-title text-lg line-clamp-2">
                            BKPRMI Peduli: Bantuan untuk Korban Bencana
                        </h3>
                        <p class="text-sm text-base-content/70 line-clamp-3">
                            BKPRMI menyalurkan bantuan kepada warga yang terdampak bencana sebagai bentuk kepedulian...
                        </p>
                        <div class="card-actions justify-end mt-4">
                            <a href="#" class="btn btn-ghost btn-sm text-primary">
                                Baca Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-base-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="card bg-gradient-to-r from-primary to-primary-focus text-primary-content shadow-2xl">
                <div class="card-body items-center text-center py-12">
                    <div class="badge badge-warning badge-lg mb-4">AYO KEMBALI KE MASJID</div>
                    <h2 class="card-title text-3xl lg:text-4xl font-bold mb-4">
                        Bergabung Bersama BKPRMI
                    </h2>
                    <p class="max-w-2xl mb-8 opacity-90">
                        Mari bersama-sama memakmurkan masjid dan membina generasi muda muslim Indonesia.
                        Daftarkan TPA/TPQ Anda atau bergabung sebagai relawan.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="#" class="btn btn-warning btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar Sekarang
                        </a>
                        <a href="#kontak"
                            class="btn btn-outline btn-lg text-white border-white hover:bg-white hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-16 bg-base-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4">Hubungi Kami</h2>
                <div class="w-24 h-1 bg-warning mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Address -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Alamat</h3>
                        <p class="text-base-content/70 text-sm">
                            Sekretariat DPP BKPRMI<br>
                            Jl. Masjid No. 1<br>
                            Jakarta Pusat, Indonesia
                        </p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Telepon</h3>
                        <p class="text-base-content/70 text-sm">
                            +62 21 1234 5678<br>
                            +62 812 3456 7890
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Email</h3>
                        <p class="text-base-content/70 text-sm">
                            info@bkprmi.or.id<br>
                            admin@bkprmi.or.id
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="text-center mt-12">
                <h3 class="font-bold mb-4">Ikuti Kami</h3>
                <div class="flex justify-center gap-4">
                    <a href="#" class="btn btn-circle btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#" class="btn btn-circle btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                    <a href="#" class="btn btn-circle btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#" class="btn btn-circle btn-outline btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                    </a>
                    <a href="#" class="btn btn-circle btn-outline btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer footer-center bg-primary text-primary-content p-10">
        <aside>
            <img src="/icons/icon-72x72.png" alt="Logo BKPRMI" class="h-16 w-16 mb-4">
            <p class="font-bold text-lg">
                SIM BKPRMI
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
    // Back to top button visibility
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 300) {
            backToTop.style.opacity = '1';
        } else {
            backToTop.style.opacity = '0';
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-slide carousel
    let currentSlide = 1;
    setInterval(() => {
        currentSlide = currentSlide >= 3 ? 1 : currentSlide + 1;
        document.querySelector(`#slide${currentSlide}`).scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'start'
        });
    }, 5000);
    </script>
</body>

</html>
