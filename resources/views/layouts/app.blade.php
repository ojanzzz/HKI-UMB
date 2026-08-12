<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Informasi HKI UM BIMA - Sentra HKI Universitas Muhammadiyah Bima')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                            DEFAULT: '#DC2626',
                            hover: '#B91C1C',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 flex flex-col min-h-screen">

    <!-- 1. Top Government Header Bar (Deep University Green) -->
    <div class="bg-[#064E3B] text-white py-1.5 px-4 sm:px-8 flex justify-between items-center text-[11px] font-medium border-b border-emerald-950/60 shadow-xs">
        <div class="flex items-center space-x-3">
            <span class="font-bold tracking-wider text-emerald-100">UNIVERSITAS MUHAMMADIYAH BIMA</span>
            <span class="text-emerald-300/40 hidden sm:inline">|</span>
            <span class="text-emerald-200 font-semibold hidden md:inline tracking-wide">SENTRA HKI & DIREKTORAT JENDERAL KEKAYAAN INTELEKTUAL</span>
        </div>
        <div class="flex items-center space-x-2 sm:space-x-3">
            <a href="tel:152" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-bold transition shadow-xs">
                CALL CENTER 152
            </a>
            <span class="hidden sm:inline-block bg-amber-500 hover:bg-amber-600 text-slate-950 px-2.5 py-0.5 roundedプール font-bold text-[11px] transition shadow-xs uppercase tracking-wide">
                HALO DJKI UM BIMA
            </span>
        </div>
    </div>

    <!-- 2. Navigation Bar (Public Navigation Only) -->
    <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-40 shadow-sm">
        <div class="flex items-center space-x-3">
            <!-- Mobile Hamburger Menu Button -->
            <button id="publicMobileMenuBtn" class="lg:hidden text-slate-700 hover:text-emerald-700 p-1.5 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle Public Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-[#064E3B] rounded-lg flex items-center justify-center text-white font-extrabold text-xs text-center leading-tight shadow-xs shrink-0">
                    HKI<br>UMB
                </div>
                <div>
                    <h1 class="text-sm sm:text-base font-extrabold text-slate-900 leading-none tracking-tight">SENTRA HKI UM BIMA</h1>
                    <p class="text-[9px] sm:text-[10px] text-emerald-700 uppercase tracking-widest font-bold mt-1">Universitas Muhammadiyah Bima</p>
                </div>
            </a>
        </div>

        <!-- Desktop Menu Items: BERANDA, PANDUAN, TENTANG, FAQ -->
        <nav class="hidden lg:flex items-center space-x-6 text-xs font-bold tracking-wider uppercase text-slate-700">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 py-2 border-b-2 {{ request()->routeIs('home') ? 'text-emerald-700 border-emerald-600' : 'border-transparent' }}">BERANDA</a>
            <a href="{{ route('panduan') }}" class="hover:text-emerald-700 py-2 border-b-2 {{ request()->routeIs('panduan') ? 'text-emerald-700 border-emerald-600' : 'border-transparent' }}">PANDUAN</a>
            <a href="{{ route('tentang') }}" class="hover:text-emerald-700 py-2 border-b-2 {{ request()->routeIs('tentang') ? 'text-emerald-700 border-emerald-600' : 'border-transparent' }}">TENTANG</a>
            <a href="{{ route('faq') }}" class="hover:text-emerald-700 py-2 border-b-2 {{ request()->routeIs('faq') ? 'text-emerald-700 border-emerald-600' : 'border-transparent' }}">FAQ</a>
        </nav>

        <div class="flex items-center space-x-2 sm:space-x-4">
            @auth
                <!-- Profile Card Button: Click to go directly to Dashboard -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="flex items-center space-x-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 px-2.5 sm:px-3 py-1.5 rounded-lg transition-all group" title="Klik untuk membuka Dashboard {{ auth()->user()->isAdmin() ? 'Admin' : 'Pemohon' }}">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-amber-500 text-slate-950 font-extrabold rounded-full flex items-center justify-center text-xs shrink-0 group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <div class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-800 leading-tight transition-colors">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-[9px] text-emerald-700 font-bold uppercase tracking-wider flex items-center gap-1">
                                <span>KE DASHBOARD {{ auth()->user()->isAdmin() ? 'ADMIN' : 'PEMOHON' }}</span>
                                <span>&rarr;</span>
                            </div>
                        </div>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-xs">
                            LOGOUT
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white px-4 sm:px-5 py-2 sm:py-2.5 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-xs">
                    LOGIN
                </a>
            @endauth
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="publicMobileDrawer" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex flex-col justify-start p-4">
        <div class="bg-white rounded-2xl p-6 space-y-4 shadow-2xl border border-slate-200">
            <div class="flex justify-between items-center border-b border-slate-200 pb-3">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-[#064E3B] rounded-lg text-white font-extrabold text-[10px] flex items-center justify-center">HKI</div>
                    <span class="font-extrabold text-xs text-slate-900 uppercase">MENU SENTRA HKI UM BIMA</span>
                </div>
                <button id="closePublicMobileDrawer" class="text-slate-500 hover:text-red-600 font-extrabold text-xl">&times;</button>
            </div>

            <nav class="flex flex-col space-y-2 text-xs font-bold uppercase tracking-wider text-slate-800">
                <a href="{{ route('home') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('home') ? 'bg-emerald-100 text-emerald-900 font-extrabold' : '' }}">🌐 BERANDA</a>
                <a href="{{ route('panduan') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('panduan') ? 'bg-emerald-100 text-emerald-900 font-extrabold' : '' }}">📖 PANDUAN PENGAJUAN</a>
                <a href="{{ route('tentang') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('tentang') ? 'bg-emerald-100 text-emerald-900 font-extrabold' : '' }}">🏢 TENTANG SENTRA HKI</a>
                <a href="{{ route('faq') }}" class="p-3 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition {{ request()->routeIs('faq') ? 'bg-emerald-100 text-emerald-900 font-extrabold' : '' }}">❓ FAQ & BANTUAN</a>

                @auth
                    <div class="pt-2 border-t border-slate-200"></div>
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="p-3 rounded-lg bg-[#064E3B] text-white font-extrabold flex items-center justify-between">
                        <span>KE DASHBOARD {{ auth()->user()->isAdmin() ? 'ADMIN' : 'PEMOHON' }}</span>
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
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Sentra HKI Universitas Muhammadiyah Bima</h4>
                <p class="text-emerald-100 leading-relaxed">
                    Portal Sentra Hak Kekayaan Intelektual Universitas Muhammadiyah Bima (UM BIMA). Memfasilitasi pendaftaran Paten, Cipta, dan Inovasi sivitas akademika ke DJKI Kemenkumham RI.
                </p>
            </div>
            <div>
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Tautan Penting</h4>
                <ul class="space-y-2 text-emerald-100 font-medium">
                    <li><a href="https://dgip.go.id" target="_blank" class="hover:text-amber-400">Portal Resmi DJKI Kemenkumham</a></li>
                    <li><a href="https://pdki-indonesia.dgip.go.id" target="_blank" class="hover:text-amber-400">Pangkalan Data HKI (PDKI)</a></li>
                    <li><a href="https://e-meterai.co.id" target="_blank" class="hover:text-amber-400">Pembelian E-Meterai Resmi</a></li>
                    <li><a href="https://umbima.ac.id" target="_blank" class="hover:text-amber-400">Universitas Muhammadiyah Bima</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-extrabold uppercase tracking-wider text-sm mb-3 text-white">Kontak Sentra HKI UM BIMA</h4>
                <p class="text-emerald-100 leading-relaxed">
                    Gedung Rektorat UM BIMA Lt. 2<br>
                    Jl. Anggrek No. 16, Kota Bima, Nusa Tenggara Barat<br>
                    Email: hki@umbima.ac.id
                </p>
            </div>
        </div>

        <div class="bg-slate-100 border-t border-slate-200 px-6 sm:px-12 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-600 font-semibold">
            <div>© {{ date('Y') }} Sentra HKI Universitas Muhammadiyah Bima (UM BIMA) - Terintegrasi DJKI Kemenkumham RI</div>
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
