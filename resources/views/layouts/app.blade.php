<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan Digital') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Blade Wind UI -->
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    <style>
        :root {
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            background-color: #eaeaea;
            z-index: 40;
            bottom: 0;
        }

        .sidebar-mobile {
            transform: translateX(-100%);
        }

        .sidebar-mobile.active {
            transform: translateX(0);
        }

        .sidebar-header {
            border-bottom: 2px solid var(--secondary-color);
            padding: 1.5rem;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: var(--secondary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.5rem;
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            overflow-y: auto;
            max-height: calc(100vh - 120px);
        }

        .nav-section-title {
            color: var(--secondary-color);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            padding: 0 0.75rem;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-link:hover {
            transform: translateX(4px);
        }

        .nav-link.active {
            font-weight: 600;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 30;
            opacity: 0;
        }

        .overlay.active {
            display: block;
        }

        /* Main Content */
        .main-content {
            transition: margin-left 0.3s ease;
            width: 100%;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: white;
            border-bottom: 1px solid #E5E1D8;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
        }

        .mobile-menu-btn {
            padding: 0.5rem;
            color: var(--primary-color);
            border-radius: 8px;
            border: 1px solid #E5E1D8;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mobile-menu-btn:hover {
            background: var(--bg-color);
            border-color: var(--secondary-color);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .icon-btn {
            padding: 0.5rem;
            color: var(--primary-color);
            border-radius: 8px;
            background: white;
            border: 1px solid #E5E1D8;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        .icon-btn:hover {
            background: var(--bg-color);
            border-color: var(--secondary-color);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #DC2626;
            color: white;
            font-size: 0.625rem;
            padding: 0.125rem 0.375rem;
            border-radius: 10px;
            font-weight: 600;
        }

        /* User Menu */
        .user-menu-wrapper {
            position: relative;
        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 8px;
            background: white;
            border: 1px solid #E5E1D8;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-menu-btn:hover {
            background: var(--bg-color);
            border-color: var(--secondary-color);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 2px solid var(--secondary-color);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .user-role {
            font-size: 0.75rem;
            color: #8B7355;
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            width: 220px;
            background: white;
            border: 1px solid #E5E1D8;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: var(--bg-color);
        }

        .dropdown-item svg {
            width: 18px;
            height: 18px;
            color: var(--secondary-color);
        }

        .dropdown-divider {
            height: 1px;
            background: #E5E1D8;
            margin: 0.5rem 0;
        }

        /* Main Content Area */
        .content-area {
            padding: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Close Button */
        .close-btn {
            position: absolute;
            top: 1.5rem;
            right: 1rem;
            background: rgba(212, 175, 55, 0.2);
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            color: var(--secondary-color);
            cursor: pointer;
            transition: all 0.2s;
            z-index: 50;
        }

        .close-btn:hover {
            background: rgba(212, 175, 55, 0.3);
        }

        /* Responsive */
        @media (min-width: 1024px) {
            .sidebar-mobile {
                transform: translateX(0);
            }

            .overlay {
                display: none !important;
            }

            .mobile-menu-btn {
                display: none;
            }

            .close-btn {
                display: none;
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 0.75rem 1rem;
            }

            .page-title {
                font-size: 1.125rem;
            }

            .user-name,
            .user-role {
                display: none;
            }

            .content-area {
                padding: 1rem;
            }
        }

        /* Scrollbar Styling */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 left-0 h-screen sidebar sidebar-mobile lg:translate-x-0">
            <!-- Close Button (Mobile Only) -->
            <button id="close-sidebar" class="close-btn lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 2L2 7v10c0 5.55 3.84 10.74 10 12 6.16-1.26 10-6.45 10-12V7l-10-5zm0 2.18l8 3.6v8.55c0 4.55-3.08 8.86-8 9.93-4.92-1.07-8-5.38-8-9.93V7.78l8-3.6zM11 8v8h2V8h-2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">{{ config('app.name', 'Perpustakaan') }}</h1>
                        <p class="text-xs">Digital Library System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <!-- Main Navigation -->
                <div class="mb-6">
                    <p class="nav-section-title">Menu Utama</p>
                    <ul>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>

                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z" />
                                </svg>
                                Koleksi Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                </svg>
                                Anggota
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                </svg>
                                Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z" />
                                </svg>
                                Kategori
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Reports Section -->
                <div class="mb-6">
                    <p class="nav-section-title">Laporan</p>
                    <ul>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                                Statistik
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Settings Section -->
                <div>
                    <p class="nav-section-title">Pengaturan</p>
                    <ul>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" />
                                </svg>
                                Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>

                                Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="top-header">
                <div class="header-content">
                    <div class="flex items-center gap-3 space-x-4">
                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-button" class="mobile-menu-btn lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </button>
                        <h1 class="page-title">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>

                    <div class="header-actions">
                        <!-- Search Button -->
                        <button class="hidden icon-btn sm:block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </button>

                        <!-- Notifications -->
                        <button class="icon-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span class="notification-badge">3</span>
                        </button>

                        <!-- User Menu -->
                        <div class="user-menu-wrapper">
                            <button id="user-menu-button" class="user-menu-btn">
                                <img class="user-avatar"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin User') }}&background=D4AF37&color=8B4513"
                                    alt="User">
                                <div class="hidden user-info md:flex">
                                    <span class="user-name">{{ Auth::user()->name ?? 'Admin User' }}</span>
                                    <span
                                        class="user-role">{{ Auth::user()->role->role_name ?? 'Administrator' }}</span>
                                </div>
                                <svg class="hidden md:block" width="16" height="16" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="user-dropdown">
                                <a href="" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" />
                                    </svg>
                                    Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{route("logout")}}" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>
                                    Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="content-area">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeSidebarButton = document.getElementById('close-sidebar');

        function openSidebar() {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        mobileMenuButton.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
        closeSidebarButton.addEventListener('click', closeSidebar);

        // Close sidebar on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.remove('active');
            }
        });

        // Close user menu when clicking a link
        userMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                userMenu.classList.remove('active');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
