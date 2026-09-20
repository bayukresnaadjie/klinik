@extends('layouts.kasir')

@section('title', 'Buat Resep')
@section('page-title', 'Buat Resep')

@section('content')

    <style>
        .resep-wrap {
            max-width: 100%;
            padding-bottom: 40px;
        }

        .resep-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .resep-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            transition: all .15s;
        }

        .resep-back:hover {
            color: var(--text-primary);
            border-color: rgba(0, 200, 200, .3);
        }

        .resep-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
        }

        .resep-page-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .resep-page-sub {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .resep-step-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .step-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            border: 1.5px solid var(--border);
            color: var(--text-muted);
            background: var(--bg-card);
            transition: all .2s;
        }

        .step-dot.active {
            background: var(--accent-cyan);
            border-color: var(--accent-cyan);
            color: #0a1a1a;
        }

        .step-dot.done {
            background: rgba(0, 200, 200, .15);
            border-color: rgba(0, 200, 200, .4);
            color: var(--accent-cyan);
        }

        .step-line {
            width: 20px;
            height: 1.5px;
            background: var(--border);
            border-radius: 2px;
        }

        .resep-alert {
            background: rgba(239, 68, 68, .08);
            border: 1px solid rgba(239, 68, 68, .25);
            border-left: 3px solid #ef4444;
            color: #f87171;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .resep-alert ul {
            margin: 0;
            padding-left: 16px;
        }

        /* Section */
        .resep-section {
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--bg-card);
            margin-bottom: 16px;
            overflow: visible !important;
        }

        .resep-section:focus-within {
            border-color: rgba(0, 200, 200, .25);
        }

        .resep-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        .resep-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .section-icon.cyan {
            background: rgba(0, 200, 200, .12);
        }

        .section-icon.gold {
            background: rgba(201, 168, 76, .12);
        }

        .section-icon.purple {
            background: rgba(139, 92, 246, .12);
        }

        .resep-section-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .resep-section-body {
            padding: 20px;
            overflow: visible !important;
        }

        /* Fields */
        .field-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-grid-pasien {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            align-items: start;
        }

        /* Umur row */
        .umur-input-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .umur-input-row .field-input {
            width: 100px;
            flex-shrink: 0;
            text-align: center;
        }

        .umur-satuan-pills {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        .umur-pill {
            position: relative;
            cursor: pointer;
        }

        .umur-pill input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .umur-pill-body {
            display: block;
            padding: 9px 14px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 500;
            border: 1.5px solid var(--border);
            background: var(--bg-base);
            color: var(--text-muted);
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
            text-align: center;
        }

        .umur-pill input[type="radio"]:checked+.umur-pill-body {
            border-color: var(--accent-cyan);
            background: rgba(0, 200, 200, .1);
            color: var(--accent-cyan);
        }

        .umur-pill-body:hover {
            border-color: rgba(0, 200, 200, .3);
            color: var(--text-primary);
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .field-label span {
            color: var(--accent-cyan);
            margin-left: 2px;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            background: var(--bg-base);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 10px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 3px rgba(0, 200, 200, .08);
            background: rgba(0, 200, 200, .02);
        }

        .field-textarea {
            resize: vertical;
            min-height: 90px;
            line-height: 1.6;
        }

        /* Payment pills */
        .payment-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .payment-pill {
            position: relative;
            flex: 1;
            min-width: 80px;
            cursor: pointer;
        }

        .payment-pill input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .payment-pill-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            padding: 12px 10px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--bg-base);
            transition: all .18s;
            text-align: center;
            cursor: pointer;
        }

        .payment-pill input[type="radio"]:checked+.payment-pill-body {
            border-color: var(--accent-cyan);
            background: rgba(0, 200, 200, .07);
            box-shadow: 0 0 0 3px rgba(0, 200, 200, .08);
        }

        .payment-pill-icon {
            font-size: 18px;
        }

        .payment-pill-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Obat count badge & add btn */
        .obat-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 200, 200, .12);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 200, 200, .2);
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 10px;
            font-family: 'IBM Plex Mono', monospace;
        }

        .btn-tambah-obat {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 200, 200, .08);
            color: var(--accent-cyan);
            border: 1.5px dashed rgba(0, 200, 200, .3);
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all .15s;
        }

        .btn-tambah-obat:hover {
            background: rgba(0, 200, 200, .14);
            border-color: rgba(0, 200, 200, .5);
        }

        /* ── OBAT CARD ── */
        .obat-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--bg-base);
            margin-bottom: 12px;
            overflow: visible;
            animation: fadeIn .2s ease;
            position: relative;
        }

        .obat-card:last-child {
            margin-bottom: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .obat-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
        }

        .obat-card-num {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            font-family: 'IBM Plex Mono', monospace;
            letter-spacing: .05em;
        }

        .obat-remove-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: rgba(239, 68, 68, .08);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all .15s;
        }

        .obat-remove-btn:hover {
            background: rgba(239, 68, 68, .18);
            border-color: rgba(239, 68, 68, .4);
        }

        .obat-card-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Row 1: obat + jumlah + satuan */
        .obat-row-main {
            display: grid;
            grid-template-columns: 1fr 90px 120px;
            gap: 10px;
            align-items: end;
        }

        /* Row 2: sigmas */
        .obat-row-sigma {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Row 3: qty schedule (qty1, pagi, siang, sore, malam, qty2) */
        .obat-row-schedule {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
            align-items: end;
        }

        /* Row 4: keterangan pakai */
        .obat-row-ket {}

        .schedule-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .schedule-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--text-muted);
            text-align: center;
        }

        .schedule-label.pagi {
            color: #fbbf24;
        }

        .schedule-label.siang {
            color: #f97316;
        }

        .schedule-label.sore {
            color: #a78bfa;
        }

        .schedule-label.malam {
            color: #60a5fa;
        }

        .schedule-label.qty {
            color: var(--accent-cyan);
        }

        .field-input.center {
            text-align: center;
            padding-left: 8px;
            padding-right: 8px;
        }

        /* Sigma display */
        .sigma-display {
            font-size: 12px;
            color: var(--accent-cyan);
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            margin-top: 4px;
        }

        /* Custom select (same pattern as original) */
        .cs-wrap {
            position: relative;
            width: 100%;
        }

        .cs-trigger {
            width: 100%;
            background: var(--bg-base);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 10px 36px 10px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            transition: border-color .2s, box-shadow .2s;
            user-select: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            box-sizing: border-box;
        }

        .cs-trigger:hover {
            border-color: rgba(0, 200, 200, .3);
        }

        .cs-trigger.open {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 3px rgba(0, 200, 200, .08);
            border-radius: 9px 9px 0 0;
        }

        .cs-trigger-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cs-trigger-text.placeholder {
            color: var(--text-muted);
        }

        .cs-arrow {
            flex-shrink: 0;
            transition: transform .2s;
            color: var(--text-muted);
        }

        .cs-trigger.open .cs-arrow {
            transform: rotate(180deg);
        }

        .cs-panel {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-card);
            border: 1.5px solid var(--accent-cyan);
            border-top: none;
            border-radius: 0 0 10px 10px;
            z-index: 9999;
            display: none;
            flex-direction: column;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .3);
            overflow: hidden;
        }

        .cs-panel.open {
            display: flex;
        }

        .cs-search-wrap {
            padding: 8px 10px;
            border-bottom: 1px solid var(--border);
        }

        .cs-search {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 12px 7px 32px;
            color: var(--text-primary);
            font-size: 12px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .15s;
            box-sizing: border-box;
        }

        .cs-search:focus {
            border-color: rgba(0, 200, 200, .4);
        }

        .cs-search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .cs-search-relative {
            position: relative;
        }

        .cs-options {
            max-height: 200px;
            overflow-y: auto;
        }

        .cs-options::-webkit-scrollbar {
            width: 4px;
        }

        .cs-options::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .1);
            border-radius: 4px;
        }

        .cs-option {
            padding: 9px 14px;
            font-size: 12.5px;
            color: var(--text-primary);
            cursor: pointer;
            transition: background .12s;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .cs-option:last-child {
            border-bottom: none;
        }

        .cs-option:hover {
            background: rgba(0, 200, 200, .07);
        }

        .cs-option.selected {
            background: rgba(0, 200, 200, .1);
            color: var(--accent-cyan);
        }

        .cs-option.placeholder-opt {
            color: var(--text-muted);
            font-style: italic;
        }

        .cs-option-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-cyan);
            flex-shrink: 0;
            opacity: 0;
        }

        .cs-option.selected .cs-option-dot {
            opacity: 1;
        }

        .cs-empty {
            padding: 14px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            display: none;
        }

        /* Footer */
        .resep-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-simpan {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-cyan);
            color: #0a1a1a;
            font-weight: 700;
            padding: 11px 28px;
            border-radius: 9px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            transition: all .18s;
        }

        .btn-simpan:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0, 200, 200, .25);
        }

        .btn-batal {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--bg-card);
            color: var(--text-secondary);
            border: 1px solid var(--border);
            padding: 11px 20px;
            border-radius: 9px;
            font-size: 13px;
            text-decoration: none;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-batal:hover {
            border-color: rgba(239, 68, 68, .3);
            color: #f87171;
        }

        .resep-hint {
            margin-left: auto;
            font-size: 11px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Sigma preview badge */
        .sigma-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 200, 200, .08);
            border: 1px solid rgba(0, 200, 200, .2);
            border-radius: 7px;
            padding: 6px 12px;
            font-size: 12px;
            color: var(--accent-cyan);
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            margin-top: 2px;
            min-height: 38px;
        }

        /* Separator inside card */
        .obat-row-sep {
            border: none;
            border-top: 1px dashed rgba(255, 255, 255, .06);
            margin: 0;
        }
    </style>

    <div class="resep-wrap">

        {{-- Breadcrumb --}}
        <div class="resep-breadcrumb">
            <a href="{{ route('kasir.resep.index') }}" class="resep-back">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Kembali ke Daftar Resep
            </a>
        </div>

        {{-- Page Header --}}
        <div class="resep-page-header">
            <div>
                <div class="resep-page-title">Buat Resep Baru</div>
                <div class="resep-page-sub">Isi data pasien dan pilih obat yang diresepkan</div>
            </div>
            <div class="resep-step-indicator">
                <div class="step-dot active">1</div>
                <div class="step-line"></div>
                <div class="step-dot">2</div>
                <div class="step-line"></div>
                <div class="step-dot">3</div>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="resep-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kasir.resep.store') }}">
            @csrf

            {{-- SECTION 1: Data Pasien --}}
            <div class="resep-section">
                <div class="resep-section-head">
                    <div class="resep-section-title">
                        <div class="section-icon cyan">👤</div>
                        <span class="resep-section-label">Data Pasien</span>
                    </div>
                </div>
                <div class="resep-section-body">
                    {{-- Baris 1: Nama Pasien + Umur | Jenis Pembayaran --}}
                    <div class="field-grid-pasien">
                        <div>
                            <div class="field-group">
                                <label class="field-label">Nama Pasien <span>*</span></label>
                                <input type="text" name="nama_pasien" value="{{ old('nama_pasien') }}"
                                    placeholder="Nama lengkap pasien" class="field-input" autocomplete="off">
                            </div>
                            <div class="field-group" style="margin-top:10px;">
                                <label class="field-label">Umur</label>
                                <div class="umur-input-row">
                                    <input type="number" name="umur" value="{{ old('umur') }}" placeholder="0"
                                        min="0" max="150" class="field-input">
                                    <div class="umur-satuan-pills">
                                        <label class="umur-pill">
                                            <input type="radio" name="satuan_umur" value="tahun"
                                                {{ old('satuan_umur', 'tahun') === 'tahun' ? 'checked' : '' }}>
                                            <span class="umur-pill-body">Tahun</span>
                                        </label>
                                        <label class="umur-pill">
                                            <input type="radio" name="satuan_umur" value="bulan"
                                                {{ old('satuan_umur') === 'bulan' ? 'checked' : '' }}>
                                            <span class="umur-pill-body">Bulan</span>
                                        </label>
                                        <label class="umur-pill">
                                            <input type="radio" name="satuan_umur" value="hari"
                                                {{ old('satuan_umur') === 'hari' ? 'checked' : '' }}>
                                            <span class="umur-pill-body">Hari</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Jenis Pembayaran</label>
                            <div class="payment-pills">
                                <label class="payment-pill">
                                    <input type="radio" name="jenis_pembayaran" value="umum"
                                        {{ old('jenis_pembayaran', 'umum') === 'umum' ? 'checked' : '' }}>
                                    <div class="payment-pill-body">
                                        <span class="payment-pill-icon">💵</span>
                                        <span class="payment-pill-name">Umum</span>
                                    </div>
                                </label>
                                <label class="payment-pill">
                                    <input type="radio" name="jenis_pembayaran" value="bpjs"
                                        {{ old('jenis_pembayaran') === 'bpjs' ? 'checked' : '' }}>
                                    <div class="payment-pill-body">
                                        <span class="payment-pill-icon">🏥</span>
                                        <span class="payment-pill-name">BPJS</span>
                                    </div>
                                </label>
                                <label class="payment-pill">
                                    <input type="radio" name="jenis_pembayaran" value="asuransi"
                                        {{ old('jenis_pembayaran') === 'asuransi' ? 'checked' : '' }}>
                                    <div class="payment-pill-body">
                                        <span class="payment-pill-icon">🛡️</span>
                                        <span class="payment-pill-name">Asuransi</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECTION 2: Daftar Obat --}}
            <div class="resep-section">
                <div class="resep-section-head">
                    <div class="resep-section-title">
                        <div class="section-icon gold">💊</div>
                        <span class="resep-section-label">Daftar Obat</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span class="obat-count-badge" id="obat-count">1 item</span>
                        <button type="button" onclick="tambahObat()" class="btn-tambah-obat">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Tambah Obat
                        </button>
                    </div>
                </div>
                <div class="resep-section-body">
                    <div id="obat-list">
                        {{-- Row pertama --}}
                        <div class="obat-card" id="obat-card-0">
                            <div class="obat-card-head">
                                <span class="obat-card-num">OBAT #1</span>
                            </div>
                            <div class="obat-card-body">

                                {{-- Baris 1: Nama Obat + Jumlah + Satuan --}}
                                <div class="obat-row-main">
                                    <div class="field-group">
                                        <label class="field-label">Nama Obat / Varian <span>*</span></label>
                                        <div class="cs-wrap" id="cs-wrap-0">
                                            <input type="hidden" name="items[0][id_varian]" id="cs-val-0">
                                            <div class="cs-trigger" id="cs-trigger-0" onclick="toggleCS(0)">
                                                <span class="cs-trigger-text placeholder" id="cs-text-0">— Pilih Obat
                                                    —</span>
                                                <svg class="cs-arrow" width="14" height="14" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <polyline points="6 9 12 15 18 9" />
                                                </svg>
                                            </div>
                                            <div class="cs-panel" id="cs-panel-0">
                                                <div class="cs-search-wrap">
                                                    <div class="cs-search-relative">
                                                        <svg class="cs-search-icon" width="13" height="13"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <circle cx="11" cy="11" r="8" />
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65" />
                                                        </svg>
                                                        <input class="cs-search" type="text"
                                                            placeholder="Cari obat..." oninput="filterCS(0, this.value)">
                                                    </div>
                                                </div>
                                                <div class="cs-options" id="cs-options-0">
                                                    <div class="cs-option placeholder-opt"
                                                        onclick="selectCS(0,'','— Pilih Obat —')">
                                                        <div class="cs-option-dot"></div>— Pilih Obat —
                                                    </div>
                                                    @foreach ($varian as $v)
                                                        <div class="cs-option" data-val="{{ $v->id_varian }}"
                                                            data-label="{{ $v->nama_merek }} {{ $v->dosis_mg }}mg — {{ $v->obat->nama_obat ?? '' }}"
                                                            onclick="selectCS(0,'{{ $v->id_varian }}','{{ $v->nama_merek }} {{ $v->dosis_mg }}mg — {{ $v->obat->nama_obat ?? '' }}')">
                                                            <div class="cs-option-dot"></div>
                                                            {{ $v->nama_merek }} {{ $v->dosis_mg }}mg
                                                            <span
                                                                style="color:var(--text-muted);font-size:11px;margin-left:auto;">{{ $v->obat->nama_obat ?? '' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="cs-empty" id="cs-empty-0">Tidak ada obat ditemukan</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Jumlah</label>
                                        <input type="number" name="items[0][jumlah]" value="1" min="1"
                                            class="field-input center" placeholder="Qty">
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Satuan</label>
                                        <div class="cs-wrap" id="cs-satuan-wrap-0">
                                            <input type="hidden" name="items[0][satuan]" id="cs-satuan-val-0">
                                            <div class="cs-trigger" id="cs-satuan-trigger-0" onclick="toggleCSatuan(0)">
                                                <span class="cs-trigger-text placeholder" id="cs-satuan-text-0">— Pilih
                                                    —</span>
                                                <svg class="cs-arrow" width="14" height="14" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <polyline points="6 9 12 15 18 9" />
                                                </svg>
                                            </div>
                                            <div class="cs-panel" id="cs-satuan-panel-0">
                                                <div class="cs-search-wrap">
                                                    <div class="cs-search-relative">
                                                        <svg class="cs-search-icon" width="13" height="13"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <circle cx="11" cy="11" r="8" />
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65" />
                                                        </svg>
                                                        <input class="cs-search" type="text"
                                                            placeholder="Cari satuan..."
                                                            oninput="filterCSatuan(0, this.value)">
                                                    </div>
                                                </div>
                                                <div class="cs-options" id="cs-satuan-options-0">
                                                    <div class="cs-option placeholder-opt"
                                                        onclick="selectCSatuan(0,'','— Pilih —')">
                                                        <div class="cs-option-dot"></div>— Pilih —
                                                    </div>
                                                    <div class="cs-option" data-val="tablet" data-label="Tablet"
                                                        onclick="selectCSatuan(0,'tablet','Tablet')">
                                                        <div class="cs-option-dot"></div>Tablet
                                                    </div>
                                                    <div class="cs-option" data-val="kapsul" data-label="Kapsul"
                                                        onclick="selectCSatuan(0,'kapsul','Kapsul')">
                                                        <div class="cs-option-dot"></div>Kapsul
                                                    </div>
                                                    <div class="cs-option" data-val="kaplet" data-label="Kaplet"
                                                        onclick="selectCSatuan(0,'kaplet','Kaplet')">
                                                        <div class="cs-option-dot"></div>Kaplet
                                                    </div>
                                                    <div class="cs-option" data-val="ml" data-label="mL"
                                                        onclick="selectCSatuan(0,'ml','mL')">
                                                        <div class="cs-option-dot"></div>mL
                                                    </div>
                                                    <div class="cs-option" data-val="botol" data-label="Botol"
                                                        onclick="selectCSatuan(0,'botol','Botol')">
                                                        <div class="cs-option-dot"></div>Botol
                                                    </div>
                                                    <div class="cs-option" data-val="sachet" data-label="Sachet"
                                                        onclick="selectCSatuan(0,'sachet','Sachet')">
                                                        <div class="cs-option-dot"></div>Sachet
                                                    </div>
                                                    <div class="cs-option" data-val="tube" data-label="Tube"
                                                        onclick="selectCSatuan(0,'tube','Tube')">
                                                        <div class="cs-option-dot"></div>Tube
                                                    </div>
                                                    <div class="cs-option" data-val="ampul" data-label="Ampul"
                                                        onclick="selectCSatuan(0,'ampul','Ampul')">
                                                        <div class="cs-option-dot"></div>Ampul
                                                    </div>
                                                    <div class="cs-option" data-val="suppositoria"
                                                        data-label="Suppositoria"
                                                        onclick="selectCSatuan(0,'suppositoria','Suppositoria')">
                                                        <div class="cs-option-dot"></div>Suppositoria
                                                    </div>
                                                    <div class="cs-option" data-val="patch" data-label="Patch"
                                                        onclick="selectCSatuan(0,'patch','Patch')">
                                                        <div class="cs-option-dot"></div>Patch
                                                    </div>
                                                </div>
                                                <div class="cs-empty" id="cs-satuan-empty-0">Tidak ditemukan</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="obat-row-sep">

                                {{-- Baris 2: Sigma 1 & Sigma 2 --}}
                                <div class="obat-row-sigma">
                                    <div class="field-group">
                                        <label class="field-label">Sigma 1 <span
                                                style="color:var(--text-muted);font-size:10px;font-weight:400;text-transform:none;">(berapa
                                                kali sehari)</span></label>
                                        <div class="cs-wrap" id="cs-s1-wrap-0">
                                            <input type="hidden" name="items[0][sigma1]" id="cs-s1-val-0">
                                            <div class="cs-trigger" id="cs-s1-trigger-0" onclick="toggleSigma(0,1)">
                                                <span class="cs-trigger-text placeholder" id="cs-s1-text-0">— Frekuensi
                                                    —</span>
                                                <svg class="cs-arrow" width="14" height="14" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <polyline points="6 9 12 15 18 9" />
                                                </svg>
                                            </div>
                                            <div class="cs-panel" id="cs-s1-panel-0">
                                                <div class="cs-search-wrap">
                                                    <div class="cs-search-relative">
                                                        <svg class="cs-search-icon" width="13" height="13"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <circle cx="11" cy="11" r="8" />
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65" />
                                                        </svg>
                                                        <input class="cs-search" type="text"
                                                            placeholder="Cari sigma..."
                                                            oninput="filterSigma(0,1,this.value)">
                                                    </div>
                                                </div>
                                                <div class="cs-options" id="cs-s1-options-0">
                                                    <div class="cs-option placeholder-opt"
                                                        onclick="selectSigma(0,1,'','— Frekuensi —')">
                                                        <div class="cs-option-dot"></div>— Frekuensi —
                                                    </div>
                                                    <div class="cs-option" data-val="s1"
                                                        data-label="S 1 d.d — 1× sehari"
                                                        onclick="selectSigma(0,1,'s1','S 1 d.d — 1× sehari')">
                                                        <div class="cs-option-dot"></div>S 1 d.d — 1× sehari
                                                    </div>
                                                    <div class="cs-option" data-val="s2"
                                                        data-label="S 2 d.d — 2× sehari"
                                                        onclick="selectSigma(0,1,'s2','S 2 d.d — 2× sehari')">
                                                        <div class="cs-option-dot"></div>S 2 d.d — 2× sehari
                                                    </div>
                                                    <div class="cs-option" data-val="s3"
                                                        data-label="S 3 d.d — 3× sehari"
                                                        onclick="selectSigma(0,1,'s3','S 3 d.d — 3× sehari')">
                                                        <div class="cs-option-dot"></div>S 3 d.d — 3× sehari
                                                    </div>
                                                    <div class="cs-option" data-val="s4"
                                                        data-label="S 4 d.d — 4× sehari"
                                                        onclick="selectSigma(0,1,'s4','S 4 d.d — 4× sehari')">
                                                        <div class="cs-option-dot"></div>S 4 d.d — 4× sehari
                                                    </div>
                                                    <div class="cs-option" data-val="s6"
                                                        data-label="S 6 d.d — 6× sehari"
                                                        onclick="selectSigma(0,1,'s6','S 6 d.d — 6× sehari')">
                                                        <div class="cs-option-dot"></div>S 6 d.d — 6× sehari
                                                    </div>
                                                    <div class="cs-option" data-val="s_omn_noct"
                                                        data-label="S omn noct — tiap malam"
                                                        onclick="selectSigma(0,1,'s_omn_noct','S omn noct — tiap malam')">
                                                        <div class="cs-option-dot"></div>S omn noct — tiap malam
                                                    </div>
                                                    <div class="cs-option" data-val="s_omn_mane"
                                                        data-label="S omn mane — tiap pagi"
                                                        onclick="selectSigma(0,1,'s_omn_mane','S omn mane — tiap pagi')">
                                                        <div class="cs-option-dot"></div>S omn mane — tiap pagi
                                                    </div>
                                                    <div class="cs-option" data-val="s_prn"
                                                        data-label="S p.r.n — jika perlu"
                                                        onclick="selectSigma(0,1,'s_prn','S p.r.n — jika perlu')">
                                                        <div class="cs-option-dot"></div>S p.r.n — jika perlu
                                                    </div>
                                                </div>
                                                <div class="cs-empty" id="cs-s1-empty-0">Tidak ditemukan</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Sigma 2 <span
                                                style="color:var(--text-muted);font-size:10px;font-weight:400;text-transform:none;">(keterangan
                                                tambahan)</span></label>
                                        <div class="cs-wrap" id="cs-s2-wrap-0">
                                            <input type="hidden" name="items[0][sigma2]" id="cs-s2-val-0">
                                            <div class="cs-trigger" id="cs-s2-trigger-0" onclick="toggleSigma(0,2)">
                                                <span class="cs-trigger-text placeholder" id="cs-s2-text-0">— Aturan Pakai
                                                    —</span>
                                                <svg class="cs-arrow" width="14" height="14" fill="none"
                                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <polyline points="6 9 12 15 18 9" />
                                                </svg>
                                            </div>
                                            <div class="cs-panel" id="cs-s2-panel-0">
                                                <div class="cs-search-wrap">
                                                    <div class="cs-search-relative">
                                                        <svg class="cs-search-icon" width="13" height="13"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <circle cx="11" cy="11" r="8" />
                                                            <line x1="21" y1="21" x2="16.65"
                                                                y2="16.65" />
                                                        </svg>
                                                        <input class="cs-search" type="text"
                                                            placeholder="Cari aturan..."
                                                            oninput="filterSigma(0,2,this.value)">
                                                    </div>
                                                </div>
                                                <div class="cs-options" id="cs-s2-options-0">
                                                    <div class="cs-option placeholder-opt"
                                                        onclick="selectSigma(0,2,'','— Aturan Pakai —')">
                                                        <div class="cs-option-dot"></div>— Aturan Pakai —
                                                    </div>
                                                    <div class="cs-option" data-val="ac"
                                                        data-label="a.c — sebelum makan"
                                                        onclick="selectSigma(0,2,'ac','a.c — sebelum makan')">
                                                        <div class="cs-option-dot"></div>a.c — sebelum makan
                                                    </div>
                                                    <div class="cs-option" data-val="pc"
                                                        data-label="p.c — sesudah makan"
                                                        onclick="selectSigma(0,2,'pc','p.c — sesudah makan')">
                                                        <div class="cs-option-dot"></div>p.c — sesudah makan
                                                    </div>
                                                    <div class="cs-option" data-val="dc"
                                                        data-label="d.c — bersama makan"
                                                        onclick="selectSigma(0,2,'dc','d.c — bersama makan')">
                                                        <div class="cs-option-dot"></div>d.c — bersama makan
                                                    </div>
                                                    <div class="cs-option" data-val="cum_aqua"
                                                        data-label="cum aqua — dengan air"
                                                        onclick="selectSigma(0,2,'cum_aqua','cum aqua — dengan air')">
                                                        <div class="cs-option-dot"></div>cum aqua — dengan air
                                                    </div>
                                                    <div class="cs-option" data-val="ante_prand"
                                                        data-label="ante prandium — sebelum makan siang"
                                                        onclick="selectSigma(0,2,'ante_prand','ante prandium — sebelum makan siang')">
                                                        <div class="cs-option-dot"></div>ante prandium — sebelum makan
                                                        siang
                                                    </div>
                                                    <div class="cs-option" data-val="hora_somni"
                                                        data-label="hora somni — saat tidur"
                                                        onclick="selectSigma(0,2,'hora_somni','hora somni — saat tidur')">
                                                        <div class="cs-option-dot"></div>hora somni — saat tidur
                                                    </div>
                                                    <div class="cs-option" data-val="sublingual"
                                                        data-label="sub lingual — bawah lidah"
                                                        onclick="selectSigma(0,2,'sublingual','sub lingual — bawah lidah')">
                                                        <div class="cs-option-dot"></div>sub lingual — bawah lidah
                                                    </div>
                                                    <div class="cs-option" data-val="prn" data-label="p.r.n — bila perlu"
                                                        onclick="selectSigma(0,2,'prn','p.r.n — bila perlu')">
                                                        <div class="cs-option-dot"></div>p.r.n — bila perlu
                                                    </div>
                                                    <div class="cs-option" data-val="oleskan"
                                                        data-label="oleskan tipis pada area"
                                                        onclick="selectSigma(0,2,'oleskan','oleskan tipis pada area')">
                                                        <div class="cs-option-dot"></div>oleskan tipis pada area
                                                    </div>
                                                    <div class="cs-option" data-val="teteskan"
                                                        data-label="teteskan pada mata/telinga"
                                                        onclick="selectSigma(0,2,'teteskan','teteskan pada mata/telinga')">
                                                        <div class="cs-option-dot"></div>teteskan pada mata/telinga
                                                    </div>
                                                </div>
                                                <div class="cs-empty" id="cs-s2-empty-0">Tidak ditemukan</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="obat-row-sep">

                                {{-- Baris 3: Jadwal (Qty1, Pagi, Siang, Sore, Malam, Qty2) --}}
                                <div class="obat-row-schedule">
                                    <div class="schedule-group">
                                        <span class="schedule-label qty">QTY 1</span>
                                        <input type="number" name="items[0][qty1]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                    <div class="schedule-group">
                                        <span class="schedule-label pagi">☀️ PAGI</span>
                                        <input type="number" name="items[0][pagi]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                    <div class="schedule-group">
                                        <span class="schedule-label siang">🌤️ SIANG</span>
                                        <input type="number" name="items[0][siang]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                    <div class="schedule-group">
                                        <span class="schedule-label sore">🌇 SORE</span>
                                        <input type="number" name="items[0][sore]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                    <div class="schedule-group">
                                        <span class="schedule-label malam">🌙 MALAM</span>
                                        <input type="number" name="items[0][malam]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                    <div class="schedule-group">
                                        <span class="schedule-label qty">QTY 2</span>
                                        <input type="number" name="items[0][qty2]" value="0" min="0"
                                            class="field-input center" placeholder="0">
                                    </div>
                                </div>

                                <hr class="obat-row-sep">

                                {{-- Baris 4: Keterangan Pakai --}}
                                <div class="field-group">
                                    <label class="field-label">Keterangan Pakai</label>
                                    <div class="cs-wrap" id="cs-ket-wrap-0">
                                        <input type="hidden" name="items[0][keterangan_pakai]" id="cs-ket-val-0">
                                        <div class="cs-trigger" id="cs-ket-trigger-0" onclick="toggleKet(0)">
                                            <span class="cs-trigger-text placeholder" id="cs-ket-text-0">— Pilih
                                                Keterangan —</span>
                                            <svg class="cs-arrow" width="14" height="14" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="6 9 12 15 18 9" />
                                            </svg>
                                        </div>
                                        <div class="cs-panel" id="cs-ket-panel-0">
                                            <div class="cs-search-wrap">
                                                <div class="cs-search-relative">
                                                    <svg class="cs-search-icon" width="13" height="13"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <circle cx="11" cy="11" r="8" />
                                                        <line x1="21" y1="21" x2="16.65"
                                                            y2="16.65" />
                                                    </svg>
                                                    <input class="cs-search" type="text"
                                                        placeholder="Cari keterangan..."
                                                        oninput="filterKet(0, this.value)">
                                                </div>
                                            </div>
                                            <div class="cs-options" id="cs-ket-options-0">
                                                <div class="cs-option placeholder-opt"
                                                    onclick="selectKet(0,'','— Pilih Keterangan —')">
                                                    <div class="cs-option-dot"></div>— Pilih Keterangan —
                                                </div>
                                                <div class="cs-option" data-val="diminum_sesudah_makan"
                                                    data-label="Diminum sesudah makan"
                                                    onclick="selectKet(0,'diminum_sesudah_makan','Diminum sesudah makan')">
                                                    <div class="cs-option-dot"></div>Diminum sesudah makan
                                                </div>
                                                <div class="cs-option" data-val="diminum_sebelum_makan"
                                                    data-label="Diminum sebelum makan"
                                                    onclick="selectKet(0,'diminum_sebelum_makan','Diminum sebelum makan')">
                                                    <div class="cs-option-dot"></div>Diminum sebelum makan
                                                </div>
                                                <div class="cs-option" data-val="diminum_bersama_makan"
                                                    data-label="Diminum bersama makan"
                                                    onclick="selectKet(0,'diminum_bersama_makan','Diminum bersama makan')">
                                                    <div class="cs-option-dot"></div>Diminum bersama makan
                                                </div>
                                                <div class="cs-option" data-val="diminum_saat_tidur"
                                                    data-label="Diminum saat tidur"
                                                    onclick="selectKet(0,'diminum_saat_tidur','Diminum saat tidur')">
                                                    <div class="cs-option-dot"></div>Diminum saat tidur
                                                </div>
                                                <div class="cs-option" data-val="diminum_dengan_air_putih"
                                                    data-label="Diminum dengan air putih yang banyak"
                                                    onclick="selectKet(0,'diminum_dengan_air_putih','Diminum dengan air putih yang banyak')">
                                                    <div class="cs-option-dot"></div>Diminum dengan air putih yang banyak
                                                </div>
                                                <div class="cs-option" data-val="jangan_dihancurkan"
                                                    data-label="Jangan dihancurkan / dikunyah"
                                                    onclick="selectKet(0,'jangan_dihancurkan','Jangan dihancurkan / dikunyah')">
                                                    <div class="cs-option-dot"></div>Jangan dihancurkan / dikunyah
                                                </div>
                                                <div class="cs-option" data-val="diteteskan_mata"
                                                    data-label="Diteteskan ke mata"
                                                    onclick="selectKet(0,'diteteskan_mata','Diteteskan ke mata')">
                                                    <div class="cs-option-dot"></div>Diteteskan ke mata
                                                </div>
                                                <div class="cs-option" data-val="diteteskan_telinga"
                                                    data-label="Diteteskan ke telinga"
                                                    onclick="selectKet(0,'diteteskan_telinga','Diteteskan ke telinga')">
                                                    <div class="cs-option-dot"></div>Diteteskan ke telinga
                                                </div>
                                                <div class="cs-option" data-val="oleskan_tipis"
                                                    data-label="Oleskan tipis pada area yang sakit"
                                                    onclick="selectKet(0,'oleskan_tipis','Oleskan tipis pada area yang sakit')">
                                                    <div class="cs-option-dot"></div>Oleskan tipis pada area yang sakit
                                                </div>
                                                <div class="cs-option" data-val="digunakan_jika_perlu"
                                                    data-label="Digunakan jika perlu saja"
                                                    onclick="selectKet(0,'digunakan_jika_perlu','Digunakan jika perlu saja')">
                                                    <div class="cs-option-dot"></div>Digunakan jika perlu saja
                                                </div>
                                                <div class="cs-option" data-val="simpan_dikulkas"
                                                    data-label="Simpan di kulkas, jangan dibekukan"
                                                    onclick="selectKet(0,'simpan_dikulkas','Simpan di kulkas, jangan dibekukan')">
                                                    <div class="cs-option-dot"></div>Simpan di kulkas, jangan dibekukan
                                                </div>
                                                <div class="cs-option" data-val="habiskan" data-label="Harap dihabiskan"
                                                    onclick="selectKet(0,'habiskan','Harap dihabiskan')">
                                                    <div class="cs-option-dot"></div>Harap dihabiskan
                                                </div>
                                                <div class="cs-option" data-val="kocok_dulu"
                                                    data-label="Kocok dahulu sebelum digunakan"
                                                    onclick="selectKet(0,'kocok_dulu','Kocok dahulu sebelum digunakan')">
                                                    <div class="cs-option-dot"></div>Kocok dahulu sebelum digunakan
                                                </div>
                                            </div>
                                            <div class="cs-empty" id="cs-ket-empty-0">Tidak ditemukan</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Catatan --}}
            <div class="resep-section">
                <div class="resep-section-head">
                    <div class="resep-section-title">
                        <div class="section-icon purple">📝</div>
                        <span class="resep-section-label">Catatan Tambahan</span>
                    </div>
                    <span style="font-size:11px;color:var(--text-muted);">Opsional</span>
                </div>
                <div class="resep-section-body">
                    <div class="field-group">
                        <textarea name="catatan" rows="3" placeholder="Catatan dokter, aturan pakai, atau informasi tambahan..."
                            class="field-textarea">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="resep-footer">
                <button type="submit" class="btn-simpan">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Simpan Resep
                </button>
                <a href="{{ route('kasir.resep.index') }}" class="btn-batal">Batal</a>
                <span class="resep-hint">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="8" />
                        <line x1="12" y1="12" x2="12" y2="16" />
                    </svg>
                    Field bertanda <span style="color:var(--accent-cyan);margin:0 2px;">*</span> wajib diisi
                </span>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        let index = 1;
        const varianData = @json($varianJson);

        const satuanOptions = [{
                val: 'tablet',
                label: 'Tablet'
            },
            {
                val: 'kapsul',
                label: 'Kapsul'
            },
            {
                val: 'kaplet',
                label: 'Kaplet'
            },
            {
                val: 'ml',
                label: 'mL'
            },
            {
                val: 'botol',
                label: 'Botol'
            },
            {
                val: 'sachet',
                label: 'Sachet'
            },
            {
                val: 'tube',
                label: 'Tube'
            },
            {
                val: 'ampul',
                label: 'Ampul'
            },
            {
                val: 'suppositoria',
                label: 'Suppositoria'
            },
            {
                val: 'patch',
                label: 'Patch'
            },
        ];

        const sigma1Options = [{
                val: 's1',
                label: 'S 1 d.d — 1× sehari'
            },
            {
                val: 's2',
                label: 'S 2 d.d — 2× sehari'
            },
            {
                val: 's3',
                label: 'S 3 d.d — 3× sehari'
            },
            {
                val: 's4',
                label: 'S 4 d.d — 4× sehari'
            },
            {
                val: 's6',
                label: 'S 6 d.d — 6× sehari'
            },
            {
                val: 's_omn_noct',
                label: 'S omn noct — tiap malam'
            },
            {
                val: 's_omn_mane',
                label: 'S omn mane — tiap pagi'
            },
            {
                val: 's_prn',
                label: 'S p.r.n — jika perlu'
            },
        ];

        const sigma2Options = [{
                val: 'ac',
                label: 'a.c — sebelum makan'
            },
            {
                val: 'pc',
                label: 'p.c — sesudah makan'
            },
            {
                val: 'dc',
                label: 'd.c — bersama makan'
            },
            {
                val: 'cum_aqua',
                label: 'cum aqua — dengan air'
            },
            {
                val: 'ante_prand',
                label: 'ante prandium — sebelum makan siang'
            },
            {
                val: 'hora_somni',
                label: 'hora somni — saat tidur'
            },
            {
                val: 'sublingual',
                label: 'sub lingual — bawah lidah'
            },
            {
                val: 'prn',
                label: 'p.r.n — bila perlu'
            },
            {
                val: 'oleskan',
                label: 'oleskan tipis pada area'
            },
            {
                val: 'teteskan',
                label: 'teteskan pada mata/telinga'
            },
        ];

        const ketOptions = [{
                val: 'diminum_sesudah_makan',
                label: 'Diminum sesudah makan'
            },
            {
                val: 'diminum_sebelum_makan',
                label: 'Diminum sebelum makan'
            },
            {
                val: 'diminum_bersama_makan',
                label: 'Diminum bersama makan'
            },
            {
                val: 'diminum_saat_tidur',
                label: 'Diminum saat tidur'
            },
            {
                val: 'diminum_dengan_air_putih',
                label: 'Diminum dengan air putih yang banyak'
            },
            {
                val: 'jangan_dihancurkan',
                label: 'Jangan dihancurkan / dikunyah'
            },
            {
                val: 'diteteskan_mata',
                label: 'Diteteskan ke mata'
            },
            {
                val: 'diteteskan_telinga',
                label: 'Diteteskan ke telinga'
            },
            {
                val: 'oleskan_tipis',
                label: 'Oleskan tipis pada area yang sakit'
            },
            {
                val: 'digunakan_jika_perlu',
                label: 'Digunakan jika perlu saja'
            },
            {
                val: 'simpan_dikulkas',
                label: 'Simpan di kulkas, jangan dibekukan'
            },
            {
                val: 'habiskan',
                label: 'Harap dihabiskan'
            },
            {
                val: 'kocok_dulu',
                label: 'Kocok dahulu sebelum digunakan'
            },
        ];

        // ── Generic close all ──
        function closeAllPanels() {
            document.querySelectorAll('.cs-panel.open').forEach(p => p.classList.remove('open'));
            document.querySelectorAll('.cs-trigger.open').forEach(t => t.classList.remove('open'));
        }

        // ── Obat (nama obat) ──
        function toggleCS(idx) {
            const panel = document.getElementById('cs-panel-' + idx);
            const trigger = document.getElementById('cs-trigger-' + idx);
            const isOpen = panel.classList.contains('open');
            closeAllPanels();
            if (!isOpen) {
                panel.classList.add('open');
                trigger.classList.add('open');
                const s = panel.querySelector('.cs-search');
                if (s) {
                    s.value = '';
                    filterCS(idx, '');
                    s.focus();
                }
            }
        }

        function selectCS(idx, val, label) {
            document.getElementById('cs-val-' + idx).value = val;
            const t = document.getElementById('cs-text-' + idx);
            t.textContent = label || '— Pilih Obat —';
            t.classList.toggle('placeholder', !val);
            document.querySelectorAll('#cs-options-' + idx + ' .cs-option').forEach(o => o.classList.toggle('selected', o
                .dataset.val === val));
            closeAllPanels();
        }

        function filterCS(idx, q) {
            const opts = document.querySelectorAll('#cs-options-' + idx + ' .cs-option:not(.placeholder-opt)');
            const empty = document.getElementById('cs-empty-' + idx);
            let v = 0;
            opts.forEach(o => {
                const m = o.dataset.label.toLowerCase().includes(q.toLowerCase());
                o.style.display = m ? '' : 'none';
                if (m) v++;
            });
            if (empty) empty.style.display = v === 0 ? 'block' : 'none';
        }

        // ── Satuan ──
        function toggleCSatuan(idx) {
            const panel = document.getElementById('cs-satuan-panel-' + idx);
            const trigger = document.getElementById('cs-satuan-trigger-' + idx);
            const isOpen = panel.classList.contains('open');
            closeAllPanels();
            if (!isOpen) {
                panel.classList.add('open');
                trigger.classList.add('open');
                const s = panel.querySelector('.cs-search');
                if (s) {
                    s.value = '';
                    filterCSatuan(idx, '');
                    s.focus();
                }
            }
        }

        function selectCSatuan(idx, val, label) {
            document.getElementById('cs-satuan-val-' + idx).value = val;
            const t = document.getElementById('cs-satuan-text-' + idx);
            t.textContent = label || '— Pilih —';
            t.classList.toggle('placeholder', !val);
            document.querySelectorAll('#cs-satuan-options-' + idx + ' .cs-option').forEach(o => o.classList.toggle(
                'selected', o.dataset.val === val));
            closeAllPanels();
        }

        function filterCSatuan(idx, q) {
            const opts = document.querySelectorAll('#cs-satuan-options-' + idx + ' .cs-option:not(.placeholder-opt)');
            const empty = document.getElementById('cs-satuan-empty-' + idx);
            let v = 0;
            opts.forEach(o => {
                const m = o.dataset.label.toLowerCase().includes(q.toLowerCase());
                o.style.display = m ? '' : 'none';
                if (m) v++;
            });
            if (empty) empty.style.display = v === 0 ? 'block' : 'none';
        }

        // ── Sigma ──
        function toggleSigma(idx, num) {
            const panel = document.getElementById('cs-s' + num + '-panel-' + idx);
            const trigger = document.getElementById('cs-s' + num + '-trigger-' + idx);
            const isOpen = panel.classList.contains('open');
            closeAllPanels();
            if (!isOpen) {
                panel.classList.add('open');
                trigger.classList.add('open');
                const s = panel.querySelector('.cs-search');
                if (s) {
                    s.value = '';
                    filterSigma(idx, num, '');
                    s.focus();
                }
            }
        }

        function selectSigma(idx, num, val, label) {
            document.getElementById('cs-s' + num + '-val-' + idx).value = val;
            const t = document.getElementById('cs-s' + num + '-text-' + idx);
            t.textContent = label || (num === 1 ? '— Frekuensi —' : '— Aturan Pakai —');
            t.classList.toggle('placeholder', !val);
            document.querySelectorAll('#cs-s' + num + '-options-' + idx + ' .cs-option').forEach(o => o.classList.toggle(
                'selected', o.dataset.val === val));
            closeAllPanels();
        }

        function filterSigma(idx, num, q) {
            const opts = document.querySelectorAll('#cs-s' + num + '-options-' + idx + ' .cs-option:not(.placeholder-opt)');
            const empty = document.getElementById('cs-s' + num + '-empty-' + idx);
            let v = 0;
            opts.forEach(o => {
                const m = o.dataset.label.toLowerCase().includes(q.toLowerCase());
                o.style.display = m ? '' : 'none';
                if (m) v++;
            });
            if (empty) empty.style.display = v === 0 ? 'block' : 'none';
        }

        // ── Keterangan Pakai ──
        function toggleKet(idx) {
            const panel = document.getElementById('cs-ket-panel-' + idx);
            const trigger = document.getElementById('cs-ket-trigger-' + idx);
            const isOpen = panel.classList.contains('open');
            closeAllPanels();
            if (!isOpen) {
                panel.classList.add('open');
                trigger.classList.add('open');
                const s = panel.querySelector('.cs-search');
                if (s) {
                    s.value = '';
                    filterKet(idx, '');
                    s.focus();
                }
            }
        }

        function selectKet(idx, val, label) {
            document.getElementById('cs-ket-val-' + idx).value = val;
            const t = document.getElementById('cs-ket-text-' + idx);
            t.textContent = label || '— Pilih Keterangan —';
            t.classList.toggle('placeholder', !val);
            document.querySelectorAll('#cs-ket-options-' + idx + ' .cs-option').forEach(o => o.classList.toggle('selected',
                o.dataset.val === val));
            closeAllPanels();
        }

        function filterKet(idx, q) {
            const opts = document.querySelectorAll('#cs-ket-options-' + idx + ' .cs-option:not(.placeholder-opt)');
            const empty = document.getElementById('cs-ket-empty-' + idx);
            let v = 0;
            opts.forEach(o => {
                const m = o.dataset.label.toLowerCase().includes(q.toLowerCase());
                o.style.display = m ? '' : 'none';
                if (m) v++;
            });
            if (empty) empty.style.display = v === 0 ? 'block' : 'none';
        }

        // ── Close on outside click ──
        document.addEventListener('click', e => {
            if (!e.target.closest('.cs-wrap')) closeAllPanels();
        });

        // ── Build options HTML ──
        function buildOptions(opts, idx, type, placeholder) {
            let html =
                `<div class="cs-option placeholder-opt" onclick="select${type}(${idx},'','${placeholder}')"><div class="cs-option-dot"></div>${placeholder}</div>`;
            opts.forEach(o => {
                html +=
                    `<div class="cs-option" data-val="${o.val}" data-label="${o.label}" onclick="select${type}(${idx},'${o.val}','${o.label}')"><div class="cs-option-dot"></div>${o.label}</div>`;
            });
            return html;
        }

        function buildVarianOptions(idx) {
            let html =
                `<div class="cs-option placeholder-opt" onclick="selectCS(${idx},'','— Pilih Obat —')"><div class="cs-option-dot"></div>— Pilih Obat —</div>`;
            varianData.forEach(v => {
                const label = `${v.merek} ${v.dosis}mg — ${v.nama}`;
                html += `<div class="cs-option" data-val="${v.id}" data-label="${label}" onclick="selectCS(${idx},'${v.id}','${label}')">
            <div class="cs-option-dot"></div>${v.merek} ${v.dosis}mg
            <span style="color:var(--text-muted);font-size:11px;margin-left:auto;">${v.nama}</span>
        </div>`;
            });
            return html;
        }

        // ── Tambah Obat ──
        function tambahObat() {
            const container = document.getElementById('obat-list');
            const idx = index;
            const num = idx + 1;

            const card = document.createElement('div');
            card.className = 'obat-card';
            card.id = 'obat-card-' + idx;
            card.innerHTML = `
        <div class="obat-card-head">
            <span class="obat-card-num">OBAT #${num}</span>
            <button type="button" class="obat-remove-btn" onclick="hapusObat(this)">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="obat-card-body">

            <!-- Row 1: Nama Obat + Jumlah + Satuan -->
            <div class="obat-row-main">
                <div class="field-group">
                    <label class="field-label">Nama Obat / Varian <span style="color:var(--accent-cyan)">*</span></label>
                    <div class="cs-wrap" id="cs-wrap-${idx}">
                        <input type="hidden" name="items[${idx}][id_varian]" id="cs-val-${idx}">
                        <div class="cs-trigger" id="cs-trigger-${idx}" onclick="toggleCS(${idx})">
                            <span class="cs-trigger-text placeholder" id="cs-text-${idx}">— Pilih Obat —</span>
                            <svg class="cs-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="cs-panel" id="cs-panel-${idx}">
                            <div class="cs-search-wrap"><div class="cs-search-relative">
                                <svg class="cs-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input class="cs-search" type="text" placeholder="Cari obat..." oninput="filterCS(${idx}, this.value)">
                            </div></div>
                            <div class="cs-options" id="cs-options-${idx}">${buildVarianOptions(idx)}</div>
                            <div class="cs-empty" id="cs-empty-${idx}">Tidak ada obat ditemukan</div>
                        </div>
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Jumlah</label>
                    <input type="number" name="items[${idx}][jumlah]" value="1" min="1" class="field-input center" placeholder="Qty">
                </div>
                <div class="field-group">
                    <label class="field-label">Satuan</label>
                    <div class="cs-wrap" id="cs-satuan-wrap-${idx}">
                        <input type="hidden" name="items[${idx}][satuan]" id="cs-satuan-val-${idx}">
                        <div class="cs-trigger" id="cs-satuan-trigger-${idx}" onclick="toggleCSatuan(${idx})">
                            <span class="cs-trigger-text placeholder" id="cs-satuan-text-${idx}">— Pilih —</span>
                            <svg class="cs-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="cs-panel" id="cs-satuan-panel-${idx}">
                            <div class="cs-search-wrap"><div class="cs-search-relative">
                                <svg class="cs-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input class="cs-search" type="text" placeholder="Cari satuan..." oninput="filterCSatuan(${idx}, this.value)">
                            </div></div>
                            <div class="cs-options" id="cs-satuan-options-${idx}">${buildOptions(satuanOptions, idx, 'CSatuan', '— Pilih —')}</div>
                            <div class="cs-empty" id="cs-satuan-empty-${idx}">Tidak ditemukan</div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="obat-row-sep">

            <!-- Row 2: Sigma -->
            <div class="obat-row-sigma">
                <div class="field-group">
                    <label class="field-label">Sigma 1 <span style="color:var(--text-muted);font-size:10px;font-weight:400;text-transform:none;">(berapa kali sehari)</span></label>
                    <div class="cs-wrap" id="cs-s1-wrap-${idx}">
                        <input type="hidden" name="items[${idx}][sigma1]" id="cs-s1-val-${idx}">
                        <div class="cs-trigger" id="cs-s1-trigger-${idx}" onclick="toggleSigma(${idx},1)">
                            <span class="cs-trigger-text placeholder" id="cs-s1-text-${idx}">— Frekuensi —</span>
                            <svg class="cs-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="cs-panel" id="cs-s1-panel-${idx}">
                            <div class="cs-search-wrap"><div class="cs-search-relative">
                                <svg class="cs-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input class="cs-search" type="text" placeholder="Cari sigma..." oninput="filterSigma(${idx},1,this.value)">
                            </div></div>
                            <div class="cs-options" id="cs-s1-options-${idx}">${buildOptions(sigma1Options, idx, 'Sigma_1_', '— Frekuensi —').replace(/select_1_/g, `selectSigma_1_`)}</div>
                            <div class="cs-empty" id="cs-s1-empty-${idx}">Tidak ditemukan</div>
                        </div>
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Sigma 2 <span style="color:var(--text-muted);font-size:10px;font-weight:400;text-transform:none;">(keterangan tambahan)</span></label>
                    <div class="cs-wrap" id="cs-s2-wrap-${idx}">
                        <input type="hidden" name="items[${idx}][sigma2]" id="cs-s2-val-${idx}">
                        <div class="cs-trigger" id="cs-s2-trigger-${idx}" onclick="toggleSigma(${idx},2)">
                            <span class="cs-trigger-text placeholder" id="cs-s2-text-${idx}">— Aturan Pakai —</span>
                            <svg class="cs-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="cs-panel" id="cs-s2-panel-${idx}">
                            <div class="cs-search-wrap"><div class="cs-search-relative">
                                <svg class="cs-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                <input class="cs-search" type="text" placeholder="Cari aturan..." oninput="filterSigma(${idx},2,this.value)">
                            </div></div>
                            <div class="cs-options" id="cs-s2-options-${idx}">${buildOptions(sigma2Options, idx, 'Sigma_2_', '— Aturan Pakai —').replace(/select_2_/g,'selectSigma_2_')}</div>
                            <div class="cs-empty" id="cs-s2-empty-${idx}">Tidak ditemukan</div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="obat-row-sep">

            <!-- Row 3: Jadwal -->
            <div class="obat-row-schedule">
                <div class="schedule-group">
                    <span class="schedule-label qty">QTY 1</span>
                    <input type="number" name="items[${idx}][qty1]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
                <div class="schedule-group">
                    <span class="schedule-label pagi">☀️ PAGI</span>
                    <input type="number" name="items[${idx}][pagi]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
                <div class="schedule-group">
                    <span class="schedule-label siang">🌤️ SIANG</span>
                    <input type="number" name="items[${idx}][siang]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
                <div class="schedule-group">
                    <span class="schedule-label sore">🌇 SORE</span>
                    <input type="number" name="items[${idx}][sore]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
                <div class="schedule-group">
                    <span class="schedule-label malam">🌙 MALAM</span>
                    <input type="number" name="items[${idx}][malam]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
                <div class="schedule-group">
                    <span class="schedule-label qty">QTY 2</span>
                    <input type="number" name="items[${idx}][qty2]" value="0" min="0" class="field-input center" placeholder="0">
                </div>
            </div>

            <hr class="obat-row-sep">

            <!-- Row 4: Keterangan Pakai -->
            <div class="field-group">
                <label class="field-label">Keterangan Pakai</label>
                <div class="cs-wrap" id="cs-ket-wrap-${idx}">
                    <input type="hidden" name="items[${idx}][keterangan_pakai]" id="cs-ket-val-${idx}">
                    <div class="cs-trigger" id="cs-ket-trigger-${idx}" onclick="toggleKet(${idx})">
                        <span class="cs-trigger-text placeholder" id="cs-ket-text-${idx}">— Pilih Keterangan —</span>
                        <svg class="cs-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="cs-panel" id="cs-ket-panel-${idx}">
                        <div class="cs-search-wrap"><div class="cs-search-relative">
                            <svg class="cs-search-icon" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input class="cs-search" type="text" placeholder="Cari keterangan..." oninput="filterKet(${idx}, this.value)">
                        </div></div>
                        <div class="cs-options" id="cs-ket-options-${idx}">${buildOptions(ketOptions, idx, 'Ket', '— Pilih Keterangan —')}</div>
                        <div class="cs-empty" id="cs-ket-empty-${idx}">Tidak ditemukan</div>
                    </div>
                </div>
            </div>

        </div>
    `;

            // Fix onclick for sigma (special case dengan 2 args)
            // We need to replace templated onclick strings properly
            card.querySelectorAll('[id^="cs-s1-options-"]').forEach(el => {
                el.querySelectorAll('.cs-option:not(.placeholder-opt)').forEach((o, i) => {
                    const opt = sigma1Options[i];
                    if (opt) o.setAttribute('onclick', `selectSigma(${idx},1,'${opt.val}','${opt.label}')`);
                });
                const plh = el.querySelector('.placeholder-opt');
                if (plh) plh.setAttribute('onclick', `selectSigma(${idx},1,'','— Frekuensi —')`);
            });
            card.querySelectorAll('[id^="cs-s2-options-"]').forEach(el => {
                el.querySelectorAll('.cs-option:not(.placeholder-opt)').forEach((o, i) => {
                    const opt = sigma2Options[i];
                    if (opt) o.setAttribute('onclick', `selectSigma(${idx},2,'${opt.val}','${opt.label}')`);
                });
                const plh = el.querySelector('.placeholder-opt');
                if (plh) plh.setAttribute('onclick', `selectSigma(${idx},2,'','— Aturan Pakai —')`);
            });
            card.querySelectorAll('[id^="cs-ket-options-"]').forEach(el => {
                el.querySelectorAll('.cs-option:not(.placeholder-opt)').forEach((o, i) => {
                    const opt = ketOptions[i];
                    if (opt) o.setAttribute('onclick', `selectKet(${idx},'${opt.val}','${opt.label}')`);
                });
            });
            card.querySelectorAll('[id^="cs-satuan-options-"]').forEach(el => {
                el.querySelectorAll('.cs-option:not(.placeholder-opt)').forEach((o, i) => {
                    const opt = satuanOptions[i];
                    if (opt) o.setAttribute('onclick', `selectCSatuan(${idx},'${opt.val}','${opt.label}')`);
                });
            });

            container.appendChild(card);
            index++;
            updateCount();
        }

        function hapusObat(btn) {
            btn.closest('.obat-card').remove();
            updateCount();
        }

        function updateCount() {
            const rows = document.querySelectorAll('.obat-card').length;
            document.getElementById('obat-count').textContent = rows + ' item';
        }
    </script>
@endpush
