@extends('layouts.app')

@section('title', 'Manajemen Supplier')
@section('page-title', 'Manajemen Supplier')

@push('styles')
    <style>
        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-header-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .page-header-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--clr-blue);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
            box-shadow: 0 2px 6px rgba(59, 130, 246, .3);
        }

        .btn-add:hover {
            opacity: .88;
            color: #fff;
        }

        /* ── Stats Row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-card);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .stat-val {
            font-size: 22px;
            font-weight: 700;
            color: var(--tx-base);
            line-height: 1;
        }

        .stat-lbl {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ── Filter ── */
        .filter-bar {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 16px;
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: var(--shadow-card);
        }

        .filter-bar select,
        .filter-bar input {
            padding: 7px 11px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            color: var(--tx-base);
            background: var(--page-bg);
            outline: none;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .15s;
        }

        .filter-bar select:focus,
        .filter-bar input:focus {
            border-color: var(--clr-blue);
        }

        .filter-bar input {
            width: 240px;
        }

        .btn-search {
            padding: 7px 14px;
            background: var(--clr-blue);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            cursor: pointer;
            transition: opacity .15s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-search:hover {
            opacity: .85;
        }

        .btn-reset {
            padding: 7px 12px;
            background: none;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 12px;
            color: var(--tx-muted);
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-reset:hover {
            border-color: var(--clr-red);
            color: var(--clr-red);
        }

        /* ── Supplier Grid ── */
        .supplier-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .supplier-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            box-shadow: var(--shadow-card);
            transition: box-shadow .2s, border-color .2s;
            position: relative;
            overflow: hidden;
        }

        .supplier-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--clr-blue);
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .supplier-card.nonaktif::before {
            background: var(--border);
        }

        .supplier-card:hover {
            box-shadow: var(--shadow-hover);
            border-color: #CBD5E1;
        }

        /* Card head */
        .sc-head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .sc-logo {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: #EFF6FF;
            color: var(--clr-blue);
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sc-logo.nonaktif {
            background: var(--page-bg);
            color: var(--tx-sub);
        }

        .sc-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tx-base);
            line-height: 1.3;
        }

        .sc-kota {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        /* Badge */
        .badge-aktif {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: #DCFCE7;
            color: #166534;
        }

        .badge-nonaktif {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: #F3F4F6;
            color: #6B7280;
        }

        /* Divider */
        .sc-divider {
            height: 1px;
            background: var(--border);
            margin: 12px 0;
        }

        /* Info rows */
        .sc-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 12px;
        }

        .sc-info-row {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: var(--tx-muted);
        }

        .sc-info-row svg {
            flex-shrink: 0;
            color: var(--tx-sub);
        }

        /* Rating */
        .sc-rating {
            display: flex;
            align-items: center;
            gap: 2px;
            margin-bottom: 12px;
        }

        .star-f {
            color: #F59E0B;
            font-size: 14px;
        }

        .star-e {
            color: #E5E7EB;
            font-size: 14px;
        }

        .rating-num {
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-muted);
            margin-left: 5px;
        }

        .rating-label {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .rl-ok {
            background: #DCFCE7;
            color: #166534;
        }

        .rl-warn {
            background: #FEF3C7;
            color: #92400E;
        }

        .rl-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Actions */
        .sc-actions {
            display: flex;
            gap: 6px;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .sc-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 0;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: none;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--tx-muted);
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .sc-btn:hover {
            background: #EFF6FF;
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        .sc-btn.danger:hover {
            background: #FEE2E2;
            border-color: var(--clr-red);
            color: var(--clr-red);
        }

        .sc-btn.toggle-on:hover {
            background: #FEF3C7;
            border-color: var(--clr-yellow);
            color: #92400E;
        }

        .sc-btn.toggle-off:hover {
            background: #DCFCE7;
            border-color: var(--clr-green);
            color: #166534;
        }

        /* Empty */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 56px 24px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            color: var(--tx-sub);
        }

        .empty-state svg {
            display: block;
            margin: 0 auto 12px;
        }

        .empty-state p {
            font-size: 13px;
            margin-bottom: 14px;
        }

        /* Pagination info */
        .pagination-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: 1fr 1fr;
            }

            .supplier-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar input {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── HEADER ── --}}
    <div class="page-header">
        <div>
            <div class="page-header-title">Manajemen Supplier</div>
            <div class="page-header-sub">Kelola data supplier obat klinik</div>
        </div>
        <a href="{{ route('admin.supplier.create') }}" class="btn-add">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Tambah Supplier
        </a>
    </div>

    {{-- ── STATS ── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF;color:var(--clr-blue)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $suppliers->total() }}</div>
                <div class="stat-lbl">Total Supplier</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#DCFCE7;color:#166534">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $suppliers->where('aktif', true)->count() }}</div>
                <div class="stat-lbl">Supplier Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7;color:#92400E">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polygon
                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ number_format($suppliers->avg('rating'), 1) }}</div>
                <div class="stat-lbl">Rating Rata-rata</div>
            </div>
        </div>
    </div>

    {{-- ── FILTER ── --}}
    <form method="GET" action="{{ route('admin.supplier.index') }}">
        <div class="filter-bar">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            <input type="text" name="q" placeholder="Cari nama, kota, atau email..." value="{{ request('q') }}">
            <button type="submit" class="btn-search">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                Cari
            </button>
            @if (request('q') || request('status'))
                <a href="{{ route('admin.supplier.index') }}" class="btn-reset">✕ Reset</a>
            @endif
        </div>
    </form>

    {{-- ── SUPPLIER GRID ── --}}
    <div class="supplier-grid">
        @forelse($suppliers as $supplier)
            @php
                $rating = round($supplier->rating ?? 0);
                $isAktif = $supplier->aktif;
                $inisial = strtoupper(substr($supplier->nama, 0, 2));
                $rlClass = match (true) {
                    ($supplier->rating ?? 0) >= 4 => 'rl-ok',
                    ($supplier->rating ?? 0) >= 2.5 => 'rl-warn',
                    default => 'rl-danger',
                };
                $rlLabel = match (true) {
                    ($supplier->rating ?? 0) >= 4 => 'Sangat Baik',
                    ($supplier->rating ?? 0) >= 2.5 => 'Cukup',
                    default => 'Perlu Evaluasi',
                };
            @endphp
            <div class="supplier-card {{ $isAktif ? '' : 'nonaktif' }}">

                {{-- Head --}}
                <div class="sc-head">
                    <div class="sc-logo {{ $isAktif ? '' : 'nonaktif' }}">{{ $inisial }}</div>
                    <div style="flex:1; min-width:0">
                        <div class="sc-name">{{ $supplier->nama }}</div>
                        <div class="sc-kota">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $supplier->kota ?? 'Kota tidak diketahui' }}
                        </div>
                    </div>
                    @if ($isAktif)
                        <span class="badge-aktif">Aktif</span>
                    @else
                        <span class="badge-nonaktif">Non-Aktif</span>
                    @endif
                </div>

                {{-- Rating --}}
                <div class="sc-rating">
                    @for ($s = 1; $s <= 5; $s++)
                        <span class="{{ $s <= $rating ? 'star-f' : 'star-e' }}">★</span>
                    @endfor
                    <span class="rating-num">{{ number_format($supplier->rating ?? 0, 1) }}</span>
                    <span class="rating-label {{ $rlClass }}">{{ $rlLabel }}</span>
                </div>

                {{-- Info --}}
                <div class="sc-info">
                    @if ($supplier->kontak)
                        <div class="sc-info-row">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.37 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9a16 16 0 0 0 6.29 6.29l.87-.87a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            {{ $supplier->kontak }}
                        </div>
                    @endif
                    @if ($supplier->email)
                        <div class="sc-info-row">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            {{ $supplier->email }}
                        </div>
                    @endif
                    @if ($supplier->alamat)
                        <div class="sc-info-row">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            {{ Str::limit($supplier->alamat, 48) }}
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="sc-actions">
                    {{-- Toggle --}}
                    <form method="POST" action="{{ route('admin.supplier.toggle', $supplier->id_supplier) }}"
                        style="flex:1">
                        @csrf @method('PATCH')
                        <button type="submit" class="sc-btn {{ $isAktif ? 'toggle-on' : 'toggle-off' }}"
                            style="width:100%" title="{{ $isAktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                            @if ($isAktif)
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="6" y="4" width="4" height="16" />
                                    <rect x="14" y="4" width="4" height="16" />
                                </svg>
                                Nonaktifkan
                            @else
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3" />
                                </svg>
                                Aktifkan
                            @endif
                        </button>
                    </form>

                    {{-- Edit --}}
                    <a href="{{ route('admin.supplier.edit', $supplier->id_supplier) }}" class="sc-btn" style="flex:1">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>

                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('admin.supplier.destroy', $supplier->id_supplier) }}"
                        style="flex:1"
                        onsubmit="return confirm('Yakin hapus supplier {{ addslashes($supplier->nama) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="sc-btn danger" style="width:100%">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14H6L5 6" />
                                <path d="M10 11v6M14 11v6M9 6V4h6v2" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty-state">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB"
                    stroke-width="1.5">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <p>Belum ada supplier ditemukan</p>
                <a href="{{ route('admin.supplier.create') }}" class="btn-add" style="display:inline-flex">
                    Tambah Supplier Pertama
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($suppliers->hasPages())
        <div class="pagination-wrap">
            <span>
                Menampilkan {{ $suppliers->firstItem() }}–{{ $suppliers->lastItem() }}
                dari {{ $suppliers->total() }} supplier
            </span>
            {{ $suppliers->withQueryString()->links() }}
        </div>
    @endif

@endsection
