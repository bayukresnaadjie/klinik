{{-- resources/views/stok_obat/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Stok Obat')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        .fo {
            --fo-gold: #C9A84C;
            --fo-gold-hover: #b8932f;
            --fo-gold-dim: rgba(201, 168, 76, 0.12);
            --fo-gold-dimmer: rgba(201, 168, 76, 0.06);
            --fo-surface: rgba(255, 255, 255, 0.04);
            --fo-surface-hover: rgba(255, 255, 255, 0.07);
            --fo-border: rgba(255, 255, 255, 0.09);
            --fo-text-primary: #E8E8E0;
            --fo-text-muted: #8A97A8;
            --fo-text-faint: #5A6472;
            --fo-radius: 10px;
            --fo-radius-sm: 7px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            color: var(--fo-text-primary)
        }

        .fo-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap
        }

        .fo-header-title h4 {
            font-size: 21px;
            font-weight: 700;
            color: var(--fo-text-primary);
            letter-spacing: -0.4px;
            margin: 0 0 3px
        }

        .fo-header-title p {
            font-size: 12px;
            color: var(--fo-text-muted);
            margin: 0
        }

        .fo-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--fo-text-faint);
            margin-bottom: 18px
        }

        .fo-breadcrumb a {
            color: var(--fo-gold);
            text-decoration: none !important
        }

        .fo-breadcrumb a:hover {
            text-decoration: underline !important
        }

        .fo-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--fo-radius-sm);
            font-size: 12.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none !important;
            border: 1px solid;
            transition: all .15s ease;
            white-space: nowrap;
            line-height: 1
        }

        .fo-btn-back {
            background: var(--fo-surface);
            border-color: var(--fo-border);
            color: var(--fo-text-muted)
        }

        .fo-btn-back:hover {
            border-color: var(--fo-gold);
            color: var(--fo-gold);
            background: var(--fo-gold-dimmer)
        }

        .fo-btn-gold {
            background: var(--fo-gold);
            border-color: var(--fo-gold);
            color: #1a1208 !important;
            font-weight: 700
        }

        .fo-btn-gold:hover {
            background: var(--fo-gold-hover);
            border-color: var(--fo-gold-hover)
        }

        .fo-btn-outline {
            background: var(--fo-surface);
            border-color: var(--fo-border);
            color: var(--fo-text-muted)
        }

        .fo-btn-outline:hover {
            border-color: var(--fo-gold);
            color: var(--fo-gold);
            background: var(--fo-gold-dimmer)
        }

        .fo-btn-danger {
            background: rgba(153, 27, 27, 0.15);
            border-color: rgba(252, 165, 165, 0.2);
            color: #FCA5A5
        }

        .fo-btn-danger:hover {
            background: rgba(153, 27, 27, 0.3);
            border-color: rgba(252, 165, 165, 0.45)
        }

        .fo-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 16px;
            border-radius: var(--fo-radius);
            font-size: 12.5px;
            font-weight: 500;
            margin-bottom: 16px
        }

        .fo-alert-danger {
            background: rgba(153, 27, 27, 0.2);
            color: #FCA5A5;
            border: 1px solid rgba(252, 165, 165, 0.2)
        }

        .fo-alert-success {
            background: rgba(6, 95, 70, 0.2);
            color: #6EE7B7;
            border: 1px solid rgba(52, 211, 153, 0.2)
        }

        .fo-alert ul {
            margin: 6px 0 0 16px;
            padding: 0
        }

        .fo-alert li {
            margin-bottom: 2px
        }

        .fo-btn-close-alert {
            background: none;
            border: none;
            font-size: 17px;
            cursor: pointer;
            color: inherit;
            opacity: .55;
            padding: 0 0 0 6px;
            line-height: 1;
            margin-left: auto
        }

        .fo-btn-close-alert:hover {
            opacity: 1
        }

        .fo-grid {
            display: grid;
            grid-template-columns: 1fr 290px;
            gap: 18px;
            align-items: start
        }

        @media(max-width:768px) {
            .fo-grid {
                grid-template-columns: 1fr
            }
        }

        .fo-card {
            background: var(--fo-surface);
            border: 1px solid var(--fo-border);
            border-radius: var(--fo-radius);
            overflow: hidden
        }

        .fo-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--fo-border);
            background: linear-gradient(90deg, var(--fo-gold-dimmer) 0%, transparent 60%)
        }

        .fo-card-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: var(--fo-text-primary);
            margin: 0
        }

        .fo-card-body {
            padding: 22px
        }

        .fo-card-footer {
            display: flex;
            gap: 8px;
            align-items: center;
            padding: 14px 20px;
            border-top: 1px solid var(--fo-border);
            background: rgba(0, 0, 0, 0.1);
            flex-wrap: wrap
        }

        .fo-section-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--fo-gold);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin: 0 0 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(201, 168, 76, 0.15)
        }

        .fo-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px
        }

        @media(max-width:480px) {
            .fo-row-2 {
                grid-template-columns: 1fr
            }
        }

        .fo-field {
            margin-bottom: 18px
        }

        .fo-field:last-child {
            margin-bottom: 0
        }

        .fo-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--fo-text-muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 7px
        }

        .fo-required {
            color: var(--fo-gold);
            margin-left: 2px
        }

        .fo-hint {
            font-size: 11px;
            color: var(--fo-text-faint);
            margin-top: 5px;
            font-style: italic
        }

        .fo-error-msg {
            font-size: 11.5px;
            color: #FCA5A5;
            margin-top: 5px
        }

        .fo-input,
        .fo-select,
        .fo-textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 9px 13px;
            border: 1px solid var(--fo-border);
            border-radius: var(--fo-radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            color: var(--fo-text-primary);
            background: #2a2d35;
            outline: none;
            transition: border-color .15s;
            color-scheme: dark
        }

        .fo-input:focus,
        .fo-select:focus,
        .fo-textarea:focus {
            border-color: var(--fo-gold);
            background: #2f323b
        }

        .fo-input::placeholder,
        .fo-textarea::placeholder {
            color: var(--fo-text-faint)
        }

        .fo-input.is-invalid,
        .fo-select.is-invalid,
        .fo-textarea.is-invalid {
            border-color: rgba(252, 165, 165, 0.5)
        }

        .fo-select {
            cursor: pointer;
            -webkit-appearance: auto;
            appearance: auto
        }

        .fo-select option {
            background: #2a2d35;
            color: var(--fo-text-primary)
        }

        .fo-textarea {
            resize: vertical;
            min-height: 70px;
            line-height: 1.55
        }

        .fo-input-prefix {
            display: flex
        }

        .fo-prefix-text {
            padding: 9px 12px;
            border: 1px solid var(--fo-border);
            border-right: none;
            border-radius: var(--fo-radius-sm) 0 0 var(--fo-radius-sm);
            background: #23262f;
            font-size: 12px;
            color: var(--fo-text-faint);
            line-height: 1.4;
            white-space: nowrap
        }

        .fo-input-prefix .fo-input {
            border-radius: 0 var(--fo-radius-sm) var(--fo-radius-sm) 0
        }

        .fo-divider {
            border: none;
            border-top: 1px solid var(--fo-border);
            margin: 20px 0
        }

        .fo-sidebar {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        .fo-side-card {
            background: var(--fo-surface);
            border: 1px solid var(--fo-border);
            border-radius: var(--fo-radius);
            overflow: hidden
        }

        .fo-side-card-hd {
            padding: 12px 16px;
            border-bottom: 1px solid var(--fo-border);
            background: linear-gradient(90deg, var(--fo-gold-dimmer) 0%, transparent 60%)
        }

        .fo-side-card-hd h5 {
            font-size: 13px;
            font-weight: 600;
            color: var(--fo-text-primary);
            margin: 0
        }

        .fo-side-card-body {
            padding: 16px
        }

        .fo-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 12px;
            gap: 8px
        }

        .fo-info-row:last-child {
            border-bottom: none
        }

        .fo-info-label {
            color: var(--fo-text-muted)
        }

        .fo-info-value {
            color: var(--fo-text-primary);
            font-weight: 600;
            text-align: right
        }

        .fo-tip {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 11px 13px;
            border-radius: 8px;
            background: rgba(201, 168, 76, 0.07);
            border: 1px solid rgba(201, 168, 76, 0.14);
            font-size: 11.5px;
            color: #C9A84C;
            line-height: 1.55
        }

        .fo-tip svg {
            flex-shrink: 0;
            margin-top: 1px
        }

        .fo-guide-item {
            display: flex;
            gap: 9px;
            font-size: 12px;
            color: var(--fo-text-muted);
            line-height: 1.55;
            margin-bottom: 10px
        }

        .fo-guide-item:last-child {
            margin-bottom: 0
        }

        .fo-guide-num {
            color: var(--fo-gold);
            font-weight: 700;
            flex-shrink: 0
        }

        /* Status kadaluarsa */
        .fo-exp-info {
            font-size: 12px;
            margin-top: 6px;
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 6px;
            display: none
        }

        .fo-exp-expired {
            background: rgba(153, 27, 27, 0.2);
            color: #FCA5A5;
            border: 1px solid rgba(252, 165, 165, 0.2)
        }

        .fo-exp-kritis {
            background: rgba(153, 27, 27, 0.15);
            color: #FCA5A5;
            border: 1px solid rgba(252, 165, 165, 0.15)
        }

        .fo-exp-warning {
            background: rgba(146, 64, 14, 0.2);
            color: #FCD34D;
            border: 1px solid rgba(252, 211, 77, 0.2)
        }

        .fo-exp-aman {
            background: rgba(6, 95, 70, 0.2);
            color: #6EE7B7;
            border: 1px solid rgba(52, 211, 153, 0.2)
        }

        /* Varian info preview */
        .fo-varian-preview {
            background: rgba(201, 168, 76, 0.05);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 8px;
            padding: 11px 14px;
            display: none;
            margin-top: 10px
        }

        .fo-varian-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--fo-text-primary)
        }

        .fo-varian-meta {
            font-size: 11.5px;
            color: var(--fo-text-muted);
            margin-top: 3px
        }
    </style>

    <div class="fo">

        {{-- Header --}}
        <div class="fo-header">
            <div class="fo-header-title">
                <h4>Tambah Stok Obat</h4>
                <p>Tambah batch stok obat baru ke gudang farmasi</p>
            </div>
            <a href="{{ route('stok-obat.index') }}" class="fo-btn fo-btn-back">
                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Breadcrumb --}}
        <div class="fo-breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('stok-obat.index') }}">Stok Obat</a>
            <span>›</span>
            <span style="color:var(--fo-text-primary)">Tambah Stok</span>
        </div>

        {{-- Flash messages --}}
        @if (session('error'))
            <div class="fo-alert fo-alert-danger">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="fo-btn-close-alert">&times;</button>
            </div>
        @endif
        @if (session('success'))
            <div class="fo-alert fo-alert-success">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="fo-btn-close-alert">&times;</button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="fo-alert fo-alert-danger">
                <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor"
                    style="flex-shrink:0;margin-top:1px">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <strong>Terdapat kesalahan pada form:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="fo-grid">

            {{-- Form Card --}}
            <div class="fo-card">
                <div class="fo-card-header">
                    <h5>Form Data Stok Obat</h5>
                </div>

                <form action="{{ route('stok-obat.store') }}" method="POST" id="formStokObat">
                    @csrf

                    <div class="fo-card-body">

                        {{-- ── Varian Obat ── --}}
                        <div class="fo-section-label">Pilih Varian Obat</div>

                        <div class="fo-field">
                            <label class="fo-label" for="id_varian">
                                Varian Obat <span class="fo-required">*</span>
                            </label>
                            <select name="id_varian" id="id_varian"
                                class="fo-select {{ $errors->has('id_varian') ? 'is-invalid' : '' }}"
                                onchange="updateVarianPreview(this)" required>
                                <option value="">-- Pilih Varian --</option>
                                @foreach ($varian as $v)
                                    <option value="{{ $v->id_varian }}" data-merek="{{ $v->nama_merek }}"
                                        data-dosis="{{ $v->dosis_mg }}" data-obat="{{ $v->obat->nama_obat ?? '' }}"
                                        data-jenis="{{ $v->obat->jenisObat->nama_jenis ?? '' }}"
                                        {{ old('id_varian') == $v->id_varian ? 'selected' : '' }}>
                                        {{ $v->nama_merek }} {{ $v->dosis_mg }}mg
                                    </option>
                                @endforeach
                            </select>
                            @error('id_varian')
                                <div class="fo-error-msg">{{ $message }}</div>
                            @enderror

                            {{-- Varian preview --}}
                            <div class="fo-varian-preview" id="varian-preview">
                                <div class="fo-varian-name" id="vp-merek">—</div>
                                <div class="fo-varian-meta" id="vp-meta">—</div>
                            </div>
                        </div>

                        <hr class="fo-divider">

                        {{-- ── Info Batch ── --}}
                        <div class="fo-section-label">Informasi Batch</div>

                        <div class="fo-row-2">
                            <div class="fo-field">
                                <label class="fo-label" for="no_batch">
                                    No. Batch <span class="fo-required">*</span>
                                </label>
                                <input type="text" name="no_batch" id="no_batch"
                                    class="fo-input {{ $errors->has('no_batch') ? 'is-invalid' : '' }}"
                                    value="{{ old('no_batch') }}" placeholder="BTH-2024-001"
                                    style="font-family:'JetBrains Mono',monospace;font-size:12px;text-transform:uppercase"
                                    required>
                                @error('no_batch')
                                    <div class="fo-error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fo-field">
                                <label class="fo-label" for="jumlah">
                                    Jumlah Stok <span class="fo-required">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah"
                                    class="fo-input {{ $errors->has('jumlah') ? 'is-invalid' : '' }}"
                                    value="{{ old('jumlah') }}" min="1" placeholder="0" required>
                                @error('jumlah')
                                    <div class="fo-error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="fo-field">
                            <label class="fo-label" for="harga_satuan">Harga Satuan (Rp)</label>
                            <div class="fo-input-prefix">
                                <span class="fo-prefix-text">Rp</span>
                                <input type="number" name="harga_satuan"
                                    class="fo-input {{ $errors->has('harga_satuan') ? 'is-invalid' : '' }}"
                                    value="{{ old('harga_satuan', 0) }}" min="0" placeholder="0">
                            </div>
                            @error('harga_satuan')
                                <div class="fo-error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="fo-divider">

                        {{-- ── Tanggal ── --}}
                        <div class="fo-section-label">Tanggal</div>

                        <div class="fo-row-2">
                            <div class="fo-field">
                                <label class="fo-label" for="tanggal_masuk">
                                    Tanggal Masuk <span class="fo-required">*</span>
                                </label>
                                <input type="date" name="tanggal_masuk"
                                    class="fo-input {{ $errors->has('tanggal_masuk') ? 'is-invalid' : '' }}"
                                    value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
                                    <div class="fo-error-msg">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="fo-field">
                                <label class="fo-label" for="tanggal_kadaluarsa">
                                    Tanggal Kadaluarsa <span class="fo-required">*</span>
                                </label>
                                <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa"
                                    class="fo-input {{ $errors->has('tanggal_kadaluarsa') ? 'is-invalid' : '' }}"
                                    value="{{ old('tanggal_kadaluarsa') }}" onchange="cekKadaluarsa(this)" required>
                                <div class="fo-exp-info" id="exp-info"></div>
                                @error('tanggal_kadaluarsa')
                                    <div class="fo-error-msg">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="fo-divider">

                        {{-- ── Keterangan ── --}}
                        <div class="fo-section-label">Keterangan</div>

                        <div class="fo-field">
                            <label class="fo-label" for="keterangan">Supplier / Keterangan</label>
                            <input type="text" name="keterangan"
                                class="fo-input {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                                value="{{ old('keterangan') }}"
                                placeholder="Contoh: PBF Kimia Farma, pembelian rutin (opsional)">
                            @error('keterangan')
                                <div class="fo-error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="fo-card-footer">
                        <button type="submit" class="fo-btn fo-btn-gold" id="btnSimpan">
                            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Simpan Stok
                        </button>
                        <button type="reset" class="fo-btn fo-btn-outline" onclick="resetExpInfo()">
                            <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                        <a href="{{ route('stok-obat.index') }}" class="fo-btn fo-btn-danger" style="margin-left:auto">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="fo-sidebar">

                {{-- Info Varian --}}
                <div class="fo-side-card">
                    <div class="fo-side-card-hd">
                        <h5>Info Varian Dipilih</h5>
                    </div>
                    <div class="fo-side-card-body" id="sidebar-varian-info">
                        <div style="font-size:12px;color:var(--fo-text-faint);text-align:center;padding:12px 0">
                            Pilih varian obat terlebih dahulu
                        </div>
                    </div>
                </div>

                {{-- Status Kadaluarsa Summary --}}
                <div class="fo-side-card" id="exp-summary-card" style="display:none">
                    <div class="fo-side-card-hd">
                        <h5>Status Kadaluarsa</h5>
                    </div>
                    <div class="fo-side-card-body" id="exp-summary-body">
                    </div>
                </div>

                {{-- Panduan --}}
                <div class="fo-side-card">
                    <div class="fo-side-card-hd">
                        <h5>Panduan Pengisian</h5>
                    </div>
                    <div class="fo-side-card-body">
                        <div class="fo-guide-item">
                            <span class="fo-guide-num">1.</span>
                            <span>Setiap batch harus memiliki nomor batch yang unik dan jelas.</span>
                        </div>
                        <div class="fo-guide-item">
                            <span class="fo-guide-num">2.</span>
                            <span>Tanggal kadaluarsa wajib lebih besar dari tanggal masuk.</span>
                        </div>
                        <div class="fo-guide-item">
                            <span class="fo-guide-num">3.</span>
                            <span>Stok dengan kadaluarsa &lt;30 hari akan ditandai sebagai kritis.</span>
                        </div>
                        <div class="fo-guide-item">
                            <span class="fo-guide-num">4.</span>
                            <span>Harga satuan bersifat opsional dan bisa diisi sesuai harga beli batch ini.</span>
                        </div>
                    </div>
                </div>

                <div class="fo-tip">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Gunakan metode FEFO (First Expired, First Out) — stok dengan kadaluarsa terdekat digunakan lebih
                        dulu.</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        /* ── Update preview varian ── */
        function updateVarianPreview(sel) {
            const opt = sel.options[sel.selectedIndex];
            const val = sel.value;
            const merek = opt.getAttribute('data-merek') || '';
            const dosis = opt.getAttribute('data-dosis') || '';
            const obat = opt.getAttribute('data-obat') || '';
            const jenis = opt.getAttribute('data-jenis') || '';

            // inline preview
            const preview = document.getElementById('varian-preview');
            if (val) {
                document.getElementById('vp-merek').textContent = `${merek} ${dosis}mg`;
                document.getElementById('vp-meta').textContent = `${obat}  •  ${jenis}`;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

            // sidebar
            const sidebar = document.getElementById('sidebar-varian-info');
            if (val) {
                sidebar.innerHTML = `
            <div style="font-size:13.5px;font-weight:600;color:#E8E8E0;margin-bottom:4px">${merek}</div>
            <div style="font-size:11.5px;color:#8A97A8;margin-bottom:12px">${obat}</div>
            <div class="fo-info-row">
                <span class="fo-info-label">Dosis</span>
                <span class="fo-info-value">${dosis} mg</span>
            </div>
            <div class="fo-info-row">
                <span class="fo-info-label">Jenis</span>
                <span style="background:rgba(30,64,175,0.25);color:#93C5FD;border:1px solid rgba(147,197,253,0.2);padding:2px 9px;border-radius:20px;font-size:11px;font-weight:600">${jenis}</span>
            </div>
        `;
            } else {
                sidebar.innerHTML =
                    `<div style="font-size:12px;color:#5A6472;text-align:center;padding:12px 0">Pilih varian obat terlebih dahulu</div>`;
            }
        }

        /* ── Cek status kadaluarsa ── */
        function cekKadaluarsa(input) {
            const expInfo = document.getElementById('exp-info');
            const expCard = document.getElementById('exp-summary-card');
            const expBody = document.getElementById('exp-summary-body');
            const val = input.value;

            // Reset semua class
            expInfo.className = 'fo-exp-info';

            if (!val) {
                expInfo.style.display = 'none';
                expCard.style.display = 'none';
                return;
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const tglExp = new Date(val);
            const selisih = Math.floor((tglExp - today) / 86400000);

            let cls, icon, msg, sideColor, sideBg, sideBorder;

            if (selisih < 0) {
                cls = 'fo-exp-expired';
                icon = '⚠';
                msg = 'Obat sudah kadaluarsa!';
                sideColor = '#FCA5A5';
                sideBg = 'rgba(153,27,27,0.2)';
                sideBorder = 'rgba(252,165,165,0.2)';
            } else if (selisih <= 30) {
                cls = 'fo-exp-kritis';
                icon = '⚠';
                msg = `Kritis — kadaluarsa dalam ${selisih} hari`;
                sideColor = '#FCA5A5';
                sideBg = 'rgba(153,27,27,0.15)';
                sideBorder = 'rgba(252,165,165,0.15)';
            } else if (selisih <= 90) {
                cls = 'fo-exp-warning';
                icon = '⚠';
                msg = `Peringatan — kadaluarsa dalam ${selisih} hari`;
                sideColor = '#FCD34D';
                sideBg = 'rgba(146,64,14,0.2)';
                sideBorder = 'rgba(252,211,77,0.2)';
            } else {
                cls = 'fo-exp-aman';
                icon = '✓';
                msg = `Aman — kadaluarsa dalam ${selisih} hari`;
                sideColor = '#6EE7B7';
                sideBg = 'rgba(6,95,70,0.2)';
                sideBorder = 'rgba(52,211,153,0.2)';
            }

            expInfo.classList.add(cls);
            expInfo.style.display = 'block';
            expInfo.textContent = `${icon} ${msg}`;

            expCard.style.display = 'block';
            expBody.innerHTML = `
        <div style="background:${sideBg};border:1px solid ${sideBorder};border-radius:8px;padding:12px 14px;text-align:center">
            <div style="font-size:22px;font-weight:700;color:${sideColor}">${selisih < 0 ? 'EXP' : selisih}</div>
            <div style="font-size:11px;color:${sideColor};margin-top:2px">${selisih < 0 ? 'Sudah kadaluarsa' : 'hari tersisa'}</div>
        </div>
    `;
        }

        function resetExpInfo() {
            const expInfo = document.getElementById('exp-info');
            expInfo.style.display = 'none';
            expInfo.className = 'fo-exp-info';
            document.getElementById('exp-summary-card').style.display = 'none';
            document.getElementById('varian-preview').style.display = 'none';
        }

        /* ── Uppercase no_batch ── */
        document.getElementById('no_batch').addEventListener('input', function() {
            const pos = this.selectionStart;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(pos, pos);
        });

        /* ── Validasi submit ── */
        document.getElementById('formStokObat').addEventListener('submit', function(e) {
            const tglMasuk = new Date(document.querySelector('input[name="tanggal_masuk"]').value);
            const tglExp = new Date(document.getElementById('tanggal_kadaluarsa').value);
            if (tglExp && tglMasuk && tglExp <= tglMasuk) {
                e.preventDefault();
                alert('Tanggal kadaluarsa harus lebih besar dari tanggal masuk.');
                return;
            }
            const jumlah = parseInt(document.getElementById('jumlah').value);
            if (jumlah < 1) {
                e.preventDefault();
                alert('Jumlah stok minimal 1.');
                return;
            }
        });

        /* ── Trigger jika ada old value ── */
        window.addEventListener('DOMContentLoaded', function() {
            const selV = document.getElementById('id_varian');
            if (selV.value) updateVarianPreview(selV);

            const oldExp = document.getElementById('tanggal_kadaluarsa').value;
            if (oldExp) cekKadaluarsa(document.getElementById('tanggal_kadaluarsa'));
        });
    </script>

@endsection
