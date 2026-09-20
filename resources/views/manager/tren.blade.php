@extends('layouts.manager')

@section('title', 'Tren Pemakaian')
@section('page_title', 'Tren Pemakaian Obat')
@section('page_subtitle', 'Analisis pola pemakaian obat per periode')

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

        .filter-select {
            font-size: 12px;
            padding: 6px 10px;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            background: var(--color-card-bg);
            color: var(--color-text-main);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
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

        .btn-filter:hover {
            opacity: .85;
        }

        /* ── Summary Strip ── */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .strip-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 14px 16px;
        }

        .strip-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 6px;
        }

        .strip-label i {
            font-size: 13px;
        }

        .strip-val {
            font-size: 24px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
        }

        .strip-trend {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 3px;
            margin-top: 4px;
        }

        .trend-up {
            color: #0F6E56;
        }

        .trend-down {
            color: #A32D2D;
        }

        .trend-flat {
            color: var(--color-text-hint);
        }

        /* ── Main Chart ── */
        .chart-canvas-wrap {
            position: relative;
            width: 100%;
            overflow-x: auto;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            min-height: 200px;
            padding: 0 4px 0;
        }

        .chart-col {
            flex: 1;
            min-width: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            height: 200px;
            justify-content: flex-end;
        }

        .chart-val {
            font-size: 10px;
            font-weight: 600;
            color: var(--color-text-muted);
        }

        .chart-bar {
            width: 100%;
            border-radius: 5px 5px 0 0;
            background: #9FE1CB;
            min-height: 4px;
            transition: height .4s ease;
            cursor: pointer;
            position: relative;
        }

        .chart-bar.active {
            background: var(--color-primary);
        }

        .chart-bar:hover {
            opacity: .8;
        }

        .chart-bar-label {
            font-size: 10px;
            color: var(--color-text-hint);
            white-space: nowrap;
            text-align: center;
        }

        .chart-y-axis {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px;
            margin-right: 8px;
            padding-bottom: 28px;
            flex-shrink: 0;
        }

        .chart-y-axis span {
            font-size: 9px;
            color: var(--color-text-hint);
            text-align: right;
            white-space: nowrap;
        }

        /* ── Two col ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        /* ── Heatmap (per hari dalam bulan) ── */
        .heatmap-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-top: 8px;
        }

        .heatmap-day-label {
            font-size: 9px;
            font-weight: 600;
            color: var(--color-text-hint);
            text-align: center;
            padding: 2px 0;
        }

        .heatmap-cell {
            aspect-ratio: 1;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: var(--color-text-hint);
            cursor: default;
            position: relative;
        }

        .heatmap-cell[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: calc(100% + 4px);
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            color: #fff;
            font-size: 10px;
            padding: 3px 7px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 10;
            pointer-events: none;
        }

        .heat-0 {
            background: var(--color-content-bg);
            border: 1px solid var(--color-border);
        }

        .heat-1 {
            background: #D1F0E5;
        }

        .heat-2 {
            background: #9FE1CB;
        }

        .heat-3 {
            background: #5DCAA5;
        }

        .heat-4 {
            background: #1D9E75;
        }

        .heat-5 {
            background: #0F6E56;
            color: #fff;
        }

        /* ── Top Obat per Minggu ── */
        .weekly-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .weekly-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            background: var(--color-content-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }

        .weekly-rank {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .weekly-name {
            flex: 1;
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .weekly-sub {
            font-size: 10px;
            color: var(--color-text-hint);
        }

        .weekly-bar-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 120px;
        }

        .weekly-bar {
            flex: 1;
            height: 5px;
            background: var(--color-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .weekly-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--color-primary);
        }

        .weekly-num {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-text-main);
            min-width: 24px;
            text-align: right;
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

        /* Pill */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: 32px;
            color: var(--color-text-hint);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 32px;
            display: block;
            margin-bottom: 8px;
        }

        @media (max-width: 1024px) {
            .two-col {
                grid-template-columns: 1fr;
            }

            .summary-strip {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .summary-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('manager.tren') }}">
        <div class="filter-bar">

            <div class="filter-group">
                <span class="filter-label">Tampilkan</span>
                <select name="rentang" class="filter-select">
                    <option value="6" {{ request('rentang', '6') == '6' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                    <option value="12" {{ request('rentang') == '12' ? 'selected' : '' }}>12 Bulan Terakhir</option>
                    <option value="3" {{ request('rentang') == '3' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">Jenis Obat</span>
                <select name="jenis" class="filter-select">
                    <option value="">Semua</option>
                    @foreach ($jenisObat as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                            {{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">Obat Spesifik</span>
                <select name="obat_id" class="filter-select">
                    <option value="">Semua Obat</option>
                    @foreach ($daftarObat as $obat)
                        <option value="{{ $obat->id }}" {{ request('obat_id') == $obat->id ? 'selected' : '' }}>
                            {{ $obat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-filter">
                <i class="ti ti-filter"></i> Terapkan
            </button>

        </div>
    </form>

    {{-- ── SUMMARY STRIP ── --}}
    <div class="summary-strip">
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-chart-bar" style="color:#1D9E75"></i>
                Total Pemakaian Periode
            </div>
            <div class="strip-val">{{ number_format($summary->total) }}</div>
            <div class="strip-trend {{ $summary->trend >= 0 ? 'trend-up' : 'trend-down' }}">
                <i class="ti ti-trending-{{ $summary->trend >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($summary->trend) }}% vs periode sebelumnya
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-calendar" style="color:#185FA5"></i>
                Rata-rata per Bulan
            </div>
            <div class="strip-val">{{ number_format($summary->rata_bulan) }}</div>
            <div class="strip-trend trend-flat">
                <i class="ti ti-minus"></i>
                Unit pemakaian / bulan
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-trophy" style="color:#BA7517"></i>
                Bulan Tertinggi
            </div>
            <div class="strip-val">{{ $summary->bulan_tertinggi }}</div>
            <div class="strip-trend trend-flat">
                <i class="ti ti-pill"></i>
                {{ number_format($summary->nilai_tertinggi) }} unit
            </div>
        </div>
    </div>

    {{-- ── MAIN TREND CHART ── --}}
    <div class="section-label">Grafik tren pemakaian</div>
    <div class="card" style="margin-bottom:18px">
        <div class="card-head">
            <span class="card-title">Pemakaian per Bulan</span>
            <span class="pill pill-info">{{ request('rentang', 6) }} Bulan</span>
        </div>

        @if ($trendBulanan->isEmpty())
            <div class="empty-state">
                <i class="ti ti-chart-bar"></i>
                Belum ada data tren
            </div>
        @else
            @php $maxVal = max($trendBulanan->pluck('total')->toArray() ?: [1]); @endphp
            <div style="display:flex; align-items:flex-end">
                <div class="chart-y-axis">
                    @foreach ([100, 80, 60, 40, 20, 0] as $pct)
                        <span>{{ number_format(($maxVal * $pct) / 100) }}</span>
                    @endforeach
                </div>
                <div class="chart-canvas-wrap" style="flex:1">
                    <div class="chart-bars">
                        @foreach ($trendBulanan as $row)
                            @php
                                $h = $maxVal > 0 ? round(($row->total / $maxVal) * 185) : 4;
                                $isLast = $loop->last;
                            @endphp
                            <div class="chart-col">
                                <div class="chart-val">{{ $row->total }}</div>
                                <div class="chart-bar {{ $isLast ? 'active' : '' }}" style="height:{{ $h }}px"
                                    title="{{ $row->label }}: {{ number_format($row->total) }} unit">
                                </div>
                                <div class="chart-bar-label">{{ $row->label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ── HEATMAP + TOP MINGGUAN ── --}}
    <div class="two-col">

        {{-- Heatmap Aktivitas Harian ── --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Aktivitas Harian — Bulan Ini</span>
                <span class="pill pill-ok">
                    {{ now()->translatedFormat('F Y') }}
                </span>
            </div>
            <div class="heatmap-grid">
                {{-- Header hari ── --}}
                @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $h)
                    <div class="heatmap-day-label">{{ $h }}</div>
                @endforeach

                {{-- Padding hari pertama ── --}}
                @php
                    $firstDay = now()->startOfMonth()->dayOfWeek; // 0=Sun
                    $daysInMonth = now()->daysInMonth;
                    $maxDaily = max($heatmapData->values()->toArray() ?: [1]);
                @endphp
                @for ($p = 0; $p < $firstDay; $p++)
                    <div></div>
                @endfor

                {{-- Sel per hari ── --}}
                @for ($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $val = $heatmapData->get($d, 0);
                        $pct = $maxDaily > 0 ? $val / $maxDaily : 0;
                        $heatLevel = match (true) {
                            $val === 0 => 0,
                            $pct <= 0.2 => 1,
                            $pct <= 0.4 => 2,
                            $pct <= 0.6 => 3,
                            $pct <= 0.8 => 4,
                            default => 5,
                        };
                    @endphp
                    <div class="heatmap-cell heat-{{ $heatLevel }}"
                        title="{{ $d }} {{ now()->translatedFormat('M') }}: {{ $val }} pemakaian">
                        {{ $d }}
                    </div>
                @endfor
            </div>

            {{-- Legend ── --}}
            <div
                style="display:flex; align-items:center; gap:6px; margin-top:12px; font-size:10px; color:var(--color-text-hint)">
                <span>Sedikit</span>
                @foreach ([0, 1, 2, 3, 4, 5] as $l)
                    <div class="heatmap-cell heat-{{ $l }}"
                        style="width:14px;height:14px;font-size:0;aspect-ratio:1"></div>
                @endforeach
                <span>Banyak</span>
            </div>
        </div>

        {{-- Top Obat Minggu Ini ── --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Top Obat — Minggu Ini</span>
                <span class="pill pill-info">7 Hari</span>
            </div>

            @if ($topMingguIni->isEmpty())
                <div class="empty-state" style="padding:20px">
                    <i class="ti ti-inbox"></i>
                    Belum ada pemakaian minggu ini
                </div>
            @else
                @php $maxWeekly = $topMingguIni->first()->total ?? 1; @endphp
                <div class="weekly-list">
                    @foreach ($topMingguIni as $i => $obat)
                        <div class="weekly-item">
                            <div class="weekly-rank">{{ $i + 1 }}</div>
                            <div style="flex:1; min-width:0">
                                <div class="weekly-name">{{ $obat->nama_obat }}</div>
                                <div class="weekly-sub">{{ $obat->jenis }}</div>
                            </div>
                            <div class="weekly-bar-wrap">
                                <div class="weekly-bar">
                                    <div class="weekly-bar-fill" style="width:{{ round(($obat->total / $maxWeekly) * 100) }}%">
                                    </div>
                                </div>
                                <span class="weekly-num">{{ $obat->total }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- ── TABEL DETAIL TREN ── --}}
    <div class="section-label">Detail tren per bulan</div>
    <div class="card" style="padding:0; overflow:hidden">
        @if ($trendBulanan->isEmpty())
            <div class="empty-state" style="padding:32px">
                <i class="ti ti-inbox"></i>
                Tidak ada data tren
            </div>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:12.5px">
                <thead>
                    <tr>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:left;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Bulan</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:right;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Total Pemakaian</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:right;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Perubahan</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:left;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAll = $trendBulanan->sum('total'); @endphp
                    @foreach ($trendBulanan as $i => $row)
                        @php
                            $prev = $i > 0 ? $trendBulanan[$i - 1]->total : null;
                            $change = $prev && $prev > 0 ? round((($row->total - $prev) / $prev) * 100) : null;
                            $propPct = $totalAll > 0 ? round(($row->total / $totalAll) * 100) : 0;
                        @endphp
                        <tr style="border-bottom:1px solid var(--color-border)">
                            <td style="padding:9px 14px; font-weight:600; color:var(--color-text-main)">
                                {{ $row->label }}
                            </td>
                            <td style="padding:9px 14px; text-align:right; font-weight:600; color:var(--color-text-main)">
                                {{ number_format($row->total) }}
                            </td>
                            <td style="padding:9px 14px; text-align:right">
                                @if ($change === null)
                                    <span style="color:var(--color-text-hint); font-size:11px">—</span>
                                @elseif($change >= 0)
                                    <span style="color:#0F6E56; font-size:11px; font-weight:600">
                                        <i class="ti ti-trending-up" style="font-size:11px"></i>
                                        +{{ $change }}%
                                    </span>
                                @else
                                    <span style="color:#A32D2D; font-size:11px; font-weight:600">
                                        <i class="ti ti-trending-down" style="font-size:11px"></i>
                                        {{ $change }}%
                                    </span>
                                @endif
                            </td>
                            <td style="padding:9px 14px">
                                <div style="display:flex; align-items:center; gap:8px">
                                    <div
                                        style="flex:1; height:5px; background:var(--color-border); border-radius:99px; overflow:hidden">
                                        <div
                                            style="height:100%; width:{{ $propPct }}%; background:var(--color-primary); border-radius:99px">
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:11px; font-weight:600; min-width:28px; color:var(--color-text-muted)">{{ $propPct }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @endsection@extends('layouts.manager')

@section('title', 'Tren Pemakaian')
@section('page_title', 'Tren Pemakaian Obat')
@section('page_subtitle', 'Analisis pola pemakaian obat per periode')

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

        .filter-select {
            font-size: 12px;
            padding: 6px 10px;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            background: var(--color-card-bg);
            color: var(--color-text-main);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
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

        .btn-filter:hover {
            opacity: .85;
        }

        /* ── Summary Strip ── */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .strip-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 14px 16px;
        }

        .strip-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 6px;
        }

        .strip-label i {
            font-size: 13px;
        }

        .strip-val {
            font-size: 24px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
        }

        .strip-trend {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 3px;
            margin-top: 4px;
        }

        .trend-up {
            color: #0F6E56;
        }

        .trend-down {
            color: #A32D2D;
        }

        .trend-flat {
            color: var(--color-text-hint);
        }

        /* ── Main Chart ── */
        .chart-canvas-wrap {
            position: relative;
            width: 100%;
            overflow-x: auto;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            min-height: 200px;
            padding: 0 4px 0;
        }

        .chart-col {
            flex: 1;
            min-width: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            height: 200px;
            justify-content: flex-end;
        }

        .chart-val {
            font-size: 10px;
            font-weight: 600;
            color: var(--color-text-muted);
        }

        .chart-bar {
            width: 100%;
            border-radius: 5px 5px 0 0;
            background: #9FE1CB;
            min-height: 4px;
            transition: height .4s ease;
            cursor: pointer;
            position: relative;
        }

        .chart-bar.active {
            background: var(--color-primary);
        }

        .chart-bar:hover {
            opacity: .8;
        }

        .chart-bar-label {
            font-size: 10px;
            color: var(--color-text-hint);
            white-space: nowrap;
            text-align: center;
        }

        .chart-y-axis {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px;
            margin-right: 8px;
            padding-bottom: 28px;
            flex-shrink: 0;
        }

        .chart-y-axis span {
            font-size: 9px;
            color: var(--color-text-hint);
            text-align: right;
            white-space: nowrap;
        }

        /* ── Two col ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        /* ── Heatmap (per hari dalam bulan) ── */
        .heatmap-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-top: 8px;
        }

        .heatmap-day-label {
            font-size: 9px;
            font-weight: 600;
            color: var(--color-text-hint);
            text-align: center;
            padding: 2px 0;
        }

        .heatmap-cell {
            aspect-ratio: 1;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: var(--color-text-hint);
            cursor: default;
            position: relative;
        }

        .heatmap-cell[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: calc(100% + 4px);
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            color: #fff;
            font-size: 10px;
            padding: 3px 7px;
            border-radius: 4px;
            white-space: nowrap;
            z-index: 10;
            pointer-events: none;
        }

        .heat-0 {
            background: var(--color-content-bg);
            border: 1px solid var(--color-border);
        }

        .heat-1 {
            background: #D1F0E5;
        }

        .heat-2 {
            background: #9FE1CB;
        }

        .heat-3 {
            background: #5DCAA5;
        }

        .heat-4 {
            background: #1D9E75;
        }

        .heat-5 {
            background: #0F6E56;
            color: #fff;
        }

        /* ── Top Obat per Minggu ── */
        .weekly-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .weekly-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            background: var(--color-content-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
        }

        .weekly-rank {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .weekly-name {
            flex: 1;
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .weekly-sub {
            font-size: 10px;
            color: var(--color-text-hint);
        }

        .weekly-bar-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 120px;
        }

        .weekly-bar {
            flex: 1;
            height: 5px;
            background: var(--color-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .weekly-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--color-primary);
        }

        .weekly-num {
            font-size: 11px;
            font-weight: 700;
            color: var(--color-text-main);
            min-width: 24px;
            text-align: right;
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

        /* Pill */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: 32px;
            color: var(--color-text-hint);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 32px;
            display: block;
            margin-bottom: 8px;
        }

        @media (max-width: 1024px) {
            .two-col {
                grid-template-columns: 1fr;
            }

            .summary-strip {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .summary-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('manager.tren') }}">
        <div class="filter-bar">

            <div class="filter-group">
                <span class="filter-label">Tampilkan</span>
                <select name="rentang" class="filter-select">
                    <option value="6" {{ request('rentang', '6') == '6' ? 'selected' : '' }}>6 Bulan Terakhir
                    </option>
                    <option value="12" {{ request('rentang') == '12' ? 'selected' : '' }}>12 Bulan Terakhir
                    </option>
                    <option value="3" {{ request('rentang') == '3' ? 'selected' : '' }}>3 Bulan Terakhir
                    </option>
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">Jenis Obat</span>
                <select name="jenis" class="filter-select">
                    <option value="">Semua</option>
                    @foreach ($jenisObat as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                            {{ $j }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">Obat Spesifik</span>
                <select name="obat_id" class="filter-select">
                    <option value="">Semua Obat</option>
                    @foreach ($daftarObat as $obat)
                        <option value="{{ $obat->id }}" {{ request('obat_id') == $obat->id ? 'selected' : '' }}>
                            {{ $obat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-filter">
                <i class="ti ti-filter"></i> Terapkan
            </button>

        </div>
    </form>

    {{-- ── SUMMARY STRIP ── --}}
    <div class="summary-strip">
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-chart-bar" style="color:#1D9E75"></i>
                Total Pemakaian Periode
            </div>
            <div class="strip-val">{{ number_format($summary->total) }}</div>
            <div class="strip-trend {{ $summary->trend >= 0 ? 'trend-up' : 'trend-down' }}">
                <i class="ti ti-trending-{{ $summary->trend >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($summary->trend) }}% vs periode sebelumnya
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-calendar" style="color:#185FA5"></i>
                Rata-rata per Bulan
            </div>
            <div class="strip-val">{{ number_format($summary->rata_bulan) }}</div>
            <div class="strip-trend trend-flat">
                <i class="ti ti-minus"></i>
                Unit pemakaian / bulan
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-label">
                <i class="ti ti-trophy" style="color:#BA7517"></i>
                Bulan Tertinggi
            </div>
            <div class="strip-val">{{ $summary->bulan_tertinggi }}</div>
            <div class="strip-trend trend-flat">
                <i class="ti ti-pill"></i>
                {{ number_format($summary->nilai_tertinggi) }} unit
            </div>
        </div>
    </div>

    {{-- ── MAIN TREND CHART ── --}}
    <div class="section-label">Grafik tren pemakaian</div>
    <div class="card" style="margin-bottom:18px">
        <div class="card-head">
            <span class="card-title">Pemakaian per Bulan</span>
            <span class="pill pill-info">{{ request('rentang', 6) }} Bulan</span>
        </div>

        @if ($trendBulanan->isEmpty())
            <div class="empty-state">
                <i class="ti ti-chart-bar"></i>
                Belum ada data tren
            </div>
        @else
            @php $maxVal = max($trendBulanan->pluck('total')->toArray() ?: [1]); @endphp
            <div style="display:flex; align-items:flex-end">
                <div class="chart-y-axis">
                    @foreach ([100, 80, 60, 40, 20, 0] as $pct)
                        <span>{{ number_format(($maxVal * $pct) / 100) }}</span>
                    @endforeach
                </div>
                <div class="chart-canvas-wrap" style="flex:1">
                    <div class="chart-bars">
                        @foreach ($trendBulanan as $row)
                            @php
                                $h = $maxVal > 0 ? round(($row->total / $maxVal) * 185) : 4;
                                $isLast = $loop->last;
                            @endphp
                            <div class="chart-col">
                                <div class="chart-val">{{ $row->total }}</div>
                                <div class="chart-bar {{ $isLast ? 'active' : '' }}"
                                    style="height:{{ $h }}px"
                                    title="{{ $row->label }}: {{ number_format($row->total) }} unit">
                                </div>
                                <div class="chart-bar-label">{{ $row->label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ── HEATMAP + TOP MINGGUAN ── --}}
    <div class="two-col">

        {{-- Heatmap Aktivitas Harian ── --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Aktivitas Harian — Bulan Ini</span>
                <span class="pill pill-ok">
                    {{ now()->translatedFormat('F Y') }}
                </span>
            </div>
            <div class="heatmap-grid">
                {{-- Header hari ── --}}
                @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $h)
                    <div class="heatmap-day-label">{{ $h }}</div>
                @endforeach

                {{-- Padding hari pertama ── --}}
                @php
                    $firstDay = now()->startOfMonth()->dayOfWeek; // 0=Sun
                    $daysInMonth = now()->daysInMonth;
                    $maxDaily = max($heatmapData->values()->toArray() ?: [1]);
                @endphp
                @for ($p = 0; $p < $firstDay; $p++)
                    <div></div>
                @endfor

                {{-- Sel per hari ── --}}
                @for ($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $val = $heatmapData->get($d, 0);
                        $pct = $maxDaily > 0 ? $val / $maxDaily : 0;
                        $heatLevel = match (true) {
                            $val === 0 => 0,
                            $pct <= 0.2 => 1,
                            $pct <= 0.4 => 2,
                            $pct <= 0.6 => 3,
                            $pct <= 0.8 => 4,
                            default => 5,
                        };
                    @endphp
                    <div class="heatmap-cell heat-{{ $heatLevel }}"
                        title="{{ $d }} {{ now()->translatedFormat('M') }}: {{ $val }} pemakaian">
                        {{ $d }}
                    </div>
                @endfor
            </div>

            {{-- Legend ── --}}
            <div
                style="display:flex; align-items:center; gap:6px; margin-top:12px; font-size:10px; color:var(--color-text-hint)">
                <span>Sedikit</span>
                @foreach ([0, 1, 2, 3, 4, 5] as $l)
                    <div class="heatmap-cell heat-{{ $l }}"
                        style="width:14px;height:14px;font-size:0;aspect-ratio:1"></div>
                @endforeach
                <span>Banyak</span>
            </div>
        </div>

        {{-- Top Obat Minggu Ini ── --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Top Obat — Minggu Ini</span>
                <span class="pill pill-info">7 Hari</span>
            </div>

            @if ($topMingguIni->isEmpty())
                <div class="empty-state" style="padding:20px">
                    <i class="ti ti-inbox"></i>
                    Belum ada pemakaian minggu ini
                </div>
            @else
                @php $maxWeekly = $topMingguIni->first()->total ?? 1; @endphp
                <div class="weekly-list">
                    @foreach ($topMingguIni as $i => $obat)
                        <div class="weekly-item">
                            <div class="weekly-rank">{{ $i + 1 }}</div>
                            <div style="flex:1; min-width:0">
                                <div class="weekly-name">{{ $obat->nama_obat }}</div>
                                <div class="weekly-sub">{{ $obat->jenis }}</div>
                            </div>
                            <div class="weekly-bar-wrap">
                                <div class="weekly-bar">
                                    <div class="weekly-bar-fill"
                                        style="width:{{ round(($obat->total / $maxWeekly) * 100) }}%"></div>
                                </div>
                                <span class="weekly-num">{{ $obat->total }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- ── TABEL DETAIL TREN ── --}}
    <div class="section-label">Detail tren per bulan</div>
    <div class="card" style="padding:0; overflow:hidden">
        @if ($trendBulanan->isEmpty())
            <div class="empty-state" style="padding:32px">
                <i class="ti ti-inbox"></i>
                Tidak ada data tren
            </div>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:12.5px">
                <thead>
                    <tr>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:left;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Bulan</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:right;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Total Pemakaian</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:right;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Perubahan</th>
                        <th
                            style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;color:var(--color-text-hint);text-align:left;padding:7px 14px;border-bottom:1px solid var(--color-border)">
                            Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalAll = $trendBulanan->sum('total'); @endphp
                    @foreach ($trendBulanan as $i => $row)
                        @php
                            $prev = $i > 0 ? $trendBulanan[$i - 1]->total : null;
                            $change = $prev && $prev > 0 ? round((($row->total - $prev) / $prev) * 100) : null;
                            $propPct = $totalAll > 0 ? round(($row->total / $totalAll) * 100) : 0;
                        @endphp
                        <tr style="border-bottom:1px solid var(--color-border)">
                            <td style="padding:9px 14px; font-weight:600; color:var(--color-text-main)">
                                {{ $row->label }}
                            </td>
                            <td style="padding:9px 14px; text-align:right; font-weight:600; color:var(--color-text-main)">
                                {{ number_format($row->total) }}
                            </td>
                            <td style="padding:9px 14px; text-align:right">
                                @if ($change === null)
                                    <span style="color:var(--color-text-hint); font-size:11px">—</span>
                                @elseif($change >= 0)
                                    <span style="color:#0F6E56; font-size:11px; font-weight:600">
                                        <i class="ti ti-trending-up" style="font-size:11px"></i>
                                        +{{ $change }}%
                                    </span>
                                @else
                                    <span style="color:#A32D2D; font-size:11px; font-weight:600">
                                        <i class="ti ti-trending-down" style="font-size:11px"></i>
                                        {{ $change }}%
                                    </span>
                                @endif
                            </td>
                            <td style="padding:9px 14px">
                                <div style="display:flex; align-items:center; gap:8px">
                                    <div
                                        style="flex:1; height:5px; background:var(--color-border); border-radius:99px; overflow:hidden">
                                        <div
                                            style="height:100%; width:{{ $propPct }}%; background:var(--color-primary); border-radius:99px">
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:11px; font-weight:600; min-width:28px; color:var(--color-text-muted)">{{ $propPct }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
