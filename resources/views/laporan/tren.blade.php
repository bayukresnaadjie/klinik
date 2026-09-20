@extends('layouts.app')

@section('title', 'Tren Pemakaian Bulanan')
@section('page-title', 'Tren Pemakaian')

@push('styles')
    <style>
        /* ── Page Header ── */
        .tr-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--tx-muted);
            text-decoration: none;
            margin-bottom: 6px;
            transition: color .15s;
        }

        .tr-back:hover {
            color: var(--clr-blue);
        }

        .tr-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tr-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .tr-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ── Filter Bar ── */
        .tr-filter-bar {
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

        .tr-filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-muted);
            white-space: nowrap;
        }

        .tr-select {
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
            min-width: 100px;
        }

        .tr-select:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        .tr-btn {
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

        .tr-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .tr-btn-primary:hover {
            opacity: .88;
        }

        /* ── Stat Cards ── */
        .tr-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .tr-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .tr-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .tr-stat:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .tr-stat-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--tx-muted);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .tr-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1;
        }

        .tr-stat-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 5px;
        }

        .tr-stat-icon {
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

        .tr-stat-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .tr-stat-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .tr-stat-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .tr-stat-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .tr-stat-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .tr-stat-accent.blue {
            background: var(--clr-blue);
        }

        .tr-stat-accent.green {
            background: #16a34a;
        }

        .tr-stat-accent.yellow {
            background: #d97706;
        }

        .tr-stat-accent.purple {
            background: var(--clr-purple);
        }

        /* ── Panel ── */
        .tr-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .tr-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tr-panel-left {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .tr-panel-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tr-panel-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .tr-panel-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .tr-panel-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .tr-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .tr-panel-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .tr-panel-body {
            padding: 18px;
        }

        /* ── Chart Container ── */
        .tr-chart-wrap {
            position: relative;
            height: 260px;
        }

        /* ── Grid 2 col ── */
        .tr-grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        @media (max-width: 900px) {
            .tr-grid2 {
                grid-template-columns: 1fr;
            }
        }

        /* ── Monthly Table ── */
        .tr-monthly-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .tr-monthly-table thead tr {
            background: #F9FAFB;
        }

        .tr-monthly-table th {
            padding: 9px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
        }

        .tr-monthly-table td {
            padding: 9px 14px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .tr-monthly-table tr:last-child td {
            border-bottom: none;
        }

        .tr-monthly-table tbody tr:hover {
            background: #FAFAFA;
        }

        .tr-monthly-table .num {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        .tr-monthly-table .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        /* Month bar inline */
        .tr-bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tr-bar-track {
            flex: 1;
            height: 5px;
            background: var(--page-bg);
            border-radius: 99px;
            overflow: hidden;
        }

        .tr-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--clr-blue);
        }

        /* Top obat rank */
        .tr-rank-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tr-rank-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tr-rank-no {
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

        .tr-rank-no.gold {
            background: #FEF3C7;
            color: #B45309;
            border-color: #FDE68A;
        }

        .tr-rank-no.silver {
            background: #F3F4F6;
            color: #374151;
            border-color: #E5E7EB;
        }

        .tr-rank-no.bronze {
            background: #FFF7ED;
            color: #C2410C;
            border-color: #FED7AA;
        }

        .tr-rank-name {
            flex: 1;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--tx-base);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tr-rank-sub {
            font-size: 11px;
            color: var(--tx-muted);
        }

        .tr-rank-val {
            font-size: 12px;
            font-weight: 700;
            color: var(--clr-blue);
            white-space: nowrap;
        }

        .tr-empty {
            text-align: center;
            padding: 36px;
            color: var(--tx-sub);
            font-size: 12.5px;
        }

        .tr-empty svg {
            display: block;
            margin: 0 auto 10px;
            opacity: .3;
        }

        /* Legend dot */
        .tr-legend {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .tr-legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--tx-muted);
        }

        .tr-legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            var dataPakai = {!! json_encode($chartPakai ?? array_fill(0, 12, 0), JSON_HEX_TAG) !!};
            var dataNilai = {!! json_encode($chartNilai ?? array_fill(0, 12, 0), JSON_HEX_TAG) !!};

            // ── Chart Tren ──
            var ctxTren = document.getElementById('chartTren');
            if (ctxTren) {
                new Chart(ctxTren, {
                    type: 'line',
                    data: {
                        labels: bulanLabels,
                        datasets: [{
                                label: 'Jumlah Pakai',
                                data: dataPakai,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59,130,246,0.08)',
                                borderWidth: 2.5,
                                pointBackgroundColor: '#3B82F6',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4,
                                fill: true,
                                yAxisID: 'y',
                            },
                            {
                                label: 'Nilai (Rp)',
                                data: dataNilai,
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245,158,11,0.06)',
                                borderWidth: 2,
                                pointBackgroundColor: '#F59E0B',
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                tension: 0.4,
                                fill: false,
                                borderDash: [5, 4],
                                yAxisID: 'y1',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                titleColor: '#111827',
                                bodyColor: '#6B7280',
                                padding: 10,
                                callbacks: {
                                    label: function(ctx) {
                                        if (ctx.datasetIndex === 1) {
                                            return ' Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                        }
                                        return ' ' + ctx.parsed.y.toLocaleString('id-ID') + ' unit';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#9CA3AF'
                                }
                            },
                            y: {
                                position: 'left',
                                grid: {
                                    color: '#F3F4F6'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#9CA3AF',
                                    callback: v => v.toLocaleString('id-ID')
                                }
                            },
                            y1: {
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#F59E0B',
                                    callback: v => 'Rp ' + (v >= 1000000 ? (v / 1000000).toFixed(1) + 'jt' :
                                        v.toLocaleString('id-ID'))
                                }
                            }
                        }
                    }
                });
            }

            // ── Chart Top Obat Donut ──
            var ctxDonut = document.getElementById('chartDonut');
            var topNama = {!! json_encode(
                collect($topObat ?? [])->pluck('nama')->values()->toArray(),
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT,
            ) !!};
            var topVal = {!! json_encode(
                collect($topObat ?? [])->pluck('total_pakai')->values()->toArray(),
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT,
            ) !!};
            var palette = ['#3B82F6', '#F59E0B', '#22C55E', '#8B5CF6', '#EF4444', '#06B6D4', '#EC4899'];

            if (ctxDonut && topVal.length > 0) {
                new Chart(ctxDonut, {
                    type: 'doughnut',
                    data: {
                        labels: topNama,
                        datasets: [{
                            data: topVal,
                            backgroundColor: palette,
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#6B7280',
                                    padding: 12,
                                    boxWidth: 10,
                                    boxHeight: 10
                                }
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                titleColor: '#111827',
                                bodyColor: '#6B7280',
                                padding: 10,
                                callbacks: {
                                    label: ctx => ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString(
                                        'id-ID') + ' unit'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="tr-page-header">
        <div>
            <a href="{{ route('laporan.index') }}" class="tr-back">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali ke Semua Laporan
            </a>
            <div class="tr-page-title">Tren Pemakaian Bulanan</div>
            <div class="tr-page-sub">Grafik perubahan dan nilai obat per bulan</div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('laporan.tren') }}">
        <div class="tr-filter-bar">
            <span class="tr-filter-label">Tahun</span>
            <select name="tahun" class="tr-select">
                @foreach (range(now()->year, now()->year - 4) as $y)
                    <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="tr-btn tr-btn-primary">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" x2="16.65" y1="21" y2="16.65" />
                </svg>
                Tampilkan
            </button>
        </div>
    </form>

    {{-- Stat Cards --}}
    <div class="tr-stats">
        <div class="tr-stat">
            <div class="tr-stat-icon blue">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="tr-stat-label">Total Pemakaian {{ request('tahun', now()->year) }}</div>
            <div class="tr-stat-value" style="color:var(--clr-blue);">{{ number_format($totalPakai ?? 0) }}</div>
            <div class="tr-stat-sub">unit obat</div>
            <div class="tr-stat-accent blue"></div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon green">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="12" x2="12" y1="2" y2="22" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="tr-stat-label">Total Nilai {{ request('tahun', now()->year) }}</div>
            <div class="tr-stat-value" style="color:#16a34a;font-size:17px;">Rp
                {{ number_format($totalNilai ?? 0, 0, ',', '.') }}</div>
            <div class="tr-stat-sub">estimasi harga</div>
            <div class="tr-stat-accent green"></div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon yellow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
            </div>
            <div class="tr-stat-label">Bulan Tertinggi</div>
            <div class="tr-stat-value" style="color:#d97706;">{{ $bulanTertinggi ?? '—' }}</div>
            <div class="tr-stat-sub">bulan dengan pemakaian terbanyak</div>
            <div class="tr-stat-accent yellow"></div>
        </div>
        <div class="tr-stat">
            <div class="tr-stat-icon purple">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            </div>
            <div class="tr-stat-label">Rata-rata / Bulan</div>
            <div class="tr-stat-value" style="color:var(--clr-purple);">{{ number_format($rataRata ?? 0) }}</div>
            <div class="tr-stat-sub">unit / bulan</div>
            <div class="tr-stat-accent purple"></div>
        </div>
    </div>

    {{-- Chart Tren (full width) --}}
    <div class="tr-panel">
        <div class="tr-panel-header">
            <div class="tr-panel-left">
                <div class="tr-panel-icon blue">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                        <polyline points="17 6 23 6 23 12" />
                    </svg>
                </div>
                <div>
                    <div class="tr-panel-title">Pemakaian & Nilai per Bulan — {{ request('tahun', now()->year) }}</div>
                    <div class="tr-panel-sub">Jumlah unit dan estimasi nilai</div>
                </div>
            </div>
            <div class="tr-legend">
                <div class="tr-legend-item">
                    <div class="tr-legend-dot" style="background:#3B82F6;"></div>
                    Jumlah Pakai
                </div>
                <div class="tr-legend-item">
                    <div class="tr-legend-dot" style="background:#F59E0B;"></div>
                    Nilai (Rp)
                </div>
            </div>
        </div>
        <div class="tr-panel-body">
            <div class="tr-chart-wrap">
                <canvas id="chartTren"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Obat + Monthly Table --}}
    <div class="tr-grid2">

        {{-- Top Obat Donut --}}
        <div class="tr-panel" style="margin-bottom:0;">
            <div class="tr-panel-header">
                <div class="tr-panel-left">
                    <div class="tr-panel-icon yellow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div>
                        <div class="tr-panel-title">Top Obat Tahun {{ request('tahun', now()->year) }}</div>
                        <div class="tr-panel-sub">Varian paling banyak dipakai</div>
                    </div>
                </div>
            </div>
            <div class="tr-panel-body">
                @if (count($topObat ?? []) > 0)
                    <div style="position:relative;height:200px;margin-bottom:16px;">
                        <canvas id="chartDonut"></canvas>
                    </div>
                    <div class="tr-rank-list">
                        @foreach ($topObat ?? [] as $i => $ob)
                            <div class="tr-rank-item">
                                <div
                                    class="tr-rank-no {{ $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')) }}">
                                    {{ $i + 1 }}
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div class="tr-rank-name">{{ $ob->nama }}</div>
                                    <div class="tr-rank-sub">{{ $ob->obat->nama ?? '' }}</div>
                                </div>
                                <div class="tr-rank-val">{{ number_format($ob->total_pakai) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="tr-empty">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                        Belum ada data untuk tahun ini
                    </div>
                @endif
            </div>
        </div>

        {{-- Rekap per Bulan Table ── --}}
        <div class="tr-panel" style="margin-bottom:0;">
            <div class="tr-panel-header">
                <div class="tr-panel-left">
                    <div class="tr-panel-icon green">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18M9 21V9" />
                        </svg>
                    </div>
                    <div>
                        <div class="tr-panel-title">Rekap per Bulan</div>
                        <div class="tr-panel-sub">Rincian bulanan {{ request('tahun', now()->year) }}</div>
                    </div>
                </div>
            </div>
            <div style="overflow-x:auto;">
                @php
                    $bulanNames = [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                    ];
                    $rekapBulan = $rekapBulan ?? [];
                    $maxBulan = collect($rekapBulan)->max('total') ?: 1;
                @endphp
                @if (count($rekapBulan) > 0)
                    <table class="tr-monthly-table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Jml. Pakai</th>
                                <th>Nilai</th>
                                <th style="width:160px;">Proporsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapBulan as $rb)
                                <tr>
                                    <td style="font-weight:500;">{{ $bulanNames[($rb->bulan ?? 1) - 1] }}</td>
                                    <td class="num" style="color:var(--clr-blue);">
                                        {{ number_format($rb->total ?? 0) }}</td>
                                    <td class="muted">Rp {{ number_format($rb->nilai ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="tr-bar-wrap">
                                            <div class="tr-bar-track">
                                                <div class="tr-bar-fill"
                                                    style="width:{{ ($rb->total / $maxBulan) * 100 }}%"></div>
                                            </div>
                                            <span style="font-size:10.5px;color:var(--tx-sub);white-space:nowrap;">
                                                {{ number_format(($rb->total / ($totalPakai ?: 1)) * 100, 1) }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="tr-empty">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18M9 21V9" />
                        </svg>
                        Belum ada data untuk tahun ini.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
