@extends('layouts.manager')

@section('title', 'Laporan Kinerja')
@section('page_title', 'Laporan Kinerja')
@section('page_subtitle', 'Analisis performa pemakaian dan stok obat')

@push('styles')
<style>
    /* ── Filter Bar ── */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .filter-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--color-text-muted);
        white-space: nowrap;
    }
    .filter-select, .filter-input {
        font-size: 12px;
        padding: 6px 10px;
        border: 1px solid var(--color-border-strong);
        border-radius: var(--radius-md);
        background: var(--color-card-bg);
        color: var(--color-text-main);
        outline: none;
        cursor: pointer;
    }
    .filter-select:focus, .filter-input:focus {
        border-color: var(--color-primary);
    }
    .btn-filter {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-primary);
        background: var(--color-primary);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: opacity .15s;
    }
    .btn-filter:hover { opacity: .85; }
    .btn-export {
        margin-left: auto;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border-strong);
        background: var(--color-card-bg);
        color: var(--color-text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: background .15s;
    }
    .btn-export:hover { background: var(--color-content-bg); }

    /* ── Summary KPI ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }
    .summary-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 14px 16px;
    }
    .summary-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--color-text-hint);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .summary-label i { font-size: 13px; }
    .summary-value {
        font-size: 24px;
        font-weight: 600;
        color: var(--color-text-main);
        line-height: 1;
        margin-bottom: 4px;
    }
    .summary-compare {
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .trend-up   { color: #0F6E56; }
    .trend-down { color: #A32D2D; }
    .trend-flat { color: var(--color-text-hint); }

    /* ── Two-col layout ── */
    .two-col {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 14px;
        margin-bottom: 18px;
    }

    /* ── Bar Chart ── */
    .chart-container {
        position: relative;
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 180px;
        padding: 0 4px;
    }
    .chart-y {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 160px;
        margin-right: 6px;
        padding-bottom: 22px;
    }
    .chart-y span {
        font-size: 9px;
        color: var(--color-text-hint);
        text-align: right;
        white-space: nowrap;
    }
    .bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        height: 100%;
    }
    .bar-val {
        font-size: 9px;
        font-weight: 600;
        color: var(--color-text-muted);
    }
    .bar-fill {
        width: 100%;
        border-radius: 4px 4px 0 0;
        background: var(--color-primary);
        min-height: 4px;
        transition: height .4s ease;
    }
    .bar-fill.secondary { background: #9FE1CB; }
    .bar-month {
        font-size: 10px;
        color: var(--color-text-hint);
        white-space: nowrap;
    }

    /* ── Donut Chart (CSS) ── */
    .donut-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 8px 0;
    }
    .donut {
        width: 100px; height: 100px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .donut-legend {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--color-text-muted);
    }
    .legend-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .legend-pct {
        margin-left: auto;
        font-size: 11px;
        font-weight: 600;
        color: var(--color-text-main);
    }

    /* ── Top Obat Table ── */
    .rank-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }
    .rank-table thead th {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--color-text-hint);
        text-align: left;
        padding: 6px 10px;
        border-bottom: 1px solid var(--color-border);
    }
    .rank-table tbody td {
        padding: 9px 10px;
        color: var(--color-text-muted);
        border-bottom: 1px solid var(--color-border);
        vertical-align: middle;
    }
    .rank-table tbody tr:last-child td { border-bottom: none; }
    .rank-table tbody tr:hover td { background: var(--color-content-bg); }

    .rank-no {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }
    .rank-no.gold   { background: #FAEEDA; color: #633806; }
    .rank-no.silver { background: #F1EFE8; color: #444441; }
    .rank-no.bronze { background: #FAECE7; color: #4A1B0C; }
    .rank-no.other  { background: var(--color-content-bg); color: var(--color-text-muted); }

    .drug-name  { font-weight: 600; color: var(--color-text-main); }
    .usage-bar-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .usage-bar {
        flex: 1;
        height: 6px;
        background: var(--color-border);
        border-radius: 99px;
        overflow: hidden;
    }
    .usage-bar-fill {
        height: 100%;
        border-radius: 99px;
        background: var(--color-primary);
    }
    .usage-num {
        font-size: 11px;
        font-weight: 600;
        min-width: 32px;
        text-align: right;
        color: var(--color-text-main);
    }

    /* Section label */
    .section-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--color-border);
    }

    /* Empty */
    .empty-state {
        text-align: center;
        padding: 32px;
        color: var(--color-text-hint);
        font-size: 12px;
    }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 8px; }

    @media (max-width: 1100px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
        .two-col      { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .summary-grid { grid-template-columns: 1fr 1fr; }
        .filter-bar   { flex-direction: column; align-items: flex-start; }
        .btn-export   { margin-left: 0; }
    }
</style>
@endpush

@section('content')

{{-- ── FILTER BAR ── --}}
<form method="GET" action="{{ route('manager.laporan') }}">
    <div class="filter-bar">

        <div class="filter-group">
            <span class="filter-label">Periode</span>
            <select name="bulan" class="filter-select">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $filterBulan == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
            <select name="tahun" class="filter-select">
                @foreach(range(now()->year, now()->year - 3) as $y)
                    <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <span class="filter-label">Jenis Obat</span>
            <select name="jenis" class="filter-select">
                <option value="">Semua</option>
                @foreach($jenisObat as $j)
                    <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-filter">
            <i class="ti ti-filter"></i> Terapkan
        </button>

        <a href="{{ route('manager.laporan.export', request()->query()) }}"
           class="btn-export">
            <i class="ti ti-download"></i> Export Excel
        </a>

    </div>
</form>

{{-- ── SUMMARY KPI ── --}}
<div class="summary-grid">
    <div class="summary-card">
        <div class="summary-label">
            <i class="ti ti-activity" style="color:#1D9E75"></i> Total Pemakaian
        </div>
        <div class="summary-value">{{ number_format($summary->total_pemakaian) }}</div>
        <div class="summary-compare {{ $summary->pemakaian_trend >= 0 ? 'trend-up' : 'trend-down' }}">
            <i class="ti ti-trending-{{ $summary->pemakaian_trend >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($summary->pemakaian_trend) }}% vs bulan lalu
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-label">
            <i class="ti ti-pill" style="color:#185FA5"></i> Variasi Obat Aktif
        </div>
        <div class="summary-value">{{ $summary->variasi_obat }}</div>
        <div class="summary-compare trend-flat">
            <i class="ti ti-minus"></i> Jenis berbeda dipakai
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-label">
            <i class="ti ti-percentage" style="color:#BA7517"></i> Efisiensi Stok
        </div>
        <div class="summary-value">{{ $summary->efisiensi }}%</div>
        <div class="summary-compare {{ $summary->efisiensi_trend >= 0 ? 'trend-up' : 'trend-down' }}">
            <i class="ti ti-trending-{{ $summary->efisiensi_trend >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($summary->efisiensi_trend) }}% vs bulan lalu
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-label">
            <i class="ti ti-alert-triangle" style="color:#E24B4A"></i> Stok Kritis
        </div>
        <div class="summary-value" style="{{ $summary->stok_kritis > 0 ? 'color:#A32D2D' : '' }}">
            {{ $summary->stok_kritis }}
        </div>
        <div class="summary-compare trend-flat">
            <i class="ti ti-pill"></i> Jenis obat stok rendah
        </div>
    </div>
</div>

{{-- ── CHART + DISTRIBUSI ── --}}
<div class="two-col">

    {{-- Bar Chart Tren ── --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Tren Pemakaian Bulanan</span>
            <span class="pill pill-info">{{ $filterTahun }}</span>
        </div>
        <div style="display:flex; align-items:flex-end">
            <div class="chart-y">
                @php $maxVal = max($trendBulanan->pluck('total')->toArray() ?: [1]); @endphp
                @foreach([100, 75, 50, 25, 0] as $pct)
                    <span>{{ number_format($maxVal * $pct / 100) }}</span>
                @endforeach
            </div>
            <div class="chart-container" style="flex:1">
                @foreach($trendBulanan as $row)
                    @php $h = $maxVal > 0 ? round(($row->total / $maxVal) * 160) : 4; @endphp
                    <div class="bar-col">
                        <div class="bar-val">{{ $row->total }}</div>
                        <div class="bar-fill {{ $row->bulan == $filterBulan ? '' : 'secondary' }}"
                             style="height:{{ $h }}px"></div>
                        <div class="bar-month">
                            {{ \Carbon\Carbon::create()->month($row->bulan)->format('M') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Distribusi Jenis ── --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Distribusi Jenis Obat</span>
        </div>
        @php
            $colors   = ['#1D9E75','#185FA5','#BA7517','#E24B4A','#9ca3af'];
            $totalPct = $distribusiJenis->sum('total');
        @endphp
        @if($distribusiJenis->isEmpty())
            <div class="empty-state">
                <i class="ti ti-chart-pie"></i>
                Tidak ada data periode ini
            </div>
        @else
            @php
                $segments = '';
                $offset   = 0;
                foreach ($distribusiJenis as $idx => $item) {
                    $pct      = $totalPct > 0 ? round(($item->total / $totalPct) * 100) : 0;
                    $color    = $colors[$idx % count($colors)];
                    $segments .= "{$color} {$offset}% " . ($offset + $pct) . "%, ";
                    $offset  += $pct;
                }
                $segments = rtrim($segments, ', ');
            @endphp
            <div class="donut-wrap">
                <div class="donut" style="background: conic-gradient({{ $segments }})"></div>
                <div class="donut-legend">
                    @foreach($distribusiJenis as $idx => $item)
                        @php $pct = $totalPct > 0 ? round(($item->total / $totalPct) * 100) : 0; @endphp
                        <div class="legend-item">
                            <div class="legend-dot"
                                 style="background:{{ $colors[$idx % count($colors)] }}"></div>
                            {{ $item->jenis }}
                            <span class="legend-pct">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>

{{-- ── TOP 10 OBAT TERBANYAK ── --}}
<div class="section-label">Top 10 obat paling banyak dipakai</div>
<div class="card">
    @if($topObat->isEmpty())
        <div class="empty-state">
            <i class="ti ti-inbox"></i>
            Belum ada data pemakaian periode ini
        </div>
    @else
        @php $maxUsage = $topObat->first()->total ?? 1; @endphp
        <table class="rank-table">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th style="width:200px">Pemakaian</th>
                    <th style="text-align:right">Total Unit</th>
                    <th style="text-align:center">Status Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topObat as $i => $obat)
                    @php
                        $rankClass = match($i) { 0 => 'gold', 1 => 'silver', 2 => 'bronze', default => 'other' };
                        $barPct    = round(($obat->total / $maxUsage) * 100);
                        $stokPct   = $obat->stok_maks > 0 ? round(($obat->stok_sisa / $obat->stok_maks) * 100) : 0;
                        $statusClass = match(true) {
                            $stokPct >= 50  => 'pill-ok',
                            $stokPct >= 25  => 'pill-warn',
                            default         => 'pill-danger',
                        };
                        $statusLabel = match(true) {
                            $stokPct >= 50  => 'Aman',
                            $stokPct >= 25  => 'Perhatian',
                            default         => 'Kritis',
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="rank-no {{ $rankClass }}">{{ $i + 1 }}</div>
                        </td>
                        <td>
                            <span class="drug-name">{{ $obat->nama_obat }}</span>
                            <div style="font-size:10px;color:var(--color-text-hint)">{{ $obat->dosis }}</div>
                        </td>
                        <td>{{ $obat->jenis }}</td>
                        <td>
                            <div class="usage-bar-wrap">
                                <div class="usage-bar">
                                    <div class="usage-bar-fill" style="width:{{ $barPct }}%"></div>
                                </div>
                                <span class="usage-num">{{ $obat->total }}</span>
                            </div>
                        </td>
                        <td style="text-align:right; font-weight:600">
                            {{ number_format($obat->total) }}
                        </td>
                        <td style="text-align:center">
                            <span class="pill {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
