<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Farmasi Klinik Yos Benito</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    {{-- Base Styles --}}
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --color-primary: #1D9E75;
            --color-primary-dark: #0F6E56;
            --color-primary-light: #E1F5EE;

            --color-sidebar-bg: #ffffff;
            --color-content-bg: #F6F7F9;
            --color-card-bg: #ffffff;

            --color-text-main: #1a1a1a;
            --color-text-muted: #6b7280;
            --color-text-hint: #9ca3af;

            --color-border: rgba(0, 0, 0, 0.08);
            --color-border-strong: rgba(0, 0, 0, 0.14);

            --color-success-bg: #E1F5EE;
            --color-success-text: #085041;
            --color-warning-bg: #FAEEDA;
            --color-warning-text: #633806;
            --color-danger-bg: #FCEBEB;
            --color-danger-text: #791F1F;
            --color-info-bg: #E6F1FB;
            --color-info-text: #0C447C;

            --sidebar-width: 220px;
            --topbar-height: 56px;
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        html,
        body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--color-text-main);
            background: var(--color-content-bg);
        }

        /* ── Layout Shell ── */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--color-sidebar-bg);
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform .25s ease;
        }

        .sidebar-brand {
            padding: 18px 16px 14px;
            border-bottom: 1px solid var(--color-border);
        }

        .sidebar-brand .badge {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .5px;
            background: var(--color-primary);
            color: #fff;
            padding: 2px 7px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .sidebar-brand .clinic-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1.25;
        }

        .sidebar-brand .clinic-sub {
            font-size: 10px;
            color: var(--color-text-hint);
            margin-top: 2px;
        }

        /* Nav */
        .nav-section-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: var(--color-text-hint);
            padding: 14px 16px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 16px;
            font-size: 12.5px;
            color: var(--color-text-muted);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all .15s;
        }

        .nav-item i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: var(--color-content-bg);
            color: var(--color-text-main);
        }

        .nav-item.active {
            color: var(--color-primary-dark);
            border-left-color: var(--color-primary);
            background: var(--color-primary-light);
            font-weight: 600;
        }

        .nav-item .nav-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            background: #E24B4A;
            color: #fff;
            padding: 1px 6px;
            border-radius: 20px;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            margin-top: auto;
            padding: 12px 16px;
            border-top: 1px solid var(--color-border);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--color-primary);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .user-role {
            font-size: 10px;
            color: var(--color-primary-dark);
        }

        .logout-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--color-text-hint);
            cursor: pointer;
            font-size: 16px;
        }

        .logout-btn:hover {
            color: #E24B4A;
        }

        /* ── Main Area ── */
        .main-area {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: var(--color-card-bg);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .topbar-subtitle {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-date {
            font-size: 11px;
            color: var(--color-text-muted);
        }

        .notif-btn {
            position: relative;
            background: none;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--color-text-muted);
            font-size: 16px;
            transition: background .15s;
        }

        .notif-btn:hover {
            background: var(--color-content-bg);
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            background: #E24B4A;
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        /* ── Page Content ── */
        .page-content {
            padding: 22px 24px;
            flex: 1;
        }

        /* ── Utility: Pill/Badge ── */
        .pill {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 9px;
            border-radius: 20px;
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .pill-warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .pill-danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        /* ── Card base ── */
        .card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-area {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="app-shell">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-brand">
                <span class="badge">Sistem Farmasi</span>
                <div class="clinic-name">Klinik<br>Yos Benito</div>
                <div class="clinic-sub">Pengelolaan Obat Terpadu</div>
            </div>

            <nav>
                <div class="nav-section-label">Utama</div>

                <a href="{{ route('manager.dashboard') }}"
                    class="nav-item {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    Dashboard
                </a>

                <a href="{{ route('manager.laporan') }}"
                    class="nav-item {{ request()->routeIs('manager.laporan*') ? 'active' : '' }}">
                    <i class="ti ti-report-analytics"></i>
                    Laporan Kinerja
                </a>

                <a href="{{ route('manager.persetujuan') }}"
                    class="nav-item {{ request()->routeIs('manager.persetujuan*') ? 'active' : '' }}">
                    <i class="ti ti-clipboard-check"></i>
                    Persetujuan
                    @if (($pendingCount ?? 0) > 0)
                        <span class="nav-badge">{{ $pendingCount }}</span>
                    @endif
                </a>

                <div class="nav-section-label">Monitoring</div>

                <a href="{{ route('manager.stok') }}"
                    class="nav-item {{ request()->routeIs('manager.stok*') ? 'active' : '' }}">
                    <i class="ti ti-pill"></i>
                    Stok Obat
                </a>

                <a href="{{ route('manager.tren') }}"
                    class="nav-item {{ request()->routeIs('manager.tren*') ? 'active' : '' }}">
                    <i class="ti ti-activity"></i>
                    Tren Pemakaian
                </a>

                <a href="{{ route('manager.peringatan') }}"
                    class="nav-item {{ request()->routeIs('manager.peringatan*') ? 'active' : '' }}">
                    <i class="ti ti-alert-triangle"></i>
                    Peringatan
                </a>

                <div class="nav-section-label">Manajemen</div>

                <a href="{{ route('manager.tim') }}"
                    class="nav-item {{ request()->routeIs('manager.tim*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    Tim Farmasi
                </a>

                <a href="{{ route('manager.supplier') }}"
                    class="nav-item {{ request()->routeIs('manager.supplier*') ? 'active' : '' }}">
                    <i class="ti ti-building-store"></i>
                    Supplier
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-chip">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'MR', 0, 2)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name ?? 'Manajer' }}</div>
                        <div class="user-role">Manajer Klinik</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin-left:auto">
                        @csrf
                        <button type="submit" class="logout-btn" title="Keluar">
                            <i class="ti ti-logout"></i>
                        </button>
                    </form>
                </div>
            </div>

        </aside>
        {{-- ── END SIDEBAR ── --}}

        {{-- ── MAIN AREA ── --}}
        <div class="main-area">

            {{-- Topbar --}}
            <header class="topbar">
                <div>
                    <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
                    <div class="topbar-subtitle">@yield('page_subtitle', 'Ringkasan operasional farmasi')</div>
                </div>
                <div class="topbar-right">
                    <span class="topbar-date" id="live-time"></span>
                    {{-- Bell Notification --}}
                    <div style="position:relative">
                        <button id="notif-btn-mgr" onclick="toggleNotifMgr()" class="notif-btn" title="Notifikasi">
                            <i class="ti ti-bell"></i>
                            <span id="notif-badge-mgr"
                                style="display:none;position:absolute;top:-4px;right:-4px;
                   min-width:18px;height:18px;background:#E24B4A;
                   border-radius:99px;font-size:10px;font-weight:700;
                   color:#fff;border:2px solid #fff;
                   align-items:center;justify-content:center;padding:0 3px">
                                0
                            </span>
                        </button>

                        {{-- Dropdown --}}
                        <div id="notif-dropdown-mgr"
                            style="display:none;position:absolute;top:calc(100% + 8px);right:0;
               width:300px;background:var(--color-card-bg);
               border:1px solid var(--color-border);border-radius:var(--radius-lg);
               box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:9999;overflow:hidden">

                            {{-- Header --}}
                            <div
                                style="padding:12px 16px;border-bottom:1px solid var(--color-border);
                    display:flex;align-items:center;justify-content:space-between">
                                <span style="font-size:13px;font-weight:700;color:var(--color-text-main)">
                                    Notifikasi
                                </span>
                                <button onclick="markAllReadMgr()"
                                    style="font-size:11px;color:var(--color-primary);background:none;
                       border:none;cursor:pointer;font-family:inherit;font-weight:600">
                                    Tandai semua dibaca
                                </button>
                            </div>

                            {{-- List --}}
                            <div id="notif-list-mgr" style="max-height:320px;overflow-y:auto">
                                <div
                                    style="padding:24px;text-align:center;
                        color:var(--color-text-muted);font-size:13px">
                                    <i class="ti ti-bell-off"
                                        style="font-size:24px;display:block;margin-bottom:6px;opacity:.4"></i>
                                    Memuat...
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div style="padding:10px 16px;border-top:1px solid var(--color-border);text-align:center">
                                <a href="{{ route('approval-requests.index') }}"
                                    style="font-size:12px;color:var(--color-primary);
                      text-decoration:none;font-weight:600">
                                    Lihat semua pengajuan →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    style="margin:16px 24px 0; padding:10px 14px; background:var(--color-success-bg); color:var(--color-success-text); border-radius:var(--radius-md); font-size:13px; display:flex; align-items:center; gap:8px;">
                    <i class="ti ti-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    style="margin:16px 24px 0; padding:10px 14px; background:var(--color-danger-bg); color:var(--color-danger-text); border-radius:var(--radius-md); font-size:13px; display:flex; align-items:center; gap:8px;">
                    <i class="ti ti-alert-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="page-content">
                @yield('content')
            </main>

        </div>
        {{-- ── END MAIN AREA ── --}}

    </div>

    <script>
        // Live clock
        function updateTime() {
            const now = new Date();
            const opts = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const date = now.toLocaleDateString('id-ID', opts);
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('live-time').textContent = date + ' · ' + time + ' WIB';
        }
        updateTime();
        setInterval(updateTime, 30000);
    </script>
    {{-- ── Modal Konfirmasi Global ── --}}
    <div id="confirm-modal"
        style="display:none;position:fixed;inset:0;z-index:9999;
     background:rgba(0,0,0,.45);backdrop-filter:blur(3px);
     align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:12px;padding:28px 24px;
                width:100%;max-width:380px;box-shadow:0 20px 60px rgba(0,0,0,.2);
                margin:16px;">
            <div id="cm-icon"
                style="width:48px;height:48px;border-radius:50%;
             display:flex;align-items:center;justify-content:center;
             margin:0 auto 14px;font-size:22px;">
            </div>
            <div id="cm-title"
                style="font-size:15px;font-weight:700;
             text-align:center;color:#111;margin-bottom:8px;">
            </div>
            <div id="cm-message"
                style="font-size:13px;color:#6b7280;
             text-align:center;line-height:1.5;margin-bottom:22px;">
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="closeConfirmModal()"
                    style="flex:1;padding:10px;border:1px solid #e5e7eb;border-radius:8px;
                       background:#fff;color:#6b7280;font-size:13px;font-weight:500;
                       cursor:pointer;transition:background .15s;font-family:inherit;">
                    Batal
                </button>
                <button id="cm-confirm-btn"
                    style="flex:1;padding:10px;border:none;border-radius:8px;
                       color:#fff;font-size:13px;font-weight:600;
                       cursor:pointer;transition:opacity .15s;font-family:inherit;">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <script>
        // ── Confirm Modal ──────────────────────────────────────────
        let _confirmCallback = null;

        function showConfirmModal({
            title,
            message,
            type = 'approve',
            onConfirm
        }) {
            const modal = document.getElementById('confirm-modal');
            const icon = document.getElementById('cm-icon');
            const titleEl = document.getElementById('cm-title');
            const msgEl = document.getElementById('cm-message');
            const btn = document.getElementById('cm-confirm-btn');

            const config = {
                approve: {
                    iconBg: '#DCFCE7',
                    iconColor: '#16A34A',
                    iconHtml: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
                    btnBg: '#16A34A',
                },
                reject: {
                    iconBg: '#FEE2E2',
                    iconColor: '#DC2626',
                    iconHtml: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
                    btnBg: '#DC2626',
                },
            };

            const c = config[type] || config.approve;

            icon.style.background = c.iconBg;
            icon.style.color = c.iconColor;
            icon.innerHTML = c.iconHtml;
            titleEl.textContent = title;
            msgEl.textContent = message;
            btn.style.background = c.btnBg;
            btn.textContent = type === 'approve' ? 'Ya, Setujui' : 'Ya, Tolak';

            _confirmCallback = onConfirm;
            modal.style.display = 'flex';
        }

        function closeConfirmModal() {
            document.getElementById('confirm-modal').style.display = 'none';
            _confirmCallback = null;
        }

        document.getElementById('cm-confirm-btn').addEventListener('click', function() {
            if (_confirmCallback) _confirmCallback();
            closeConfirmModal();
        });

        // Tutup modal jika klik backdrop
        document.getElementById('confirm-modal').addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });
    </script>
    <script>
        // ── Notification System Manager ────────────────────────
        let notifOpenMgr = false;

        function toggleNotifMgr() {
            notifOpenMgr = !notifOpenMgr;
            const dd = document.getElementById('notif-dropdown-mgr');
            dd.style.display = notifOpenMgr ? 'block' : 'none';
            if (notifOpenMgr) fetchNotificationsMgr();
        }

        function fetchNotificationsMgr() {
            fetch('{{ route('notifications.index') }}')
                .then(r => r.json())
                .then(data => {
                    updateBadgeMgr(data.unread_count);
                    renderNotificationsMgr(data.notifications);
                })
                .catch(console.error);
        }

        function updateBadgeMgr(count) {
            const badge = document.getElementById('notif-badge-mgr');
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        function renderNotificationsMgr(notifications) {
            const list = document.getElementById('notif-list-mgr');
            if (!notifications.length) {
                list.innerHTML = `
            <div style="padding:24px;text-align:center;
                        color:var(--color-text-muted);font-size:13px">
                <i class="ti ti-bell-off"
                    style="font-size:24px;display:block;margin-bottom:6px;opacity:.4"></i>
                Tidak ada notifikasi
            </div>`;
                return;
            }

            list.innerHTML = notifications.map(n => `
        <div onclick="readNotifMgr(${n.id}, '${n.url ?? '#'}')"
            style="padding:12px 16px;border-bottom:1px solid var(--color-border);
                   cursor:pointer;transition:background .15s;
                   background:${n.is_read ? 'transparent' : 'rgba(29,158,117,.05)'}"
            onmouseover="this.style.background='var(--color-content-bg)'"
            onmouseout="this.style.background='${n.is_read ? 'transparent' : 'rgba(29,158,117,.05)'}'">
            <div style="display:flex;align-items:flex-start;gap:10px">
                <div style="width:32px;height:32px;border-radius:var(--radius-md);
                            flex-shrink:0;background:${n.icon.bg};color:${n.icon.color};
                            display:flex;align-items:center;justify-content:center">
                    <i class="ti ti-${n.icon.icon}" style="font-size:15px"></i>
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:12.5px;
                                font-weight:${n.is_read ? '500' : '700'};
                                color:var(--color-text-main);margin-bottom:2px">
                        ${n.title}
                    </div>
                    <div style="font-size:11.5px;color:var(--color-text-muted);
                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        ${n.message}
                    </div>
                    <div style="font-size:10px;color:var(--color-text-hint);margin-top:3px">
                        ${n.time}
                    </div>
                </div>
                ${!n.is_read ? '<div style="width:7px;height:7px;border-radius:50%;background:var(--color-primary);flex-shrink:0;margin-top:4px"></div>' : ''}
            </div>
        </div>
    `).join('');
        }

        function readNotifMgr(id, url) {
            fetch(`/notifications/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            }).then(() => {
                fetchNotificationsMgr();
                if (url && url !== '#') window.location.href = url;
            });
        }

        function markAllReadMgr() {
            fetch('/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                }
            }).then(() => fetchNotificationsMgr());
        }

        // Tutup dropdown klik di luar
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('notif-btn-mgr');
            const dd = document.getElementById('notif-dropdown-mgr');
            if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
                notifOpenMgr = false;
                dd.style.display = 'none';
            }
        });

        // Polling setiap 30 detik
        fetchNotificationsMgr();
        setInterval(fetchNotificationsMgr, 30000);
    </script>
    @stack('scripts')

</body>

</html>
