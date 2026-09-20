@extends('layouts.app')

@section('title', 'Rekap Stok Obat')
@section('page-title', 'Laporan Stok')

@push('styles')
    <style>
        /* ── Filter Bar ── */
        .ls-filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-card);
            flex-wrap: wrap;
        }

        .ls-filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-muted);
            white-space: nowrap;
        }

        .ls-select {
            padding: 7px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            outline: none;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            min-width: 140px;
        }

        .ls-select:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        .ls-filter-divider {
            width: 1px;
            height: 22px;
            background: var(--border);
            margin: 0 4px;
        }

        .ls-btn {
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
            text-decoration: none;
        }

        .ls-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .ls-btn-primary:hover {
            opacity: .88;
        }

        .ls-btn-ghost {
            background: transparent;
            color: var(--tx-muted);
        }

        .ls-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        .ls-btn-export {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
            margin-left: auto;
        }

        .ls-btn-export:hover {
            opacity: .88;
        }

        /* ── Stat Cards ── */
        .ls-stats {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 1100px) {
            .ls-stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 680px) {
            .ls-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .ls-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .ls-stat:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .ls-stat-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .ls-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1;
        }

        .ls-stat-value.green {
            color: #16a34a;
        }

        .ls-stat-value.blue {
            color: var(--clr-blue);
        }

        .ls-stat-value.yellow {
            color: #d97706;
        }

        .ls-stat-value.red {
            color: var(--clr-red);
        }

        .ls-stat-value.purple {
            color: var(--clr-purple);
        }

        .ls-stat-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .ls-stat-accent.green {
            background: #16a34a;
        }

        .ls-stat-accent.blue {
            background: var(--clr-blue);
        }

        .ls-stat-accent.yellow {
            background: #d97706;
        }

        .ls-stat-accent.red {
            background: var(--clr-red);
        }

        .ls-stat-accent.purple {
            background: var(--clr-purple);
        }

        .ls-stat-accent.gray {
            background: var(--tx-sub);
        }

        .ls-stat-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .ls-stat-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .ls-stat-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .ls-stat-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .ls-stat-icon.red {
            background: #FEE2E2;
            color: var(--clr-red);
        }

        .ls-stat-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .ls-stat-icon.gray {
            background: #F3F4F6;
            color: var(--tx-muted);
        }

        /* ── Content Grid ── */
        .ls-content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .ls-content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Panel ── */
        .ls-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .ls-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
        }

        .ls-panel-title-wrap {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .ls-panel-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ls-panel-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .ls-panel-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .ls-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .ls-panel-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .ls-panel-body {
            padding: 16px 18px;
        }

        /* ── Distribution ── */
        .ls-distrib-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .ls-distrib-item {
            padding: 14px;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
        }

        .ls-distrib-item.aman {
            background: #F0FDF4;
            border-color: #BBF7D0;
        }

        .ls-distrib-item.minimum {
            background: #FEF3C7;
            border-color: #FDE68A;
        }

        .ls-distrib-item.kritis {
            background: #FFF7ED;
            border-color: #FED7AA;
        }

        .ls-distrib-item.expired {
            background: #FEF2F2;
            border-color: #FECACA;
        }

        .ls-distrib-item.habis {
            background: #FEF2F2;
            border-color: #FECACA;
        }

        .ls-di-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .ls-distrib-item.aman .ls-di-label {
            color: #166534;
        }

        .ls-distrib-item.minimum .ls-di-label {
            color: #92400E;
        }

        .ls-distrib-item.kritis .ls-di-label {
            color: #9A3412;
        }

        .ls-distrib-item.expired .ls-di-label {
            color: #991B1B;
        }

        .ls-distrib-item.habis .ls-di-label {
            color: #991B1B;
        }

        .ls-di-value {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .ls-distrib-item.aman .ls-di-value {
            color: #16a34a;
        }

        .ls-distrib-item.minimum .ls-di-value {
            color: #d97706;
        }

        .ls-distrib-item.kritis .ls-di-value {
            color: #ea580c;
        }

        .ls-distrib-item.expired .ls-di-value {
            color: var(--clr-red);
        }

        .ls-distrib-item.habis .ls-di-value {
            color: var(--clr-red);
        }

        .ls-di-sub {
            font-size: 10.5px;
            opacity: .7;
            margin-top: 4px;
        }

        /* ── Bar chart ── */
        .ls-bar-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ls-bar-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .ls-bar-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--tx-base);
        }

        .ls-bar-count {
            font-size: 11px;
            color: var(--tx-muted);
            font-weight: 600;
        }

        .ls-bar-track {
            height: 6px;
            background: var(--page-bg);
            border-radius: 99px;
            overflow: hidden;
        }

        .ls-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--clr-blue);
            transition: width .6s ease;
        }

        .ls-empty {
            text-align: center;
            padding: 28px 0;
            color: var(--tx-sub);
            font-size: 12.5px;
        }

        /* ── Table ── */
        .ls-table-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 8px;
        }

        .ls-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            flex-wrap: wrap;
            gap: 10px;
        }

        .ls-table-title-wrap {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .ls-count-badge {
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            background: #EFF6FF;
            color: var(--clr-blue);
            font-weight: 600;
            border: 1px solid #BFDBFE;
        }

        .ls-table-actions {
            display: flex;
            gap: 8px;
        }

        .ls-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .ls-tbl thead tr {
            background: #F9FAFB;
        }

        .ls-tbl th {
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

        .ls-tbl td {
            padding: 10px 14px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .ls-tbl tr:last-child td {
            border-bottom: none;
        }

        .ls-tbl tbody tr:hover {
            background: #FAFAFA;
        }

        .ls-tbl td.num {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        .ls-tbl .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        .st-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .st-pill::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
        }

        .st-pill.aman {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        .st-pill.minimum {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid #FDE68A;
        }

        .st-pill.kritis {
            background: #FFEDD5;
            color: #C2410C;
            border: 1px solid #FED7AA;
        }

        .st-pill.expired {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        .st-pill.habis {
            background: #F3F4F6;
            color: #374151;
            border: 1px solid #E5E7EB;
        }

        .ls-tbl-empty {
            padding: 36px;
            text-align: center;
            color: var(--tx-sub);
            font-size: 12.5px;
        }

        .ls-tbl-empty svg {
            display: block;
            margin: 0 auto 10px;
            opacity: .3;
        }

        .ls-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .ls-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .ls-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .ls-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--tx-muted);
            text-decoration: none;
            margin-bottom: 6px;
            transition: color .15s;
        }

        .ls-back:hover {
            color: var(--clr-blue);
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="ls-page-header">
        <div>
            <a href="{{ route('laporan.index') }}" class="ls-back">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali ke Semua Laporan
            </a>
            <div class="ls-page-title">Rekap Stok Obat</div>
            <div class="ls-page-sub">Status ketersediaan semua varian obat</div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            @can('export-laporan')
                <a href="{{ route('export.stok.excel') }}" class="ls-btn ls-btn-export">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('export.stok.pdf') }}" class="ls-btn"
                    style="background:#dc2626;color:#fff;border-color:#dc2626;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Export PDF
                </a>
            @endcan
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('laporan.stok') }}">
        <div class="ls-filter-bar">
            <span class="ls-filter-label">Jenis Obat</span>
            <select name="jenis" class="ls-select">
                <option value="semua">Semua Jenis</option>
                @foreach ($jenisObatList ?? [] as $jo)
                    <option value="{{ $jo->id_jenis }}" {{ $filterJenis == $jo->id_jenis ? 'selected' : '' }}>
                        {{ $jo->nama_jenis }}
                    </option>
                @endforeach
            </select>

            <div class="ls-filter-divider"></div>

            <span class="ls-filter-label">Status Stok</span>
            <select name="status" class="ls-select">
                <option value="semua" {{ $filterStatus === 'semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="aman" {{ $filterStatus === 'aman' ? 'selected' : '' }}>Aman</option>
                <option value="minimum" {{ $filterStatus === 'minimum' ? 'selected' : '' }}>Stok Minimum</option>
                <option value="kritis" {{ $filterStatus === 'kritis' ? 'selected' : '' }}>Kritis / Exp</option>
                <option value="expired" {{ $filterStatus === 'expired' ? 'selected' : '' }}>Sudah Expired</option>
                <option value="habis" {{ $filterStatus === 'habis' ? 'selected' : '' }}>Stok Habis</option>
            </select>

            <button type="submit" class="ls-btn ls-btn-primary">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" x2="16.65" y1="21" y2="16.65" />
                </svg>
                Filter
            </button>
            <a href="{{ route('laporan.stok') }}" class="ls-btn ls-btn-ghost">Reset</a>
        </div>
    </form>

    {{-- Stat Cards --}}
    <div class="ls-stats">
        <div class="ls-stat">
            <div class="ls-stat-icon gray">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="ls-stat-label">Total Varian</div>
            <div class="ls-stat-value">{{ $totalVarian ?? 0 }}</div>
            <div class="ls-stat-accent gray"></div>
        </div>
        <div class="ls-stat">
            <div class="ls-stat-icon blue">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="ls-stat-label">Total Stok</div>
            <div class="ls-stat-value blue">{{ number_format($totalStok ?? 0) }}</div>
            <div class="ls-stat-accent blue"></div>
        </div>
        <div class="ls-stat">
            <div class="ls-stat-icon green">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="12" x2="12" y1="2" y2="22" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="ls-stat-label">Nilai Inventori</div>
            <div class="ls-stat-value green" style="font-size:16px;">
                Rp {{ number_format($nilaiInventori ?? 0, 0, ',', '.') }}
            </div>
            <div class="ls-stat-accent green"></div>
        </div>
        <div class="ls-stat">
            <div class="ls-stat-icon red">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" x2="12" y1="8" y2="12" />
                    <line x1="12" x2="12.01" y1="16" y2="16" />
                </svg>
            </div>
            <div class="ls-stat-label">Stok Habis</div>
            <div class="ls-stat-value red">{{ $stokHabis ?? 0 }}</div>
            <div class="ls-stat-accent red"></div>
        </div>
        <div class="ls-stat">
            <div class="ls-stat-icon yellow">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
            </div>
            <div class="ls-stat-label">Stok Kritis</div>
            <div class="ls-stat-value yellow">{{ $stokKritis ?? 0 }}</div>
            <div class="ls-stat-accent yellow"></div>
        </div>
        <div class="ls-stat">
            <div class="ls-stat-icon purple">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
            </div>
            <div class="ls-stat-label">Sudah Expired</div>
            <div class="ls-stat-value purple">{{ $sudahExpired ?? 0 }}</div>
            <div class="ls-stat-accent purple"></div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="ls-content-grid">

        {{-- Bar Chart Stok per Jenis --}}
        <div class="ls-panel">
            <div class="ls-panel-header">
                <div class="ls-panel-title-wrap">
                    <div class="ls-panel-icon blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="18" x2="18" y1="20" y2="10" />
                            <line x1="12" x2="12" y1="20" y2="4" />
                            <line x1="6" x2="6" y1="20" y2="14" />
                        </svg>
                    </div>
                    <div>
                        <div class="ls-panel-title">Stok per Jenis Obat</div>
                        <div class="ls-panel-sub">Distribusi berdasarkan kategori</div>
                    </div>
                </div>
            </div>
            <div class="ls-panel-body">
                @php
                    $maxStok = $stokPerJenis->max('total_stok') ?: 1;
                @endphp
                @if ($stokPerJenis->count() > 0)
                    <div class="ls-bar-list">
                        @foreach ($stokPerJenis as $item)
                            <div class="ls-bar-item">
                                <div class="ls-bar-top">
                                    <span class="ls-bar-name">{{ $item['nama'] }}</span>
                                    <span class="ls-bar-count">{{ number_format($item['total_stok']) }} unit</span>
                                </div>
                                <div class="ls-bar-track">
                                    <div class="ls-bar-fill" style="width:{{ ($item['total_stok'] / $maxStok) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="ls-empty">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB"
                            stroke-width="1.5" style="margin:0 auto 8px">
                            <line x1="18" x2="18" y1="20" y2="10" />
                            <line x1="12" x2="12" y1="20" y2="4" />
                            <line x1="6" x2="6" y1="20" y2="14" />
                        </svg>
                        Belum ada data stok
                    </div>
                @endif
            </div>
        </div>

        {{-- Distribusi Status --}}
        <div class="ls-panel">
            <div class="ls-panel-header">
                <div class="ls-panel-title-wrap">
                    <div class="ls-panel-icon green">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </div>
                    <div>
                        <div class="ls-panel-title">Distribusi Status Stok</div>
                        <div class="ls-panel-sub">Kondisi ketersediaan semua varian</div>
                    </div>
                </div>
            </div>
            <div class="ls-panel-body">
                <div class="ls-distrib-grid">
                    <div class="ls-distrib-item aman">
                        <div class="ls-di-label">Aman</div>
                        <div class="ls-di-value">{{ $distribStatus['aman'] ?? 0 }}</div>
                        <div class="ls-di-sub">varian</div>
                    </div>
                    <div class="ls-distrib-item minimum">
                        <div class="ls-di-label">Stok Minimum</div>
                        <div class="ls-di-value">{{ $distribStatus['minimum'] ?? 0 }}</div>
                        <div class="ls-di-sub">varian</div>
                    </div>
                    <div class="ls-distrib-item kritis">
                        <div class="ls-di-label">Kritis / Exp</div>
                        <div class="ls-di-value">{{ $distribStatus['kritis'] ?? 0 }}</div>
                        <div class="ls-di-sub">varian</div>
                    </div>
                    <div class="ls-distrib-item expired">
                        <div class="ls-di-label">Expired</div>
                        <div class="ls-di-value">{{ $distribStatus['expired'] ?? 0 }}</div>
                        <div class="ls-di-sub">varian</div>
                    </div>
                    <div class="ls-distrib-item habis" style="grid-column:span 2;">
                        <div class="ls-di-label">Stok Habis</div>
                        <div class="ls-di-value">{{ $distribStatus['habis'] ?? 0 }}</div>
                        <div class="ls-di-sub">varian tidak tersedia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Table --}}
    <div class="ls-table-panel">
        <div class="ls-table-header">
            <div class="ls-table-title-wrap">
                <div class="ls-panel-icon blue">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18M9 21V9" />
                    </svg>
                </div>
                <div>
                    <div class="ls-panel-title">Detail Stok Semua Varian</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-top:2px;">
                        <span class="ls-count-badge">{{ $varian->count() }} varian</span>
                    </div>
                </div>
            </div>
            <div class="ls-table-actions">
                @can('export-laporan')
                    <a href="{{ route('export.stok.excel') }}" class="ls-btn ls-btn-export"
                        style="font-size:11.5px;padding:6px 12px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Excel
                    </a>
                @endcan
            </div>
        </div>

        @if ($varian->count() > 0)
            <div style="overflow-x:auto;">
                <table class="ls-tbl">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Nama Varian</th>
                            <th>Obat</th>
                            <th>Jenis</th>
                            <th>Stok</th>
                            <th>Stok Min.</th>
                            <th>Exp. Date</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($varian as $i => $v)
                            @php
                                $status = $v['status'];
                                $labels = [
                                    'aman' => 'Aman',
                                    'minimum' => 'Min.',
                                    'kritis' => 'Kritis',
                                    'expired' => 'Expired',
                                    'habis' => 'Habis',
                                    'no_limit' => 'Aman',
                                ];
                            @endphp
                            <tr>
                                <td class="muted">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:500;font-size:13px;">
                                        {{ $v['nama_merek'] }}
                                        @if ($v['dosis_mg'])
                                            <span style="font-size:10.5px;color:var(--tx-muted);font-weight:400;">
                                                {{ $v['dosis_mg'] }} mg
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="muted">{{ $v['nama_obat'] }}</td>
                                <td class="muted">{{ $v['jenis'] }}</td>
                                <td class="num">{{ number_format($v['total_stok']) }}</td>
                                <td class="muted">{{ number_format($v['stok_minimum']) }}</td>
                                <td class="muted">{{ $v['exp_terdekat'] }}</td>
                                <td class="num" style="color:#16a34a;">
                                    Rp {{ number_format($v['harga'], 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="st-pill {{ $status }}">
                                        {{ $labels[$status] ?? ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="ls-tbl-empty">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
                Tidak ada data yang sesuai filter.
            </div>
        @endif
    </div>

@endsection
