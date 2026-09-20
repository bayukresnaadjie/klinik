<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir') — Klinik Yos Benito</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-base: #0d0f14;
            --bg-sidebar: #111318;
            --bg-card: #161a22;
            --bg-card-alt: #1b1f2a;
            --bg-hover: #1e2330;
            --border: #252b3a;
            --border-light: #2e3547;
            --text-primary: #e8ecf5;
            --text-secondary: #8a94aa;
            --text-muted: #5a6275;
            --accent-cyan: #00c8c8;
            --accent-amber: #f59e0b;
            --accent-red: #ef4444;
            --accent-green: #22c55e;
            --accent-blue: #3b82f6;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 200px;
            min-width: 200px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 20px 16px 16px;
            border-bottom: 1px solid var(--border);
        }

        .brand-label {
            font-size: 9px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--accent-cyan);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-label::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            background: var(--accent-cyan);
            border-radius: 50%;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.1;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .nav-section {
            padding: 16px 12px 4px;
        }

        .nav-section-label {
            font-size: 9px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 6px;
            margin-bottom: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: background .15s, color .15s;
            text-decoration: none;
        }

        .nav-item:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: rgba(0, 200, 200, .1);
            color: var(--accent-cyan);
        }

        .nav-icon {
            width: 15px;
            height: 15px;
            opacity: .7;
            flex-shrink: 0;
        }

        .nav-item.active .nav-icon {
            opacity: 1;
        }

        .sidebar-spacer {
            flex: 1;
        }

        .sidebar-user {
            padding: 12px 14px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
        }

        .user-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: var(--accent-red);
            cursor: pointer;
            transition: background .15s;
            background: none;
            border: none;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, .1);
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            height: 52px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-sidebar);
            flex-shrink: 0;
        }

        .topbar-title {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: 'IBM Plex Mono', monospace;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-time {
            font-size: 12px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-secondary);
            background: var(--bg-card);
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .topbar-user .avatar {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 40px;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-light);
            border-radius: 99px;
        }

        .sb-logout {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--accent-red);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .15s;
        }

        .sb-logout:hover {
            background: rgba(239, 68, 68, .1);
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-label">Sistem Kasir</div>
            <div class="brand-name">Klinik<br>Yos Benito</div>
            <div class="brand-sub">Pengelolaan Obat Terpadu</div>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Transaksi</div>
            <a href="{{ route('kasir.dashboard') }}"
                class="nav-item {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('kasir.resep.index') }}"
                class="nav-item {{ request()->routeIs('kasir.resep.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    <rect x="9" y="3" width="6" height="4" rx="1" />
                    <line x1="9" y1="12" x2="15" y2="12" />
                    <line x1="9" y1="16" x2="13" y2="16" />
                </svg>
                Input Resep
            </a>
            <a href="{{ route('kasir.struk.index') }}"
                class="nav-item {{ request()->routeIs('kasir.struk.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 2h12a1 1 0 011 1v18l-3-2-3 2-3-2-3 2V3a1 1 0 011-1z" />
                    <line x1="9" y1="7" x2="15" y2="7" />
                    <line x1="9" y1="11" x2="15" y2="11" />
                    <line x1="9" y1="15" x2="12" y2="15" />
                </svg>
                Cetak Struk
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Stok</div>
            <a href="{{ route('kasir.stok.index') }}"
                class="nav-item {{ request()->routeIs('kasir.stok.index') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path
                        d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                </svg>
                Cek Stok Obat
            </a>
            <a href="{{ route('kasir.stok.menipis') }}"
                class="nav-item {{ request()->routeIs('kasir.stok.menipis') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                Stok Menipis
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Laporan</div>
            <a href="{{ route('kasir.laporan.harian') }}"
                class="nav-item {{ request()->routeIs('kasir.laporan.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10" />
                    <line x1="12" y1="20" x2="12" y2="4" />
                    <line x1="6" y1="20" x2="6" y2="14" />
                </svg>
                Transaksi Harian
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-label">Akun</div>
            <a href="{{ route('kasir.profil') }}"
                class="nav-item {{ request()->routeIs('kasir.profil') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                Profil Saya
            </a>
        </div>

        <div class="sidebar-spacer"></div>

        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'KS', 0, 2)) }}</div>
            <div style="flex:1;min-width:0;overflow:hidden;">
                <div class="user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name ?? 'Kasir' }}
                </div>
                <div class="user-role">{{ auth()->user()->role ?? 'Kasir' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="
            background:rgba(239,68,68,.1);
            border:1px solid rgba(239,68,68,.25);
            color:#f87171;border-radius:7px;
            padding:6px 10px;font-size:12px;font-weight:500;
            font-family:'DM Sans',sans-serif;cursor:pointer;
            display:flex;align-items:center;gap:5px;white-space:nowrap;
            transition:background .15s;"
                    onmouseover="this.style.background='rgba(239,68,68,.18)'"
                    onmouseout="this.style.background='rgba(239,68,68,.1)'">
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

    {{-- MAIN --}}
    <div class="main">
        <header class="topbar">
            <div class="topbar-title">Kasir — @yield('page-title')</div>
            <div class="topbar-right">
                <div class="topbar-time" id="clock">{{ now()->format('D, d M Y H:i:s') }}</div>
                <div class="topbar-user">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'KS', 0, 2)) }}</div>
                    <span>{{ auth()->user()->name ?? 'Kasir' }}</span>
                </div>
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');
            const ss = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent =
                `${days[now.getDay()]}, ${String(now.getDate()).padStart(2,'0')} ${months[now.getMonth()]} ${now.getFullYear()} ${hh}:${mm}:${ss}`;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @stack('scripts')
</body>

</html>
