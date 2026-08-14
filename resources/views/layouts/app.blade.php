<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Informasi KI UM BIMA - Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/apple-touch-icon.png') }}">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            850: '#064E3B',
                            900: '#065F46',
                            800: '#047857',
                            700: '#059669',
                        },
                        republic: {
                            green: '#064E3B',
                            gold: '#D97706',
                            red: '#DC2626',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col selection:bg-emerald-600 selection:text-white">

    <!-- 1. Top Bar Republik / Lembaga -->
    <div class="bg-[#064E3B] text-white py-1.5 px-4 sm:px-8 flex justify-between items-center text-[11px] font-medium border-b border-emerald-950/60 shadow-xs">
        <div class="flex items-center space-x-3">
            <span class="font-bold tracking-wider text-emerald-100">UNIVERSITAS MUHAMMADIYAH BIMA</span>
            <span class="text-emerald-300/40 hidden sm:inline">|</span>
            <span class="text-emerald-200 font-semibold hidden md:inline tracking-wide">DIREKTORAT INOVASI DAN KEKAYAAN INTELEKTUAL (KI) & DJKI</span>
        </div>
        <div class="flex items-center space-x-2 sm:space-x-3">
            <a href="tel:152" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-bold transition shadow-xs">
                CALL CENTER 152
            </a>
            <span class="hidden sm:inline-block bg-amber-500 hover:bg-amber-600 text-slate-950 px-2.5 py-0.5 rounded font-bold text-[11px] transition shadow-xs uppercase tracking-wide">
                HALO DJKI UM BIMA
            </span>
        </div>
    </div>

    <!-- 2. Navigation Bar (Public Navigation Only) -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-4 sm:px-6 py-3 flex justify-between items-center sticky top-0 z-40 shadow-sm">
        <div class="flex items-center space-x-3">
            <!-- Mobile Hamburger Menu Button -->
            <button id="publicMobileMenuBtn" class="lg:hidden text-slate-700 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle Public Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-11 h-11 sm:w-14 sm:h-14 bg-white rounded-xl border border-slate-200 shadow-sm flex items-center justify-center p-1 group-hover:border-emerald-300 transition-colors">
                    <img src="{{ asset('logo/logo.png') }}" alt="Logo KI UMB" class="w-full h-full object-contain">
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-xs sm:text-sm font-extrabold text-slate-900 leading-none tracking-tight">DIREKTORAT INOVASI & KEKAYAAN INTELEKTUAL (KI)</h1>
                    <p class="text-[9px] sm:text-[10px] text-emerald-700 uppercase tracking-widest font-bold mt-1">Universitas Muhammadiyah Bima</p>
                </div>
            </a>
        </div>

        <!-- Desktop Menu Items -->
        <nav class="hidden lg:flex items-center space-x-1 text-xs font-bold tracking-wider uppercase text-slate-700">
            <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : '' }}">Beranda</a>
            <a href="{{ route('panduan') }}" class="px-3 py-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('panduan') ? 'bg-emerald-50 text-emerald-700' : '' }}">Panduan</a>
            <a href="{{ route('tentang') }}" class="px-3 py-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('tentang') ? 'bg-emerald-50 text-emerald-700' : '' }}">Tentang</a>
            <a href="{{ route('faq') }}" class="px-3 py-2 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('faq') ? 'bg-emerald-50 text-emerald-700' : '' }}">FAQ</a>
        </nav>

        <!-- Right Action Buttons -->
        <div class="flex items-center space-x-2.5">
            @guest
                <a href="{{ route('login') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow-md flex items-center space-x-2">
                    <span>Masuk</span>
                    <svg class="w-3.5 h-3.5 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
                <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow-md hidden sm:inline-flex items-center space-x-2">
                    <span>Daftar</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </a>
            @else
                <div class="flex items-center space-x-3">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow-md flex items-center space-x-2">
                        <span>Dashboard</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </a>
                </div>
            @endguest
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="publicMobileDrawer" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm flex flex-col justify-start p-4">
        <div class="bg-white rounded-2xl p-6 space-y-4 shadow-2xl border border-slate-200 w-full max-w-sm">
            <div class="flex justify-between items-center border-b border-slate-200 pb-3">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo/logo.png') }}" alt="Logo KI UMB" class="w-8 h-8 object-contain">
                    <span class="font-extrabold text-xs text-slate-900 uppercase">KI UM BIMA</span>
                </div>
                <button id="closePublicMobileDrawer" class="text-slate-500 hover:text-red-600 font-extrabold text-xl">&times;</button>
            </div>

            <nav class="flex flex-col space-y-1 text-xs font-bold uppercase tracking-wider text-slate-800">
                <a href="{{ route('home') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('home') ? 'bg-emerald-100 text-emerald-900' : '' }}">Beranda</a>
                <a href="{{ route('panduan') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('panduan') ? 'bg-emerald-100 text-emerald-900' : '' }}">Panduan</a>
                <a href="{{ route('tentang') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('tentang') ? 'bg-emerald-100 text-emerald-900' : '' }}">Tentang</a>
                <a href="{{ route('faq') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('faq') ? 'bg-emerald-100 text-emerald-900' : '' }}">FAQ</a>

                @auth
                    <div class="pt-2 border-t border-slate-200"></div>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="p-3 rounded-lg bg-[#064E3B] text-white font-extrabold flex items-center justify-between">
                        <span>Dashboard</span>
                        <span>&rarr;</span>
                    </a>
                @endauth
            </nav>
        </div>
    </div>

    <!-- Alert Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-md text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-md text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 font-bold">&times;</button>
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded-md text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                <span>{{ session('warning') }}</span>
                <button onclick="this.parentElement.remove()" class="text-amber-600 hover:text-amber-900 font-bold">&times;</button>
            </div>
        @endif
        @if(session('info'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-md text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                <span>{{ session('info') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Deep Emerald Green -->
    <footer class="bg-[#064E3B] text-white pt-10 border-t-4 border-amber-500 mt-12">
        <div class="max-w-7xl mx-auto px-6 pb-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-xs">
            <div>
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima</h4>
                <p class="text-emerald-100 leading-relaxed">
                    Portal Direktorat Inovasi dan Kekayaan Intelektual (KI) Universitas Muhammadiyah Bima (UM BIMA). Memfasilitasi pendaftaran Paten, Cipta, dan Inovasi sivitas akademika ke DJKI Kemenkumham RI.
                </p>
            </div>
            <div>
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Tautan Penting</h4>
                <ul class="space-y-2 text-emerald-100 font-medium">
                    <li><a href="https://dgip.go.id" target="_blank" class="hover:text-amber-400">Portal Resmi DJKI Kemenkumham</a></li>
                    <li><a href="https://pdki-indonesia.dgip.go.id" target="_blank" class="hover:text-amber-400">Pangkalan Data Kekayaan Intelektual (PDKI)</a></li>
                    <li><a href="https://e-meterai.co.id" target="_blank" class="hover:text-amber-400">Pembelian E-Meterai Resmi</a></li>
                    <li><a href="https://umbima.ac.id" target="_blank" class="hover:text-amber-400">Universitas Muhammadiyah Bima</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Kontak Direktorat Inovasi & KI UM BIMA</h4>
                <p class="text-emerald-100 leading-relaxed">
                    Gedung Rektorat UM BIMA Lt. 2<br>
                    Jl. Anggrek No. 16, Kota Bima, Nusa Tenggara Barat<br>
                    Email: hki@umbima.ac.id
                </p>
            </div>
        </div>

        <div class="bg-slate-100 border-t border-slate-200 px-6 sm:px-12 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-600 font-semibold">
            <div>© {{ date('Y') }} Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima - Terintegrasi DJKI Kemenkumham RI</div>
            <div class="flex items-center space-x-6 font-semibold">
                <a href="{{ route('panduan') }}" class="hover:text-slate-900 transition">Panduan Layanan</a>
                <a href="{{ route('tentang') }}" class="hover:text-slate-900 transition">Tentang Kami</a>
                <a href="{{ route('faq') }}" class="hover:text-slate-900 transition">FAQ</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('publicMobileMenuBtn');
            const closeBtn = document.getElementById('closePublicMobileDrawer');
            const drawer = document.getElementById('publicMobileDrawer');

            if (openBtn && drawer && closeBtn) {
                openBtn.addEventListener('click', function() {
                    drawer.classList.remove('hidden');
                });
                closeBtn.addEventListener('click', function() {
                    drawer.classList.add('hidden');
                });
                drawer.addEventListener('click', function(e) {
                    if (e.target === drawer) drawer.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>
