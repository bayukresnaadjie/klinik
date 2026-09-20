{{-- resources/views/jenis_obat/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Jenis Obat — ' . $jenisObat->nama_jenis)

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        .mx {
            --gold: #E2B96F;
            --gold2: #C9953A;
            --gold-dim: rgba(226, 185, 111, 0.08);
            --bg2: #13161D;
            --bg3: #1A1E28;
            --border: rgba(255, 255, 255, 0.07);
            --border2: rgba(226, 185, 111, 0.2);
            --tx1: #F0EDE6;
            --tx2: #8C95A6;
            --tx3: #4A5568;
            --green: #4ADE80;
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
            margin-bottom: 28px;
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

        .mx-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            background: none;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--tx2);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all .2s;
            white-space: nowrap;
        }

        .mx-btn-back:hover {
            border-color: var(--border2);
            color: var(--gold);
            background: var(--gold-dim);
        }

        /* ── Grid ── */
        .mx-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 768px) {
            .mx-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Card ── */
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
            font-size: 11px;
            color: var(--tx2);
            margin-top: 1px;
        }

        .mx-card-body {
            padding: 22px;
        }

        /* ── Fields ── */
        .mx-field {
            margin-bottom: 18px;
        }

        .mx-field:last-child {
            margin-bottom: 0;
        }

        .mx-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx2);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .mx-req {
            color: var(--gold);
            margin-left: 2px;
        }

        .mx-input {
            width: 100%;
            box-sizing: border-box;
            padding: 9px 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            color: var(--tx1);
            background: var(--bg3);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .mx-input:focus {
            border-color: var(--border2);
            box-shadow: 0 0 0 3px rgba(226, 185, 111, .08);
        }

        .mx-input::placeholder {
            color: var(--tx3);
        }

        .mx-input.is-invalid {
            border-color: rgba(248, 113, 113, .5);
            box-shadow: 0 0 0 3px rgba(248, 113, 113, .08);
        }

        .mx-error-msg {
            font-size: 11.5px;
            color: #fca5a5;
            margin-top: 5px;
        }

        /* ── Preview box ── */
        .mx-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            background: var(--bg3);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .mx-preview-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #1a0f00;
        }

        .mx-preview-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--tx1);
        }

        .mx-preview-sub {
            font-size: 11.5px;
            color: var(--tx3);
            margin-top: 2px;
        }

        /* ── Card footer ── */
        .mx-card-foot {
            display: flex;
            gap: 8px;
            align-items: center;
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, .1);
            flex-wrap: wrap;
        }

        /* ── Buttons ── */
        .mx-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a0f00;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border-radius: 9px;
            border: none;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 16px rgba(226, 185, 111, .25);
        }

        .mx-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(226, 185, 111, .4);
        }

        .mx-btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            background: none;
            border: 1px solid rgba(248, 113, 113, .2);
            border-radius: 9px;
            color: var(--red);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all .15s;
            margin-left: auto;
        }

        .mx-btn-cancel:hover {
            background: rgba(248, 113, 113, .1);
            border-color: rgba(248, 113, 113, .4);
            color: var(--red);
        }

        /* ── Sidebar ── */
        .mx-sidebar {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .mx-info-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .mx-info-card-hd {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--gold-dim) 0%, transparent 60%);
            font-size: 13px;
            font-weight: 700;
            color: var(--tx1);
        }

        .mx-info-card-body {
            padding: 16px;
        }

        .mx-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 9px 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            font-size: 12.5px;
            gap: 12px;
        }

        .mx-info-row:last-child {
            border-bottom: none;
        }

        .mx-info-label {
            color: var(--tx2);
            flex-shrink: 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 600;
        }

        .mx-info-value {
            color: var(--tx1);
            font-weight: 600;
            text-align: right;
        }

        .mx-info-value.mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
        }

        .mx-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 12px 0;
        }

        .mx-tip {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 12px 14px;
            border-radius: 10px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            font-size: 12px;
            color: var(--gold);
            line-height: 1.6;
        }

        .mx-tip svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* panduan list */
        .mx-guide {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mx-guide li {
            display: flex;
            gap: 7px;
            font-size: 12px;
            color: var(--tx2);
            line-height: 1.6;
        }

        .mx-guide li span {
            color: var(--gold);
            flex-shrink: 0;
        }
    </style>

    <div class="mx">

        {{-- Header --}}
        <div class="mx-header">
            <div>
                <div class="mx-eyebrow">Master Data</div>
                <div class="mx-title">Edit Jenis Obat</div>
                <div class="mx-sub">Ubah nama kategori jenis obat</div>
            </div>
            <a href="{{ route('master.jenis-obat.index') }}" class="mx-btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="mx-grid">

            {{-- ── Form Card ── --}}
            <div class="mx-card">
                <div class="mx-card-top">
                    <div class="mx-card-icon">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </div>
                    <div>
                        <div class="mx-card-title">Edit Data Jenis Obat</div>
                        <div class="mx-card-sub">Ubah informasi kategori obat</div>
                    </div>
                </div>

                <form action="{{ route('master.jenis-obat.update', $jenisObat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mx-card-body">

                        {{-- Preview live --}}
                        <div class="mx-preview">
                            <div class="mx-preview-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                    <line x1="7" y1="7" x2="7.01" y2="7" />
                                </svg>
                            </div>
                            <div>
                                <div class="mx-preview-name" id="previewName">{{ $jenisObat->nama_jenis }}</div>
                                <div class="mx-preview-sub">Dibuat {{ $jenisObat->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        {{-- Nama Jenis --}}
                        <div class="mx-field">
                            <label class="mx-label" for="nama_jenis">
                                Nama Jenis Obat <span class="mx-req">*</span>
                            </label>
                            <input type="text" id="nama_jenis" name="nama_jenis"
                                class="mx-input {{ $errors->has('nama_jenis') ? 'is-invalid' : '' }}"
                                value="{{ old('nama_jenis', $jenisObat->nama_jenis) }}"
                                placeholder="Contoh: Tablet, Sirup, Kapsul"
                                oninput="document.getElementById('previewName').textContent = this.value || '...'" required
                                autofocus>
                            @error('nama_jenis')
                                <div class="mx-error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mx-card-foot">
                        <button type="submit" class="mx-btn-submit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('master.jenis-obat.index') }}" class="mx-btn-cancel">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            {{-- ── Sidebar ── --}}
            <div class="mx-sidebar">

                {{-- Data saat ini --}}
                <div class="mx-info-card">
                    <div class="mx-info-card-hd">Data Saat Ini</div>
                    <div class="mx-info-card-body">
                        <div class="mx-info-row">
                            <span class="mx-info-label">ID</span>
                            <span class="mx-info-value mono">#{{ $jenisObat->id_jenis ?? $jenisObat->id }}</span>
                        </div>
                        <div class="mx-info-row">
                            <span class="mx-info-label">Nama Jenis</span>
                            <span class="mx-info-value">{{ $jenisObat->nama_jenis }}</span>
                        </div>
                        <div class="mx-info-row">
                            <span class="mx-info-label">Jumlah Obat</span>
                            <span class="mx-info-value"
                                style="color:var(--blue)">{{ $jenisObat->obat_count ?? $jenisObat->obat()->count() }}
                                obat</span>
                        </div>
                        <div class="mx-divider" style="margin:4px 0 8px;"></div>
                        <div class="mx-info-row">
                            <span class="mx-info-label">Dibuat</span>
                            <span class="mx-info-value mono"
                                style="font-size:11px;">{{ $jenisObat->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="mx-info-row">
                            <span class="mx-info-label">Diubah</span>
                            <span class="mx-info-value mono"
                                style="font-size:11px;">{{ $jenisObat->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Panduan --}}
                <div class="mx-info-card">
                    <div class="mx-info-card-hd">Panduan</div>
                    <div class="mx-info-card-body">
                        <ul class="mx-guide">
                            <li><span>•</span> Jenis obat digunakan untuk mengkategorikan obat (zat aktif).</li>
                            <li><span>•</span> Pastikan nama jenis tidak duplikat dengan data yang sudah ada.</li>
                            <li><span>•</span> Perubahan nama akan berpengaruh ke seluruh obat di bawahnya.</li>
                            <li><span>•</span> Gunakan nama yang jelas, contoh: Tablet, Sirup, Kapsul.</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
