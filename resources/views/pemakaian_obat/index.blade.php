@extends('layouts.app')

@section('title', 'Pemakaian Obat')
@section('page-title', 'Pemakaian Obat')

@push('styles')
    <style>
        .po-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .po-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .po-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* Stat cards */
        .po-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .po-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .po-stat {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
        }

        .po-stat-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--tx-sub);
            margin-bottom: 8px;
        }

        .po-stat-value {
            font-family: 'Sora', sans-serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .po-stat-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 5px;
        }

        .po-stat-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        /* Filter */
        .po-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 14px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-card);
            flex-wrap: wrap;
        }

        .po-input,
        .po-select {
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            outline: none;
        }

        .po-input:focus,
        .po-select:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
        }

        .po-btn {
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
            text-decoration: none;
        }

        .po-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .po-btn-primary:hover {
            opacity: .88;
        }

        .po-btn-ghost {
            background: transparent;
            color: var(--tx-muted);
        }

        .po-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        .po-btn-green {
            background: #16a34a;
            color: #fff;
            border-color: #16a34a;
        }

        .po-btn-green:hover {
            opacity: .88;
        }

        .po-btn-red-soft {
            background: #FEE2E2;
            color: #991B1B;
            border-color: #FECACA;
        }

        .po-btn-red-soft:hover {
            background: #FECACA;
        }

        /* Panel */
        .po-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .po-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
            flex-wrap: wrap;
            gap: 8px;
        }

        .po-panel-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .po-count {
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            background: #EFF6FF;
            color: var(--clr-blue);
            font-weight: 600;
            border: 1px solid #BFDBFE;
        }

        /* Table */
        .po-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .po-tbl thead tr {
            background: #F9FAFB;
        }

        .po-tbl th {
            padding: 9px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            color: var(--tx-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .po-tbl td {
            padding: 10px 14px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .po-tbl tr:last-child td {
            border-bottom: none;
        }

        .po-tbl tbody tr:hover {
            background: #FAFAFA;
        }

        .po-tbl .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        .po-tbl .num {
            font-variant-numeric: tabular-nums;
            font-weight: 600;
        }

        .po-drug {
            font-weight: 600;
            font-size: 13px;
            color: var(--tx-base);
        }

        .po-drug-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .po-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .po-badge-blue {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }

        .po-badge-red {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .po-empty {
            padding: 48px 20px;
            text-align: center;
            color: var(--tx-sub);
            font-size: 12.5px;
        }

        .po-empty svg {
            display: block;
            margin: 0 auto 10px;
            opacity: .3;
        }

        .po-pager {
            padding: 12px 18px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .po-pager-info {
            font-size: 12px;
            color: var(--tx-muted);
        }

        .po-pager .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .po-pager .page-item .page-link {
            padding: 5px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: none;
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            color: var(--tx-muted);
            text-decoration: none;
            display: inline-block;
            line-height: 1.4;
            transition: all .15s;
        }

        .po-pager .page-item.active .page-link {
            background: var(--clr-blue);
            border-color: var(--clr-blue);
            color: #fff;
            font-weight: 600;
        }

        .po-pager .page-item:not(.active) .page-link:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        .po-pager .page-item.disabled .page-link {
            opacity: .35;
            cursor: default;
        }
    </style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="po-header">
        <div>
            <div class="po-title">Pemakaian Obat</div>
            <div class="po-sub">Riwayat dan pencatatan pemakaian obat</div>
        </div>
        <a href="{{ route('pemakaian-obat.create') }}" class="po-btn po-btn-green">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Catat Pemakaian
        </a>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div
            style="background:#DCFCE7;color:#166534;border:1px solid #BBF7D0;padding:10px 14px;border-radius:8px;font-size:12.5px;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:10px 14px;border-radius:8px;font-size:12.5px;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stat Cards --}}
    <div class="po-stats">

        {{-- Card 1: Total Pemakaian --}}
        <div class="po-stat">
            <div class="po-stat-label">Total Pemakaian</div>
            <div class="po-stat-value" style="color:var(--clr-blue);">{{ number_format($totalPemakaian ?? 0) }}</div>
            <div class="po-stat-sub">unit sepanjang waktu</div>
            <div class="po-stat-bar" style="background:var(--clr-blue);"></div>
        </div>

        {{-- Card 2: Bulan Ini --}}
        <div class="po-stat">
            <div class="po-stat-label">Bulan Ini</div>
            <div class="po-stat-value" style="color:#16a34a;">
                {{ number_format($pemakaianBulanIni ?? 0) }}
            </div>
            <div class="po-stat-sub">
                unit dipakai
                @if (($pemakaianBulanLalu ?? 0) > 0)
                    @php $selisih = ($pemakaianBulanIni ?? 0) - $pemakaianBulanLalu; @endphp
                    <span style="margin-left:4px;font-weight:600;color:{{ $selisih >= 0 ? '#16a34a' : '#dc2626' }}">
                        {{ $selisih >= 0 ? '↑' : '↓' }} {{ number_format(abs($selisih)) }} vs bln lalu
                    </span>
                @else
                    <span style="margin-left:4px;color:var(--tx-sub);">
                        (bln lalu: {{ number_format($pemakaianBulanLalu ?? 0) }})
                    </span>
                @endif
            </div>
            <div class="po-stat-bar" style="background:#16a34a;"></div>
        </div>

        {{-- Card 3: Nilai Bulan Ini --}}
        <div class="po-stat">
            <div class="po-stat-label">Nilai Bulan Ini</div>
            <div class="po-stat-value" style="color:var(--clr-purple);font-size:18px;">
                Rp {{ number_format($nilaiPemakaian ?? 0, 0, ',', '.') }}
            </div>
            <div class="po-stat-sub">
                estimasi harga
                @if (($nilaiPemakaianLalu ?? 0) > 0)
                    @php $selisihNilai = ($nilaiPemakaian ?? 0) - $nilaiPemakaianLalu; @endphp
                    <span style="margin-left:4px;font-weight:600;color:{{ $selisihNilai >= 0 ? '#16a34a' : '#dc2626' }}">
                        {{ $selisihNilai >= 0 ? '↑' : '↓' }}
                        Rp {{ number_format(abs($selisihNilai), 0, ',', '.') }}
                    </span>
                @else
                    <span style="margin-left:4px;color:var(--tx-sub);">
                        (bln lalu: Rp {{ number_format($nilaiPemakaianLalu ?? 0, 0, ',', '.') }})
                    </span>
                @endif
            </div>
            <div class="po-stat-bar" style="background:var(--clr-purple);"></div>
        </div>

        {{-- Card 4: Jenis Obat --}}
        <div class="po-stat">
            <div class="po-stat-label">Jenis Obat</div>
            <div class="po-stat-value" style="color:var(--clr-yellow);">{{ $jumlahJenis ?? 0 }}</div>
            <div class="po-stat-sub">varian bulan ini</div>
            <div class="po-stat-bar" style="background:var(--clr-yellow);"></div>
        </div>

    </div>{{-- /po-stats --}}

    {{-- Filter --}}
    <form method="GET" action="{{ route('pemakaian-obat.index') }}">
        <div class="po-filter">
            <input type="text" name="cari" class="po-input" placeholder="Cari obat / keterangan..."
                value="{{ request('cari') }}" style="width:200px;">
            <select name="jenis" class="po-select">
                <option value="semua">Semua Jenis</option>
                @foreach ($jenisObatList as $j)
                    <option value="{{ $j->id_jenis }}" {{ request('jenis') == $j->id_jenis ? 'selected' : '' }}>
                        {{ $j->nama_jenis }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="dari" class="po-input" value="{{ request('dari') }}">
            <span style="font-size:12px;color:var(--tx-muted);">s/d</span>
            <input type="date" name="sampai" class="po-input" value="{{ request('sampai') }}">
            <button type="submit" class="po-btn po-btn-primary">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" x2="16.65" y1="21" y2="16.65" />
                </svg>
                Filter
            </button>
            <a href="{{ route('pemakaian-obat.index') }}" class="po-btn po-btn-ghost">Reset</a>
            @if (request()->hasAny(['cari', 'jenis', 'dari', 'sampai']))
                <span style="font-size:11.5px;color:var(--tx-muted);margin-left:4px;">
                    Total filter: <strong>{{ number_format($totalJumlah) }}</strong> unit
                </span>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="po-panel">
        <div class="po-panel-header">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="po-panel-title">Riwayat Pemakaian</span>
                <span class="po-count">{{ $pemakaianList->total() }} record</span>
            </div>
            <a href="{{ route('laporan.pemakaian') }}" class="po-btn po-btn-primary"
                style="font-size:11.5px;padding:5px 12px;">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
                Lihat Laporan Lengkap
            </a>
        </div>

        @if ($pemakaianList->isEmpty())
            <div class="po-empty">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Belum ada data pemakaian
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="po-tbl">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Obat</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemakaianList as $i => $p)
                            <tr>
                                <td class="muted">
                                    {{ ($pemakaianList->currentPage() - 1) * $pemakaianList->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="po-drug">{{ $p->varianObat->nama_merek ?? '-' }}</div>
                                    <div class="po-drug-sub">
                                        {{ $p->varianObat->obat->nama_obat ?? '-' }}
                                        @if ($p->varianObat->dosis_mg)
                                            · {{ $p->varianObat->dosis_mg }}mg
                                        @endif
                                    </div>
                                </td>
                                <td class="muted">{{ \Carbon\Carbon::parse($p->tanggal_pakai)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="po-badge po-badge-blue">{{ number_format($p->jumlah_pakai) }} unit</span>
                                </td>
                                <td class="muted">{{ $p->keterangan ?: '-' }}</td>
                                <td>
                                    <form action="{{ route('pemakaian-obat.destroy', $p) }}" method="POST"
                                        onsubmit="return confirm('Batalkan pemakaian dan kembalikan stok?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="po-btn po-btn-red-soft"
                                            style="font-size:11px;padding:4px 10px;">
                                            Batal
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($pemakaianList->hasPages())
                <div class="po-pager">
                    <span class="po-pager-info">
                        Menampilkan {{ $pemakaianList->firstItem() }}–{{ $pemakaianList->lastItem() }}
                        dari {{ $pemakaianList->total() }} record
                    </span>
                    {{ $pemakaianList->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
