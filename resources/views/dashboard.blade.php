@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
    <style>
        :root {
            --c-blue: #378ADD;
            --c-green: #4CAF6E;
            --c-yellow: #F5A623;
            --c-red: #E24B4A;
            --c-purple: #8B7CF6;
            --c-border: #E5E7EB;
            --c-card: #FFFFFF;
            --c-text: #1a1a2e;
            --c-muted: #6B7280;
            --c-sub: #9CA3AF;
            --radius: 10px;
            --radius-sm: 6px;
        }

        .db-welcome {
            margin-bottom: 20px;
        }

        .db-welcome h1 {
            font-size: 18px;
            font-weight: 600;
            color: var(--c-text);
        }

        .db-welcome p {
            font-size: 12px;
            color: var(--c-muted);
            margin-top: 2px;
        }

        .db-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            background: #FCEBEB;
            border: 0.5px solid #F7C1C1;
            color: #A32D2D;
            font-size: 12px;
            margin-bottom: 18px;
        }

        .db-alert a {
            margin-left: auto;
            color: #A32D2D;
            font-size: 11px;
            border: 0.5px solid #F7C1C1;
            padding: 2px 8px;
            border-radius: 4px;
            text-decoration: none;
        }

        /* STAT CARDS */
        .db-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .db-stat {
            background: var(--c-card);
            border: 0.5px solid var(--c-border);
            border-radius: var(--radius);
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }

        .db-stat:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .07);
            transform: translateY(-1px);
        }

        .db-stat::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .db-stat.blue::after {
            background: var(--c-blue);
        }

        .db-stat.green::after {
            background: var(--c-green);
        }

        .db-stat.yellow::after {
            background: var(--c-yellow);
        }

        .db-stat.red::after {
            background: var(--c-red);
        }

        .db-stat-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--c-sub);
            margin-bottom: 8px;
        }

        .db-stat-value {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -.02em;
            line-height: 1;
            margin-bottom: 5px;
        }

        .db-stat.blue .db-stat-value {
            color: var(--c-blue);
        }

        .db-stat.green .db-stat-value {
            color: var(--c-green);
        }

        .db-stat.yellow .db-stat-value {
            color: var(--c-yellow);
        }

        .db-stat.red .db-stat-value {
            color: var(--c-red);
        }

        .db-stat-sub {
            font-size: 11px;
            color: var(--c-muted);
        }

        .db-stat-icon {
            position: absolute;
            bottom: 10px;
            right: 14px;
            width: 40px;
            height: 40px;
            opacity: .06;
        }

        /* GRID */
        .db-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        /* CARD */
        .db-card {
            background: var(--c-card);
            border: 0.5px solid var(--c-border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .db-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px 10px;
            border-bottom: 0.5px solid var(--c-border);
        }

        .db-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--c-text);
        }

        .db-card-link {
            font-size: 11px;
            color: var(--c-blue);
            text-decoration: none;
            padding: 3px 9px;
            border: 0.5px solid #BFDBFE;
            border-radius: 4px;
            background: #EFF6FF;
            transition: background .15s;
        }

        .db-card-link:hover {
            background: #DBEAFE;
        }

        .db-card-body {
            padding: 16px;
        }

        /* CHART */
        .db-chart-wrap {
            position: relative;
            height: 170px;
        }

        /* DONUT */
        .db-donut-wrap {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px;
        }

        .db-donut-canvas {
            width: 110px;
            height: 110px;
            flex-shrink: 0;
        }

        .db-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .db-legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .db-legend-label {
            font-size: 11.5px;
            color: var(--c-muted);
            flex: 1;
        }

        .db-legend-val {
            font-size: 12px;
            font-weight: 600;
            color: var(--c-text);
        }

        /* TABLE */
        .db-table-wrap {
            overflow-x: auto;
        }

        .db-table {
            width: 100%;
            border-collapse: collapse;
        }

        .db-table th {
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--c-sub);
            padding: 8px 14px;
            text-align: left;
            background: #FAFAFA;
            border-bottom: 0.5px solid var(--c-border);
        }

        .db-table td {
            padding: 9px 14px;
            font-size: 12px;
            color: var(--c-muted);
            border-bottom: 0.5px solid #F3F4F6;
            vertical-align: middle;
        }

        .db-table tr:last-child td {
            border-bottom: none;
        }

        .db-table tr:hover td {
            background: #FAFAFA;
        }

        .db-drug {
            font-weight: 600;
            color: var(--c-text);
            font-size: 12.5px;
        }

        /* BADGES */
        .db-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .badge-red {
            background: #FCEBEB;
            color: #A32D2D;
            border: 0.5px solid #F7C1C1;
        }

        .badge-yellow {
            background: #FAEEDA;
            color: #854F0B;
            border: 0.5px solid #FAC775;
        }

        .badge-green {
            background: #EAF3DE;
            color: #3B6D11;
            border: 0.5px solid #C0DD97;
        }

        .badge-blue {
            background: #EFF6FF;
            color: #185FA5;
            border: 0.5px solid #BFDBFE;
        }

        /* STOCK PROGRESS */
        .db-stock-num {
            font-size: 14px;
            font-weight: 700;
        }

        .db-prog {
            height: 4px;
            background: #F3F4F6;
            border-radius: 2px;
            margin-top: 4px;
            width: 80px;
        }

        .db-prog-fill {
            height: 100%;
            border-radius: 2px;
            transition: width .5s;
        }

        .prog-red {
            background: var(--c-red);
        }

        .prog-yellow {
            background: var(--c-yellow);
        }

        /* ACTION BUTTONS */
        .db-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            padding: 16px;
        }

        .db-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            border: 0.5px solid transparent;
            font-family: inherit;
        }

        .db-btn svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        .db-btn-full {
            grid-column: span 2;
        }

        .db-btn-primary {
            background: var(--c-blue);
            color: #fff;
            border-color: var(--c-blue);
        }

        .db-btn-primary:hover {
            background: #2563EB;
        }

        .db-btn-success {
            background: #EAF3DE;
            color: #3B6D11;
            border-color: #C0DD97;
        }

        .db-btn-success:hover {
            background: #D4E8C2;
        }

        .db-btn-default {
            background: #F9FAFB;
            color: #374151;
            border-color: #E5E7EB;
        }

        .db-btn-default:hover {
            background: #F3F4F6;
        }

        .db-btn-warning {
            background: #FAEEDA;
            color: #854F0B;
            border-color: #FAC775;
        }

        .db-btn-warning:hover {
            background: #FDDCAA;
        }

        /* ACTIVITY */
        .db-activity {
            padding: 4px 16px 16px;
        }

        .db-act-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 0.5px solid #F3F4F6;
        }

        .db-act-item:last-child {
            border-bottom: none;
        }

        .db-act-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .db-act-text {
            font-size: 12px;
            color: #374151;
        }

        .db-act-text strong {
            color: var(--c-text);
            font-weight: 600;
        }

        .db-act-time {
            font-size: 10px;
            color: var(--c-sub);
            margin-top: 2px;
        }

        @media (max-width: 1100px) {
            .db-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .db-grid-2 {
                grid-template-columns: 1fr;
            }

            .db-stats {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Welcome --}}
    <div class="db-welcome">
        <h1>Selamat datang, {{ auth()->user()->name }} 👋</h1>
        <p>Berikut ringkasan kondisi farmasi Klinik Yos Benito hari ini.</p>
    </div>

    {{-- Alert stok kritis --}}
    @if (isset($stokKritis) && $stokKritis->count() > 0)
        <div class="db-alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                <line x1="12" x2="12" y1="9" y2="13" />
                <line x1="12" x2="12.01" y1="17" y2="17" />
            </svg>
            <span><strong>Perhatian!</strong> Terdapat {{ $stokKritis->count() }} obat dengan stok di bawah minimum.</span>
            <a href="{{ route('stok-minimum.index') }}">Lihat Semua →</a>
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="db-stats">
        <div class="db-stat blue">
            <div class="db-stat-label">Total Variasi Obat</div>
            <div class="db-stat-value">{{ $totalVariasiObat ?? 0 }}</div>
            <div class="db-stat-sub">Jenis variasi terdaftar</div>
            <svg class="db-stat-icon" viewBox="0 0 24 24" fill="currentColor" style="color:var(--c-blue)">
                <path
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
            </svg>
        </div>
        <div class="db-stat green">
            <div class="db-stat-label">Total Stok</div>
            <div class="db-stat-value">{{ number_format($totalStok ?? 0) }}</div>
            <div class="db-stat-sub">Unit tersedia</div>
            <svg class="db-stat-icon" viewBox="0 0 24 24" fill="currentColor" style="color:var(--c-green)">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div class="db-stat yellow">
            <div class="db-stat-label">Mendekati Exp</div>
            <div class="db-stat-value">{{ $mendekatiExp ?? 0 }}</div>
            <div class="db-stat-sub">Batch &lt; 30 hari</div>
            <svg class="db-stat-icon" viewBox="0 0 24 24" fill="currentColor" style="color:var(--c-yellow)">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div class="db-stat red">
            <div class="db-stat-label">Sudah Expire</div>
            <div class="db-stat-value">{{ $sudahExpire ?? 0 }}</div>
            <div class="db-stat-sub">Batch ada stok</div>
            <svg class="db-stat-icon" viewBox="0 0 24 24" fill="currentColor" style="color:var(--c-red)">
                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    {{-- ROW 2: TREN + DISTRIBUSI --}}
    <div class="db-grid-2">
        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Tren Pemakaian Obat (6 Bulan)</span>
                <a href="{{ route('laporan.tren') }}" class="db-card-link">Analisis →</a>
            </div>
            <div class="db-card-body">
                <div class="db-chart-wrap"><canvas id="trendChart"></canvas></div>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Distribusi Jenis Obat</span>
            </div>
            <div class="db-donut-wrap">
                <canvas id="donutChart" class="db-donut-canvas" width="110" height="110"></canvas>
                <div style="flex:1;">
                    @php
                        $distribusi =
                            $distribusiJenis ??
                            collect([
                                ['label' => 'Analgesik', 'value' => 32, 'color' => '#378ADD'],
                                ['label' => 'Antibiotik', 'value' => 28, 'color' => '#4CAF6E'],
                                ['label' => 'Vitamin', 'value' => 20, 'color' => '#F5A623'],
                                ['label' => 'Antasida', 'value' => 12, 'color' => '#8B7CF6'],
                                ['label' => 'Lainnya', 'value' => 8, 'color' => '#9CA3AF'],
                            ]);
                    @endphp
                    @foreach ($distribusi as $item)
                        <div class="db-legend-item">
                            <div class="db-legend-dot" style="background:{{ $item['color'] }}"></div>
                            <span class="db-legend-label">{{ $item['label'] }}</span>
                            <span class="db-legend-val">{{ $item['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 3: BATCH KADALUARSA + PEMAKAIAN TERAKHIR --}}
    <div class="db-grid-2">
        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Batch Mendekati Kadaluarsa</span>
                <a href="{{ route('stok-obat.index') }}" class="db-card-link">Lihat semua →</a>
            </div>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Stok</th>
                            <th>Exp</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batchKadaluarsa ?? [] as $b)
                            <tr>
                                <td><span class="db-drug">{{ $b['nama'] ?? '-' }}</span></td>
                                <td>{{ $b['stok'] ?? 0 }}</td>
                                <td>{{ $b['exp'] ?? '-' }}</td>
                                <td>
                                    @php $status = $b['status'] ?? 'aman'; @endphp
                                    @if ($status === 'kritis')
                                        <span class="db-badge badge-red">Kritis</span>
                                    @elseif($status === 'segera')
                                        <span class="db-badge badge-yellow">Segera</span>
                                    @else
                                        <span class="db-badge badge-green">Aman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:20px;color:var(--c-muted);">Tidak ada
                                    batch mendekati kadaluarsa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Pemakaian Terakhir</span>
                <a href="{{ route('pemakaian-obat.index') }}" class="db-card-link">Lihat semua →</a>
            </div>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Qty</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemakaianTerakhir ?? [] as $p)
                            <tr>
                                <td><span class="db-drug">{{ $p['nama'] ?? '-' }}</span></td>
                                <td><span class="db-badge badge-blue">{{ $p['qty'] ?? 0 }}</span></td>
                                <td style="color:var(--c-sub);font-size:11px;">{{ $p['waktu'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center;padding:20px;color:var(--c-muted);">Belum ada
                                    data pemakaian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ROW 4: STOK RESTOCK + AKSI CEPAT --}}
    <div class="db-grid-2">
        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Stok Perlu Restock</span>
                <a href="{{ route('stok-minimum.index') }}" class="db-card-link">Detail →</a>
            </div>
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Stok</th>
                            <th>Min</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stokRestock ?? [] as $s)
                            <tr>
                                <td><span class="db-drug">{{ $s['nama'] ?? '-' }}</span></td>
                                <td>
                                    <span class="db-stock-num">{{ $s['stok'] ?? 0 }}</span>
                                    <div class="db-prog">
                                        <div class="db-prog-fill prog-red" style="width:{{ min($s['pct'] ?? 0, 100) }}%">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $s['min'] ?? 0 }}</td>
                                <td><a href="{{ route('stok-obat.create') }}" class="db-badge badge-blue">+ Order</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:20px;color:var(--c-muted);">Semua stok
                                    aman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-header">
                <span class="db-card-title">Aksi Cepat</span>
            </div>
            <div class="db-actions">
                <a href="{{ route('stok-obat.create') }}" class="db-btn db-btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Stok
                </a>
                <a href="{{ route('pemakaian-obat.create') }}" class="db-btn db-btn-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Input Pemakaian
                </a>
                <a href="{{ route('master.jenis-obat.index') }}" class="db-btn db-btn-default">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
                    </svg>
                    Master Data
                </a>
                <a href="{{ route('stok-minimum.index') }}" class="db-btn db-btn-warning">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Stok Minimum
                </a>
                <a href="{{ route('laporan.index') }}" class="db-btn db-btn-default db-btn-full">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Cetak Laporan (PDF / Excel)
                </a>
            </div>
        </div>
    </div>

    {{-- ROW 5: STATUS PENGAJUAN ──────────────────────────── --}}
    <div class="db-card" style="margin-bottom:16px;">
        <div class="db-card-header">
            <span class="db-card-title">Status Pengajuan Saya</span>
            <div style="display:flex;align-items:center;gap:8px;">
                @if (($pendingApproval ?? 0) > 0)
                    <span class="db-badge badge-yellow">{{ $pendingApproval }} Pending</span>
                @endif
                <a href="{{ route('approval-requests.index') }}" class="db-card-link">Lihat semua →</a>
            </div>
        </div>

        @if (isset($approvalRequestSaya) && $approvalRequestSaya->count() > 0)
            <div class="db-table-wrap">
                <table class="db-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Diproses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvalRequestSaya as $req)
                            <tr>
                                <td>
                                    <span class="db-drug">{{ $req->judul }}</span>
                                    @if ($req->deskripsi)
                                        <div style="font-size:11px;color:var(--c-muted)">
                                            {{ Str::limit($req->deskripsi, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="db-badge badge-blue">
                                        {{ match ($req->tipe) {
                                            'restock' => '📦 Restock',
                                            'supplier' => '🏭 Supplier',
                                            'hapus_batch' => '🗑️ Hapus Batch',
                                            'tambah_obat' => '💊 Tambah Obat',
                                            default => $req->tipe,
                                        } }}
                                    </span>
                                </td>
                                <td>
                                    @if ($req->status === 'pending')
                                        <span class="db-badge badge-yellow">⏳ Pending</span>
                                    @elseif($req->status === 'approved')
                                        <span class="db-badge badge-green">✔ Disetujui</span>
                                    @else
                                        <span class="db-badge badge-red">✕ Ditolak</span>
                                    @endif
                                </td>
                                <td style="font-size:11px;color:var(--c-muted)">
                                    {{ $req->created_at->format('d M Y') }}
                                </td>
                                <td style="font-size:11px;color:var(--c-muted)">
                                    @if ($req->approved_at)
                                        {{ $req->approved_at->format('d M Y') }}
                                        @if ($req->approver)
                                            <div style="font-size:10px">oleh {{ $req->approver->name }}</div>
                                        @endif
                                    @else
                                        <span style="color:var(--c-sub)">Belum diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align:center;padding:24px;color:var(--c-muted);font-size:13px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" style="opacity:.3;display:block;margin:0 auto 8px">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
                Belum ada pengajuan.
                <a href="{{ route('approval-requests.create') }}"
                    style="color:var(--c-blue);font-weight:600;text-decoration:none;display:block;margin-top:6px">
                    + Buat Pengajuan Baru
                </a>
            </div>
        @endif
    </div>
    {{-- ROW 5: LOG AKTIVITAS --}}
    <div class="db-card" style="margin-bottom:8px;">
        <div class="db-card-header">
            <span class="db-card-title">Aktivitas Terkini</span>
        </div>
        <div class="db-activity">
            @php
                $aktivitas = $aktivitasTerkini ?? [
                    [
                        'warna' => '#4CAF6E',
                        'teks' => 'Stok <strong>Paracetamol 500mg</strong> ditambahkan sebanyak 100 tablet',
                        'waktu' => '2 menit lalu',
                    ],
                    [
                        'warna' => '#378ADD',
                        'teks' => 'Laporan stok bulan ini berhasil dibuka',
                        'waktu' => '15 menit lalu',
                    ],
                    [
                        'warna' => '#F5A623',
                        'teks' => 'Pemakaian <strong>Amoxicillin 500mg</strong> sebanyak 6 kapsul diinput',
                        'waktu' => '28 menit lalu',
                    ],
                    [
                        'warna' => '#E24B4A',
                        'teks' => 'Batch <strong>Metformin 500mg</strong> stok di bawah minimum',
                        'waktu' => '1 jam lalu',
                    ],
                    ['warna' => '#8B7CF6', 'teks' => 'Laporan stok diekspor ke PDF', 'waktu' => '2 jam lalu'],
                ];
            @endphp
            @foreach ($aktivitas as $log)
                <div class="db-act-item">
                    <div class="db-act-dot" style="background:{{ $log['warna'] }}"></div>
                    <div>
                        <div class="db-act-text">{!! $log['teks'] !!}</div>
                        <div class="db-act-time">{{ $log['waktu'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- STAT KASIR --}}
    <div class="db-stats" style="margin-top:8px;margin-bottom:20px;">
        <div class="db-stat blue">
            <div class="db-stat-label">Resep Hari Ini</div>
            <div class="db-stat-value">{{ $resepHariIni ?? 0 }}</div>
            <div class="db-stat-sub">{{ $resepSelesai ?? 0 }} selesai · {{ $resepMenunggu ?? 0 }} menunggu</div>
        </div>
        <div class="db-stat green">
            <div class="db-stat-label">Total Omset</div>
            <div class="db-stat-value">Rp
                {{ number_format(($ringkasanKasir['total_omset'] ?? 0) / 1000, 0, ',', '.') }}k</div>
            <div class="db-stat-sub">{{ $ringkasanKasir['total_selesai'] ?? 0 }} transaksi selesai</div>
        </div>
        <div class="db-stat yellow">
            <div class="db-stat-label">Dibatalkan</div>
            <div class="db-stat-value">{{ $ringkasanKasir['total_dibatalkan'] ?? 0 }}</div>
            <div class="db-stat-sub">Bulan ini</div>
        </div>
        <div class="db-stat red">
            <div class="db-stat-label">Rata per Transaksi</div>
            <div class="db-stat-value">Rp
                {{ number_format(($ringkasanKasir['rata_per_transaksi'] ?? 0) / 1000, 0, ',', '.') }}k</div>
            <div class="db-stat-sub">Nilai rata-rata</div>
        </div>
    </div>

    {{-- TABEL TRANSAKSI KASIR --}}
    <div class="db-card" style="margin-bottom:16px;">
        <div class="db-card-header">
            <span class="db-card-title">Transaksi Kasir Terbaru</span>
            <span style="font-size:11px;color:var(--c-muted);">
                {{ now()->startOfMonth()->format('d M') }} – {{ now()->format('d M Y') }}
            </span>
        </div>
        <div class="db-table-wrap">
            <table class="db-table">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Pasien</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Kembalian</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($transaksiKasir ?? collect())->take(10) as $trx)
                        <tr>
                            <td style="font-family:monospace;font-size:11px;color:var(--c-blue);">
                                {{ $trx['no_transaksi'] ?? '-' }}</td>
                            <td style="font-weight:600;">{{ $trx['nama_pasien'] ?? '-' }}</td>
                            <td style="color:var(--c-muted);">{{ $trx['nama_kasir'] ?? '-' }}</td>
                            <td style="font-family:monospace;font-weight:600;">Rp
                                {{ number_format($trx['total'] ?? 0, 0, ',', '.') }}</td>
                            <td style="font-family:monospace;">Rp {{ number_format($trx['bayar'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td style="font-family:monospace;">Rp {{ number_format($trx['kembalian'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                @if (($trx['status'] ?? '') === 'selesai')
                                    <span class="db-badge badge-green">✓ Selesai</span>
                                @elseif(($trx['status'] ?? '') === 'batal')
                                    <span class="db-badge badge-red">✗ Batal</span>
                                @elseif(($trx['status'] ?? '') === 'tunda')
                                    <span class="db-badge badge-yellow">⏸ Tunda</span>
                                @else
                                    <span class="db-badge badge-yellow">⏳ Menunggu</span>
                                @endif
                            </td>
                            <td style="font-size:11px;color:var(--c-muted);">{{ $trx['waktu'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                style="text-align:center;padding:32px;color:var(--c-muted);font-size:13px;">
                                ⚠️ Tidak dapat terhubung ke sistem kasir atau belum ada transaksi bulan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Tren Pemakaian
            var trendLabels = {!! json_encode($trendLabels ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
            var trendData = {!! json_encode($trendPemakaian ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

            @php
                $donutData = isset($distribusiJenis) ? array_column($distribusiJenis->toArray(), 'value') : [32, 28, 20, 12, 8];
                $donutColors = isset($distribusiJenis) ? array_column($distribusiJenis->toArray(), 'color') : ['#378ADD', '#4CAF6E', '#F5A623', '#8B7CF6', '#9CA3AF'];
            @endphp
            var donutData = {!! json_encode($donutData, JSON_HEX_TAG) !!};
            var donutColors = {!! json_encode($donutColors, JSON_HEX_TAG) !!};

            // Chart Tren
            var trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                var ctx2d = trendCtx.getContext('2d');
                var grad = ctx2d.createLinearGradient(0, 0, 0, 170);
                grad.addColorStop(0, 'rgba(55,138,221,0.15)');
                grad.addColorStop(1, 'rgba(55,138,221,0)');
                new Chart(ctx2d, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: [{
                            label: 'Pemakaian',
                            data: trendData,
                            borderColor: '#378ADD',
                            backgroundColor: grad,
                            borderWidth: 2,
                            pointBackgroundColor: '#378ADD',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4,
                            fill: true,
                        }]
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
                                titleColor: '#1a1a2e',
                                bodyColor: '#6B7280',
                                padding: 10,
                                callbacks: {
                                    label: function(ctx) {
                                        return ' ' + ctx.parsed.y.toLocaleString('id-ID') + ' unit';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: '#F3F4F6'
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    font: {
                                        size: 11
                                    }
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: '#F3F4F6'
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    font: {
                                        size: 11
                                    }
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Chart Donut
            var donutCtx = document.getElementById('donutChart');
            if (donutCtx) {
                new Chart(donutCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: donutData,
                            backgroundColor: donutColors,
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 4,
                        }]
                    },
                    options: {
                        responsive: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#fff',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                titleColor: '#1a1a2e',
                                bodyColor: '#6B7280',
                                callbacks: {
                                    label: function(ctx) {
                                        return ' ' + ctx.parsed;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
