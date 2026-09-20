{{-- resources/views/varian_obat/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Varian Obat')

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
            --blue: #60A5FA;
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

        .mx-alert-danger {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 18px;
            background: rgba(248, 113, 113, .1);
            color: #fca5a5;
            border: 1px solid rgba(248, 113, 113, .2);
        }

        .mx-alert-danger ul {
            margin: 6px 0 0 16px;
            padding: 0;
        }

        .mx-alert-danger li {
            margin-bottom: 2px;
        }

        .mx-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
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

        .mx-section-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin: 0 0 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(226, 185, 111, .15);
        }

        .mx-section-label:not(:first-child) {
            margin-top: 22px;
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

        .mx-hint {
            font-size: 11px;
            color: var(--tx3);
            margin-top: 6px;
            font-style: italic;
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
        .mx-select.is-invalid {
            border-color: rgba(248, 113, 113, .5);
        }

        .mx-error {
            font-size: 11.5px;
            color: var(--red);
            margin-top: 6px;
        }

        .mx-input-prefix {
            display: flex;
        }

        .mx-prefix-text {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-right: none;
            border-radius: 9px 0 0 9px;
            background: var(--bg4);
            font-size: 12px;
            color: var(--tx3);
            line-height: 1.4;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .mx-input-prefix .mx-input {
            border-radius: 0 9px 9px 0;
        }

        .mx-input-suffix {
            display: flex;
        }

        .mx-input-suffix .mx-input {
            border-radius: 9px 0 0 9px;
        }

        .mx-suffix-text {
            border: 1px solid var(--border);
            border-left: none;
            border-radius: 0 9px 9px 0;
            background: var(--bg4);
            color: var(--tx3);
            font-size: 12px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            white-space: nowrap;
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

        .mx-btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            background: none;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--tx2);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .mx-btn-reset:hover {
            border-color: var(--border2);
            color: var(--gold);
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

        .mx-sidebar {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .mx-obat-preview {
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            border-radius: 10px;
            padding: 13px 14px;
            display: none;
            margin-top: 10px;
        }

        .mx-obat-preview-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--tx1);
            margin-bottom: 6px;
        }

        .mx-obat-preview-meta {
            font-size: 11.5px;
            color: var(--tx2);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .mx-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(96, 165, 250, .12);
            color: #93c5fd;
            border: 1px solid rgba(96, 165, 250, .2);
        }

        .mx-sidebar-empty {
            font-size: 12px;
            color: var(--tx3);
            text-align: center;
            padding: 14px 0;
        }

        .mx-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            font-size: 12px;
            gap: 8px;
        }

        .mx-info-row:last-child {
            border-bottom: none;
        }

        .mx-info-label {
            color: var(--tx3);
            flex-shrink: 0;
        }

        .mx-info-value {
            color: var(--tx1);
            font-weight: 600;
            text-align: right;
        }

        .mx-tip {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 12px 14px;
            border-radius: 10px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            font-size: 11.5px;
            color: var(--gold);
            line-height: 1.55;
        }

        .mx-tip svg {
            flex-shrink: 0;
            margin-top: 1px;
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
            <span style="color:var(--tx1)">Tambah Varian</span>
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
                    <div class="mx-title">Tambah Varian Obat</div>
                    <div class="mx-sub">Tambahkan merek &amp; dosis baru untuk obat yang sudah terdaftar</div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mx-alert-danger">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    style="flex-shrink:0;margin-top:1px">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
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

        <div class="mx-grid">

            {{-- Form Card --}}
            <div class="mx-card">
                <div class="mx-card-top">
                    <div class="mx-card-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                        </svg>
                    </div>
                    <div>
                        <div class="mx-card-title">Form Data Varian Obat</div>
                        <div class="mx-card-sub">Merek, dosis, dan harga untuk obat induk yang dipilih</div>
                    </div>
                </div>

                <form action="{{ route('master.varian-obat.store') }}" method="POST" id="form-varian">
                    @csrf

                    <div class="mx-card-body">

                        <div class="mx-section-label">Obat Induk</div>

                        <div class="mx-field">
                            <label class="mx-label" for="id_obat">
                                Obat (Zat Aktif) <span class="mx-req">*</span>
                            </label>
                            <select id="id_obat" name="id_obat"
                                class="mx-select {{ $errors->has('id_obat') ? 'is-invalid' : '' }}"
                                onchange="updateObatPreview(this)" required>
                                <option value="" disabled selected>-- Pilih Obat --</option>
                                @foreach ($obatList as $obat)
                                    <option value="{{ $obat->id_obat }}"
                                        data-jenis="{{ $obat->jenisObat->nama_jenis ?? '-' }}"
                                        data-nama="{{ $obat->nama_obat }}"
                                        {{ old('id_obat') == $obat->id_obat ? 'selected' : '' }}>
                                        {{ $obat->nama_obat }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mx-hint">Pilih zat aktif induk untuk varian merek ini.</div>
                            @error('id_obat')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror

                            <div class="mx-obat-preview" id="obat-preview">
                                <div class="mx-obat-preview-name" id="preview-nama">—</div>
                                <div class="mx-obat-preview-meta">
                                    Jenis: <span id="preview-jenis" class="mx-badge">—</span>
                                </div>
                            </div>
                        </div>

                        <div class="mx-section-label">Merek &amp; Dosis</div>

                        <div class="mx-field">
                            <label class="mx-label" for="nama_merek">
                                Nama Merek <span class="mx-req">*</span>
                            </label>
                            <input type="text" id="nama_merek" name="nama_merek"
                                class="mx-input {{ $errors->has('nama_merek') ? 'is-invalid' : '' }}"
                                value="{{ old('nama_merek') }}" placeholder="Contoh: Advil, Allopurinol Generik" required>
                            <div class="mx-hint">Nama dagang / merek dari zat aktif yang dipilih.</div>
                            @error('nama_merek')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mx-field">
                            <label class="mx-label" for="dosis_mg">Dosis</label>
                            <div class="mx-input-suffix">
                                <input type="number" id="dosis_mg" name="dosis_mg" min="0" step="0.01"
                                    class="mx-input {{ $errors->has('dosis_mg') ? 'is-invalid' : '' }}"
                                    value="{{ old('dosis_mg') }}" placeholder="Contoh: 500">
                                <span class="mx-suffix-text">mg</span>
                            </div>
                            <div class="mx-hint">Kosongkan jika varian ini tidak punya dosis spesifik (mis. larutan infus).
                            </div>
                            @error('dosis_mg')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mx-section-label">Harga</div>

                        <div class="mx-field">
                            <label class="mx-label" for="harga">
                                Harga (Rp) <span class="mx-req">*</span>
                            </label>
                            <div class="mx-input-prefix">
                                <span class="mx-prefix-text">Rp</span>
                                <input type="number" id="harga" name="harga" min="0"
                                    class="mx-input {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                                    value="{{ old('harga', 0) }}" required>
                            </div>
                            <div class="mx-hint">Harga ini akan tercatat sebagai entri awal pada Riwayat Harga varian.
                            </div>
                            @error('harga')
                                <div class="mx-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mx-card-footer">
                        <button type="submit" class="mx-btn-submit">
                            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Simpan Varian
                        </button>
                        <button type="reset" class="mx-btn-reset" onclick="resetObatPreview()">
                            <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                        <a href="{{ route('master.varian-obat.index') }}" class="mx-btn-cancel">Batal</a>
                    </div>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="mx-sidebar">

                <div class="mx-card">
                    <div class="mx-card-top">
                        <div class="mx-card-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18" />
                            </svg>
                        </div>
                        <div>
                            <div class="mx-card-title">Info Obat Dipilih</div>
                        </div>
                    </div>
                    <div class="mx-card-body" id="sidebar-obat-info">
                        <div class="mx-sidebar-empty">Pilih obat induk terlebih dahulu</div>
                    </div>
                </div>

                <div class="mx-card">
                    <div class="mx-card-top">
                        <div class="mx-card-icon">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="16" x2="12" y2="12" />
                                <line x1="12" y1="8" x2="12.01" y2="8" />
                            </svg>
                        </div>
                        <div>
                            <div class="mx-card-title">Panduan Pengisian</div>
                        </div>
                    </div>
                    <div class="mx-card-body">
                        <ul class="mx-guide-list">
                            <li><span class="dot">•</span> Varian digunakan untuk membedakan merek dan dosis dari satu
                                zat aktif yang sama.</li>
                            <li><span class="dot">•</span> Satu obat (zat aktif) bisa memiliki banyak varian merek &amp;
                                dosis.</li>
                            <li><span class="dot">•</span> Perubahan harga selanjutnya akan tersimpan otomatis di
                                Riwayat Harga, bukan menimpa harga lama.</li>
                        </ul>
                    </div>
                </div>

                <div class="mx-tip">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Contoh: Allopurinol tersedia sebagai varian "Allopurinol Generik" dengan dosis 100mg dan
                        300mg.</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateObatPreview(sel) {
            const opt = sel.options[sel.selectedIndex];
            const nama = opt.getAttribute('data-nama') || '';
            const jenis = opt.getAttribute('data-jenis') || '';
            const val = sel.value;

            const preview = document.getElementById('obat-preview');
            if (val) {
                document.getElementById('preview-nama').textContent = nama;
                document.getElementById('preview-jenis').textContent = jenis;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

            const sidebar = document.getElementById('sidebar-obat-info');
            if (val) {
                sidebar.innerHTML = `
                <div style="font-size:13.5px;font-weight:700;color:var(--tx1);margin-bottom:10px">${nama}</div>
                <div class="mx-info-row">
                    <span class="mx-info-label">Jenis</span>
                    <span class="mx-badge">${jenis}</span>
                </div>
            `;
            } else {
                sidebar.innerHTML = `<div class="mx-sidebar-empty">Pilih obat induk terlebih dahulu</div>`;
            }
        }

        function resetObatPreview() {
            document.getElementById('obat-preview').style.display = 'none';
            document.getElementById('sidebar-obat-info').innerHTML =
                `<div class="mx-sidebar-empty">Pilih obat induk terlebih dahulu</div>`;
        }

        window.addEventListener('DOMContentLoaded', function() {
            const sel = document.getElementById('id_obat');
            if (sel.value) updateObatPreview(sel);
        });
    </script>
@endsection
