@extends('layouts.app')

@section('title', 'Laporan Pemakaian Obat')
@section('page-title', 'Laporan Pemakaian')

@push('styles')
    <style>
        /* ── Page Header ── */
        .lp-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--tx-muted);
            text-decoration: none;
            margin-bottom: 6px;
            transition: color .15s;
        }

        .lp-back:hover {
            color: var(--clr-blue);
        }

        .lp-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .lp-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .lp-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ── Filter Bar ── */
        .lp-filter-bar {
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

        .lp-filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-muted);
            white-space: nowrap;
        }

        .lp-input {
            padding: 7px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .lp-input:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        .lp-filter-divider {
            width: 1px;
            height: 22px;
            background: var(--border);
            margin: 0 2px;
        }

        .lp-btn {
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
            white-space: nowrap;
        }

        .lp-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .lp-btn-primary:hover {
            opacity: .88;
        }

        .lp-btn-ghost {
            background: transparent;
            color: var(--tx-muted);
        }

        .lp-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        .lp-btn-green {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }

        .lp-btn-green:hover {
            opacity: .88;
        }

        .lp-btn-red {
            background: #dc2626;
            color: #fff;
            border-color: #dc2626;
        }

        .lp-btn-red:hover {
            opacity: .88;
        }

        /* Quick range buttons */
        .lp-range-group {
            display: flex;
            gap: 4px;
            margin-left: auto;
        }

        .lp-range-btn {
            padding: 6px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            font-family: 'DM Sans', sans-serif;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
        }

        .lp-range-btn:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        .lp-range-btn.active {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        /* ── Stat Cards ── */
        .lp-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .lp-stats {
                grid-template-columns: 1fr;
            }
        }

        .lp-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .lp-stat:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .lp-stat-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .lp-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1;
        }

        .lp-stat-value.blue {
            color: var(--clr-blue);
        }

        .lp-stat-value.green {
            color: #16a34a;
        }

        .lp-stat-value.purple {
            color: var(--clr-purple);
        }

        .lp-stat-sub {
            font-size: 11.5px;
            color: var(--tx-sub);
            margin-top: 6px;
        }

        .lp-stat-icon {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lp-stat-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .lp-stat-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .lp-stat-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .lp-stat-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .lp-stat-accent.blue {
            background: var(--clr-blue);
        }

        .lp-stat-accent.green {
            background: #16a34a;
        }

        .lp-stat-accent.purple {
            background: var(--clr-purple);
        }

        /* ── Panel ── */
        .lp-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .lp-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            flex-wrap: wrap;
            gap: 10px;
        }

        .lp-panel-left {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .lp-panel-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lp-panel-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .lp-panel-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .lp-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .lp-panel-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .lp-panel-body {
            padding: 18px;
        }

        .lp-count-badge {
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            background: #EFF6FF;
            color: var(--clr-blue);
            font-weight: 600;
            border: 1px solid #BFDBFE;
        }

        /* ── Table ── */
        .lp-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .lp-tbl thead tr {
            background: #F9FAFB;
        }

        .lp-tbl th {
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

        .lp-tbl td {
            padding: 10px 14px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .lp-tbl tr:last-child td {
            border-bottom: none;
        }

        .lp-tbl tbody tr:hover {
            background: #FAFAFA;
        }

        .lp-tbl .num {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        .lp-tbl .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        /* Top obat card dalam panel */
        .lp-top-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width: 900px) {
            .lp-top-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Top obat bar list */
        .lp-rank-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lp-rank-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lp-rank-no {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--page-bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: var(--tx-muted);
            flex-shrink: 0;
        }

        .lp-rank-no.top {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .lp-rank-info {
            flex: 1;
            min-width: 0;
        }

        .lp-rank-name {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--tx-base);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .lp-rank-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .lp-rank-bar-wrap {
            flex: 1;
        }

        .lp-rank-track {
            height: 5px;
            background: var(--page-bg);
            border-radius: 99px;
            overflow: hidden;
            margin-top: 4px;
        }

        .lp-rank-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--clr-blue);
        }

        .lp-rank-val {
            font-size: 12px;
            font-weight: 700;
            color: var(--clr-blue);
            white-space: nowrap;
        }

        /* Bulan summary pills */
        .lp-month-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        @media (max-width: 700px) {
            .lp-month-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .lp-month-pill {
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            text-align: center;
        }

        .lp-month-name {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--tx-muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .lp-month-value {
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--clr-blue);
            margin-top: 4px;
        }

        .lp-month-sub {
            font-size: 10px;
            color: var(--tx-sub);
            margin-top: 2px;
        }

        .lp-empty {
            text-align: center;
            padding: 36px;
            color: var(--tx-sub);
            font-size: 12.5px;
        }

        .lp-empty svg {
            display: block;
            margin: 0 auto 10px;
            opacity: .3;
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="lp-page-header">
        <div>
            <a href="{{ route('laporan.index') }}" class="lp-back">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali ke Semua Laporan
            </a>
            <div class="lp-page-title">Laporan Pemakaian Obat</div>
            <div class="lp-page-sub">Rekap pemakaian berdasarkan periode</div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('export.pemakaian.excel', request()->query()) }}" class="lp-btn lp-btn-green">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('export.pemakaian.pdf', request()->query()) }}" class="lp-btn lp-btn-red">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Export PDF
                </a>
            @endif
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('laporan.pemakaian') }}">
        <div class="lp-filter-bar">
            <span class="lp-filter-label">Dari Tanggal</span>
            <input type="date" name="dari" class="lp-input"
                value="{{ request('dari', now()->startOfMonth()->toDateString()) }}">
            <span class="lp-filter-label">Sampai</span>
            <input type="date" name="sampai" class="lp-input" value="{{ request('sampai', now()->toDateString()) }}">

            <button type="submit" class="lp-btn lp-btn-primary">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" x2="16.65" y1="21" y2="16.65" />
                </svg>
                Tampilkan
            </button>
            <a href="{{ route('laporan.pemakaian') }}" class="lp-btn lp-btn-ghost">Reset</a>

            <div class="lp-filter-divider"></div>

            {{-- Quick range --}}
            <div class="lp-range-group">
                <a href="{{ route('laporan.pemakaian', ['dari' => now()->toDateString(), 'sampai' => now()->toDateString()]) }}"
                    class="lp-range-btn {{ request('dari') === now()->toDateString() && request('sampai') === now()->toDateString() ? 'active' : '' }}">
                    Hari ini
                </a>
                <a href="{{ route('laporan.pemakaian', ['dari' => now()->startOfWeek()->toDateString(), 'sampai' => now()->toDateString()]) }}"
                    class="lp-range-btn">
                    Minggu ini
                </a>
                <a href="{{ route('laporan.pemakaian', ['dari' => now()->startOfMonth()->toDateString(), 'sampai' => now()->toDateString()]) }}"
                    class="lp-range-btn {{ !request()->has('dari') || (request('dari') === now()->startOfMonth()->toDateString() && request('sampai') === now()->toDateString()) ? 'active' : '' }}">
                    Bulan ini
                </a>
                <a href="{{ route('laporan.pemakaian', ['dari' => now()->subMonth()->startOfMonth()->toDateString(), 'sampai' => now()->subMonth()->endOfMonth()->toDateString()]) }}"
                    class="lp-range-btn">
                    Bulan lalu
                </a>
            </div>
        </div>
    </form>

    {{-- Stat Cards --}}
    <div class="lp-stats">
        <div class="lp-stat">
            <div class="lp-stat-icon blue">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="lp-stat-label">Total Item Dipakai</div>
            <div class="lp-stat-value blue">{{ number_format($totalItem ?? 0) }}</div>
            <div class="lp-stat-sub">unit obat dalam periode ini</div>
            <div class="lp-stat-accent blue"></div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon green">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="12" x2="12" y1="2" y2="22" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="lp-stat-label">Total Nilai Pemakaian</div>
            <div class="lp-stat-value green" style="font-size:20px;">Rp
                {{ number_format($totalNilai ?? 0, 0, ',', '.') }}</div>
            <div class="lp-stat-sub">estimasi harga</div>
            <div class="lp-stat-accent green"></div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon purple">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M12 2v3m0 14v3M4.22 4.22l2.12 2.12m11.32 11.32 2.12 2.12M2 12h3m14 0h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" />
                </svg>
            </div>
            <div class="lp-stat-label">Jenis Obat Dipakai</div>
            <div class="lp-stat-value purple">{{ $jumlahJenis ?? 0 }}</div>
            <div class="lp-stat-sub">varian berbeda</div>
            <div class="lp-stat-accent purple"></div>
        </div>
    </div>

    {{-- Top Obat + Monthly Summary --}}
    <div class="lp-top-grid" style="margin-bottom:16px;">

        {{-- Top Obat --}}
        <div class="lp-panel" style="margin-bottom:0;">
            <div class="lp-panel-header">
                <div class="lp-panel-left">
                    <div class="lp-panel-icon blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                            <polyline points="17 6 23 6 23 12" />
                        </svg>
                    </div>
                    <div>
                        <div class="lp-panel-title">Top Obat Terbanyak</div>
                        <div class="lp-panel-sub">Berdasarkan jumlah pemakaian</div>
                    </div>
                </div>
            </div>
            <div class="lp-panel-body">
                @php
                    $topObat = $topObat ?? [];
                    $maxPakai = collect($topObat)->max('total_pakai') ?: 1;
                @endphp
                @if (count($topObat) > 0)
                    <div class="lp-rank-list">
                        @foreach ($topObat as $i => $ob)
                            <div class="lp-rank-item">
                                <div class="lp-rank-no {{ $i < 3 ? 'top' : '' }}">{{ $i + 1 }}</div>
                                <div class="lp-rank-info" style="flex:1.5;min-width:0;">
                                    <div class="lp-rank-name">{{ $ob['nama_merek'] }}</div>
                                    <div class="lp-rank-sub">{{ $ob['nama_obat'] }}</div>
                                    <div class="lp-rank-track">
                                        <div class="lp-rank-fill"
                                            style="width:{{ ($ob['total_pakai'] / $maxPakai) * 100 }}%"></div>
                                    </div>
                                </div>
                                <div class="lp-rank-val">{{ number_format($ob['total_pakai']) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="lp-empty">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                        </svg>
                        Belum ada data pemakaian
                    </div>
                @endif
            </div>
        </div>

        {{-- Rekap per Bulan --}}
        <div class="lp-panel" style="margin-bottom:0;">
            <div class="lp-panel-header">
                <div class="lp-panel-left">
                    <div class="lp-panel-icon purple">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                    </div>
                    <div>
                        <div class="lp-panel-title">Rekap per Bulan</div>
                        <div class="lp-panel-sub">Total pemakaian bulanan tahun ini</div>
                    </div>
                </div>
            </div>
            <div class="lp-panel-body">
                @php
                    $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    $rekapBulan = $rekapBulan ?? [];
                @endphp
                @if (count($rekapBulan) > 0)
                    <div class="lp-month-grid">
                        @foreach ($rekapBulan as $rb)
                            <div class="lp-month-pill">
                                <div class="lp-month-name">{{ $bulanNames[($rb->bulan ?? 1) - 1] }}</div>
                                <div class="lp-month-value">{{ number_format($rb->total ?? 0) }}</div>
                                <div class="lp-month-sub">unit</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="lp-empty">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                        </svg>
                        Belum ada data bulanan
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Detail Table --}}
    <div class="lp-panel">
        <div class="lp-panel-header">
            <div class="lp-panel-left">
                <div class="lp-panel-icon blue">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18M9 21V9" />
                    </svg>
                </div>
                <div>
                    <div class="lp-panel-title">Detail Pemakaian per Obat</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-top:3px;">
                        <span class="lp-count-badge">{{ count($detailList ?? []) }} varian</span>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('export.pemakaian.excel', request()->query()) }}" class="lp-btn lp-btn-green"
                        style="font-size:11.5px;padding:6px 12px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('export.pemakaian.pdf', request()->query()) }}" class="lp-btn lp-btn-red"
                        style="font-size:11.5px;padding:6px 12px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        PDF
                    </a>
                @endif
            </div>
        </div>

        @if (!empty($detailList) && $detailList->count() > 0)
            <div style="overflow-x:auto;">
                <table class="lp-tbl">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Nama Varian</th>
                            <th>Obat</th>
                            <th>Jenis</th>
                            <th>Jml. Dipakai</th>
                            <th>Harga Satuan</th>
                            <th>Total Nilai</th>
                            <th>Terakhir Dipakai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailList as $i => $d)
                            <tr>
                                <td class="muted">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:500;font-size:13px;">
                                        {{ $d['nama_merek'] }}
                                        @if ($d['dosis_mg'])
                                            <span style="font-size:10.5px;color:var(--tx-muted);font-weight:400;">
                                                {{ $d['dosis_mg'] }} mg
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="muted">{{ $d['nama_obat'] }}</td>
                                <td class="muted">{{ $d['jenis'] }}</td>
                                <td class="num" style="color:var(--clr-blue);">{{ number_format($d['total_pakai']) }}
                                </td>
                                <td class="muted">Rp {{ number_format($d['harga'], 0, ',', '.') }}</td>
                                <td class="num" style="color:#16a34a;">
                                    Rp {{ number_format($d['total_nilai'], 0, ',', '.') }}
                                </td>
                                <td class="muted">
                                    {{ $d['last_pakai'] ? \Carbon\Carbon::parse($d['last_pakai'])->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="lp-empty">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Tidak ada data pemakaian pada periode ini.
            </div>
        @endif
    </div>

@endsection
