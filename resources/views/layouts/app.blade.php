<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Sistem Farmasi') }}</title>

    {{-- Fonts: Sora (display) + DM Sans (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    {{-- Vite --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        /* ══════════════════════════════════════
           TOKENS
        ══════════════════════════════════════ */
        :root {
            --sidebar-w: 220px;
            --topbar-h: 54px;

            /* Sidebar — deep navy */
            --sb-bg: #111827;
            --sb-border: rgba(255, 255, 255, 0.06);
            --sb-text: rgba(255, 255, 255, 0.45);
            --sb-text-hover: rgba(255, 255, 255, 0.85);
            --sb-active-bg: rgba(255, 255, 255, 0.07);
            --sb-hover-bg: rgba(255, 255, 255, 0.04);
            --sb-accent: #F5A623;
            /* warm amber */

            /* Page */
            --page-bg: #F0F2F5;
            --card-bg: #FFFFFF;
            --border: #E5E7EB;

            /* Text */
            --tx-base: #111827;
            --tx-muted: #6B7280;
            --tx-sub: #9CA3AF;

            /* Semantic */
            --clr-blue: #3B82F6;
            --clr-green: #22C55E;
            --clr-yellow: #F59E0B;
            --clr-red: #EF4444;
            --clr-purple: #8B5CF6;

            --radius: 10px;
            --radius-sm: 6px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-hover: 0 4px 16px rgba(0, 0, 0, .09);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: var(--tx-base);
            min-height: 100vh;
            font-size: 13.5px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sb-bg);
            display: flex;
            flex-direction: column;
            z-index: 200;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        /* Brand */
        .sb-brand {
            padding: 20px 16px 16px;
            border-bottom: 1px solid var(--sb-border);
            flex-shrink: 0;
        }

        .sb-eyebrow {
            font-family: 'Sora', sans-serif;
            font-size: 9px;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--sb-accent);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sb-eyebrow::before {
            content: '';
            display: inline-block;
            width: 16px;
            height: 2px;
            background: var(--sb-accent);
            border-radius: 1px;
        }

        .sb-name {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -.01em;
        }

        .sb-sub {
            font-size: 10.5px;
            color: var(--sb-text);
            margin-top: 3px;
        }

        /* Nav section */
        .sb-section {
            padding: 6px 0 2px;
        }

        .sb-group-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.2);
            padding: 8px 16px 4px;
        }

        .sb-divider {
            height: 1px;
            background: var(--sb-border);
            margin: 4px 16px;
        }

        /* Nav item */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 16px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--sb-text);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: background .15s, color .15s, border-color .15s;
            position: relative;
        }

        .nav-item:hover {
            background: var(--sb-hover-bg);
            color: var(--sb-text-hover);
        }

        .nav-item.active {
            background: var(--sb-active-bg);
            color: #fff;
            border-left-color: var(--sb-accent);
        }

        .nav-item svg {
            flex-shrink: 0;
            opacity: .55;
            transition: opacity .15s;
        }

        .nav-item:hover svg {
            opacity: .85;
        }

        .nav-item.active svg {
            opacity: 1;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--clr-red);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            border-radius: 20px;
            padding: 1px 6px;
            min-width: 18px;
            text-align: center;
        }

        /* Sidebar footer / user */
        .sb-footer {
            margin-top: auto;
            padding: 12px 16px;
            border-top: 1px solid var(--sb-border);
            display: flex;
            align-items: center;
            gap: 9px;
            flex-shrink: 0;
        }

        .sb-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sb-accent), #f97316);
            color: #412402;
            font-family: 'Sora', sans-serif;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb-user-name {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, .85);
        }

        .sb-user-role {
            font-size: 10px;
            color: var(--sb-text);
        }

        .sb-logout {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--sb-text);
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            line-height: 0;
            transition: color .15s, background .15s;
        }

        .sb-logout:hover {
            color: var(--clr-red);
            background: rgba(239, 68, 68, .1);
        }

        /* ══════════════════════════════════════
           MAIN WRAPPER
        ══════════════════════════════════════ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ══════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════ */
        .topbar {
            position: sticky;
            top: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            box-shadow: var(--shadow-card);
        }

        .topbar-title {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--tx-base);
            flex: 1;
            letter-spacing: -.01em;
        }

        .topbar-clock {
            font-size: 11.5px;
            color: var(--tx-muted);
            background: var(--page-bg);
            border: 1px solid var(--border);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            white-space: nowrap;
        }

        /* Topbar icon button */
        .tb-btn {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--tx-muted);
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            position: relative;
        }

        .tb-btn:hover {
            background: #fff;
            border-color: var(--clr-blue);
            color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
        }

        .tb-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--clr-red);
            border: 1.5px solid #fff;
        }

        /* Notif dropdown */
        .notif-wrap {
            position: relative;
        }

        .notif-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 290px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            display: none;
            z-index: 300;
            overflow: hidden;
        }

        .notif-dropdown.open {
            display: block;
            animation: dropIn .15s ease;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notif-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px 10px;
            border-bottom: 1px solid var(--border);
        }

        .notif-header strong {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .notif-header a {
            font-size: 11px;
            color: var(--clr-blue);
            text-decoration: none;
        }

        .notif-header a:hover {
            text-decoration: underline;
        }

        .notif-list {
            padding: 6px 0;
            max-height: 280px;
            overflow-y: auto;
        }

        .notif-item {
            display: flex;
            gap: 10px;
            padding: 9px 14px;
            transition: background .12s;
            cursor: default;
        }

        .notif-item:hover {
            background: #F9FAFB;
        }

        .ni-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .ni-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .ni-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .ni-info {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .ni-success {
            background: #DCFCE7;
            color: #166534;
        }

        .notif-text {
            font-size: 11.5px;
            color: #374151;
            line-height: 1.4;
        }

        .notif-time {
            font-size: 10px;
            color: var(--tx-sub);
            margin-top: 2px;
        }

        .notif-empty {
            padding: 20px 14px;
            text-align: center;
            font-size: 12px;
            color: var(--tx-sub);
        }

        /* Topbar user chip */
        .tb-user {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 4px 10px 4px 4px;
            border: 1px solid var(--border);
            border-radius: 30px;
            background: var(--page-bg);
            font-size: 12px;
            font-weight: 500;
            color: var(--tx-base);
            cursor: default;
        }

        .tb-user-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--clr-yellow), #f97316);
            color: #412402;
            font-family: 'Sora', sans-serif;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ══════════════════════════════════════
           FLASH MESSAGES
        ══════════════════════════════════════ */
        .flash-wrap {
            padding: 0 24px;
            margin-top: 16px;
        }

        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            margin-bottom: 10px;
        }

        .flash-success {
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #BBF7D0;
        }

        .flash-error {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .flash-warning {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .flash-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            opacity: .5;
            color: inherit;
            padding: 0;
        }

        .flash-close:hover {
            opacity: 1;
        }

        /* ══════════════════════════════════════
           PAGE CONTENT
        ══════════════════════════════════════ */
        .page-content {
            flex: 1;
            padding: 22px 24px 32px;
        }

        /* ══════════════════════════════════════
           MOBILE OVERLAY
        ══════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 199;
            backdrop-filter: blur(2px);
        }

        .mobile-menu-btn {
            display: none;
            width: 34px;
            height: 34px;
            align-items: center;
            justify-content: center;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--tx-muted);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s cubic-bezier(.4, 0, .2, 1);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .main-wrap {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .page-content {
                padding: 16px;
            }

            .topbar {
                padding: 0 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ══════════ SIDEBAR ══════════ --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sb-brand">
            <div class="sb-eyebrow">Sistem Farmasi</div>
            <div class="sb-name">Klinik<br>Yos Benito</div>
            <div class="sb-sub">Pengelolaan Obat Terpadu</div>
        </div>

        {{-- Dashboard --}}
        <div class="sb-section">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
            </a>
        </div>

        <div class="sb-divider"></div>

        {{-- Master Data --}}
        <div class="sb-section">
            <div class="sb-group-label">Master Data</div>
            <a href="{{ route('master.jenis-obat.index') }}"
                class="nav-item {{ request()->routeIs('master.jenis-obat.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M12 2v3m0 14v3M4.22 4.22l2.12 2.12m11.32 11.32 2.12 2.12M2 12h3m14 0h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" />
                </svg>
                Jenis Obat
            </a>
            <a href="{{ route('master.obat.index') }}"
                class="nav-item {{ request()->routeIs('master.obat.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z" />
                    <path d="m8.5 8.5 7 7" />
                </svg>
                Obat (Zat Aktif)
            </a>
            <a href="{{ route('master.varian-obat.index') }}"
                class="nav-item {{ request()->routeIs('master.varian-obat.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path
                        d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18" />
                </svg>
                Varian Obat
            </a>
        </div>

        <div class="sb-divider"></div>

        {{-- Stok & Pemakaian --}}
        <div class="sb-section">
            <div class="sb-group-label">Stok & Pemakaian</div>
            <a href="{{ route('stok-obat.index') }}"
                class="nav-item {{ request()->routeIs('stok-obat.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
                Stok Obat
            </a>
            <a href="{{ route('pemakaian-obat.index') }}"
                class="nav-item {{ request()->routeIs('pemakaian-obat.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                Pemakaian Obat
            </a>
            <a href="{{ route('stok-minimum.index') }}"
                class="nav-item {{ request()->routeIs('stok-minimum.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Stok Minimum
                @php $jumlahMinimum = $jumlahStokMinimum ?? 0; @endphp
                @if ($jumlahMinimum > 0)
                    <span class="nav-badge">{{ $jumlahMinimum }}</span>
                @endif
            </a>
        </div>

        <div class="sb-divider"></div>

        {{-- Laporan --}}
        <div class="sb-section">
            <div class="sb-group-label">Laporan</div>
            <a href="{{ route('laporan.index') }}"
                class="nav-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
                Semua Laporan
            </a>
            <a href="{{ route('laporan.stok') }}"
                class="nav-item {{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="18" x2="18" y1="20" y2="10" />
                    <line x1="12" x2="12" y1="20" y2="4" />
                    <line x1="6" x2="6" y1="20" y2="14" />
                </svg>
                Laporan Stok
            </a>
            <a href="{{ route('laporan.pemakaian') }}"
                class="nav-item {{ request()->routeIs('laporan.pemakaian') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Laporan Pemakaian
            </a>
            <a href="{{ route('laporan.tren') }}"
                class="nav-item {{ request()->routeIs('laporan.tren') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                </svg>
                Tren Pemakaian
            </a>
        </div>

        {{-- Manajemen (admin only) --}}
        {{-- Manajemen (admin & manager) --}}
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
            <div class="sb-divider"></div>
            <div class="sb-section">
                <div class="sb-group-label">Manajemen</div>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('users.index') }}"
                        class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.supplier.index') }}"
                        class="nav-item {{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Supplier
                    </a>
                @endif

                <a href="{{ route('approval-requests.index') }}"
                    class="nav-item {{ request()->routeIs('approval-requests.*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 11l3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    Approval Request
                </a>

                @if (auth()->user()->role === 'manager')
                    <a href="{{ route('manager.riwayat') }}"
                        class="nav-item {{ request()->routeIs('manager.riwayat') ? 'active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                        Riwayat Keputusan
                    </a>
                @endif
            </div>
        @endif

        <div class="sb-divider"></div>

        {{-- Akun --}}
        <div class="sb-section">
            <div class="sb-group-label">Akun</div>
            <a href="{{ route('profil.edit') }}"
                class="nav-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profil Saya
            </a>
        </div>

        {{-- Footer / user --}}
        <div class="sb-footer">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div style="flex:1;min-width:0;overflow:hidden;">
                <div class="sb-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div class="sb-user-role">{{ auth()->user()->role ?? 'Administrator' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="
            background:rgba(239,68,68,.08);
            border:1px solid rgba(239,68,68,.22);
            color:#f87171;border-radius:6px;
            padding:5px 10px;font-size:11.5px;font-weight:600;
            font-family:'DM Sans',sans-serif;cursor:pointer;
            display:flex;align-items:center;gap:5px;white-space:nowrap;
            transition:background .15s;"
                    onmouseover="this.style.background='rgba(239,68,68,.16)'"
                    onmouseout="this.style.background='rgba(239,68,68,.08)'">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ══════════ MAIN ══════════ --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <header class="topbar">
            {{-- Mobile hamburger --}}
            <button class="mobile-menu-btn" onclick="openSidebar()" aria-label="Menu">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>

            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>

            {{-- Clock --}}
            <span class="topbar-clock" id="topbar-clock">{{ now()->translatedFormat('l, d F Y') }}</span>

            {{-- Notifikasi --}}
            <div class="notif-wrap">
                <button class="tb-btn" id="notifBtn" onclick="toggleNotif(event)" aria-label="Notifikasi"
                    style="position:relative">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span id="notif-badge"
                        style="display:none;position:absolute;top:-4px;right:-4px;
                   min-width:18px;height:18px;background:#E24B4A;
                   border-radius:99px;font-size:10px;font-weight:700;
                   color:#fff;border:2px solid #fff;
                   align-items:center;justify-content:center;padding:0 3px">
                        0
                    </span>
                </button>

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">
                        <strong>Notifikasi</strong>
                        <button onclick="markAllRead()"
                            style="background:none;border:none;cursor:pointer;
                       font-size:11px;color:var(--clr-blue);font-family:inherit">
                            Tandai semua dibaca
                        </button>
                    </div>
                    <div class="notif-list" id="notif-list">
                        <div class="notif-empty">Memuat...</div>
                    </div>
                </div>
            </div>{{-- ← tutup notif-wrap di sini --}}

            {{-- User --}}
            <div class="tb-user">
                <div class="tb-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>{{-- ← tutup header di sini --}}

        {{-- Flash messages --}}
        @if (session('success') || session('error') || session('warning'))
            <div class="flash-wrap">
                @if (session('success'))
                    <div class="flash flash-success" id="flash-success">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ session('success') }}
                        <button class="flash-close" onclick="this.closest('.flash').remove()">✕</button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="flash flash-error" id="flash-error">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        {{ session('error') }}
                        <button class="flash-close" onclick="this.closest('.flash').remove()">✕</button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="flash flash-warning" id="flash-warning">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                            <line x1="12" x2="12.01" y1="17" y2="17" />
                        </svg>
                        {{ session('warning') }}
                        <button class="flash-close" onclick="this.closest('.flash').remove()">✕</button>
                    </div>
                @endif
            </div>
        @endif

        {{-- ── Page Content ── --}}
        <main class="page-content">
            @yield('content')
        </main>

    </div>{{-- /.main-wrap --}}

    <script>
        /* ── Notif dropdown ── */
        function toggleNotif(e) {
            e.stopPropagation();
            const dd = document.getElementById('notifDropdown');
            const isOpen = dd.classList.contains('open');
            dd.classList.toggle('open');
            if (!isOpen) fetchNotifications();
        }

        document.addEventListener('click', function(e) {
            var drop = document.getElementById('notifDropdown');
            var btn = document.getElementById('notifBtn');
            if (drop && btn && !btn.contains(e.target) && !drop.contains(e.target)) {
                drop.classList.remove('open');
            }
        });

        /* ── Notification System ── */
        function fetchNotifications() {
            fetch('{{ route('notifications.index') }}')
                .then(r => r.json())
                .then(data => {
                    updateNotifBadge(data.unread_count);
                    renderNotifications(data.notifications);
                })
                .catch(console.error);
        }

        function updateNotifBadge(count) {
            const btn = document.getElementById('notifBtn');
            let dot = btn.querySelector('.tb-dot');
            if (count > 0) {
                if (!dot) {
                    dot = document.createElement('span');
                    dot.className = 'tb-dot';
                    btn.appendChild(dot);
                }
            } else {
                if (dot) dot.remove();
            }
        }

        function renderNotifications(notifications) {
            const list = document.getElementById('notif-list');
            if (!notifications.length) {
                list.innerHTML = '<div class="notif-empty">Tidak ada notifikasi baru</div>';
                return;
            }

            list.innerHTML = notifications.map(n => `
        <div class="notif-item" onclick="readNotif(${n.id}, '${n.url ?? ''}')"
            style="cursor:pointer;background:${n.is_read ? 'transparent' : '#F0FDF4'}">
            <div class="ni-icon" style="background:${n.icon.bg};color:${n.icon.color}">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
            </div>
            <div>
                <div class="notif-text" style="font-weight:${n.is_read ? '400' : '600'}">
                    ${n.title}
                </div>
                <div class="notif-text" style="color:#6B7280">${n.message}</div>
                <div class="notif-time">${n.time}</div>
            </div>
            ${!n.is_read ? '<div style="width:7px;height:7px;border-radius:50%;background:#22C55E;margin-left:auto;flex-shrink:0;margin-top:4px"></div>' : ''}
        </div>
    `).join('');
        }

        function readNotif(id, url) {
            fetch(`/notifications/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            }).then(() => {
                fetchNotifications();
                if (url) window.location.href = url;
            });
        }

        function markAllRead() {
            fetch('/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            }).then(() => fetchNotifications());
        }

        // Polling setiap 30 detik
        fetchNotifications();
        setInterval(fetchNotifications, 30000);
        /* ── Mobile sidebar ── */
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }

        /* ── Live clock ── */
        (function clock() {
            var el = document.getElementById('topbar-clock');
            if (!el) return;
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            function pad(n) {
                return String(n).padStart(2, '0');
            }

            function tick() {
                var d = new Date();
                el.textContent = days[d.getDay()] + ', ' + pad(d.getDate()) + ' ' +
                    months[d.getMonth()] + ' ' + d.getFullYear() +
                    '  ' + pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
            }
            tick();
            setInterval(tick, 1000);
        })();

        /* ── Auto-dismiss flash ── */
        setTimeout(function() {
            ['flash-success', 'flash-error', 'flash-warning'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity .4s';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.remove();
                    }, 400);
                }
            });
        }, 4000);
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    @stack('scripts')

</body>

</html>
