@extends('layouts.manager')

@section('title', 'Dashboard Manajer')
@section('page_title', 'Selamat datang, ' . auth()->user()->name . ' 👋')
@section('page_subtitle', 'Ringkasan operasional farmasi hari ini')

@push('styles')
    <style>
        /* ── KPI Grid ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .kpi-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 14px 16px;
            border-left: 3px solid var(--color-primary);
            position: relative;
            overflow: hidden;
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            top: -18px;
            right: -18px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            opacity: .06;
            background: currentColor;
        }

        .kpi-card.green {
            border-left-color: #1D9E75;
        }

        .kpi-card.blue {
            border-left-color: #185FA5;
        }

        .kpi-card.red {
            border-left-color: #E24B4A;
        }

        .kpi-card.amber {
            border-left-color: #BA7517;
        }

        .kpi-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: .4px;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 6px;
        }

        .kpi-label i {
            font-size: 13px;
        }

        .kpi-value {
            font-size: 26px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
            margin-bottom: 5px;
        }

        .kpi-trend {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .kpi-trend.up {
            color: #0F6E56;
        }

        .kpi-trend.down {
            color: #A32D2D;
        }

        .kpi-trend.warn {
            color: #854F0B;
        }

        .kpi-trend i {
            font-size: 12px;
        }

        /* ── Two-column layout ── */
        .two-col {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        /* ── Chart ── */
        .chart-wrap {
            position: relative;
            height: 140px;
            display: flex;
            align-items: flex-end;
            gap: 6px;
            padding: 0 4px;
            overflow: hidden;
        }

        .bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            height: 100%;
            justify-content: flex-end;
            min-width: 0;
        }

        .bar-fill {
            width: 100%;
            border-radius: 4px 4px 0 0;
            background: var(--color-primary);
            transition: height .4s ease;
            min-height: 4px;
            flex-shrink: 0;
        }

        .bar-fill.highlight {
            background: var(--color-primary-dark);
        }

        .bar-month {
            font-size: 10px;
            color: var(--color-text-hint);
            white-space: nowrap;
        }

        .bar-val {
            font-size: 9px;
            font-weight: 600;
            color: var(--color-text-muted);
            margin-bottom: 2px;
        }

        .chart-y-labels {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 140px;
            margin-right: 6px;
            padding-bottom: 22px;
            flex-shrink: 0;
        }

        .chart-y-labels span {
            font-size: 9px;
            color: var(--color-text-hint);
            text-align: right;
        }

        /* ── Approval List ── */
        .approval-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .approval-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: var(--color-content-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            transition: border-color .15s;
        }

        .approval-item:hover {
            border-color: var(--color-border-strong);
        }

        .appr-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .appr-icon.warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .appr-icon.info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .appr-icon.danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

        .appr-body {
            flex: 1;
            min-width: 0;
        }

        .appr-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .appr-sub {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 1px;
        }

        .appr-actions {
            display: flex;
            gap: 5px;
            flex-shrink: 0;
        }

        .btn-approve,
        .btn-reject {
            font-size: 10px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            border: 1px solid;
            cursor: pointer;
            transition: opacity .15s;
        }

        .btn-approve {
            background: var(--color-success-bg);
            color: var(--color-success-text);
            border-color: #5DCAA5;
        }

        .btn-reject {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
            border-color: #F09595;
        }

        .btn-approve:hover,
        .btn-reject:hover {
            opacity: .75;
        }

        /* ── Mini Stats Row ── */
        .mini-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .mini-stat {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mini-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .mini-val {
            font-size: 18px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .mini-lbl {
            font-size: 11px;
            color: var(--color-text-muted);
        }

        /* ── Usage Table ── */
        .usage-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .usage-table thead th {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            text-align: left;
            padding: 6px 10px;
            border-bottom: 1px solid var(--color-border);
        }

        .usage-table tbody td {
            padding: 9px 10px;
            color: var(--color-text-muted);
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
        }

        .usage-table tbody tr:last-child td {
            border-bottom: none;
        }

        .usage-table tbody tr:hover td {
            background: var(--color-content-bg);
        }

        .drug-name {
            font-weight: 600;
            color: var(--color-text-main);
        }

        /* Stok bar */
        .stok-bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stok-bar {
            flex: 1;
            height: 5px;
            background: var(--color-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .stok-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--color-primary);
        }

        .stok-bar-fill.warn {
            background: #BA7517;
        }

        .stok-bar-fill.danger {
            background: #E24B4A;
        }

        .stok-num {
            font-size: 11px;
            font-weight: 600;
            min-width: 28px;
            text-align: right;
        }

        /* Section divider */
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

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 24px;
            color: var(--color-text-hint);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 28px;
            display: block;
            margin-bottom: 6px;
        }

        @media (max-width: 1100px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .two-col {
                grid-template-columns: 1fr;
            }

            .mini-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .kpi-grid {
                grid-template-columns: 1fr 1fr;
            }

            .mini-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── KPI CARDS ── --}}
    <div class="section-label">Ringkasan hari ini</div>
    <div class="kpi-grid">

        <div class="kpi-card green">
            <div class="kpi-label">
                <i class="ti ti-pill"></i> Total Stok Aktif
            </div>
            <div class="kpi-value">{{ $totalStok }}</div>
            <div class="kpi-trend up">
                <i class="ti ti-trending-up"></i>
                {{ $stokTrend }}% vs bulan lalu
            </div>
        </div>

        <div class="kpi-card blue">
            <div class="kpi-label">
                <i class="ti ti-chart-line"></i> Pemakaian Bulan Ini
            </div>
            <div class="kpi-value">{{ $pemakaianBulanIni }}</div>
            <div class="kpi-trend {{ $pemakaianTrend >= 0 ? 'up' : 'down' }}">
                <i class="ti ti-trending-{{ $pemakaianTrend >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($pemakaianTrend) }}% dari target
            </div>
        </div>

        <div class="kpi-card red">
            <div class="kpi-label">
                <i class="ti ti-clipboard-check"></i> Perlu Persetujuan
            </div>
            <div class="kpi-value" style="color:#A32D2D">{{ $pendingApproval }}</div>
            <div class="kpi-trend warn">
                <i class="ti ti-clock"></i>
                Permintaan pending
            </div>
        </div>

        <div class="kpi-card amber">
            <div class="kpi-label">
                <i class="ti ti-percentage"></i> Efisiensi Stok
            </div>
            <div class="kpi-value" style="color:#BA7517">{{ $efisiensiStok }}%</div>
            <div class="kpi-trend {{ $efisiensiTrend >= 0 ? 'up' : 'down' }}">
                <i class="ti ti-trending-{{ $efisiensiTrend >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($efisiensiTrend) }}% dari minggu lalu
            </div>
        </div>

    </div>

    {{-- ── MINI STATS ── --}}
    <div class="mini-row" style="grid-template-columns:repeat(4,1fr)">
        <div class="mini-stat">
            <div class="mini-icon" style="background:var(--color-success-bg);color:var(--color-success-text)">
                <i class="ti ti-users"></i>
            </div>
            <div>
                <div class="mini-val">{{ $staffAktif }}</div>
                <div class="mini-lbl">Staff Aktif Hari Ini</div>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-icon" style="background:var(--color-warning-bg);color:var(--color-warning-text)">
                <i class="ti ti-receipt"></i>
            </div>
            <div>
                <div class="mini-val">{{ $transaksiHariIni }}</div>
                <div class="mini-lbl">Transaksi Hari Ini</div>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-icon" style="background:var(--color-info-bg);color:var(--color-info-text)">
                <i class="ti ti-calendar-x"></i>
            </div>
            <div>
                <div class="mini-val">{{ $batchMendekatiExp }}</div>
                <div class="mini-lbl">Batch Mendekati Exp</div>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-icon" style="background:var(--color-primary-light);color:var(--color-primary-dark)">
                <i class="ti ti-truck-delivery"></i>
            </div>
            <div>
                <div class="mini-val">{{ $pengirimanBulanIni }}</div>
                <div class="mini-lbl">Pengiriman Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- ── CHART + APPROVAL ── --}}
    <div class="two-col" style="margin-bottom:18px">

        {{-- Tren Chart --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Tren Pemakaian Obat (6 Bulan)</span>
                <span class="pill pill-info">Live</span>
            </div>
            @php
                $maxVal = max(array_merge($trendValues ?? [0], [1]));
                $steps = [100, 75, 50, 25, 0];
            @endphp
            <div style="display:flex;align-items:flex-end">
                <div class="chart-y-labels">
                    @foreach ($steps as $step)
                        <span>{{ round(($maxVal * $step) / 100) }}</span>
                    @endforeach
                </div>
                <div class="chart-wrap" style="flex:1">
                    @foreach ($trendLabels as $i => $label)
                        @php
                            $val = $trendValues[$i] ?? 0;
                            $pct = $maxVal > 0 ? round(($val / $maxVal) * 140) : 4;
                            $isLast = $i === array_key_last($trendLabels);
                        @endphp
                        <div class="bar-col">
                            <div class="bar-val">{{ $val }}</div>
                            <div class="bar-fill {{ $isLast ? 'highlight' : '' }}" style="height:{{ max($pct, 4) }}px">
                            </div>
                            <div class="bar-month">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div style="margin-top:12px; text-align:right">
                <a href="{{ route('manager.tren') }}"
                    style="font-size:11px; color:var(--color-primary-dark); text-decoration:none; font-weight:600">
                    Lihat analisis lengkap <i class="ti ti-arrow-right" style="font-size:11px"></i>
                </a>
            </div>
        </div>

        {{-- Approval --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">Persetujuan Masuk</span>
                @if ($pendingApproval > 0)
                    <span class="pill pill-warn">{{ $pendingApproval }} Pending</span>
                @else
                    <span class="pill pill-ok">Semua selesai</span>
                @endif
            </div>

            @if ($approvalRequests->isEmpty())
                <div class="empty-state">
                    <i class="ti ti-circle-check" style="color:#1D9E75"></i>
                    Tidak ada permintaan pending
                </div>
            @else
                <div class="approval-list">
                    @foreach ($approvalRequests->take(4) as $req)
                        <div class="approval-item">
                            <div class="appr-icon {{ $req->icon_type }}">
                                <i class="ti ti-{{ $req->icon }}"></i>
                            </div>
                            <div class="appr-body">
                                <div class="appr-title">{{ $req->judul }}</div>
                                <div class="appr-sub">{{ $req->deskripsi }}</div>
                            </div>
                            <div class="appr-actions">
                                <form method="POST" action="{{ route('approval-requests.approve', $req->id) }}"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-approve">Setuju</button>
                                </form>
                                <form method="POST"action="{{ route('approval-requests.reject', $req->id) }}"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-reject">Tolak</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    @if ($approvalRequests->count() > 4)
                        <a href="{{ route('manager.persetujuan') }}"
                            style="font-size:11px; color:var(--color-primary-dark); text-decoration:none; font-weight:600; text-align:center; display:block; padding-top:4px">
                            Lihat {{ $approvalRequests->count() - 4 }} lainnya →
                        </a>
                    @endif
                </div>
            @endif
        </div>

    </div>

    {{-- ── USAGE TABLE ── --}}
    <div class="section-label">Ringkasan pemakaian terakhir</div>
    <div class="card">
        <div class="card-head">
            <span class="card-title">Detail Pemakaian Obat</span>
            <a href="{{ route('manager.laporan') }}"
                style="font-size:11px; color:var(--color-primary-dark); text-decoration:none; font-weight:600">
                Lihat semua <i class="ti ti-arrow-right" style="font-size:11px"></i>
            </a>
        </div>

        @if ($pemakaianTerakhir->isEmpty())
            <div class="empty-state">
                <i class="ti ti-inbox"></i>
                Belum ada data pemakaian hari ini
            </div>
        @else
            <table class="usage-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th style="text-align:center">QTY Terpakai</th>
                        <th style="width:180px">Sisa Stok</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemakaianTerakhir as $item)
                        @php
                            $pct = $item->stok_maks > 0 ? round(($item->stok_sisa / $item->stok_maks) * 100) : 0;
                            $barClass = $pct >= 50 ? '' : ($pct >= 25 ? 'warn' : 'danger');
                            $statusClass = match (true) {
                                $pct >= 50 => 'pill-ok',
                                $pct >= 25 => 'pill-warn',
                                default => 'pill-danger',
                            };
                            $statusLabel = match (true) {
                                $pct >= 50 => 'Aman',
                                $pct >= 25 => 'Perhatian',
                                default => 'Stok Rendah',
                            };
                        @endphp
                        <tr>
                            <td><span class="drug-name">{{ $item->nama_obat }}</span></td>
                            <td>{{ $item->jenis }}</td>
                            <td style="text-align:center; font-weight:600">{{ $item->qty }}</td>
                            <td>
                                <div class="stok-bar-wrap">
                                    <div class="stok-bar">
                                        <div class="stok-bar-fill {{ $barClass }}"
                                            style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="stok-num">{{ $item->stok_sisa }}</span>
                                </div>
                            </td>
                            <td><span class="pill {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td style="font-size:11px">
                                {{ \Carbon\Carbon::parse($item->waktu)->format('d/m/Y') }}
                                <div style="font-size:10px;color:var(--color-text-hint)">
                                    {{ \Carbon\Carbon::parse($item->created)->format('H:i') }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
