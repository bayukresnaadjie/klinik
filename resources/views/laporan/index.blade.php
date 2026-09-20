@extends('layouts.app')

@section('title', 'Semua Laporan')
@section('page-title', 'Laporan')

@push('styles')
    <style>
        /* ══ PAGE HEADER ══ */
        .sl-page-header {
            margin-bottom: 24px;
        }

        .sl-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .sl-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ══ STAT STRIP ══ */
        .sl-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        @media (max-width: 900px) {
            .sl-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .sl-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .sl-stat:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .sl-stat-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .sl-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 700;
            line-height: 1;
        }

        .sl-stat-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 4px;
        }

        .sl-stat-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sl-stat-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .sl-stat-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .sl-stat-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .sl-stat-icon.red {
            background: #FEE2E2;
            color: var(--clr-red);
        }

        .sl-stat-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .sl-stat-accent.blue {
            background: var(--clr-blue);
        }

        .sl-stat-accent.green {
            background: #16a34a;
        }

        .sl-stat-accent.yellow {
            background: #d97706;
        }

        .sl-stat-accent.red {
            background: var(--clr-red);
        }

        /* ══ SECTION LABEL ══ */
        .sl-section-label {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sl-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ══ REPORT CARDS GRID ══ */
        .sl-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        @media (max-width: 960px) {
            .sl-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .sl-cards-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ══ REPORT CARD ══ */
        .sl-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: box-shadow .2s, transform .2s, border-color .2s;
            position: relative;
        }

        .sl-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
            border-color: transparent;
        }

        .sl-card:hover .sl-card-arrow {
            transform: translateX(3px);
        }

        /* Color accent top border */
        .sl-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .sl-card.blue::before {
            background: var(--clr-blue);
        }

        .sl-card.green::before {
            background: #16a34a;
        }

        .sl-card.purple::before {
            background: var(--clr-purple);
        }

        .sl-card-top {
            padding: 20px 20px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .sl-card-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sl-card-icon-wrap.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .sl-card-icon-wrap.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .sl-card-icon-wrap.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .sl-card-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .sl-card-badge.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
            border: 1px solid #BFDBFE;
        }

        .sl-card-badge.green {
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #BBF7D0;
        }

        .sl-card-badge.purple {
            background: #F3F0FF;
            color: #6D28D9;
            border: 1px solid #DDD6FE;
        }

        .sl-card-body {
            padding: 14px 20px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sl-card-title {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--tx-base);
            margin-bottom: 6px;
        }

        .sl-card-desc {
            font-size: 12px;
            color: var(--tx-muted);
            line-height: 1.65;
            flex: 1;
        }

        /* Meta info (e.g. last updated) */
        .sl-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .sl-card-meta-info {
            font-size: 11px;
            color: var(--tx-sub);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sl-card-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: gap .15s;
        }

        .sl-card-link.blue {
            color: var(--clr-blue);
        }

        .sl-card-link.green {
            color: #16a34a;
        }

        .sl-card-link.purple {
            color: var(--clr-purple);
        }

        .sl-card-arrow {
            transition: transform .2s;
        }

        /* ══ QUICK ACCESS GRID (Export shortcuts) ══ */
        .sl-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        @media (max-width: 600px) {
            .sl-quick-grid {
                grid-template-columns: 1fr;
            }
        }

        .sl-quick-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--card-bg);
            text-decoration: none;
            color: inherit;
            transition: border-color .15s, box-shadow .15s, background .15s;
            box-shadow: var(--shadow-card);
        }

        .sl-quick-item:hover {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
            background: #FAFEFF;
        }

        .sl-quick-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sl-quick-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .sl-quick-icon.red {
            background: #FEE2E2;
            color: var(--clr-red);
        }

        .sl-quick-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .sl-quick-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .sl-quick-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .sl-quick-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .sl-quick-arrow {
            margin-left: auto;
            color: var(--tx-sub);
            transition: transform .15s;
        }

        .sl-quick-item:hover .sl-quick-arrow {
            transform: translateX(3px);
            color: var(--clr-blue);
        }

        /* ══ RIGHT PANEL ══ */
        .sl-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 960px) {
            .sl-layout {
                grid-template-columns: 1fr;
            }
        }

        .sl-side-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 14px;
        }

        .sl-side-card:last-child {
            margin-bottom: 0;
        }

        .sl-side-header {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
        }

        .sl-side-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sl-side-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .sl-side-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .sl-side-title {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .sl-side-body {
            padding: 14px 16px;
        }

        /* Alert list */
        .sl-alert-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sl-alert-item {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 9px 11px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            line-height: 1.5;
        }

        .sl-alert-item.warn {
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            color: #92400E;
        }

        .sl-alert-item.danger {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        .sl-alert-item.info {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: #1E40AF;
        }

        .sl-alert-text {
            flex: 1;
        }

        .sl-alert-count {
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 700;
            margin-left: auto;
            flex-shrink: 0;
        }

        /* Period summary */
        .sl-period-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .sl-period-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .sl-period-row:last-child {
            border-bottom: none;
        }

        .sl-period-label {
            color: var(--tx-muted);
        }

        .sl-period-val {
            font-weight: 600;
            color: var(--tx-base);
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="sl-page-header">
        <div class="sl-page-title">Laporan</div>
        <div class="sl-page-sub">Pilih jenis laporan yang ingin ditampilkan</div>
    </div>

    {{-- Stat Strip --}}
    <div class="sl-stats">
        <div class="sl-stat">
            <div class="sl-stat-icon blue">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="sl-stat-label">Total Varian</div>
            <div class="sl-stat-value" style="color:var(--clr-blue);">{{ $totalVarian ?? 0 }}</div>
            <div class="sl-stat-sub">varian terdaftar</div>
            <div class="sl-stat-accent blue"></div>
        </div>
        <div class="sl-stat">
            <div class="sl-stat-icon green">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="sl-stat-label">Pemakaian Bulan Ini</div>
            <div class="sl-stat-value" style="color:#16a34a;">{{ number_format($pemakaianBulanIni ?? 0) }}</div>
            <div class="sl-stat-sub">unit obat</div>
            <div class="sl-stat-accent green"></div>
        </div>
        <div class="sl-stat">
            <div class="sl-stat-icon yellow">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
            </div>
            <div class="sl-stat-label">Bawah Minimum</div>
            <div class="sl-stat-value" style="color:#d97706;">{{ $bawahMinimum ?? 0 }}</div>
            <div class="sl-stat-sub">varian perlu diisi</div>
            <div class="sl-stat-accent yellow"></div>
        </div>
        <div class="sl-stat">
            <div class="sl-stat-icon red">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
            </div>
            <div class="sl-stat-label">Akan Expired</div>
            <div class="sl-stat-value" style="color:var(--clr-red);">{{ $akanExpired ?? 0 }}</div>
            <div class="sl-stat-sub">dalam 30 hari ke depan</div>
            <div class="sl-stat-accent red"></div>
        </div>
    </div>

    <div class="sl-layout">

        {{-- ══ LEFT: Main Reports ══ --}}
        <div>
            <div class="sl-section-label">Laporan Utama</div>

            <div class="sl-cards-grid">

                {{-- Laporan Pemakaian --}}
                <a href="{{ route('laporan.pemakaian') }}" class="sl-card blue">
                    <div class="sl-card-top">
                        <div class="sl-card-icon-wrap blue">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <span class="sl-card-badge blue">Periode</span>
                    </div>
                    <div class="sl-card-body">
                        <div class="sl-card-title">Laporan Pemakaian</div>
                        <div class="sl-card-desc">
                            Rekap pemakaian obat per periode dengan grafik tren harian dan top 5 obat terbanyak digunakan.
                        </div>
                        <div class="sl-card-meta">
                            <div class="sl-card-meta-info">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Diperbarui realtime
                            </div>
                            <span class="sl-card-link blue">
                                Lihat laporan
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" class="sl-card-arrow">
                                    <line x1="5" x2="19" y1="12" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                {{-- Rekap Stok --}}
                <a href="{{ route('laporan.stok') }}" class="sl-card green">
                    <div class="sl-card-top">
                        <div class="sl-card-icon-wrap green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <rect width="20" height="14" x="2" y="7" rx="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <span class="sl-card-badge green">Inventori</span>
                    </div>
                    <div class="sl-card-body">
                        <div class="sl-card-title">Rekap Stok</div>
                        <div class="sl-card-desc">
                            Status stok semua varian obat, nilai inventori, filter per jenis dan status ketersediaan.
                        </div>
                        <div class="sl-card-meta">
                            <div class="sl-card-meta-info">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Diperbarui realtime
                            </div>
                            <span class="sl-card-link green">
                                Lihat laporan
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" class="sl-card-arrow">
                                    <line x1="5" x2="19" y1="12" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                {{-- Tren Bulanan --}}
                <a href="{{ route('laporan.tren') }}" class="sl-card purple">
                    <div class="sl-card-top">
                        <div class="sl-card-icon-wrap purple">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                <polyline points="17 6 23 6 23 12" />
                            </svg>
                        </div>
                        <span class="sl-card-badge purple">Tahunan</span>
                    </div>
                    <div class="sl-card-body">
                        <div class="sl-card-title">Tren Bulanan</div>
                        <div class="sl-card-desc">
                            Grafik pemakaian dan nilai obat per bulan dalam satu tahun. Bandingkan antar bulan dengan mudah.
                        </div>
                        <div class="sl-card-meta">
                            <div class="sl-card-meta-info">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Per tahun
                            </div>
                            <span class="sl-card-link purple">
                                Lihat laporan
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" class="sl-card-arrow">
                                    <line x1="5" x2="19" y1="12" y2="12" />
                                    <polyline points="12 5 19 12 12 19" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

            </div>

            {{-- ── Quick Export ── --}}
            @can('export-laporan')
                <div class="sl-section-label">Export Cepat</div>
                <div class="sl-quick-grid">
                    <a href="{{ route('export.pemakaian.excel') }}" class="sl-quick-item">
                        <div class="sl-quick-icon green">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" x2="12" y1="15" y2="3" />
                            </svg>
                        </div>
                        <div>
                            <div class="sl-quick-name">Pemakaian — Excel</div>
                            <div class="sl-quick-sub">Export data bulan ini</div>
                        </div>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="sl-quick-arrow">
                            <line x1="5" x2="19" y1="12" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                    <a href="{{ route('export.pemakaian.pdf') }}" class="sl-quick-item">
                        <div class="sl-quick-icon red">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <div>
                            <div class="sl-quick-name">Pemakaian — PDF</div>
                            <div class="sl-quick-sub">Export data bulan ini</div>
                        </div>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="sl-quick-arrow">
                            <line x1="5" x2="19" y1="12" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                    <a href="{{ route('export.stok.excel') }}" class="sl-quick-item">
                        <div class="sl-quick-icon blue">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" x2="12" y1="15" y2="3" />
                            </svg>
                        </div>
                        <div>
                            <div class="sl-quick-name">Rekap Stok — Excel</div>
                            <div class="sl-quick-sub">Semua varian obat</div>
                        </div>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="sl-quick-arrow">
                            <line x1="5" x2="19" y1="12" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                    <a href="{{ route('export.stok.pdf') }}" class="sl-quick-item">
                        <div class="sl-quick-icon purple">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <div>
                            <div class="sl-quick-name">Rekap Stok — PDF</div>
                            <div class="sl-quick-sub">Semua varian obat</div>
                        </div>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="sl-quick-arrow">
                            <line x1="5" x2="19" y1="12" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
            @endcan

        </div>{{-- /left --}}

        {{-- ══ RIGHT: Side Panels ══ --}}
        <div>

            {{-- Alert Stok --}}
            <div class="sl-side-card">
                <div class="sl-side-header">
                    <div class="sl-side-icon yellow">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                            <line x1="12" x2="12.01" y1="17" y2="17" />
                        </svg>
                    </div>
                    <div class="sl-side-title">Status Stok</div>
                </div>
                <div class="sl-side-body">
                    <div class="sl-alert-list">
                        <div class="sl-alert-item danger">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            <div class="sl-alert-text">Stok habis</div>
                            <div class="sl-alert-count">{{ $stokHabis ?? 0 }}</div>
                        </div>
                        <div class="sl-alert-item warn">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                <line x1="12" x2="12" y1="9" y2="13" />
                            </svg>
                            <div class="sl-alert-text">Bawah minimum</div>
                            <div class="sl-alert-count">{{ $bawahMinimum ?? 0 }}</div>
                        </div>
                        <div class="sl-alert-item danger">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" x2="16" y1="2" y2="6" />
                                <line x1="8" x2="8" y1="2" y2="6" />
                                <line x1="3" x2="21" y1="10" y2="10" />
                            </svg>
                            <div class="sl-alert-text">Akan expired 30 hari</div>
                            <div class="sl-alert-count">{{ $akanExpired ?? 0 }}</div>
                        </div>
                        <div class="sl-alert-item info">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            <div class="sl-alert-text">Sudah expired</div>
                            <div class="sl-alert-count">{{ $sudahExpired ?? 0 }}</div>
                        </div>
                    </div>
                    <a href="{{ route('laporan.stok', ['status' => 'kritis']) }}"
                        style="display:block;margin-top:12px;text-align:center;font-size:12px;font-weight:600;color:var(--clr-blue);text-decoration:none;padding:8px;border-radius:var(--radius-sm);border:1px solid var(--border);transition:background .15s;"
                        onmouseover="this.style.background='var(--page-bg)'" onmouseout="this.style.background=''">
                        Lihat detail stok →
                    </a>
                </div>
            </div>

            {{-- Ringkasan Periode --}}
            <div class="sl-side-card">
                <div class="sl-side-header">
                    <div class="sl-side-icon blue">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                    </div>
                    <div class="sl-side-title">Ringkasan {{ now()->translatedFormat('F Y') }}</div>
                </div>
                <div class="sl-side-body">
                    <div class="sl-period-list">
                        <div class="sl-period-row">
                            <span class="sl-period-label">Total pemakaian</span>
                            <span class="sl-period-val">{{ number_format($pemakaianBulanIni ?? 0) }} unit</span>
                        </div>
                        <div class="sl-period-row">
                            <span class="sl-period-label">Nilai pemakaian</span>
                            <span class="sl-period-val">Rp
                                {{ number_format($nilaiPemakaianBulanIni ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="sl-period-row">
                            <span class="sl-period-label">Jenis obat dipakai</span>
                            <span class="sl-period-val">{{ $jenisDipakai ?? 0 }} varian</span>
                        </div>
                        <div class="sl-period-row">
                            <span class="sl-period-label">Nilai inventori</span>
                            <span class="sl-period-val" style="color:#16a34a;">Rp
                                {{ number_format($nilaiInventori ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="sl-period-row">
                            <span class="sl-period-label">Total stok</span>
                            <span class="sl-period-val">{{ number_format($totalStok ?? 0) }} unit</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /right --}}
    </div>

@endsection
