@extends('layouts.manager')

@section('title', 'Monitoring Stok')
@section('page_title', 'Monitoring Stok Obat')
@section('page_subtitle', 'Pantau kondisi stok seluruh obat di klinik')

@push('styles')
    <style>
        /* ── Summary Strip ── */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .strip-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 13px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .strip-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .strip-val {
            font-size: 20px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1;
        }

        .strip-lbl {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 2px;
        }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
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

        .filter-search {
            position: relative;
            margin-left: auto;
        }

        .filter-search i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: var(--color-text-hint);
            pointer-events: none;
        }

        .filter-search input {
            padding: 6px 12px 6px 30px;
            border: 1px solid var(--color-border-strong);
            border-radius: var(--radius-md);
            font-size: 12px;
            background: var(--color-card-bg);
            color: var(--color-text-main);
            width: 210px;
            outline: none;
        }

        .filter-search input:focus {
            border-color: var(--color-primary);
        }

        /* ── Stok Table ── */
        .stok-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .stok-table thead th {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            text-align: left;
            padding: 7px 12px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .stok-table tbody td {
            padding: 10px 12px;
            color: var(--color-text-muted);
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
        }

        .stok-table tbody tr:last-child td {
            border-bottom: none;
        }

        .stok-table tbody tr:hover td {
            background: var(--color-content-bg);
        }

        .drug-name {
            font-weight: 600;
            color: var(--color-text-main);
            font-size: 13px;
        }

        .drug-dosis {
            font-size: 10px;
            color: var(--color-text-hint);
            margin-top: 1px;
        }

        .stok-bar-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 140px;
        }

        .stok-bar {
            flex: 1;
            height: 6px;
            background: var(--color-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .stok-bar-fill {
            height: 100%;
            border-radius: 99px;
        }

        .stok-bar-fill.ok {
            background: #1D9E75;
        }

        .stok-bar-fill.warn {
            background: #BA7517;
        }

        .stok-bar-fill.danger {
            background: #E24B4A;
        }

        .stok-num {
            font-size: 12px;
            font-weight: 600;
            min-width: 30px;
            text-align: right;
            color: var(--color-text-main);
        }

        .exp-ok {
            color: var(--color-text-muted);
            font-size: 12px;
        }

        .exp-warn {
            color: #854F0B;
            font-weight: 600;
            font-size: 12px;
        }

        .exp-danger {
            color: #A32D2D;
            font-weight: 600;
            font-size: 12px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .pill i {
            font-size: 10px;
        }

        .pill-ok {
            background: var(--color-success-bg);
            color: var(--color-success-text);
        }

        .pill-warn {
            background: var(--color-warning-bg);
            color: var(--color-warning-text);
        }

        .pill-danger {
            background: var(--color-danger-bg);
            color: var(--color-danger-text);
        }

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

        .empty-state {
            text-align: center;
            padding: 40px 24px;
            color: var(--color-text-hint);
            font-size: 12px;
        }

        .empty-state i {
            font-size: 36px;
            display: block;
            margin-bottom: 8px;
        }

        .pagination-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 14px;
            font-size: 12px;
            color: var(--color-text-muted);
        }

        @media (max-width: 1024px) {
            .summary-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .summary-strip {
                grid-template-columns: 1fr 1fr;
            }

            .filter-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-search {
                margin-left: 0;
                width: 100%;
            }

            .filter-search input {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── SUMMARY STRIP ── --}}
    <div class="summary-strip">
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-success-bg);color:var(--color-success-text)">
                <i class="ti ti-pill"></i>
            </div>
            <div>
                <div class="strip-val">{{ $totalJenis }}</div>
                <div class="strip-lbl">Total Jenis Obat</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-info-bg);color:var(--color-info-text)">
                <i class="ti ti-stack"></i>
            </div>
            <div>
                <div class="strip-val">{{ number_format($totalUnit) }}</div>
                <div class="strip-lbl">Total Unit Stok</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-warning-bg);color:var(--color-warning-text)">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <div>
                <div class="strip-val" style="{{ $stokRendah > 0 ? 'color:#BA7517' : '' }}">
                    {{ $stokRendah }}
                </div>
                <div class="strip-lbl">Stok Rendah</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-danger-bg);color:var(--color-danger-text)">
                <i class="ti ti-calendar-x"></i>
            </div>
            <div>
                <div class="strip-val" style="{{ $mendekatiExp > 0 ? 'color:#A32D2D' : '' }}">
                    {{ $mendekatiExp }}
                </div>
                <div class="strip-lbl">Mendekati Expired</div>
            </div>
        </div>
    </div>

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('manager.stok') }}">
        <div class="filter-bar">

            <select name="jenis" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                @foreach ($jenisObat as $j)
                    <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Aman</option>
                <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                <option value="kritis" {{ request('status') == 'kritis' ? 'selected' : '' }}>Kritis</option>
                <option value="exp" {{ request('status') == 'exp' ? 'selected' : '' }}>Mendekati Exp</option>
            </select>

            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="nama" {{ request('sort', 'nama') == 'nama' ? 'selected' : '' }}>Urut: Nama</option>
                <option value="stok_asc" {{ request('sort') == 'stok_asc' ? 'selected' : '' }}>Urut: Stok ↑
                </option>
                <option value="stok_desc" {{ request('sort') == 'stok_desc' ? 'selected' : '' }}>Urut: Stok ↓
                </option>
                <option value="exp" {{ request('sort') == 'exp' ? 'selected' : '' }}>Urut: Exp. Terdekat
                </option>
            </select>

            <div class="filter-search">
                <i class="ti ti-search"></i>
                <input type="text" name="q" placeholder="Cari nama obat..." value="{{ request('q') }}">
            </div>

        </div>
    </form>

    {{-- ── STOK TABLE ── --}}
    <div class="section-label">Daftar stok obat</div>
    <div class="card" style="padding:0; overflow:hidden">

        @if ($stokList->isEmpty())
            <div class="empty-state">
                <i class="ti ti-inbox"></i>
                Tidak ada data stok ditemukan
            </div>
        @else
            <table class="stok-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Jenis</th>
                        <th>Batch</th>
                        <th style="width:190px">Stok Tersedia</th>
                        <th>Min. Stok</th>
                        <th>Expired</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stokList as $item)
                        @php
                            $pct = $item->stok_maks > 0 ? min(100, round(($item->jumlah / $item->stok_maks) * 100)) : 0;
                            $barClass = match (true) {
                                $pct >= 50 => 'ok',
                                $pct >= 25 => 'warn',
                                default => 'danger',
                            };
                            $isKritis = $item->jumlah <= ($item->stok_minimum ?? 0);
                            $isRendah = $item->jumlah <= ($item->stok_minimum ?? 0) * 2 && !$isKritis;
                            $statusClass = match (true) {
                                $item->jumlah <= 0 => 'pill-danger',
                                $isKritis => 'pill-danger',
                                $isRendah => 'pill-warn',
                                default => 'pill-ok',
                            };
                            $statusLabel = match (true) {
                                $item->jumlah <= 0 => 'Habis',
                                $isKritis => 'Kritis',
                                $isRendah => 'Rendah',
                                default => 'Aman',
                            };
                            $expDate = $item->tanggal_kadaluarsa
                                ? \Carbon\Carbon::parse($item->tanggal_kadaluarsa)
                                : null;
                            $expDays = $expDate ? now()->diffInDays($expDate, false) : null;
                            $expClass = match (true) {
                                $expDays === null => 'exp-ok',
                                $expDays < 0 => 'exp-danger',
                                $expDays <= 30 => 'exp-danger',
                                $expDays <= 90 => 'exp-warn',
                                default => 'exp-ok',
                            };
                            $expLabel = match (true) {
                                $expDays === null => '-',
                                $expDays < 0 => 'Sudah expired',
                                $expDays <= 90 => $expDate->format('d M Y') . ' (' . $expDays . ' hr)',
                                default => $expDate->format('d M Y'),
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="drug-name">{{ $item->nama_obat }}</div>
                                <div class="drug-dosis">{{ $item->nama_merek . ' ' . $item->dosis_mg . 'mg' }}</div>
                            </td>
                            <td>{{ $item->jenis }}</td>
                            <td style="font-size:11px; font-family:monospace; color:var(--color-text-hint)">
                                {{ $item->no_batch ?? '-' }}
                            </td>
                            <td>
                                <div class="stok-bar-wrap">
                                    <div class="stok-bar">
                                        <div class="stok-bar-fill {{ $barClass }}" style="width:{{ $pct }}%">
                                        </div>
                                    </div>
                                    <span class="stok-num">{{ number_format($item->jumlah) }}</span>
                                </div>
                            </td>
                            <td style="font-size:12px; font-weight:600">
                                {{ number_format($item->stok_minimum ?? 0) }}
                            </td>
                            <td class="{{ $expClass }}">{{ $expLabel }}</td>
                            <td>
                                <span class="pill {{ $statusClass }}">
                                    @if ($statusClass === 'pill-ok')
                                        <i class="ti ti-circle-check"></i>
                                    @elseif($statusClass === 'pill-warn')
                                        <i class="ti ti-alert-triangle"></i>
                                    @else
                                        <i class="ti ti-alert-circle"></i>
                                    @endif
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if ($stokList->hasPages())
        <div class="pagination-wrap">
            <span>
                Menampilkan {{ $stokList->firstItem() }}–{{ $stokList->lastItem() }}
                dari {{ $stokList->total() }} obat
            </span>
            {{ $stokList->withQueryString()->links() }}
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        const q = document.querySelector('input[name="q"]');
        if (q) {
            q.addEventListener('keydown', e => {
                if (e.key === 'Enter') e.target.form.submit();
            });
        }
    </script>
@endpush
