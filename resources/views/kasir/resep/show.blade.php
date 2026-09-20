@extends('layouts.kasir')

@section('title', 'Detail Resep')
@section('page-title', 'Detail Resep')

@push('styles')
    <style>
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            color: var(--text-muted);
            font-family: 'IBM Plex Mono', monospace;
        }

        .breadcrumb a {
            color: var(--accent-cyan);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            font-family: 'IBM Plex Mono', monospace;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            letter-spacing: .04em;
        }

        .status-pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pill.menunggu {
            background: rgba(245, 158, 11, .15);
            color: #fbbf24;
        }

        .status-pill.selesai {
            background: rgba(34, 197, 94, .15);
            color: var(--accent-green);
        }

        .status-pill.dibatalkan {
            background: rgba(239, 68, 68, .15);
            color: var(--accent-red);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 16px;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-cyan);
        }

        .card-body {
            padding: 20px;
        }

        .info-row {
            display: flex;
            align-items: baseline;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            gap: 16px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 11px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            min-width: 130px;
            flex-shrink: 0;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
        }

        .info-value.mono {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            font-size: 10px;
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .items-table th:last-child {
            text-align: right;
        }

        .items-table td {
            padding: 13px 16px;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table td:last-child {
            text-align: right;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
        }

        .items-table tr:hover td {
            background: var(--bg-hover);
        }

        .item-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .item-sub {
            font-size: 11px;
            color: var(--text-muted);
        }

        .qty-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-card-alt);
            border: 1px solid var(--border-light);
            border-radius: 6px;
            padding: 3px 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'IBM Plex Mono', monospace;
        }

        .total-section {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .total-row.grand {
            padding-top: 12px;
            margin-top: 8px;
            border-top: 1px solid var(--border-light);
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .total-row.grand .amount {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
            font-size: 18px;
        }

        .side-info {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .side-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
        }

        .side-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .08em;
            font-family: 'IBM Plex Mono', monospace;
        }

        .side-body {
            padding: 16px 18px;
        }

        .side-row {
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .side-row:last-child {
            border-bottom: none;
        }

        .side-label {
            font-size: 10px;
            font-family: 'IBM Plex Mono', monospace;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .side-val {
            font-size: 14px;
            font-weight: 600;
        }

        .side-val.mono {
            font-family: 'IBM Plex Mono', monospace;
            color: var(--accent-cyan);
            font-size: 13px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: opacity .15s, background .15s;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary {
            background: var(--accent-cyan);
            color: #0a1a1a;
        }

        .btn-primary:hover {
            opacity: .88;
        }

        .btn-secondary {
            background: var(--bg-card-alt);
            color: var(--text-primary);
            border: 1px solid var(--border-light);
        }

        .btn-secondary:hover {
            background: var(--bg-hover);
        }

        .btn-danger {
            background: rgba(239, 68, 68, .15);
            color: var(--accent-red);
            border: 1px solid rgba(239, 68, 68, .25);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, .25);
        }

        .btn-amber {
            background: rgba(245, 158, 11, .15);
            color: var(--accent-amber);
            border: 1px solid rgba(245, 158, 11, .25);
        }

        .btn-amber:hover {
            background: rgba(245, 158, 11, .25);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(34, 197, 94, .1);
            border: 1px solid rgba(34, 197, 94, .25);
            color: var(--accent-green);
        }

        .empty-items {
            padding: 32px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }
    </style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('kasir.resep.index') }}">← Daftar Resep</a>
        <span>/</span>
        <span>Detail #{{ $resep->id }}</span>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Resep</h1>
            <p class="page-subtitle">{{ $resep->no_resep ?? 'RES-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="header-actions">
            @if ($resep->status === 'menunggu')
                <a href="{{ route('kasir.resep.edit', $resep->id) }}" class="btn btn-secondary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
            @endif
            <a href="{{ route('kasir.resep.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">

        {{-- KIRI --}}
        <div>
            {{-- Info Resep --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-title-dot"></span>
                        Informasi Resep
                    </div>
                    <span class="status-pill {{ $resep->status ?? 'menunggu' }}">
                        {{ ucfirst($resep->status ?? 'menunggu') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">No. Resep</span>
                        <span
                            class="info-value mono">{{ $resep->no_resep ?? 'RES-' . str_pad($resep->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nama Pasien</span>
                        <span class="info-value">{{ $resep->pasien ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dokter</span>
                        <span class="info-value">{{ $resep->dokter ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span
                            class="info-value">{{ \Carbon\Carbon::parse($resep->created_at)->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    @if ($resep->catatan)
                        <div class="info-row">
                            <span class="info-label">Catatan</span>
                            <span class="info-value">{{ $resep->catatan }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tabel Obat --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-title-dot" style="background:var(--accent-blue)"></span>
                        Daftar Obat
                    </div>
                    <span style="font-size:11px;color:var(--text-muted);font-family:'IBM Plex Mono',monospace;">
                        {{ $resep->items->count() }} item
                    </span>
                </div>

                @if ($resep->items->isEmpty())
                    <div class="empty-items">Belum ada obat di resep ini.</div>
                @else
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Signa & Jadwal</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resep->items as $i => $item)
                                <tr>
                                    <td
                                        style="color:var(--text-muted);font-family:'IBM Plex Mono',monospace;font-size:12px;">
                                        {{ $i + 1 }}</td>
                                    <td>
                                        <div class="item-name">
                                            {{ $item->varianObat->nama_merek ?? ($item->nama_obat ?? '-') }}</div>
                                        <div class="item-sub">
                                            {{ $item->varianObat->obat->nama_obat ?? '' }}
                                            @if ($item->varianObat->dosis_mg ?? false)
                                                · {{ $item->varianObat->dosis_mg }}mg
                                            @endif
                                        </div>
                                    </td>
                                    <td><span class="qty-badge">{{ $item->jumlah }}</span></td>
                                    <td
                                        style="font-family:'IBM Plex Mono',monospace;color:var(--text-secondary);font-size:12px;">
                                        Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                    </td>

                                    {{-- KOLOM SIGNA BARU --}}
                                    <td>
                                        {{-- Aturan pakai (frekuensi) --}}
                                        @if ($item->signa ?? false)
                                            <div
                                                style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:6px;">
                                                🔁 {{ $item->signa }}
                                            </div>
                                        @endif

                                        {{-- Jadwal minum --}}
                                        @php
                                            $jadwal = [];
                                            if ($item->pagi ?? false) {
                                                $jadwal[] = ['label' => 'Pagi', 'color' => '#f59e0b'];
                                            }
                                            if ($item->siang ?? false) {
                                                $jadwal[] = ['label' => 'Siang', 'color' => '#3b82f6'];
                                            }
                                            if ($item->sore ?? false) {
                                                $jadwal[] = ['label' => 'Sore', 'color' => '#f97316'];
                                            }
                                            if ($item->malam ?? false) {
                                                $jadwal[] = ['label' => 'Malam', 'color' => '#8b5cf6'];
                                            }
                                        @endphp
                                        @if (!empty($jadwal))
                                            <div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:6px;">
                                                @foreach ($jadwal as $j)
                                                    <span
                                                        style="
                            display:inline-flex;align-items:center;gap:4px;
                            font-size:11px;font-weight:600;
                            padding:2px 8px;border-radius:20px;
                            background:{{ $j['color'] }}22;
                            color:{{ $j['color'] }};
                            border:1px solid {{ $j['color'] }}44;
                        ">●
                                                        {{ $j['label'] }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Keterangan tambahan --}}
                                        @if ($item->keterangan ?? false)
                                            <div style="font-size:11px;color:var(--text-muted);font-style:italic;">
                                                ℹ {{ $item->keterangan }}
                                            </div>
                                        @endif

                                        {{-- Kalau semua kosong --}}
                                        @if (!($item->signa ?? false) && empty($jadwal) && !($item->keterangan ?? false))
                                            <span style="font-size:11px;color:var(--text-muted);">—</span>
                                        @endif
                                    </td>

                                    <td>Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="total-section">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($resep->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="total-row grand">
                            <span>Total Harga</span>
                            <span class="amount">Rp {{ number_format($resep->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- KANAN --}}
        <div>
            {{-- Aksi --}}
            {{-- Aksi --}}
            <div class="side-info">
                <div class="side-header">
                    <div class="side-title">Aksi</div>
                </div>
                <div class="side-body">

                    @if ($resep->status === 'menunggu')
                        <a href="{{ config('app.kasir_url', 'http://127.0.0.1:8001') }}/kasir/dari-resep/{{ $resep->id }}"
                            class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <line x1="2" y1="10" x2="22" y2="10" />
                            </svg>
                            💳 Proses Pembayaran
                        </a>

                        <a href="{{ route('kasir.resep.edit', $resep->id) }}" class="btn btn-amber"
                            style="width:100%;justify-content:center;margin-bottom:10px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit Resep
                        </a>

                        <form method="POST" action="{{ route('kasir.resep.destroy', $resep->id) }}"
                            onsubmit="return confirm('Yakin hapus resep ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">
                                <svg width="14" height="14" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                </svg>
                                Hapus Resep
                            </button>
                        </form>
                    @elseif ($resep->status === 'selesai')
                        <a href="{{ route('kasir.struk.index') }}" class="btn btn-secondary"
                            style="width:100%;justify-content:center;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M17 3H7a2 2 0 00-2 2v16l3-2 2 2 2-2 2 2 2-2 3 2V5a2 2 0 00-2-2z" />
                            </svg>
                            Cetak Struk
                        </a>
                    @endif

                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="side-info">
                <div class="side-header">
                    <div class="side-title">Ringkasan</div>
                </div>
                <div class="side-body">
                    <div class="side-row">
                        <span class="side-label">Status</span>
                        <span class="status-pill {{ $resep->status ?? 'menunggu' }}" style="margin-top:4px;">
                            {{ ucfirst($resep->status ?? 'menunggu') }}
                        </span>
                    </div>
                    <div class="side-row">
                        <span class="side-label">Jumlah Item</span>
                        <span class="side-val">{{ $resep->items->count() }} obat</span>
                    </div>
                    <div class="side-row">
                        <span class="side-label">Total Unit</span>
                        <span class="side-val">{{ $resep->items->sum('jumlah') }} unit</span>
                    </div>
                    <div class="side-row">
                        <span class="side-label">Total Harga</span>
                        <span class="side-val mono">Rp {{ number_format($resep->total_harga ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="side-row">
                        <span class="side-label">Dibuat</span>
                        <span class="side-val" style="font-size:13px;">
                            {{ \Carbon\Carbon::parse($resep->created_at)->translatedFormat('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
