<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Direktorat Inovasi & KI UM BIMA')</title>

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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Smooth Collapsible Sidebar Transitions */
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Collapsed state styles */
        .sidebar-collapsed .sidebar-text {
            display: none !important;
        }
        .sidebar-collapsed .sidebar-logo-sub {
            display: none !important;
        }
        .sidebar-collapsed .sidebar-[#064E3B] {
            width: 5rem !important; /* 80px */
        }
        .sidebar-collapsed .sidebar-menu-item {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col">

    <div class="flex flex-1 min-h-screen relative overflow-x-hidden" id="appLayout">
        
        <!-- 1. LEFT SIDEBAR NAVIGATION (UI/UX Pro Max Collapsible Sidebar) -->
        <aside id="mainSidebar" class="bg-[#064E3B] text-white w-64 min-h-screen flex flex-col justify-between sidebar-transition z-40 fixed lg:static inset-y-0 left-0 -translate-x-full lg:translate-x-0 shadow-2xl border-r border-emerald-900/50">
            
            <!-- Sidebar Header & Branding -->
            <div>
                <div class="h-16 px-4 bg-[#043E2F] flex items-center justify-between border-b border-emerald-800/60">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 overflow-hidden">
                        <img src="{{ asset('logo/logo.png') }}" alt="Logo KI UMB" class="w-9 h-9 object-contain shrink-0">
                        <div class="sidebar-text truncate">
                            <h1 class="text-[10px] font-extrabold text-white tracking-tight leading-none uppercase">DIREKTORAT INOVASI & KI</h1>
                            <p class="text-[9px] text-emerald-300 font-bold tracking-widest mt-0.5 uppercase">UM BIMA</p>
                        </div>
                    </a>

                    <!-- Sidebar Toggle Button inside Header for Desktop -->
                    <button id="sidebarCollapseBtn" class="hidden lg:flex text-emerald-200 hover:text-white p-1.5 rounded-md hover:bg-emerald-800/60 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links List -->
                <nav class="p-3 space-y-1 text-xs font-bold tracking-wide">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <!-- ADMIN MENU ITEMS -->
                            <div class="px-3 py-2 text-[10px] text-emerald-300/70 uppercase tracking-wider sidebar-text font-extrabold">MENU ADMINISTRATOR</div>
                            
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📊</span>
                                <span class="sidebar-text">Dashboard Admin</span>
                            </a>

                            <a href="{{ route('admin.users') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.users*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">👤</span>
                                <span class="sidebar-text">Verifikasi Akun User</span>
                            </a>

                            <a href="{{ route('admin.manage-users') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.manage-users*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">👥</span>
                                <span class="sidebar-text">Manajemen User & Admin</span>
                            </a>

                            <a href="{{ route('admin.faculties') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.faculties*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">🏛️</span>
                                <span class="sidebar-text">Fakultas & Unit Kerja</span>
                            </a>

                            <a href="{{ route('admin.application-types') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.application-types*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">🏷️</span>
                                <span class="sidebar-text">Tipe Permohonan KI</span>
                            </a>

                            <a href="{{ route('admin.application-categories') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.application-categories*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📂</span>
                                <span class="sidebar-text">Kategori Pengajuan</span>
                            </a>

                            <a href="{{ route('admin.templates') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.templates*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📄</span>
                                <span class="sidebar-text">Templates Dokumen</span>
                            </a>

                            <a href="{{ route('admin.applications') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.applications*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📂</span>
                                <span class="sidebar-text">Review Permohonan KI</span>
                            </a>

                            <a href="{{ route('admin.activity-logs') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.activity-logs*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📜</span>
                                <span class="sidebar-text">Log Aktivitas System</span>
                            </a>

                            <a href="{{ route('admin.sliders') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.sliders*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">🖼️</span>
                                <span class="sidebar-text">Sliders Banner Hero</span>
                            </a>

                            <a href="{{ route('admin.popups') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.popups*') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📢</span>
                                <span class="sidebar-text">Welcome Popup Modal</span>
                            </a>

                        @else
                            <!-- USER MENU ITEMS -->
                            <div class="px-3 py-2 text-[10px] text-emerald-300/70 uppercase tracking-wider sidebar-text font-extrabold">MENU PEMOHON KI</div>

                            <a href="{{ route('user.dashboard') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('user.dashboard') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">📊</span>
                                <span class="sidebar-text">Dashboard Saya</span>
                            </a>

                            <a href="{{ route('applications.create') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('applications.create') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">➕</span>
                                <span class="sidebar-text">Ajukan Paten Baru</span>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="sidebar-menu-item flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('profile.edit') ? 'bg-amber-500 text-slate-950 font-extrabold shadow-md' : 'text-emerald-100 hover:bg-emerald-800/60 hover:text-white' }}">
                                <span class="text-base">👤</span>
                                <span class="sidebar-text">Profil Saya</span>
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <!-- Sidebar User Profile Footer -->
            @auth
            <div class="p-3 bg-[#043E2F] border-t border-emerald-800/60 flex items-center justify-between">
                <a href="{{ auth()->user()->isUser() ? route('profile.edit') : '#' }}" class="flex items-center space-x-3 overflow-hidden group">
                    <div class="w-8 h-8 bg-amber-500 text-slate-950 font-extrabold rounded-full flex items-center justify-center text-xs shrink-0 group-hover:scale-105 transition-transform">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="sidebar-text truncate">
                        <div class="text-xs font-bold text-white truncate group-hover:text-amber-400 transition-colors">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] text-emerald-300 font-bold uppercase">{{ auth()->user()->role }}</div>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="sidebar-text">
                    @csrf
                    <button type="submit" title="Logout" class="text-red-400 hover:text-red-300 p-1.5 rounded hover:bg-emerald-900/60 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        <!-- Overlay backdrop for Mobile Sidebar -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden"></div>

        <!-- 2. RIGHT MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-100">
            
            <!-- Top Navigation / Header Bar -->
            <header class="bg-white border-b border-slate-200 h-16 px-6 flex justify-between items-center sticky top-0 z-20 shadow-xs">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Hamburger Toggle Button -->
                    <button id="mobileSidebarToggle" class="lg:hidden text-slate-700 hover:text-emerald-700 p-2 rounded-lg hover:bg-slate-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Desktop Sidebar Toggle Button -->
                    <button id="desktopSidebarToggle" class="hidden lg:flex text-slate-700 hover:text-emerald-700 p-2 rounded-lg hover:bg-slate-100 transition" title="Toggle Sidebar Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>

                    <!-- Page Breadcrumb Title -->
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-tight">@yield('title', 'Dashboard Portal KI')</h2>
                        <p class="text-[10px] text-slate-500 font-semibold uppercase">Universitas Muhammadiyah Bima (UM BIMA)</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @auth
                        @php
                            $userNotifications = \App\Models\UserNotification::where('user_id', auth()->id())
                                ->latest()
                                ->take(6)
                                ->get();
                            $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp

                        <!-- Notification Bell Icon Dropdown -->
                        <div class="relative">
                            <button id="notifBellBtn" onclick="document.getElementById('notificationDropdown').classList.toggle('hidden')" class="relative p-2 text-slate-600 hover:text-[#064E3B] hover:bg-slate-100 rounded-full transition" title="Notifikasi System">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if($unreadCount > 0)
                                    <span class="absolute top-1 right-1 bg-red-600 text-white text-[9px] font-extrabold w-4 h-4 rounded-full flex items-center justify-center animate-pulse">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </button>

                            <!-- Notification Dropdown Menu -->
                            <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 text-xs overflow-hidden">
                                <div class="bg-[#064E3B] text-white px-4 py-3 flex justify-between items-center">
                                    <div class="font-extrabold uppercase tracking-wider text-xs flex items-center gap-1.5">
                                        <span>🔔</span> Notifikasi System
                                    </div>
                                    @if($unreadCount > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] bg-amber-500 hover:bg-amber-600 text-slate-950 px-2 py-0.5 rounded font-extrabold uppercase">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                    @forelse($userNotifications as $notif)
                                        <div class="p-3.5 hover:bg-slate-50 transition {{ $notif->is_read ? 'opacity-70' : 'bg-emerald-50/40 font-semibold' }}">
                                            <div class="flex justify-between items-start gap-2">
                                                <h4 class="font-bold text-slate-900 text-xs">{{ $notif->title }}</h4>
                                                <span class="text-[9px] text-slate-400 font-mono whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">{{ $notif->message }}</p>
                                            @if($notif->link_url)
                                                <a href="{{ $notif->link_url }}" class="inline-block mt-2 text-[#064E3B] font-extrabold text-[10px] uppercase hover:underline">
                                                    Lihat Detail &rarr;
                                                </a>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="p-6 text-center text-slate-500 font-medium">
                                            Belum ada notifikasi baru.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endauth

                    <a href="tel:152" class="hidden sm:inline-flex bg-emerald-100 text-[#064E3B] px-3 py-1 rounded text-xs font-bold uppercase tracking-wider">
                        CALL CENTER 152
                    </a>
                    <a href="{{ route('home') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white px-4 py-2 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-xs flex items-center space-x-1.5">
                        <span>🌐</span>
                        <span>BERANDA UTAMA</span>
                    </a>
                </div>
            </header>

            <!-- Alert Flash Messages -->
            <div class="max-w-7xl mx-auto px-6 pt-4 w-full">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-lg text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 font-bold">&times;</button>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="bg-amber-50 border border-amber-300 text-amber-900 px-4 py-3 rounded-lg text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                        <span>{{ session('warning') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-amber-600 hover:text-amber-900 font-bold">&times;</button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-lg text-xs font-semibold mb-4 shadow-xs flex items-center justify-between">
                        <span>{{ session('info') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                    </div>
                @endif
            </div>

            <!-- Page Main Content Body -->
            <main class="flex-grow p-6">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-slate-200 px-6 py-4 text-[11px] text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2 font-medium">
                <div>© {{ date('Y') }} Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima</div>
                <div class="flex space-x-4 font-semibold">
                    <a href="{{ route('panduan') }}" class="hover:text-emerald-700">Panduan Layanan</a>
                    <a href="{{ route('tentang') }}" class="hover:text-emerald-700">Tentang Direktorat Inovasi & KI</a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-700">FAQ</a>
                </div>
            </footer>
        </div>

    </div>

    <!-- Toggle Sidebar JavaScript Code (UI/UX Pro Max Toggle State) -->
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            const appLayout = document.getElementById('appLayout');

            // Restore saved desktop collapse state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 1024) {
                appLayout.classList.add('sidebar-collapsed');
                sidebar.classList.add('w-20');
                sidebar.classList.remove('w-64');
            }

            function toggleDesktopSidebar() {
                const currentlyCollapsed = appLayout.classList.contains('sidebar-collapsed');
                if (currentlyCollapsed) {
                    appLayout.classList.remove('sidebar-collapsed');
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    localStorage.setItem('sidebarCollapsed', 'false');
                } else {
                    appLayout.classList.add('sidebar-collapsed');
                    sidebar.classList.add('w-20');
                    sidebar.classList.remove('w-64');
                    localStorage.setItem('sidebarCollapsed', 'true');
                }
            }

            function toggleMobileSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }

            if (desktopToggle) desktopToggle.addEventListener('click', toggleDesktopSidebar);
            if (collapseBtn) collapseBtn.addEventListener('click', toggleDesktopSidebar);
            if (mobileToggle) mobileToggle.addEventListener('click', toggleMobileSidebar);
            if (backdrop) backdrop.addEventListener('click', toggleMobileSidebar);
        });
    </script>
</body>
</html>
