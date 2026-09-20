@extends('layouts.app')

@section('title', 'Stok Minimum')
@section('page-title', 'Stok Minimum')

@push('styles')
    <style>
        /* ══ PAGE HEADER ══ */
        .sm-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .sm-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .sm-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ══ BUTTONS ══ */
        .sm-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all .15s;
            white-space: nowrap;
        }

        .sm-btn:active {
            transform: scale(.98);
        }

        .sm-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .sm-btn-primary:hover {
            opacity: .88;
            box-shadow: 0 4px 12px rgba(59, 130, 246, .25);
        }

        .sm-btn-ghost {
            background: var(--card-bg);
            color: var(--tx-muted);
            border-color: var(--border);
        }

        .sm-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        .sm-btn-green {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }

        .sm-btn-green:hover {
            opacity: .88;
        }

        /* ══ STAT CARDS ══ */
        .sm-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .sm-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .sm-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .sm-stat:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .sm-stat-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .sm-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .sm-stat-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 5px;
        }

        .sm-stat-icon {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sm-stat-icon.gray {
            background: #F3F4F6;
            color: var(--tx-muted);
        }

        .sm-stat-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .sm-stat-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .sm-stat-icon.red {
            background: #FEE2E2;
            color: var(--clr-red);
        }

        .sm-stat-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .sm-stat-accent.gray {
            background: #9CA3AF;
        }

        .sm-stat-accent.blue {
            background: var(--clr-blue);
        }

        .sm-stat-accent.yellow {
            background: #d97706;
        }

        .sm-stat-accent.red {
            background: var(--clr-red);
        }

        /* ══ GUIDE BOX ══ */
        .sm-guide {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 14px 16px;
            border-radius: var(--radius);
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            margin-bottom: 16px;
            font-size: 12.5px;
            color: #1E40AF;
            line-height: 1.65;
        }

        .sm-guide-icon {
            flex-shrink: 0;
            margin-top: 1px;
        }

        .sm-guide strong {
            font-weight: 700;
        }

        /* ══ TOOLBAR ══ */
        .sm-toolbar {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sm-search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            flex: 1;
            min-width: 180px;
            max-width: 280px;
            transition: border-color .15s, box-shadow .15s;
        }

        .sm-search-wrap:focus-within {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
            background: #fff;
        }

        .sm-search-input {
            border: none;
            background: transparent;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            color: var(--tx-base);
            width: 100%;
        }

        .sm-search-input::placeholder {
            color: var(--tx-sub);
        }

        .sm-select {
            padding: 7px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            outline: none;
            cursor: pointer;
            min-width: 140px;
            transition: border-color .15s, box-shadow .15s;
        }

        .sm-select:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        /* ══ PANEL ══ */
        .sm-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .sm-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            flex-wrap: wrap;
            gap: 10px;
        }

        .sm-panel-left {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .sm-panel-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            background: #FEF3C7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sm-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .sm-panel-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .sm-count-badge {
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            background: #EFF6FF;
            color: var(--clr-blue);
            font-weight: 600;
            border: 1px solid #BFDBFE;
        }

        /* ══ TABLE ══ */
        .sm-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .sm-tbl thead tr {
            background: #F9FAFB;
        }

        .sm-tbl th {
            padding: 10px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .sm-tbl td {
            padding: 10px 14px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .sm-tbl tr:last-child td {
            border-bottom: none;
        }

        .sm-tbl tbody tr:hover {
            background: #FAFAFA;
        }

        .sm-tbl .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        /* Obat cell */
        .sm-obat-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sm-obat-avatar {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: #EFF6FF;
            color: var(--clr-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sm-obat-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--tx-base);
        }

        .sm-obat-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        /* Stok gauge */
        .sm-stok-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 100px;
        }

        .sm-stok-nums {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .sm-stok-val {
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 700;
        }

        .sm-stok-unit {
            font-size: 10.5px;
            color: var(--tx-sub);
        }

        .sm-bar-track {
            height: 5px;
            background: var(--page-bg);
            border-radius: 99px;
            overflow: hidden;
        }

        .sm-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .4s ease;
        }

        .sm-bar-fill.safe {
            background: #22C55E;
        }

        .sm-bar-fill.warn {
            background: #F59E0B;
        }

        .sm-bar-fill.danger {
            background: var(--clr-red);
        }

        .sm-bar-fill.empty {
            background: #D1D5DB;
        }

        /* Status pill */
        .sm-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .sm-pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .sm-pill.aman {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        .sm-pill.minimum {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FDE68A;
        }

        .sm-pill.kritis {
            background: #FFEDD5;
            color: #C2410C;
            border: 1px solid #FED7AA;
        }

        .sm-pill.habis {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        /* Minimum input */
        .sm-min-input {
            width: 80px;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .sm-min-input:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
            background: #fff;
        }

        /* Toggle alert */
        .sm-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .sm-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .sm-toggle-track {
            width: 36px;
            height: 20px;
            border-radius: 20px;
            background: #D1D5DB;
            transition: background .2s;
            display: flex;
            align-items: center;
            padding: 2px;
        }

        .sm-toggle input:checked+.sm-toggle-track {
            background: var(--clr-blue);
        }

        .sm-toggle-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
            transition: transform .2s;
        }

        .sm-toggle input:checked~.sm-toggle-track .sm-toggle-thumb {
            transform: translateX(16px);
        }

        /* Empty state */
        .sm-empty {
            padding: 60px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .sm-empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 4px;
        }

        .sm-empty-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .sm-empty-sub {
            font-size: 12.5px;
            color: var(--tx-muted);
        }

        /* Save bar (sticky bottom) */
        .sm-save-bar {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-top: 1px solid var(--border);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            z-index: 50;
            margin: 0 -24px;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, .06);
        }

        .sm-save-bar-text {
            font-size: 12.5px;
            color: var(--tx-muted);
        }

        .sm-save-bar-text strong {
            color: var(--tx-base);
        }
    </style>
@endpush

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="sm-header">
        <div>
            <div class="sm-title">Stok Minimum</div>
            <div class="sm-sub">Atur batas stok minimum dan aktifkan notifikasi per varian obat</div>
        </div>
    </div>

    {{-- ══ STAT CARDS ══ --}}
    <div class="sm-stats">
        <div class="sm-stat">
            <div class="sm-stat-icon gray">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="sm-stat-label">Total Varian</div>
            <div class="sm-stat-value" style="color:var(--tx-base);">{{ $totalVarian ?? 0 }}</div>
            <div class="sm-stat-sub">semua varian terdaftar</div>
            <div class="sm-stat-accent gray"></div>
        </div>
        <div class="sm-stat">
            <div class="sm-stat-icon blue">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </div>
            <div class="sm-stat-label">Alert Aktif</div>
            <div class="sm-stat-value" style="color:var(--clr-blue);">{{ $alertAktif ?? 0 }}</div>
            <div class="sm-stat-sub">varian dipantau</div>
            <div class="sm-stat-accent blue"></div>
        </div>
        <div class="sm-stat">
            <div class="sm-stat-icon yellow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
            </div>
            <div class="sm-stat-label">Bawah Minimum</div>
            <div class="sm-stat-value" style="color:#d97706;">{{ $bawahMinimum ?? 0 }}</div>
            <div class="sm-stat-sub">perlu segera diisi</div>
            <div class="sm-stat-accent yellow"></div>
        </div>
        <div class="sm-stat">
            <div class="sm-stat-icon red">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" x2="12" y1="8" y2="12" />
                    <line x1="12" x2="12.01" y1="16" y2="16" />
                </svg>
            </div>
            <div class="sm-stat-label">Stok Habis</div>
            <div class="sm-stat-value" style="color:var(--clr-red);">{{ $stokHabis ?? 0 }}</div>
            <div class="sm-stat-sub">tidak tersedia</div>
            <div class="sm-stat-accent red"></div>
        </div>
    </div>

    {{-- ══ GUIDE ══ --}}
    <div class="sm-guide">
        <div class="sm-guide-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
        </div>
        <div>
            <strong>Cara menggunakan stok minimum:</strong><br>
            Isi kolom <strong>Stok Minimum</strong> dengan angka batas stok yang harus selalu tersedia, lalu aktifkan
            <strong>Alert</strong> untuk mengaktifkan pemantauan.
            Sistem akan menampilkan peringatan di dashboard saat stok turun di bawah angka minimum. Isi <strong>0</strong>
            dan matikan Alert jika varian tidak perlu dipantau.
        </div>
    </div>

    {{-- ══ TOOLBAR ══ --}}
    <form method="GET" action="{{ route('stok-minimum.index') }}" id="filterForm">
        <div class="sm-toolbar">
            <div class="sm-search-wrap">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" x2="16.65" y1="21" y2="16.65" />
                </svg>
                <input type="text" name="search" class="sm-search-input" placeholder="Cari nama obat atau merek..."
                    value="{{ request('search') }}" oninput="debounceSubmit()">
            </div>

            <select name="jenis_obat_id" class="sm-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                @foreach ($jenisObatList ?? [] as $jo)
                    <option value="{{ $jo->id }}" {{ request('jenis_obat_id') == $jo->id ? 'selected' : '' }}>
                        {{ $jo->nama }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="sm-select" onchange="this.form.submit()">
                <option value="">Semua Varian</option>
                <option value="bawah" {{ request('status') === 'bawah' ? 'selected' : '' }}>Bawah Minimum</option>
                <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Stok Habis</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Alert Aktif</option>
            </select>

            @if (request()->hasAny(['search', 'jenis_obat_id', 'status']))
                <a href="{{ route('stok-minimum.index') }}" class="sm-btn sm-btn-ghost" style="padding:7px 10px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="18" x2="6" y1="6" y2="18" />
                        <line x1="6" x2="18" y1="6" y2="18" />
                    </svg>
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- ══ TABLE PANEL ══ --}}
    <form action="{{ route('stok-minimum.update-massal') }}" method="POST" id="formMassal">
        @csrf

        <div class="sm-panel">
            <div class="sm-panel-header">
                <div class="sm-panel-left">
                    <div class="sm-panel-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </div>
                    <div>
                        <div class="sm-panel-title">Daftar Varian Obat</div>
                        <div style="display:flex;align-items:center;gap:6px;margin-top:3px;">
                            <span class="sm-count-badge">{{ count($varianList ?? []) }} varian</span>
                        </div>
                    </div>
                </div>
                <div style="font-size:11.5px;color:var(--tx-muted);">
                    Ubah nilai lalu klik <strong style="color:var(--tx-base);">Simpan Semua</strong>
                </div>
            </div>

            @if (count($varianList ?? []) > 0)
                <div style="overflow-x:auto;">
                    <table class="sm-tbl">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Varian / Obat</th>
                                <th>Jenis</th>
                                <th>Stok Saat Ini</th>
                                <th>Stok Minimum</th>
                                <th>Alert</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($varianList as $i => $v)
                                @php
                                    $stok = $v->stok ?? 0;
                                    $min = $v->stok_minimum ?? 0;
                                    $pct = $min > 0 ? min(($stok / ($min * 2)) * 100, 100) : ($stok > 0 ? 100 : 0);
                                    $barClass =
                                        $stok === 0
                                            ? 'empty'
                                            : ($stok <= $min
                                                ? 'danger'
                                                : ($stok <= $min * 1.5
                                                    ? 'warn'
                                                    : 'safe'));
                                    $status =
                                        $stok === 0
                                            ? 'habis'
                                            : ($stok <= $min
                                                ? 'kritis'
                                                : ($stok <= $min * 1.5
                                                    ? 'minimum'
                                                    : 'aman'));
                                    $statusLabel = [
                                        'aman' => 'Aman',
                                        'minimum' => 'Hampir Minimum',
                                        'kritis' => 'Bawah Minimum',
                                        'habis' => 'Stok Habis',
                                    ];
                                @endphp
                                <tr>
                                    <td class="muted">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="sm-obat-cell">
                                            <div class="sm-obat-avatar">{{ strtoupper(substr($v->nama, 0, 1)) }}</div>
                                            <div>
                                                <div class="sm-obat-name">{{ $v->nama }}</div>
                                                <div class="sm-obat-sub">{{ $v->obat->nama_obat ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="muted">
                                        {{ $v->obat->jenisObat->nama_jenis ?? ($v->obat->jenis_obat ?? ($v->obat->id_jenis ?? '-')) }}
                                    </td>
                                    <td>
                                        <div class="sm-stok-wrap">
                                            <div class="sm-stok-nums">
                                                <span class="sm-stok-val"
                                                    style="color:{{ $stok === 0 ? 'var(--clr-red)' : ($stok <= $min ? '#d97706' : 'var(--tx-base)') }};">
                                                    {{ number_format($stok) }}
                                                </span>
                                                <span class="sm-stok-unit">unit</span>
                                            </div>
                                            <div class="sm-bar-track">
                                                <div class="sm-bar-fill {{ $barClass }}"
                                                    style="width:{{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" min="0" name="minimum[{{ $v->id }}]"
                                            class="sm-min-input" value="{{ $v->stok_minimum ?? 0 }}" placeholder="0">
                                    </td>
                                    <td>
                                        <label class="sm-toggle">
                                            <input type="checkbox" name="alert[{{ $v->id }}]" value="1"
                                                {{ $v->alert_aktif ?? false ? 'checked' : '' }}>
                                            <div class="sm-toggle-track">
                                                <div class="sm-toggle-thumb"></div>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <span class="sm-pill {{ $status }}">{{ $statusLabel[$status] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="sm-empty">
                    <div class="sm-empty-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB"
                            stroke-width="1.5">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </div>
                    <div class="sm-empty-title">Tidak ada varian yang ditemukan</div>
                    <div class="sm-empty-sub">
                        @if (request()->hasAny(['search', 'jenis_obat_id', 'status']))
                            Coba ubah kata kunci atau filter pencarian
                        @else
                            Belum ada varian obat yang terdaftar
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- ══ STICKY SAVE BAR ══ --}}
        @if (count($varianList ?? []) > 0)
            <div class="sm-save-bar">
                <div class="sm-save-bar-text">
                    Ubah nilai stok minimum dan status alert, lalu klik <strong>Simpan Semua Perubahan</strong>.
                </div>
                <button type="submit" class="sm-btn sm-btn-green">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Simpan Semua Perubahan
                </button>
            </div>
        @endif

    </form>

@endsection

@push('scripts')
    <script>
        // Debounce search
        var searchTimer;

        function debounceSubmit() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                document.getElementById('filterForm').submit();
            }, 500);
        }
    </script>
@endpush
