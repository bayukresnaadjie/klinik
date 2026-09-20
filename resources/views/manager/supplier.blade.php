@extends('layouts.manager')

@section('title', 'Supplier')
@section('page_title', 'Manajemen Supplier')
@section('page_subtitle', 'Pantau dan kelola daftar supplier obat klinik')

@push('styles')
    <style>
        /* ── Summary Strip ── */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
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
            width: 220px;
            outline: none;
        }

        .filter-search input:focus {
            border-color: var(--color-primary);
        }

        /* ── Supplier Grid ── */
        .supplier-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .supplier-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 16px;
            transition: border-color .15s, box-shadow .15s;
            position: relative;
            overflow: hidden;
        }

        .supplier-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .supplier-card.aktif::after {
            background: var(--color-primary);
        }

        .supplier-card.nonaktif::after {
            background: var(--color-border-strong);
        }

        .supplier-card:hover {
            border-color: var(--color-border-strong);
            box-shadow: var(--shadow-sm);
        }

        .supplier-head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .supplier-logo {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .supplier-logo.nonaktif {
            background: var(--color-content-bg);
            color: var(--color-text-hint);
        }

        .supplier-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-main);
            line-height: 1.3;
        }

        .supplier-kota {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .supplier-kota i {
            font-size: 12px;
        }

        .supplier-divider {
            height: 1px;
            background: var(--color-border);
            margin: 12px 0;
        }

        .supplier-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }

        .supplier-stat {
            padding: 8px 10px;
            background: var(--color-content-bg);
            border-radius: var(--radius-md);
        }

        .supplier-stat-val {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text-main);
        }

        .supplier-stat-lbl {
            font-size: 10px;
            color: var(--color-text-hint);
            margin-top: 2px;
        }

        .supplier-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .supplier-meta-row {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            color: var(--color-text-muted);
        }

        .supplier-meta-row i {
            font-size: 13px;
            color: var(--color-text-hint);
            flex-shrink: 0;
        }

        .supplier-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid var(--color-border);
        }

        /* ── Rating Stars ── */
        .rating-wrap {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .star {
            font-size: 12px;
            color: #d1d5db;
        }

        .star.filled {
            color: #BA7517;
        }

        .rating-val {
            font-size: 11px;
            font-weight: 600;
            color: var(--color-text-muted);
            margin-left: 3px;
        }

        /* ── Pill ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
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

        .pill-info {
            background: var(--color-info-bg);
            color: var(--color-info-text);
        }

        .pill-muted {
            background: var(--color-content-bg);
            color: var(--color-text-hint);
            border: 1px solid var(--color-border);
        }

        /* ── Riwayat Table ── */
        .riwayat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .riwayat-table thead th {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: var(--color-text-hint);
            text-align: left;
            padding: 7px 14px;
            border-bottom: 1px solid var(--color-border);
            white-space: nowrap;
        }

        .riwayat-table tbody td {
            padding: 9px 14px;
            color: var(--color-text-muted);
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
        }

        .riwayat-table tbody tr:last-child td {
            border-bottom: none;
        }

        .riwayat-table tbody tr:hover td {
            background: var(--color-content-bg);
        }

        .supplier-chip {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .supplier-chip-logo {
            width: 26px;
            height: 26px;
            border-radius: var(--radius-sm);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ── Section Label ── */
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

        /* ── Empty ── */
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

        @media (max-width: 1024px) {
            .summary-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .summary-strip {
                grid-template-columns: 1fr 1fr;
            }

            .supplier-grid {
                grid-template-columns: 1fr;
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
                <i class="ti ti-building-store"></i>
            </div>
            <div>
                <div class="strip-val">{{ $totalSupplier }}</div>
                <div class="strip-lbl">Total Supplier</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-info-bg);color:var(--color-info-text)">
                <i class="ti ti-circle-check"></i>
            </div>
            <div>
                <div class="strip-val">{{ $supplierAktif }}</div>
                <div class="strip-lbl">Supplier Aktif</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-warning-bg);color:var(--color-warning-text)">
                <i class="ti ti-truck-delivery"></i>
            </div>
            <div>
                <div class="strip-val">{{ $pengirimanBulanIni }}</div>
                <div class="strip-lbl">Pengiriman Bulan Ini</div>
            </div>
        </div>
        <div class="strip-card">
            <div class="strip-icon" style="background:var(--color-primary-light);color:var(--color-primary-dark)">
                <i class="ti ti-star"></i>
            </div>
            <div>
                <div class="strip-val">{{ number_format($ratingRataRata, 1) }}</div>
                <div class="strip-lbl">Rating Rata-Rata</div>
            </div>
        </div>
    </div>

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('manager.supplier') }}">
        <div class="filter-bar">

            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="nama" {{ request('sort', 'nama') == 'nama' ? 'selected' : '' }}>Urut: Nama</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Urut: Rating ↓</option>
                <option value="pengiriman"{{ request('sort') == 'pengiriman' ? 'selected' : '' }}>Urut: Pengiriman ↓
                </option>
            </select>

            <div class="filter-search">
                <i class="ti ti-search"></i>
                <input type="text" name="q" placeholder="Cari nama supplier..." value="{{ request('q') }}"
                    onkeydown="if(event.key==='Enter')this.form.submit()">
            </div>

        </div>
    </form>

    {{-- ── SUPPLIER GRID ── --}}
    <div class="section-label">Daftar supplier</div>

    @if ($supplierList->isEmpty())
        <div class="empty-state">
            <i class="ti ti-building-store"></i>
            Tidak ada supplier ditemukan
        </div>
    @else
        <div class="supplier-grid" id="supplierGrid">
            @foreach ($supplierList as $supplier)
                @php
                    $isAktif = $supplier->aktif ?? false;
                    $inisial = strtoupper(
                        collect(explode(' ', $supplier->nama))
                            ->take(2)
                            ->map(fn($w) => substr($w, 0, 1))
                            ->join(''),
                    );
                    $rating = round($supplier->rating ?? 0);
                @endphp
                <div class="supplier-card {{ $isAktif ? 'aktif' : 'nonaktif' }}"
                    data-search="{{ strtolower($supplier->nama . ' ' . $supplier->kota) }}">

                    <div class="supplier-head">
                        <div class="supplier-logo {{ $isAktif ? '' : 'nonaktif' }}">
                            {{ $inisial }}
                        </div>
                        <div style="flex:1; min-width:0">
                            <div class="supplier-name">{{ $supplier->nama }}</div>
                            <div class="supplier-kota">
                                <i class="ti ti-map-pin"></i>
                                {{ $supplier->kota ?? 'Kota tidak diketahui' }}
                            </div>
                        </div>
                        <span class="pill {{ $isAktif ? 'pill-ok' : 'pill-muted' }}">
                            {{ $isAktif ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <div class="supplier-stats">
                        <div class="supplier-stat">
                            <div class="supplier-stat-val">{{ $supplier->total_item_supplied ?? 0 }}</div>
                            <div class="supplier-stat-lbl">Item Disuplai</div>
                        </div>
                        <div class="supplier-stat">
                            <div class="supplier-stat-val">{{ $supplier->total_pengiriman ?? 0 }}</div>
                            <div class="supplier-stat-lbl">Total Pengiriman</div>
                        </div>
                    </div>

                    <div class="supplier-meta">
                        @if ($supplier->kontak)
                            <div class="supplier-meta-row">
                                <i class="ti ti-phone"></i>
                                {{ $supplier->kontak }}
                            </div>
                        @endif
                        @if ($supplier->email)
                            <div class="supplier-meta-row">
                                <i class="ti ti-mail"></i>
                                {{ $supplier->email }}
                            </div>
                        @endif
                        @if ($supplier->alamat)
                            <div class="supplier-meta-row">
                                <i class="ti ti-map"></i>
                                {{ Str::limit($supplier->alamat, 45) }}
                            </div>
                        @endif
                        @if ($supplier->pengiriman_terakhir)
                            <div class="supplier-meta-row">
                                <i class="ti ti-truck-delivery"></i>
                                Pengiriman terakhir:
                                {{ \Carbon\Carbon::parse($supplier->pengiriman_terakhir)->translatedFormat('d M Y') }}
                            </div>
                        @endif
                    </div>

                    <div class="supplier-footer">
                        <div class="rating-wrap">
                            @for ($s = 1; $s <= 5; $s++)
                                <i
                                    class="ti ti-star{{ $s <= $rating ? '-filled' : '' }} star {{ $s <= $rating ? 'filled' : '' }}"></i>
                            @endfor
                            <span class="rating-val">{{ number_format($supplier->rating ?? 0, 1) }}</span>
                        </div>
                        <span
                            class="pill {{ match (true) {
                                ($supplier->rating ?? 0) >= 4 => 'pill-ok',
                                ($supplier->rating ?? 0) >= 2.5 => 'pill-warn',
                                default => 'pill-danger',
                            } }}">
                            {{ match (true) {
                                ($supplier->rating ?? 0) >= 4 => 'Sangat Baik',
                                ($supplier->rating ?? 0) >= 2.5 => 'Cukup',
                                default => 'Perlu Evaluasi',
                            } }}
                        </span>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

    {{-- ── TOMBOL + MODAL CATAT PENGIRIMAN ── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <div class="section-label" style="margin:0;flex:1">Catat pengiriman baru</div>
        <button onclick="document.getElementById('modal-pengiriman').style.display='flex'"
            style="display:inline-flex;align-items:center;gap:6px;
               background:var(--color-primary);color:#fff;border:none;
               border-radius:var(--radius-md);padding:8px 14px;
               font-size:12.5px;font-weight:600;cursor:pointer;font-family:inherit">
            <i class="ti ti-plus"></i> Catat Pengiriman
        </button>
    </div>

    {{-- Modal --}}
    <div id="modal-pengiriman"
        style="display:none;position:fixed;inset:0;z-index:9999;
           background:rgba(0,0,0,.45);backdrop-filter:blur(3px);
           align-items:center;justify-content:center;padding:16px">

        <div
            style="background:var(--color-card-bg);border-radius:var(--radius-lg);
                width:100%;max-width:520px;box-shadow:0 20px 60px rgba(0,0,0,.15);
                overflow:hidden">

            {{-- Modal Header --}}
            <div
                style="padding:16px 20px;border-bottom:1px solid var(--color-border);
                    display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:10px">
                    <div
                        style="width:34px;height:34px;border-radius:var(--radius-md);
                            background:var(--color-primary-light);color:var(--color-primary-dark);
                            display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-truck-delivery" style="font-size:16px"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:var(--color-text-main)">
                            Catat Pengiriman Baru
                        </div>
                        <div style="font-size:11px;color:var(--color-text-muted);margin-top:1px">
                            Data akan disimpan ke riwayat pengiriman
                        </div>
                    </div>
                </div>
                <button onclick="document.getElementById('modal-pengiriman').style.display='none'"
                    style="background:none;border:none;cursor:pointer;
                       color:var(--color-text-hint);font-size:20px;
                       display:flex;align-items:center;padding:4px">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <form method="POST" action="{{ route('manager.supplier.pengiriman.store') }}">
                @csrf
                <div style="padding:20px;display:flex;flex-direction:column;gap:14px">

                    {{-- Supplier --}}
                    <div style="position:relative">
                        <input type="hidden" name="supplier_id" id="supplier_id_input">
                        <div id="supplier-selected" onclick="toggleDropdown()"
                            style="width:100%;font-size:13px;padding:8px 12px;
               border:1px solid var(--color-border);border-radius:var(--radius-md);
               background:var(--color-content-bg);color:var(--color-text-muted);
               cursor:pointer;display:flex;align-items:center;justify-content:space-between;
               user-select:none">
                            <span id="supplier-label">-- Pilih Supplier --</span>
                            <i class="ti ti-chevron-down" style="font-size:14px"></i>
                        </div>

                        <div id="supplier-dropdown"
                            style="display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;
               background:var(--color-card-bg);border:1px solid var(--color-border);
               border-radius:var(--radius-md);box-shadow:0 8px 24px rgba(0,0,0,.1);
               z-index:100;overflow:hidden;max-height:200px;overflow-y:auto">
                            @foreach ($supplierList as $s)
                                <div onclick="selectSupplier('{{ $s->id_supplier }}', '{{ $s->nama }}')"
                                    style="padding:10px 14px;cursor:pointer;font-size:13px;
                   display:flex;align-items:center;gap:10px;
                   transition:background .1s;border-bottom:1px solid var(--color-border)"
                                    onmouseover="this.style.background='var(--color-content-bg)'"
                                    onmouseout="this.style.background=''">
                                    <div
                                        style="width:28px;height:28px;border-radius:var(--radius-sm);
                        background:var(--color-primary-light);color:var(--color-primary-dark);
                        font-size:10px;font-weight:700;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0">
                                        {{ strtoupper(substr($s->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:var(--color-text-main)">{{ $s->nama }}
                                        </div>
                                        <div style="font-size:10px;color:var(--color-text-muted)">{{ $s->kota }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div>
                            <label
                                style="font-size:12px;font-weight:600;color:var(--color-text-muted);
                                       display:block;margin-bottom:5px">
                                Tanggal Kirim <span style="color:var(--color-danger-text)">*</span>
                            </label>
                            <input type="date" name="tanggal_kirim" required
                                value="{{ old('tanggal_kirim', date('Y-m-d')) }}"
                                style="width:100%;font-size:13px;padding:8px 12px;
                                   border:1px solid var(--color-border);border-radius:var(--radius-md);
                                   background:var(--color-content-bg);color:var(--color-text-main);
                                   outline:none;font-family:inherit">
                        </div>
                        <div>
                            <label
                                style="font-size:12px;font-weight:600;color:var(--color-text-muted);
                                       display:block;margin-bottom:5px">
                                Tanggal Terima
                                <span style="font-weight:400;font-style:italic">(opsional)</span>
                            </label>
                            <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima') }}"
                                style="width:100%;font-size:13px;padding:8px 12px;
                                   border:1px solid var(--color-border);border-radius:var(--radius-md);
                                   background:var(--color-content-bg);color:var(--color-text-main);
                                   outline:none;font-family:inherit">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            style="font-size:12px;font-weight:600;color:var(--color-text-muted);
                                   display:block;margin-bottom:5px">
                            Status <span style="color:var(--color-danger-text)">*</span>
                        </label>
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px">
                            @foreach ([['value' => 'dikirim', 'emoji' => '🚚', 'label' => 'Dikirim', 'bg' => '#FEF3C7', 'color' => '#92400E'], ['value' => 'diterima', 'emoji' => '✔', 'label' => 'Diterima', 'bg' => '#DCFCE7', 'color' => '#166534'], ['value' => 'dibatalkan', 'emoji' => '✕', 'label' => 'Dibatalkan', 'bg' => '#FEE2E2', 'color' => '#991B1B']] as $opt)
                                <label style="cursor:pointer">
                                    <input type="radio" name="status" value="{{ $opt['value'] }}"
                                        {{ old('status', 'dikirim') === $opt['value'] ? 'checked' : '' }}
                                        style="display:none" class="status-radio">
                                    <div class="status-option" data-value="{{ $opt['value'] }}"
                                        style="padding:10px 8px;border:2px solid var(--color-border);
                                       border-radius:var(--radius-md);text-align:center;
                                       transition:all .15s;
                                       {{ old('status', 'dikirim') === $opt['value'] ? 'border-color:' . $opt['color'] . ';background:' . $opt['bg'] : '' }}">
                                        <div style="font-size:18px">{{ $opt['emoji'] }}</div>
                                        <div
                                            style="font-size:11px;font-weight:600;margin-top:3px;
                                            color:var(--color-text-main)">
                                            {{ $opt['label'] }}
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label
                            style="font-size:12px;font-weight:600;color:var(--color-text-muted);
                                   display:block;margin-bottom:5px">
                            Keterangan
                            <span style="font-weight:400;font-style:italic">(opsional)</span>
                        </label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                            placeholder="Contoh: Pengiriman obat generik batch Q2..."
                            style="width:100%;font-size:13px;padding:8px 12px;
                               border:1px solid var(--color-border);border-radius:var(--radius-md);
                               background:var(--color-content-bg);color:var(--color-text-main);
                               outline:none;font-family:inherit">
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div
                    style="padding:14px 20px;border-top:1px solid var(--color-border);
                        display:flex;align-items:center;justify-content:flex-end;gap:8px">
                    <button type="button" onclick="document.getElementById('modal-pengiriman').style.display='none'"
                        style="padding:8px 16px;border:1px solid var(--color-border);
                           border-radius:var(--radius-md);background:var(--color-card-bg);
                           color:var(--color-text-muted);font-size:13px;font-weight:500;
                           cursor:pointer;font-family:inherit">
                        Batal
                    </button>
                    <button type="submit"
                        style="display:inline-flex;align-items:center;gap:6px;
                           background:var(--color-primary);color:#fff;border:none;
                           border-radius:var(--radius-md);padding:8px 18px;
                           font-size:13px;font-weight:600;cursor:pointer;font-family:inherit">
                        <i class="ti ti-check"></i> Simpan Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- ── RIWAYAT PENGIRIMAN ── --}}
    <div id="riwayat" class="section-label" style="margin-top:24px">
        Riwayat pengiriman terbaru
    </div>
    <div class="card" style="padding:0;overflow:hidden">
        @if ($riwayatPengiriman->isEmpty())
            <div class="empty-state" style="padding:32px">
                <i class="ti ti-inbox"></i>
                Belum ada riwayat pengiriman
            </div>
        @else
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Tanggal Kirim</th>
                        <th>Tanggal Terima</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPengiriman as $riwayat)
                        @php $badge = $riwayat->badgeConfig(); @endphp
                        <tr>
                            <td>
                                <div class="supplier-chip">
                                    <div class="supplier-chip-logo">
                                        {{ strtoupper(substr($riwayat->supplier->nama ?? 'S', 0, 2)) }}
                                    </div>
                                    <span style="font-weight:600;color:var(--color-text-main)">
                                        {{ $riwayat->supplier->nama ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td style="font-size:12px">
                                {{ $riwayat->tanggal_kirim->format('d M Y') }}
                            </td>
                            <td style="font-size:12px">
                                {{ $riwayat->tanggal_terima?->format('d M Y') ?? '-' }}
                            </td>
                            <td style="font-size:12px;color:var(--color-text-muted)">
                                {{ $riwayat->keterangan ?? '-' }}
                            </td>
                            <td>
                                <span class="pill" style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td style="font-size:12px;color:var(--color-text-muted)">
                                {{ $riwayat->createdBy->name ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if ($riwayatPengiriman->hasPages())
        <div style="display:flex;justify-content:flex-end;margin-top:14px">
            {{ $riwayatPengiriman->withQueryString()->links() }}
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        // Live search pada kartu supplier
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                document.querySelectorAll('#supplierGrid .supplier-card').forEach(card => {
                    card.style.display = card.dataset.search.includes(q) ? '' : 'none';
                });
            });
        }

        {{-- Status radio visual --}}
        document.querySelectorAll('.status-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const colors = {
                    'dikirim': {
                        border: '#92400E',
                        bg: '#FEF3C7'
                    },
                    'diterima': {
                        border: '#166534',
                        bg: '#DCFCE7'
                    },
                    'dibatalkan': {
                        border: '#991B1B',
                        bg: '#FEE2E2'
                    },
                };
                document.querySelectorAll('.status-option').forEach(opt => {
                    opt.style.borderColor = 'var(--color-border)';
                    opt.style.background = '';
                });
                const selected = document.querySelector(`.status-option[data-value="${this.value}"]`);
                if (selected && colors[this.value]) {
                    selected.style.borderColor = colors[this.value].border;
                    selected.style.background = colors[this.value].bg;
                }
            });
        });

        {{-- Tutup modal klik backdrop --}}
        document.getElementById('modal-pengiriman').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        function toggleDropdown() {
            const dd = document.getElementById('supplier-dropdown');
            dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
        }

        function selectSupplier(id, nama) {
            document.getElementById('supplier_id_input').value = id;
            document.getElementById('supplier-label').textContent = nama;
            document.getElementById('supplier-label').style.color = 'var(--color-text-main)';
            document.getElementById('supplier-dropdown').style.display = 'none';
        }

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('supplier-selected')?.closest('div[style*="position:relative"]');
            if (wrap && !wrap.contains(e.target)) {
                document.getElementById('supplier-dropdown').style.display = 'none';
            }
        });
    </script>
@endpush
