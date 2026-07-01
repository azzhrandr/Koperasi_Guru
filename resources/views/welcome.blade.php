<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Informasi Koperasi Guru</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Fallback Tailwind CSS CDN jika asset belum dicompile secara lokal -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'media',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                            },
                            colors: {
                                emerald: {
                                    50: '#ecfdf5',
                                    100: '#d1fae5',
                                    200: '#a7f3d0',
                                    300: '#6ee7b7',
                                    400: '#34d399',
                                    500: '#10b981',
                                    600: '#059669',
                                    700: '#047857',
                                    800: '#065f46',
                                    900: '#064e3b',
                                },
                            }
                        }
                    }
                }
            </script>
        @endif

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .dark .glassmorphism {
                background: rgba(15, 23, 42, 0.75);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
        </style>
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 antialiased selection:bg-emerald-500 selection:text-white transition-colors duration-300 overflow-x-hidden font-sans">
        
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 glassmorphism border-b border-slate-200/50 dark:border-slate-800/50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <!-- Brand/Logo -->
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-tr from-emerald-500 to-teal-600 rounded-xl shadow-md shadow-emerald-500/20 text-white">
                            <!-- Logo SVG (Shield + Book + Grow leaf representing Cooperative of Teachers) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253M12 4v16m0-16V3" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l3-3 3 3" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-lg sm:text-xl tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">Koperasi<span class="text-emerald-600 dark:text-emerald-400">Guru</span></span>
                            <span class="block text-[10px] sm:text-xs font-semibold text-slate-500 dark:text-slate-400 tracking-wider uppercase leading-none">Sistem Informasi</span>
                        </div>
                    </div>

                    <!-- Navigation Menu (Desktop) -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#fitur" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Fitur</a>
                        <a href="#keunggulan" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Keunggulan</a>
                        <a href="#kontak" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Kontak</a>
                    </div>

                    <!-- CTA Buttons / Auth Status -->
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-600/30 transition-all duration-300 hover:-translate-y-0.5 group">
                                    <span>Dashboard</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all">
                                    Masuk
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded-xl transition-all duration-300">
                                        Daftar Anggota
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-8 pb-16 sm:py-24 md:py-32 overflow-hidden">
            <!-- Background Decorative Blobs -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
            <div class="absolute top-1/3 left-10 w-[300px] h-[300px] bg-teal-500/10 dark:bg-teal-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Hero Content Left (7 Columns) -->
                    <div class="lg:col-span-7 text-center lg:text-left space-y-6 sm:space-y-8">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 dark:bg-emerald-400/10 text-emerald-700 dark:text-emerald-300 text-xs sm:text-sm font-semibold border border-emerald-500/20">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Sistem Informasi Koperasi Digital Terpercaya</span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1] sm:leading-none">
                            Sistem Informasi <br class="hidden sm:inline">
                            <span class="bg-gradient-to-r from-emerald-600 via-teal-500 to-amber-500 dark:from-emerald-400 dark:via-teal-400 dark:to-amber-300 bg-clip-text text-transparent">Koperasi Guru</span>
                        </h1>

                        <!-- Description -->
                        <p class="max-w-xl mx-auto lg:mx-0 text-base sm:text-lg md:text-xl text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                            Platform digital modern untuk mengelola simpanan, pinjaman, data anggota, serta seluruh transaksi keuangan Koperasi Guru secara terintegrasi, transparan, aman, dan mudah diakses.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-2xl shadow-xl shadow-emerald-500/20 hover:shadow-emerald-600/35 transition-all duration-300 hover:-translate-y-1">
                                    Dashboard Utama
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-2xl shadow-xl shadow-emerald-500/20 hover:shadow-emerald-600/35 transition-all duration-300 hover:-translate-y-1">
                                    Masuk ke Portal
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-2xl shadow-md transition-all duration-300 hover:-translate-y-1">
                                        Registrasi Anggota
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <!-- Stats Highlights -->
                        <div class="grid grid-cols-3 gap-4 pt-6 max-w-md mx-auto lg:mx-0 border-t border-slate-200/60 dark:border-slate-800/60">
                            <div>
                                <span class="block text-2xl sm:text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">100%</span>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aman & Terenkripsi</span>
                            </div>
                            <div class="border-x border-slate-200/60 dark:border-slate-800/60 px-2">
                                <span class="block text-2xl sm:text-3xl font-extrabold text-teal-600 dark:text-teal-400">Real-Time</span>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Informasi Saldo</span>
                            </div>
                            <div>
                                <span class="block text-2xl sm:text-3xl font-extrabold text-amber-500 dark:text-amber-400">Paperless</span>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanpa Dokumen Fisik</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Visual Right (5 Columns) -->
                    <div class="lg:col-span-5 relative w-full max-w-md lg:max-w-none mx-auto">
                        <!-- Background Glow effect -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 to-teal-500/20 rounded-3xl filter blur-2xl -z-10"></div>
                        
                        <!-- Visual Container (Mockup Dashboard) -->
                        <div class="w-full bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 sm:p-6 transition-all duration-300 relative overflow-hidden group hover:border-emerald-500/30">
                            
                            <!-- Header Mockup -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-emerald-500/10 dark:bg-emerald-400/10 flex items-center justify-center font-bold text-xs text-emerald-600 dark:text-emerald-400">
                                        KG
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Kartu Dashboard Anggota</div>
                                        <div class="text-[9px] text-slate-400 uppercase tracking-wider font-semibold">Koperasi Guru Mandiri</div>
                                    </div>
                                </div>
                                <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            </div>

                            <!-- Balance Card Mockup -->
                            <div class="mt-4 p-4 bg-gradient-to-br from-slate-900 to-slate-800 dark:from-emerald-950 dark:to-slate-900 text-white rounded-2xl shadow-md relative overflow-hidden">
                                <div class="absolute -right-10 -bottom-10 w-28 h-28 bg-emerald-500/10 rounded-full blur-xl"></div>
                                <span class="text-[10px] font-semibold text-slate-400 dark:text-emerald-400 uppercase tracking-wider block">Total Simpanan Guru</span>
                                <span class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1 block">Rp 24.580.000</span>
                                <div class="flex justify-between items-center mt-4 text-[10px] text-slate-400">
                                    <span>No. Anggota: KPG-202604</span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 font-semibold">Aktif</span>
                                </div>
                            </div>

                            <!-- Financial Mini Chart SVG -->
                            <div class="mt-4 bg-slate-50 dark:bg-slate-950 rounded-2xl p-4 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Grafik Simpanan (1 Tahun)</span>
                                    <span class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400">+12.5% SHU</span>
                                </div>
                                <svg viewBox="0 0 100 35" class="w-full h-16 text-emerald-500" fill="none" stroke="currentColor">
                                    <defs>
                                        <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="rgba(16,185,129,0.3)"/>
                                            <stop offset="100%" stop-color="rgba(16,185,129,0)"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M 0 30 Q 15 28 25 18 T 50 15 T 75 8 T 100 2" stroke-width="2" stroke-linecap="round" />
                                    <path d="M 0 30 Q 15 28 25 18 T 50 15 T 75 8 T 100 2 L 100 35 L 0 35 Z" fill="url(#chartGrad)" stroke="none" />
                                    <!-- Circles indicators -->
                                    <circle cx="25" cy="18" r="1.5" fill="#10b981" />
                                    <circle cx="50" cy="15" r="1.5" fill="#10b981" />
                                    <circle cx="75" cy="8" r="1.5" fill="#10b981" />
                                    <circle cx="100" cy="2" r="2.5" fill="#10b981" />
                                </svg>
                            </div>

                            <!-- List of Recent Transactions -->
                            <div class="mt-4 space-y-2.5">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block">Aktivitas Terakhir</span>
                                
                                <!-- Trx 1 -->
                                <div class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-100 dark:border-slate-800/80">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Setoran Simpanan Wajib</div>
                                            <div class="text-[9px] text-slate-400">Hari ini, 08:30</div>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">+Rp 100.000</span>
                                </div>

                                <!-- Trx 2 -->
                                <div class="flex items-center justify-between p-2.5 bg-slate-50 dark:bg-slate-950 rounded-xl border border-slate-100 dark:border-slate-800/80">
                                    <div class="flex items-center gap-2">
                                        <div class="p-1.5 bg-amber-500/10 dark:bg-amber-500/20 text-amber-500 dark:text-amber-400 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Pembayaran Cicilan Pinjaman</div>
                                            <div class="text-[9px] text-slate-400">Kemarin, 14:15</div>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">-Rp 750.000</span>
                                </div>
                            </div>

                            <!-- Floating Badges / Achievements -->
                            <div class="absolute -right-3 top-28 bg-emerald-500 dark:bg-emerald-600 text-white px-3 py-1.5 rounded-xl shadow-lg flex items-center gap-1.5 animate-[bounce_4s_infinite] border border-emerald-400/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="text-[10px] font-bold tracking-wide uppercase">100% Aman</span>
                            </div>

                            <div class="absolute -left-4 bottom-24 bg-amber-500 text-slate-900 px-3 py-1.5 rounded-xl shadow-lg flex items-center gap-1.5 animate-[bounce_5s_infinite] border border-amber-400/20">
                                <span class="text-[10px] font-extrabold tracking-wide uppercase">Bunga Rendah</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 sm:py-28 bg-white dark:bg-slate-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <h2 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Fitur Utama</h2>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Layanan Koperasi Digital Kami</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-base sm:text-lg font-medium leading-relaxed">
                        Kami menyediakan empat pilar fitur utama untuk memudahkan seluruh transaksi simpan-pinjam dan pengelolaan data administrasi para guru.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                    
                    <!-- Fitur 1: Manajemen Data Anggota -->
                    <div class="group bg-slate-50 dark:bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-slate-200 mb-3">Manajemen Data Anggota</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                            Pendaftaran secara online yang praktis. Pengurus dapat memverifikasi berkas, mengelola profil guru, dan memantau keaktifan anggota secara digital.
                        </p>
                    </div>

                    <!-- Fitur 2: Simpanan -->
                    <div class="group bg-slate-50 dark:bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-500 dark:text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-slate-200 mb-3">Simpanan</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                            Pencatatan transparan untuk Simpanan Pokok, Simpanan Wajib, dan Simpanan Sukarela. Anggota dapat melihat mutasi dan perkembangan tabungan real-time.
                        </p>
                    </div>

                    <!-- Fitur 3: Pinjaman -->
                    <div class="group bg-slate-50 dark:bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 dark:bg-teal-500/20 text-teal-500 dark:text-teal-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-slate-200 mb-3">Pinjaman</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                            Kalkulator pengajuan cicilan otomatis, pengajuan pinjaman online secara efisien, serta transparansi bunga dan riwayat sisa cicilan anggota.
                        </p>
                    </div>

                    <!-- Fitur 4: Laporan -->
                    <div class="group bg-slate-50 dark:bg-slate-950 p-6 sm:p-8 rounded-3xl border border-slate-200/50 dark:border-slate-800/50 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-500 dark:text-purple-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-extrabold text-slate-800 dark:text-slate-200 mb-3">Laporan</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                            Laporan keuangan kas koperasi bulanan, grafik profitabilitas, data sisa hasil usaha (SHU), dan transparansi laporan tahunan bagi anggota.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Advantages Section -->
        <section id="keunggulan" class="py-20 sm:py-28 relative overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
            <!-- Blur light decorative -->
            <div class="absolute -right-40 top-1/2 w-[350px] h-[350px] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left Columns (Visual Presentation) -->
                    <div class="lg:col-span-5 relative flex justify-center">
                        <div class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-500/5 filter blur-3xl rounded-full -z-10"></div>
                        <!-- Security badge design -->
                        <div class="p-8 sm:p-12 bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-slate-200/50 dark:border-slate-800/50 max-w-sm text-center relative overflow-hidden group hover:border-emerald-500/20">
                            <!-- Background decoration -->
                            <div class="absolute -top-16 -right-16 w-32 h-32 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors"></div>
                            
                            <!-- Large shield badge -->
                            <div class="w-20 h-20 rounded-full bg-emerald-500/10 dark:bg-emerald-400/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 animate-[pulse_3s_infinite]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-extrabold text-slate-800 dark:text-slate-200 mb-2">Transparan & Aman</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                Sistem kami memastikan semua proses keuangan terverifikasi otomatis dengan standard enkripsi terkini demi keamanan dana anggota.
                            </p>
                            
                            <div class="mt-6 flex items-center justify-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest bg-emerald-500/10 dark:bg-emerald-500/20 px-3 py-1.5 rounded-full">
                                Verified Secure
                            </div>
                        </div>
                    </div>

                    <!-- Right Columns (Advantages Grid) -->
                    <div class="lg:col-span-7 space-y-8">
                        <div class="space-y-4">
                            <h2 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Keunggulan Sistem</h2>
                            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Kelebihan Menggunakan Aplikasi Kami</h3>
                            <p class="text-slate-500 dark:text-slate-400 font-medium text-base sm:text-lg leading-relaxed">
                                Sistem Informasi Koperasi Guru dirancang untuk memberikan kemudahan pelayanan simpan pinjam digital yang transparan dan dapat dipantau langsung.
                            </p>
                        </div>

                        <!-- Advantages Points -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-4">
                            
                            <!-- Poin 1 -->
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Transparan & Real-Time</h4>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                    Setiap nominal setoran simpanan atau potongan cicilan pinjaman tercatat instan pada profil dashboard Anda secara terbuka.
                                </p>
                            </div>

                            <!-- Poin 2 -->
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Keamanan Enkripsi Data</h4>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                    Keamanan transaksi terlindungi enkripsi end-to-end untuk memastikan privasi serta kerahasiaan nominal dana simpanan guru tetap aman.
                                </p>
                            </div>

                            <!-- Poin 3 -->
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Akses Fleksibel & Cepat</h4>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                    Dapat diakses kapan saja dan di mana saja melalui browser ponsel, tablet, maupun laptop secara cepat dan sangat responsif.
                                </p>
                            </div>

                            <!-- Poin 4 -->
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="p-1 bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Paperless & Efisien</h4>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                    Kurangi penumpukan berkas fisik. Seluruh pengajuan pinjaman dan persetujuan pengurus dilakukan secara online dan efisien.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer id="kontak" class="bg-slate-900 text-slate-400 py-16 transition-colors duration-300 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 pb-12 border-b border-slate-800">
                    
                    <!-- Left Col (Brand) -->
                    <div class="space-y-4 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-2.5">
                            <div class="p-2 bg-gradient-to-tr from-emerald-500 to-teal-600 rounded-xl text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253M12 4v16m0-16V3" />
                                </svg>
                            </div>
                            <span class="font-extrabold text-lg text-white tracking-tight">Koperasi<span class="text-emerald-500">Guru</span></span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium max-w-sm mx-auto md:mx-0">
                            Sistem portal digital untuk mewujudkan tata kelola keuangan koperasi guru yang kredibel, aman, terpercaya, dan menyejahterakan anggota secara merata.
                        </p>
                    </div>

                    <!-- Center Col (Quick Links) -->
                    <div class="text-center md:text-left space-y-4">
                        <h4 class="text-sm font-extrabold text-white uppercase tracking-wider">Akses Navigasi</h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm font-semibold">
                            <li><a href="#" class="hover:text-emerald-500 transition-colors">Beranda</a></li>
                            <li><a href="#fitur" class="hover:text-emerald-500 transition-colors">Fitur Utama</a></li>
                            <li><a href="#keunggulan" class="hover:text-emerald-500 transition-colors">Keunggulan Sistem</a></li>
                        </ul>
                    </div>

                    <!-- Right Col (Contact / Info) -->
                    <div class="text-center md:text-left space-y-4">
                        <h4 class="text-sm font-extrabold text-white uppercase tracking-wider">Hubungi Kami</h4>
                        <ul class="space-y-3 text-xs sm:text-sm font-medium">
                            <li class="flex items-center justify-center md:justify-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>kontak@koperasiguru.org</span>
                            </li>
                            <li class="flex items-center justify-center md:justify-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>(021) 8765-4321</span>
                            </li>
                            <li class="flex items-start justify-center md:justify-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-emerald-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="max-w-[220px]">Gedung Guru Indonesia Lt. 2, Jl. Pendidikan No. 45, Jakarta</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- Bottom Footer (Copyright) -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center text-xs text-slate-600">
                    <p>&copy; 2026 Koperasi Guru Indonesia. Hak Cipta Dilindungi.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                        <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>