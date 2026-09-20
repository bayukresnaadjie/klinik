{{-- resources/views/obat/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Obat — ' . $obat->nama_obat)

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

        .mx-jenis-badge {
            padding: 3px 12px;
            border-radius: 20px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            font-size: 11px;
            font-weight: 600;
            color: var(--gold);
        }

        .mx-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
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

        .mx-card-footer {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, .15);
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

        .mx-field {
            margin-bottom: 18px;
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

        .mx-select {
            cursor: pointer;
        }

        .mx-select option {
            background: var(--bg3);
            color: var(--tx1);
        }

        .mx-input.is-invalid,
        .mx-select.is-invalid {
            border-color: rgba(248, 113, 113, .5);
        }

        .mx-error {
            font-size: 11.5px;
            color: var(--red);
            margin-top: 6px;
        }

        .mx-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a0f00;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 20px rgba(226, 185, 111, 0.25);
        }

        .mx-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(226, 185, 111, 0.4);
        }

        .mx-btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 10px 18px;
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
            margin-left: auto;
        }

        .mx-btn-cancel:hover {
            border-color: rgba(248, 113, 113, .4);
            color: var(--red);
            background: rgba(248, 113, 113, .08);
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
            <a href="{{ route('master.obat.index') }}">Data Obat</a>
            <span>›</span>
            <span style="color:var(--tx1)">Edit Obat</span>
        </div>

        <div class="mx-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <a href="{{ route('master.obat.index') }}" class="mx-btn-back" title="Kembali">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </a>
                <div>
                    <div class="mx-eyebrow">Master Data</div>
                    <div class="mx-title">Edit Obat</div>
                    <div class="mx-sub">Ubah data zat aktif / nama generik obat</div>
                </div>
            </div>
            <span class="mx-jenis-badge">{{ $obat->jenisObat->nama_jenis ?? '-' }}</span>
        </div>

        <div class="mx-grid">

            {{-- ── Card 1: Form Edit ── --}}
            <div class="mx-card">
                <div class="mx-card-top">
                    <div class="mx-card-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18" />
                        </svg>
                    </div>
                    <div>
                        <div class="mx-card-title">Data Zat Aktif</div>
                        <div class="mx-card-sub">Informasi nama generik dan jenis sediaan obat</div>
                    </div>
                </div>

                <div class="mx-card-body">

                    <div class="mx-preview">
                        <div class="mx-preview-icon">⚗️</div>
                        <div>
                            <div class="mx-preview-name">{{ $obat->nama_obat }}</div>
                            <div class="mx-preview-meta">ID #{{ $obat->id_obat }}</div>
                        </div>
                    </div>

                    <form action="{{ route('master.obat.update', $obat->id_obat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mx-field">
                            <label class="mx-label" for="nama_obat">
                                Nama Obat (Zat Aktif) <span class="mx-req">*</span>
                            </label>
                            <input id="nama_obat" name="nama_obat" type="text"
                                class="mx-input {{ $errors->has('nama_obat') ? 'is-invalid' : '' }}"
                                value="{{ old('nama_obat', $obat->nama_obat) }}"
                                placeholder="Contoh: Amoxicillin, Paracetamol" required>
                            @error('nama_obat')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mx-field">
                            <label class="mx-label" for="id_jenis">
                                Jenis Obat <span class="mx-req">*</span>
                            </label>
                            <select id="id_jenis" name="id_jenis"
                                class="mx-select {{ $errors->has('id_jenis') ? 'is-invalid' : '' }}" required>
                                <option value="" disabled>Pilih jenis obat</option>
                                @foreach ($jenisObat as $jenis)
                                    <option value="{{ $jenis->id_jenis }}"
                                        {{ old('id_jenis', $obat->id_jenis) == $jenis->id_jenis ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mx-card-footer" style="margin:22px -22px -22px; padding-left:22px; padding-right:22px;">
                            <button type="submit" class="mx-btn-submit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('master.obat.index') }}" class="mx-btn-cancel">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Card 2: Info ── --}}
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

                    <div class="mx-section-label">Data Saat Ini</div>
                    <div class="mx-data-row">
                        <div>
                            <div class="mx-data-key">ID</div>
                            <div class="mx-data-val mono">#{{ $obat->id_obat }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Jenis Obat</div>
                            <div class="mx-data-val">{{ $obat->jenisObat->nama_jenis ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Nama Obat</div>
                            <div class="mx-data-val">{{ $obat->nama_obat }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Jumlah Varian</div>
                            <div class="mx-data-val">{{ $obat->varian_obat_count ?? $obat->varianObat()->count() }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Dibuat</div>
                            <div class="mx-data-val">{{ $obat->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <div class="mx-data-key">Terakhir Diubah</div>
                            <div class="mx-data-val">{{ $obat->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <hr class="mx-divider">

                    <div class="mx-section-label">Panduan</div>
                    <ul class="mx-guide-list">
                        <li><span class="dot">•</span> Zat aktif merupakan kandungan utama dalam suatu obat.</li>
                        <li><span class="dot">•</span> Pilih jenis obat yang sesuai dengan bentuk sediaannya.</li>
                        <li><span class="dot">•</span> Perubahan akan mempengaruhi semua varian obat yang terkait.</li>
                        <li><span class="dot">•</span> Pastikan nama menggunakan nama generik yang baku.</li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
@endsection
