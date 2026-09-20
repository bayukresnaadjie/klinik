{{-- resources/views/varian_obat/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Varian Obat — ' . $varianObat->nama_merek)

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        .mx {
            --gold: #E2B96F;
            --gold2: #C9953A;
            --gold-dim: rgba(226, 185, 111, 0.08);
            --bg2: #13161D;
            --bg3: #1A1E28;
            --bg4: #222838;
            --border: rgba(255, 255, 255, 0.07);
            --border2: rgba(226, 185, 111, 0.2);
            --tx1: #F0EDE6;
            --tx2: #8C95A6;
            --tx3: #4A5568;
            --red: #F87171;
            --teal: #2DD4BF;
            --amber: #FCD34D;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            color: var(--tx1);
        }

        .mx-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .mx-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .mx-eyebrow::before {
            content: '';
            display: block;
            width: 18px;
            height: 1.5px;
            background: var(--gold);
            border-radius: 2px;
        }

        .mx-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--tx1);
            letter-spacing: -.5px;
            line-height: 1;
        }

        .mx-sub {
            font-size: 12.5px;
            color: var(--tx2);
            margin-top: 5px;
        }

        .mx-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--tx3);
            margin-bottom: 18px;
        }

        .mx-breadcrumb a {
            color: var(--gold);
            text-decoration: none;
        }

        .mx-breadcrumb a:hover {
            text-decoration: underline;
        }

        .mx-btn-back {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--bg3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tx2);
            text-decoration: none !important;
            flex-shrink: 0;
            transition: .15s;
        }

        .mx-btn-back:hover {
            border-color: var(--border2);
            color: var(--gold);
        }

        .mx-harga-badge {
            padding: 4px 13px;
            border-radius: 20px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            font-size: 12px;
            font-weight: 700;
            color: var(--gold);
            font-family: 'JetBrains Mono', monospace;
        }

        .mx-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            align-items: start;
        }

        @media (max-width:840px) {
            .mx-grid {
                grid-template-columns: 1fr;
            }
        }

        .mx-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .4);
        }

        .mx-card-top {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--gold-dim) 0%, transparent 50%);
        }

        .mx-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            flex-shrink: 0;
        }

        .mx-card-icon.teal {
            background: rgba(45, 212, 191, .1);
            border-color: rgba(45, 212, 191, .25);
            color: var(--teal);
        }

        .mx-card-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--tx1);
        }

        .mx-card-sub {
            font-size: 11.5px;
            color: var(--tx3);
            margin-top: 1px;
        }

        .mx-card-body {
            padding: 24px 22px;
        }

        .mx-preview {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 12px;
            background: var(--bg3);
            border: 1px solid var(--border);
            margin-bottom: 22px;
        }

        .mx-preview-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a0f00;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .mx-preview-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--tx1);
        }

        .mx-preview-meta {
            font-size: 11.5px;
            color: var(--tx3);
            margin-top: 2px;
            font-family: 'JetBrains Mono', monospace;
        }

        .mx-preview-tags {
            display: flex;
            gap: 6px;
            margin-top: 7px;
            flex-wrap: wrap;
        }

        .mx-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: var(--gold-dim);
            color: var(--gold);
            border: 1px solid var(--border2);
        }

        .mx-badge-muted {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: var(--bg4);
            color: var(--tx2);
            border: 1px solid var(--border);
        }

        .mx-field {
            margin-bottom: 16px;
        }

        .mx-field:last-child {
            margin-bottom: 0;
        }

        .mx-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx2);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 7px;
        }

        .mx-req {
            color: var(--gold);
        }

        .mx-input,
        .mx-select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 13px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: var(--bg3);
            color: var(--tx1);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, background .15s;
        }

        .mx-input:focus,
        .mx-select:focus {
            border-color: var(--border2);
            background: var(--bg4);
        }

        .mx-input::placeholder {
            color: var(--tx3);
        }

        .mx-select {
            cursor: pointer;
        }

        .mx-select option {
            background: var(--bg3);
            color: var(--tx1);
        }

        .mx-input.is-invalid,
        .mx-select.is-invalid,
        .mx-input-group.is-invalid {
            border-color: rgba(248, 113, 113, .5);
        }

        .mx-error {
            font-size: 11.5px;
            color: var(--red);
            margin-top: 6px;
        }

        .mx-input-group {
            display: flex;
            border-radius: 9px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: border-color .15s;
            background: var(--bg3);
        }

        .mx-input-group:focus-within {
            border-color: var(--border2);
        }

        .mx-input-group .mx-input {
            border: none;
            background: transparent;
            border-radius: 0;
            flex: 1;
            min-width: 0;
        }

        .mx-input-group .mx-input:focus {
            background: transparent;
        }

        .mx-input-addon {
            padding: 10px 12px;
            background: var(--bg4);
            color: var(--tx3);
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .mx-input-addon.prefix {
            border-right: 1px solid var(--border);
        }

        .mx-input-addon.suffix {
            border-left: 1px solid var(--border);
        }

        .mx-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width:480px) {
            .mx-field-row {
                grid-template-columns: 1fr;
            }
        }

        .mx-btn-submit {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a0f00;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all .2s;
            margin-top: 18px;
            box-shadow: 0 4px 20px rgba(226, 185, 111, 0.25);
        }

        .mx-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(226, 185, 111, 0.4);
        }

        .mx-btn-submit.teal {
            background: linear-gradient(135deg, var(--teal), #14b8a6);
            color: #06231d;
            box-shadow: 0 4px 20px rgba(45, 212, 191, .25);
            margin-top: 14px;
        }

        .mx-btn-submit.teal:hover {
            box-shadow: 0 8px 28px rgba(45, 212, 191, .4);
        }

        .mx-btn-cancel {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            background: none;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--tx2);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            transition: all .15s;
            margin-top: 8px;
        }

        .mx-btn-cancel:hover {
            border-color: rgba(248, 113, 113, .4);
            color: var(--red);
            background: rgba(248, 113, 113, .08);
        }

        .mx-harga-box {
            padding: 11px 14px;
            border-radius: 10px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mx-harga-box-label {
            font-size: 11.5px;
            color: var(--tx2);
        }

        .mx-harga-box-val {
            font-size: 15px;
            font-weight: 700;
            color: var(--gold);
            font-family: 'JetBrains Mono', monospace;
        }

        .mx-note {
            margin-top: 10px;
            padding: 10px 12px;
            background: rgba(252, 211, 77, .08);
            border: 1px solid rgba(252, 211, 77, .2);
            border-radius: 9px;
            font-size: 11.5px;
            color: var(--amber);
            line-height: 1.5;
        }

        .mx-section-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin: 0 0 14px;
        }

        .mx-data-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mx-data-key {
            font-size: 10.5px;
            color: var(--tx3);
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .mx-data-val {
            font-size: 13px;
            color: var(--tx1);
            font-weight: 500;
        }

        .mx-data-val.mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--gold);
        }

        .mx-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 16px 0;
        }

        .mx-guide-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mx-guide-list li {
            display: flex;
            gap: 8px;
            font-size: 12px;
            color: var(--tx2);
            line-height: 1.6;
        }

        .mx-guide-list li span.dot {
            color: var(--gold);
            flex-shrink: 0;
        }
    </style>

    <div class="mx">

        <div class="mx-breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('master.varian-obat.index') }}">Varian Obat</a>
            <span>›</span>
            <span style="color:var(--tx1)">Edit Varian</span>
        </div>

        <div class="mx-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('master.varian-obat.index') }}" class="mx-btn-back" title="Kembali">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </a>
                <div>
                    <div class="mx-eyebrow">Master Data</div>
                    <div class="mx-title">Edit Varian Obat</div>
                    <div class="mx-sub">Ubah merek, dosis, dan harga</div>
                </div>
            </div>
            <span class="mx-harga-badge">Rp {{ number_format($varianObat->harga, 0, ',', '.') }}</span>
        </div>

        <div class="mx-grid">

            {{-- ── KOLOM KIRI: Detail Varian + Ubah Harga ── --}}
            <div style="display:flex; flex-direction:column; gap:18px;">

                {{-- Card 1: Detail Varian --}}
                <div class="mx-card">
                    <div class="mx-card-top">
                        <div class="mx-card-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="mx-card-title">Detail Varian</div>
                            <div class="mx-card-sub">Merek dagang, dosis, dan harga</div>
                        </div>
                    </div>
                    <div class="mx-card-body">

                        <div class="mx-preview">
                            <div class="mx-preview-icon">💊</div>
                            <div>
                                <div class="mx-preview-name">{{ $varianObat->nama_merek }}</div>
                                <div class="mx-preview-meta">
                                    {{ $varianObat->dosis_mg }} mg · Rp {{ number_format($varianObat->harga, 0, ',', '.') }}
                                </div>
                                <div class="mx-preview-tags">
                                    <span class="mx-badge">{{ $varianObat->obat->nama_obat ?? '-' }}</span>
                                    <span
                                        class="mx-badge-muted">{{ $varianObat->obat->jenisObat->nama_jenis ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('master.varian-obat.update', $varianObat) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mx-field">
                                <label class="mx-label" for="id_obat">
                                    Nama Obat (Zat Aktif) <span class="mx-req">*</span>
                                </label>
                                <select id="id_obat" name="id_obat"
                                    class="mx-select {{ $errors->has('id_obat') ? 'is-invalid' : '' }}" required>
                                    <option value="" disabled>Pilih zat aktif</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->id_obat }}"
                                            {{ old('id_obat', $varianObat->id_obat) == $item->id_obat ? 'selected' : '' }}>
                                            {{ $item->nama_obat }} ({{ $item->jenisObat->nama_jenis ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_obat')
                                    <div class="mx-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mx-field">
                                <label class="mx-label" for="nama_merek">
                                    Nama Merek / Dagang <span class="mx-req">*</span>
                                </label>
                                <input id="nama_merek" name="nama_merek" type="text"
                                    class="mx-input {{ $errors->has('nama_merek') ? 'is-invalid' : '' }}"
                                    value="{{ old('nama_merek', $varianObat->nama_merek) }}"
                                    placeholder="Contoh: Amoxicillin 500mg" required>
                                @error('nama_merek')
                                    <div class="mx-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mx-field-row">
                                <div class="mx-field" style="margin-bottom:0">
                                    <label class="mx-label" for="dosis_mg">
                                        Dosis <span class="mx-req">*</span>
                                    </label>
                                    <div class="mx-input-group {{ $errors->has('dosis_mg') ? 'is-invalid' : '' }}">
                                        <input id="dosis_mg" name="dosis_mg" type="number" min="1" class="mx-input"
                                            value="{{ old('dosis_mg', $varianObat->dosis_mg) }}" placeholder="0" required>
                                        <span class="mx-input-addon suffix">mg</span>
                                    </div>
                                    @error('dosis_mg')
                                        <div class="mx-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mx-field" style="margin-bottom:0">
                                    <label class="mx-label" for="harga">
                                        Harga Satuan <span class="mx-req">*</span>
                                    </label>
                                    <div class="mx-input-group {{ $errors->has('harga') ? 'is-invalid' : '' }}">
                                        <span class="mx-input-addon prefix">Rp</span>
                                        <input id="harga" name="harga" type="number" min="0" class="mx-input"
                                            value="{{ old('harga', $varianObat->harga) }}" placeholder="0" required>
                                    </div>
                                    @error('harga')
                                        <div class="mx-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="mx-btn-submit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('master.varian-obat.index') }}" class="mx-btn-cancel">Batal</a>
                        </form>

                    </div>
                </div>{{-- /Card 1 --}}

                {{-- Card 2: Ubah Harga --}}
                <div class="mx-card">
                    <div class="mx-card-top">
                        <div class="mx-card-icon teal">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <div>
                            <div class="mx-card-title">Ubah Harga</div>
                            <div class="mx-card-sub">Harga lama tetap berlaku sampai tanggal yang dipilih</div>
                        </div>
                    </div>
                    <div class="mx-card-body">

                        <div class="mx-harga-box">
                            <span class="mx-harga-box-label">Harga aktif sekarang</span>
                            <span class="mx-harga-box-val">
                                Rp {{ number_format($varianObat->hargaAktif?->harga ?? $varianObat->harga, 0, ',', '.') }}
                            </span>
                        </div>

                        <form action="{{ route('master.harga-varian.update', $varianObat->id_varian) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="mx-field-row">
                                <div class="mx-field" style="margin-bottom:0">
                                    <label class="mx-label" for="harga_baru">
                                        Harga Baru <span class="mx-req">*</span>
                                    </label>
                                    <div class="mx-input-group {{ $errors->has('harga') ? 'is-invalid' : '' }}">
                                        <span class="mx-input-addon prefix">Rp</span>
                                        <input id="harga_baru" name="harga" type="number" min="0"
                                            class="mx-input" placeholder="0" value="{{ old('harga') }}" required>
                                    </div>
                                    @error('harga')
                                        <div class="mx-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mx-field" style="margin-bottom:0">
                                    <label class="mx-label" for="berlaku_mulai">
                                        Berlaku Mulai <span class="mx-req">*</span>
                                    </label>
                                    <input id="berlaku_mulai" name="berlaku_mulai" type="date"
                                        class="mx-input {{ $errors->has('berlaku_mulai') ? 'is-invalid' : '' }}"
                                        min="{{ now()->toDateString() }}"
                                        value="{{ old('berlaku_mulai', now()->startOfMonth()->toDateString()) }}"
                                        required>
                                    @error('berlaku_mulai')
                                        <div class="mx-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mx-note">
                                Harga lama akan otomatis ditutup sehari sebelum tanggal berlaku baru.
                            </div>

                            <button type="submit" class="mx-btn-submit teal">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Simpan Harga Baru
                            </button>
                        </form>

                    </div>
                </div>{{-- /Card 2 --}}

            </div>{{-- /kolom kiri --}}

            {{-- ── KOLOM KANAN: Informasi ── --}}
            <div class="mx-card">
                <div class="mx-card-top">
                    <div class="mx-card-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <div class="mx-card-title">Informasi</div>
                        <div class="mx-card-sub">Detail dan panduan pengisian</div>
                    </div>
                </div>
                <div class="mx-card-body">

                    <div class="mx-harga-box">
                        <span class="mx-harga-box-label">Harga satuan saat ini</span>
                        <span class="mx-harga-box-val">Rp {{ number_format($varianObat->harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="mx-section-label">Data Saat Ini</div>
                    <div class="mx-data-row">
                        <div>
                            <div class="mx-data-key">ID</div>
                            <div class="mx-data-val mono">#{{ $varianObat->id_varian ?? $varianObat->id }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Zat Aktif</div>
                            <div class="mx-data-val">{{ $varianObat->obat->nama_obat ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Jenis Obat</div>
                            <div class="mx-data-val">{{ $varianObat->obat->jenisObat->nama_jenis ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Nama Merek</div>
                            <div class="mx-data-val">{{ $varianObat->nama_merek }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Dosis</div>
                            <div class="mx-data-val">{{ $varianObat->dosis_mg }} mg</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Harga Satuan</div>
                            <div class="mx-data-val">Rp {{ number_format($varianObat->harga, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Dibuat</div>
                            <div class="mx-data-val">{{ $varianObat->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Terakhir Diubah</div>
                            <div class="mx-data-val">{{ $varianObat->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <hr class="mx-divider">

                    <div class="mx-section-label">Panduan</div>
                    <ul class="mx-guide-list">
                        <li><span class="dot">•</span> Varian obat adalah produk spesifik dari suatu zat aktif.</li>
                        <li><span class="dot">•</span> Dosis diisi dalam satuan miligram (mg).</li>
                        <li><span class="dot">•</span> Harga satuan adalah harga per unit/tablet/kapsul.</li>
                        <li><span class="dot">•</span> Gunakan form Ubah Harga untuk mengatur harga baru yang berlaku di
                            bulan mendatang.</li>
                        <li><span class="dot">•</span> Perubahan harga tidak mengubah harga pada resep yang sudah ada.
                        </li>
                    </ul>

                </div>
            </div>{{-- /Card 3: Informasi --}}

        </div>{{-- /mx-grid --}}
    </div>
@endsection
