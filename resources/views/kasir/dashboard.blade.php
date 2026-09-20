@extends('layouts.kasir')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
    <style>
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn-kasir {
            background: var(--accent-cyan);
            color: #0a1a1a;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            letter-spacing: .02em;
            transition: opacity .15s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kasir:hover {
            opacity: .88;
        }

        /* ── STAT CARDS ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-bottom: 16px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
        }

        .stat-label {
            font-size: 10px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-unit {
            font-size: 13px;
            color: var(--text-secondary);
            margin-left: 3px;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            margin-top: 8px;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .stat-badge.green {
            background: rgba(34, 197, 94, .12);
            color: var(--accent-green);
        }

        .stat-badge.amber {
            background: rgba(245, 158, 11, .12);
            color: var(--accent-amber);
        }

        .stat-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* ── ALERTS ── */
        .alert-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .alert-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-left: 3px solid var(--accent-red);
            border-radius: 10px;
            padding: 13px 16px;
        }

        .alert-title {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .alert-sub {
            font-size: 11px;
            color: var(--accent-red);
        }

        .alert-link {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .alert-link:hover {
            color: var(--text-primary);
        }

        /* ── BOTTOM GRID ── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
        }

        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-cyan);
        }

        .panel-link {
            font-size: 12px;
            color: var(--accent-cyan);
            cursor: pointer;
            background: rgba(0, 200, 200, .08);
            padding: 4px 10px;
            border-radius: 5px;
            transition: background .15s;
            text-decoration: none;
        }

        .panel-link:hover {
            background: rgba(0, 200, 200, .16);
        }

        /* ── QUEUE ── */
        .queue-item {
            display: flex;
            align-items: center;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
            transition: background .15s;
        }

        .queue-item:last-child {
            border-bottom: none;
        }

        .queue-item:hover {
            background: var(--bg-hover);
        }

        .queue-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--bg-card-alt);
            border: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .queue-info {
            flex: 1;
        }

        .queue-name-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 3px;
        }

        .queue-name {
            font-size: 13px;
            font-weight: 600;
        }

        .tag {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 4px;
            letter-spacing: .04em;
        }

        .tag.bpjs {
            background: rgba(59, 130, 246, .18);
            color: #60a5fa;
        }

        .tag.umum {
            background: rgba(34, 197, 94, .15);
            color: #4ade80;
        }

        .tag.asuransi {
            background: rgba(139, 92, 246, .18);
            color: #a78bfa;
        }

        .queue-drugs {
            font-size: 11px;
            color: var(--text-muted);
        }

        .queue-right {
            text-align: right;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .queue-time {
            font-size: 11px;
            color: var(--text-muted);
            font-family: 'IBM Plex Mono', monospace;
        }

        .status-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 5px;
            letter-spacing: .04em;
        }

        .status-badge.menunggu {
            background: rgba(245, 158, 11, .15);
            color: #fbbf24;
        }

        .status-badge.tunda {
            background: rgba(239, 68, 68, .15);
            color: #f87171;
        }

        /* ── STOCK ── */
        .stock-item {
            display: flex;
            align-items: center;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
            transition: background .15s;
        }

        .stock-item:last-child {
            border-bottom: none;
        }

        .stock-item:hover {
            background: var(--bg-hover);
        }

        .stock-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--bg-card-alt);
            border: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stock-info {
            flex: 1;
        }

        .stock-name {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .stock-cat {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .stock-bar {
            height: 4px;
            border-radius: 99px;
            background: var(--bg-base);
            overflow: hidden;
        }

        .stock-fill {
            height: 100%;
            border-radius: 99px;
        }

        .fill-green {
            background: var(--accent-green);
        }

        .fill-red {
            background: var(--accent-red);
        }

        .fill-amber {
            background: var(--accent-amber);
        }

        .stock-qty {
            font-size: 22px;
            font-weight: 700;
            text-align: right;
            line-height: 1;
        }

        .stock-unit {
            font-size: 10px;
            color: var(--text-muted);
            text-align: right;
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Kasir</h1>
            <p class="page-subtitle">Ringkasan stok &amp; resep hari ini &middot; Shift Pagi 08:00 – 16:00</p>
        </div>
        <a href="{{ route('kasir.resep.create') }}" class="btn-kasir">Kasir</a>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stat-grid">

        <div class="stat-card" style="border-left:3px solid var(--accent-cyan)">
            <div class="stat-label">Resep Saya</div>
            <div>
                <span class="stat-value">{{ $resepOlehSaya ?? 0 }}</span>
                <span class="stat-unit">resep</span>
            </div>
            <div class="stat-badge green">Shift saya</div>
        </div>

        <div class="stat-card" style="border-left:3px solid var(--accent-green)">
            <div class="stat-label">Omset Saya</div>
            <div>
                <span class="stat-value">
                    Rp {{ number_format(($omsetOlehSaya ?? 0) / 1000, 0, ',', '.') }}k
                </span>
            </div>
            <div class="stat-badge green">Shift saya</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Resep Hari Ini</div>
            <div>
                <span class="stat-value">{{ $stats['total_resep'] ?? 0 }}</span>
                <span class="stat-unit">resep</span>
            </div>
            <div class="stat-badge green">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <polyline points="18 15 12 9 6 15" />
                </svg>
                +{{ $stats['resep_delta'] ?? 0 }} dari kemarin
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Sudah Dilayani</div>
            <div>
                <span class="stat-value">{{ $stats['sudah_dilayani'] ?? 0 }}</span>
                <span class="stat-unit">selesai</span>
            </div>
            <div class="stat-sub">{{ $stats['menunggu'] ?? 0 }} menunggu</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Transaksi</div>
            <div>
                <span class="stat-value">
                    Rp {{ number_format(($stats['total_transaksi'] ?? 0) / 1000000, 1) }}jt
                </span>
            </div>
            <div class="stat-badge {{ ($stats['transaksi_pct'] ?? 0) >= 0 ? 'green' : 'amber' }}">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <polyline points="18 15 12 9 6 15" />
                </svg>
                {{ ($stats['transaksi_pct'] ?? 0) >= 0 ? '+' : '' }}{{ $stats['transaksi_pct'] ?? 0 }}% hari ini
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Stok Hampir Habis</div>
            <div>
                <span class="stat-value">{{ $stats['stok_menipis_count'] ?? 0 }}</span>
                <span class="stat-unit">item</span>
            </div>
            <div class="stat-badge amber">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                perlu restock
            </div>
        </div>

    </div>

    {{-- ── ALERTS ── --}}
    @if (isset($alerts) && count($alerts))
        <div class="alert-list">
            @foreach ($alerts as $alert)
                <div class="alert-item">
                    <div>
                        <div class="alert-title">{{ $alert['nama_obat'] }} — {{ $alert['keterangan'] }}</div>
                        <div class="alert-sub">{{ $alert['detail'] }}</div>
                    </div>
                    <a href="{{ route('kasir.stok.show', $alert['id']) }}" class="alert-link">
                        Laporkan
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── BOTTOM GRID ── --}}
    <div class="bottom-grid">

        {{-- Antrean Resep --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <span class="panel-title-dot"></span>
                    Antrean Resep — Menunggu
                </div>
                <a href="{{ route('kasir.resep.index') }}" class="panel-link">Lihat semua</a>
            </div>

            @forelse($antrean ?? [] as $i => $item)
                <div class="queue-item">
                    <div class="queue-num">{{ $i + 1 }}</div>
                    <div class="queue-info">
                        <div class="queue-name-row">
                            <span class="queue-name">{{ $item->pasien }}</span>
                            <span class="tag {{ strtolower($item->jenis_pembayaran ?? 'umum') }}">
                                {{ strtoupper($item->jenis_pembayaran ?? 'UMUM') }}
                            </span>
                        </div>
                        <div class="queue-drugs">{{ $item->daftar_obat ?? '-' }}</div>
                    </div>
                    <div class="queue-right">
                        <div class="queue-time">
                            {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
                        </div>
                        <span class="status-badge {{ strtolower($item->status) }}">
                            {{ ucfirst($item->status) }}
                        </span>
                        <a href="{{ route('kasir.resep.show', $item->id) }}"
                            style="font-size:11px;padding:5px 12px;background:rgba(0,200,200,.1);color:var(--accent-cyan);border-radius:5px;text-decoration:none;border:1px solid rgba(0,200,200,.2);white-space:nowrap;transition:background .15s"
                            onmouseover="this.style.background='rgba(0,200,200,.2)'"
                            onmouseout="this.style.background='rgba(0,200,200,.1)'">
                            Proses →
                        </a>
                    </div>
                </div>
            @empty
                <div style="padding:24px;text-align:center;color:var(--text-muted);font-size:13px;">
                    Tidak ada antrean saat ini
                </div>
            @endforelse
        </div>

        {{-- Stok Cepat Lihat --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <span class="panel-title-dot" style="background:var(--accent-blue)"></span>
                    Stok Cepat Lihat
                </div>
            </div>

            @forelse($stokCepat ?? [] as $stok)
                <div class="stock-item">
                    <div class="stock-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path
                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0016.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 002 8.5c0 2.3 1.5 4.05 3 5.5l7 7 7-7z" />
                        </svg>
                    </div>
                    <div class="stock-info">
                        <div class="stock-name">{{ $stok->nama_obat }}</div>
                        <div class="stock-cat">{{ $stok->kategori }}</div>
                        <div class="stock-bar">
                            <div class="stock-fill {{ $stok->pct > 60 ? 'fill-green' : ($stok->pct > 30 ? 'fill-amber' : 'fill-red') }}"
                                style="width:{{ $stok->pct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="stock-qty">{{ $stok->stok }}</div>
                        <div class="stock-unit">{{ $stok->satuan }}</div>
                    </div>
                </div>
            @empty
                @php
                    $stokDemo = [
                        [
                            'name' => 'Paracetamol 500mg',
                            'cat' => 'Analgesik',
                            'qty' => 410,
                            'unit' => 'tablet',
                            'pct' => 82,
                        ],
                        [
                            'name' => 'Amoxicillin 500mg',
                            'cat' => 'Antibiotik',
                            'qty' => 12,
                            'unit' => 'tablet',
                            'pct' => 8,
                        ],
                        [
                            'name' => 'Infus NaCl 0,9%',
                            'cat' => 'Cairan Infus',
                            'qty' => 55,
                            'unit' => 'botol',
                            'pct' => 55,
                        ],
                        [
                            'name' => 'Metformin 500mg',
                            'cat' => 'Antidiabetes',
                            'qty' => 76,
                            'unit' => 'tablet',
                            'pct' => 38,
                        ],
                    ];
                @endphp
                @foreach ($stokDemo as $s)
                    <div class="stock-item">
                        <div class="stock-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="3" />
                                <line x1="12" y1="8" x2="12" y2="16" />
                                <line x1="8" y1="12" x2="16" y2="12" />
                            </svg>
                        </div>
                        <div class="stock-info">
                            <div class="stock-name">{{ $s['name'] }}</div>
                            <div class="stock-cat">{{ $s['cat'] }}</div>
                            <div class="stock-bar">
                                <div class="stock-fill {{ $s['pct'] > 60 ? 'fill-green' : ($s['pct'] > 25 ? 'fill-amber' : 'fill-red') }}"
                                    style="width:{{ $s['pct'] }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="stock-qty">{{ $s['qty'] }}</div>
                            <div class="stock-unit">{{ $s['unit'] }}</div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

    </div>{{-- end bottom-grid --}}

@endsection
