@extends('layouts.app')

@section('title', 'Import Stok Obat')
@section('page-title', 'Import Stok Obat')

@push('styles')
    <style>
        /* ══ PAGE HEADER ══ */
        .im-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--tx-muted);
            text-decoration: none;
            margin-bottom: 6px;
            transition: color .15s;
        }

        .im-back:hover {
            color: var(--clr-blue);
        }

        .im-page-header {
            margin-bottom: 22px;
        }

        .im-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .im-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* ══ LAYOUT ══ */
        .im-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 960px) {
            .im-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ══ CARD ══ */
        .im-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .im-card:last-child {
            margin-bottom: 0;
        }

        .im-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
        }

        .im-card-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .im-card-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .im-card-icon.green {
            background: #DCFCE7;
            color: #16a34a;
        }

        .im-card-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .im-card-icon.purple {
            background: #F3F0FF;
            color: var(--clr-purple);
        }

        .im-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .im-card-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .im-card-body {
            padding: 20px;
        }

        /* ══ STEP BADGE ══ */
        .im-step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--clr-blue);
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ══ STEP 1: Download Template ══ */
        .im-template-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .im-template-info {
            flex: 1;
        }

        .im-template-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tx-base);
            margin-bottom: 4px;
        }

        .im-template-desc {
            font-size: 12px;
            color: var(--tx-muted);
            line-height: 1.6;
        }

        .im-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: var(--radius-sm);
            background: #16a34a;
            color: #fff;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: opacity .15s, box-shadow .15s;
        }

        .im-download-btn:hover {
            opacity: .88;
            box-shadow: 0 4px 12px rgba(22, 163, 74, .3);
        }

        /* ══ STEP 2: Panduan Kolom ══ */
        .im-guide-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .im-guide-tbl thead tr {
            background: #F9FAFB;
        }

        .im-guide-tbl th {
            padding: 8px 12px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--tx-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
        }

        .im-guide-tbl td {
            padding: 9px 12px;
            color: var(--tx-base);
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .im-guide-tbl tr:last-child td {
            border-bottom: none;
        }

        .im-guide-tbl tbody tr:hover {
            background: #FAFAFA;
        }

        .im-guide-tbl .muted {
            color: var(--tx-muted);
            font-size: 11.5px;
        }

        .im-guide-tbl code {
            background: #F3F4F6;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 11.5px;
            color: var(--clr-blue);
            font-family: monospace;
        }

        .im-required-pill {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .im-required-pill.yes {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        .im-required-pill.no {
            background: #F3F4F6;
            color: #6B7280;
            border: 1px solid #E5E7EB;
        }

        /* ══ STEP 3: Upload ══ */
        .im-dropzone {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 36px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            background: var(--page-bg);
            position: relative;
        }

        .im-dropzone:hover,
        .im-dropzone.dragover {
            border-color: var(--clr-blue);
            background: #EFF6FF;
        }

        .im-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .im-dropzone-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #EFF6FF;
            color: var(--clr-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 22px;
        }

        .im-dropzone-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tx-base);
            margin-bottom: 4px;
        }

        .im-dropzone-sub {
            font-size: 12px;
            color: var(--tx-muted);
        }

        .im-dropzone-hint {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 8px;
        }

        /* File selected state */
        .im-file-selected {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            margin-top: 12px;
        }

        .im-file-selected.show {
            display: flex;
        }

        .im-file-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .im-file-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .im-file-size {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .im-file-clear {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--tx-muted);
            padding: 4px;
            border-radius: 4px;
            transition: color .15s;
        }

        .im-file-clear:hover {
            color: var(--clr-red);
        }

        /* Action buttons */
        .im-action-row {
            display: flex;
            gap: 8px;
            margin-top: 14px;
        }

        .im-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all .15s;
        }

        .im-btn:active {
            transform: scale(.98);
        }

        .im-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .im-btn-primary:hover {
            opacity: .88;
            box-shadow: 0 4px 12px rgba(59, 130, 246, .25);
        }

        .im-btn-ghost {
            background: var(--card-bg);
            color: var(--tx-muted);
            border-color: var(--border);
        }

        .im-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        /* ══ RIGHT: Tips Card ══ */
        .im-tip-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .im-tip-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .im-tip-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--page-bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
            color: var(--tx-muted);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .im-tip-text {
            font-size: 12px;
            color: var(--tx-base);
            line-height: 1.65;
        }

        .im-tip-text strong {
            color: var(--tx-base);
            font-weight: 600;
        }

        /* ══ WARNING BOX ══ */
        .im-warn {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 13px 15px;
            border-radius: var(--radius-sm);
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            font-size: 12px;
            color: #92400E;
            line-height: 1.65;
            margin-top: 16px;
        }

        .im-warn svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ══ PROGRESS (upload state) ══ */
        .im-progress-wrap {
            display: none;
            margin-top: 12px;
        }

        .im-progress-wrap.show {
            display: block;
        }

        .im-progress-bar {
            height: 6px;
            background: var(--page-bg);
            border-radius: 99px;
            overflow: hidden;
        }

        .im-progress-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--clr-blue);
            width: 0%;
            transition: width .3s ease;
            animation: progressAnim 1.5s ease-in-out infinite;
        }

        @keyframes progressAnim {
            0% {
                width: 10%;
            }

            50% {
                width: 80%;
            }

            100% {
                width: 95%;
            }
        }

        .im-progress-label {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 6px;
            text-align: center;
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="im-page-header">
        <a href="{{ route('stok-obat.index') }}" class="im-back">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Kembali ke Stok Obat
        </a>
        <div class="im-page-title">Import Stok Obat</div>
        <div class="im-page-sub">Upload file Excel untuk menambah ratusan stok sekaligus</div>
    </div>

    <div class="im-grid">

        {{-- ══ LEFT COLUMN: Steps ══ --}}
        <div>

            {{-- Step 1: Download Template --}}
            <div class="im-card">
                <div class="im-card-header">
                    <span class="im-step-badge">1</span>
                    <div>
                        <div class="im-card-title">Download Template Excel</div>
                        <div class="im-card-sub">Gunakan template resmi agar kolom sesuai format sistem</div>
                    </div>
                </div>
                <div class="im-card-body">
                    <div class="im-template-box">
                        <div class="im-template-info">
                            <div class="im-template-title">📄 template_import_stok.xlsx</div>
                            <div class="im-template-desc">
                                Jangan ubah nama kolom header di baris pertama.<br>
                                Isi data mulai dari baris kedua sesuai panduan kolom di bawah.
                            </div>
                        </div>
                        <a href="{{ route('stok-obat.template') }}" class="im-download-btn">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" x2="12" y1="15" y2="3" />
                            </svg>
                            Download Template
                        </a>
                    </div>
                </div>
            </div>

            {{-- Step 2: Panduan Kolom --}}
            <div class="im-card">
                <div class="im-card-header">
                    <span class="im-step-badge">2</span>
                    <div>
                        <div class="im-card-title">Panduan Pengisian Kolom</div>
                        <div class="im-card-sub">Pastikan format data sesuai agar import berhasil</div>
                    </div>
                </div>
                <div class="im-card-body" style="padding:0;">
                    <div style="overflow-x:auto;">
                        <table class="im-guide-tbl">
                            <thead>
                                <tr>
                                    <th>Kolom</th>
                                    <th>Contoh</th>
                                    <th>Keterangan</th>
                                    <th>Wajib</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>nama_merek</code></td>
                                    <td class="muted">Paracetamol GSK</td>
                                    <td class="muted">Harus cocok dengan data varian di sistem</td>
                                    <td><span class="im-required-pill yes">Ya</span></td>
                                </tr>
                                <tr>
                                    <td><code>dosis_mg</code></td>
                                    <td class="muted">500</td>
                                    <td class="muted">Angka saja, tanpa satuan "mg"</td>
                                    <td><span class="im-required-pill yes">Ya</span></td>
                                </tr>
                                <tr>
                                    <td><code>no_batch</code></td>
                                    <td class="muted">BTH-2024-001</td>
                                    <td class="muted">Nomor batch dari supplier</td>
                                    <td><span class="im-required-pill no">Opsional</span></td>
                                </tr>
                                <tr>
                                    <td><code>jumlah</code></td>
                                    <td class="muted">100</td>
                                    <td class="muted">Angka bulat, minimal 1</td>
                                    <td><span class="im-required-pill yes">Ya</span></td>
                                </tr>
                                <tr>
                                    <td><code>harga_satuan</code></td>
                                    <td class="muted">1500</td>
                                    <td class="muted">Angka rupiah, tanpa titik/koma</td>
                                    <td><span class="im-required-pill no">Opsional</span></td>
                                </tr>
                                <tr>
                                    <td><code>tanggal_masuk</code></td>
                                    <td class="muted">2024-01-15</td>
                                    <td class="muted">Format <code>YYYY-MM-DD</code></td>
                                    <td><span class="im-required-pill no">Opsional</span></td>
                                </tr>
                                <tr>
                                    <td><code>tanggal_kadaluarsa</code></td>
                                    <td class="muted">2026-06-30</td>
                                    <td class="muted">Format <code>YYYY-MM-DD</code>, harus &gt; tanggal masuk</td>
                                    <td><span class="im-required-pill yes">Ya</span></td>
                                </tr>
                                <tr>
                                    <td><code>keterangan</code></td>
                                    <td class="muted">PBF Kimia Farma</td>
                                    <td class="muted">Supplier atau catatan tambahan</td>
                                    <td><span class="im-required-pill no">Opsional</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Step 3: Upload --}}
            <div class="im-card">
                <div class="im-card-header">
                    <span class="im-step-badge">3</span>
                    <div>
                        <div class="im-card-title">Upload File Excel</div>
                        <div class="im-card-sub">Drag & drop atau klik untuk memilih file</div>
                    </div>
                </div>
                <div class="im-card-body">
                    <form action="{{ route('stok-obat.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        @csrf

                        <div class="im-dropzone" id="dropzone" onclick="triggerFile()">
                            <input type="file" name="file" id="fileInput" accept=".xlsx,.xls"
                                onchange="onFileSelected(this)">
                            <div class="im-dropzone-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" x2="12" y1="3" y2="15" />
                                </svg>
                            </div>
                            <div class="im-dropzone-title">Klik atau seret file ke sini</div>
                            <div class="im-dropzone-sub">Format: <strong>.xlsx</strong> atau <strong>.xls</strong></div>
                            <div class="im-dropzone-hint">Maksimal ukuran file: <strong>5 MB</strong></div>
                        </div>

                        {{-- File selected preview --}}
                        <div class="im-file-selected" id="fileSelected">
                            <div class="im-file-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div>
                                <div class="im-file-name" id="fileName">—</div>
                                <div class="im-file-size" id="fileSize">—</div>
                            </div>
                            <button type="button" class="im-file-clear" onclick="clearFile()" title="Hapus file">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" x2="6" y1="6" y2="18" />
                                    <line x1="6" x2="18" y1="6" y2="18" />
                                </svg>
                            </button>
                        </div>

                        {{-- Upload progress --}}
                        <div class="im-progress-wrap" id="progressWrap">
                            <div class="im-progress-bar">
                                <div class="im-progress-fill"></div>
                            </div>
                            <div class="im-progress-label">Sedang mengimport data...</div>
                        </div>

                        @error('file')
                            <div style="margin-top:8px;font-size:11.5px;color:var(--clr-red);">{{ $message }}</div>
                        @enderror

                        <div class="im-action-row">
                            <button type="submit" class="im-btn im-btn-primary" id="submitBtn" disabled
                                onclick="startProgress()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                                Upload &amp; Import
                            </button>
                            <a href="{{ route('stok-obat.index') }}" class="im-btn im-btn-ghost">Batal</a>
                        </div>

                    </form>

                    {{-- Warning --}}
                    <div class="im-warn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                            <line x1="12" x2="12.01" y1="17" y2="17" />
                        </svg>
                        <span>
                            <strong>Catatan penting:</strong> Baris yang gagal divalidasi akan dilewati dan dilaporkan —
                            baris yang valid tetap diimport. Pastikan <code
                                style="background:#FDE68A;padding:1px 5px;border-radius:3px;font-size:11px;">nama_merek</code>
                            dan <code
                                style="background:#FDE68A;padding:1px 5px;border-radius:3px;font-size:11px;">dosis_mg</code>
                            sudah terdaftar sebagai varian di sistem sebelum import.
                        </span>
                    </div>
                </div>
            </div>

        </div>{{-- /left col --}}

        {{-- ══ RIGHT COLUMN: Tips ══ --}}
        <div>
            <div class="im-card">
                <div class="im-card-header">
                    <div class="im-card-icon purple">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <div class="im-card-title">Tips Import</div>
                        <div class="im-card-sub">Panduan agar import berhasil</div>
                    </div>
                </div>
                <div class="im-card-body">
                    <div class="im-tip-list">
                        <div class="im-tip-item">
                            <div class="im-tip-dot">1</div>
                            <div class="im-tip-text">Selalu gunakan <strong>template resmi</strong> yang didownload dari
                                sistem agar format kolom sesuai.</div>
                        </div>
                        <div class="im-tip-item">
                            <div class="im-tip-dot">2</div>
                            <div class="im-tip-text">Pastikan <strong>nama_merek</strong> dan <strong>dosis_mg</strong>
                                sudah terdaftar di master data varian obat sebelum import.</div>
                        </div>
                        <div class="im-tip-item">
                            <div class="im-tip-dot">3</div>
                            <div class="im-tip-text">Format tanggal harus <strong>YYYY-MM-DD</strong> (contoh: <code
                                    style="background:#F3F4F6;padding:1px 5px;border-radius:3px;font-size:11px;">2026-06-30</code>).
                                Jangan gunakan format DD/MM/YYYY.</div>
                        </div>
                        <div class="im-tip-item">
                            <div class="im-tip-dot">4</div>
                            <div class="im-tip-text">Kolom <strong>harga_satuan</strong> diisi angka saja tanpa titik/koma
                                (contoh: <code
                                    style="background:#F3F4F6;padding:1px 5px;border-radius:3px;font-size:11px;">15000</code>
                                bukan Rp 15.000).</div>
                        </div>
                        <div class="im-tip-item">
                            <div class="im-tip-dot">5</div>
                            <div class="im-tip-text"><strong>Jangan mengubah nama kolom header</strong> di baris pertama.
                                Sistem mengenali kolom berdasarkan nama persis.</div>
                        </div>
                        <div class="im-tip-item">
                            <div class="im-tip-dot">6</div>
                            <div class="im-tip-text">Baris yang error akan dilaporkan setelah proses selesai. Baris lain
                                yang valid tetap berhasil diimport.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hasil import sebelumnya (jika ada) --}}
            @if (session('import_result'))
                @php $res = session('import_result'); @endphp
                <div class="im-card" style="margin-top:0;">
                    <div class="im-card-header">
                        <div class="im-card-icon green">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <div>
                            <div class="im-card-title">Hasil Import Terakhir</div>
                            <div class="im-card-sub">{{ now()->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    <div class="im-card-body" style="padding:16px 20px;">
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <div
                                style="display:flex;justify-content:space-between;padding:8px 12px;border-radius:6px;background:#F0FDF4;border:1px solid #BBF7D0;">
                                <span style="font-size:12px;color:#166534;">✓ Berhasil diimport</span>
                                <strong style="font-size:13px;color:#166534;">{{ $res['success'] ?? 0 }} baris</strong>
                            </div>
                            @if (($res['failed'] ?? 0) > 0)
                                <div
                                    style="display:flex;justify-content:space-between;padding:8px 12px;border-radius:6px;background:#FEE2E2;border:1px solid #FECACA;">
                                    <span style="font-size:12px;color:#991B1B;">✕ Gagal / dilewati</span>
                                    <strong style="font-size:13px;color:#991B1B;">{{ $res['failed'] }} baris</strong>
                                </div>
                            @endif
                        </div>
                        @if (!empty($res['errors']))
                            <div style="margin-top:10px;font-size:11.5px;color:var(--tx-muted);">
                                <strong style="color:var(--tx-base);">Detail error:</strong>
                                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:3px;">
                                    @foreach ($res['errors'] as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>{{-- /right col --}}
    </div>

@endsection

@push('scripts')
    <script>
        /* ── Drag & Drop ── */
        var dropzone = document.getElementById('dropzone');
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        dropzone.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            var files = e.dataTransfer.files;
            if (files.length) {
                document.getElementById('fileInput').files = files;
                onFileSelected(document.getElementById('fileInput'));
            }
        });

        function triggerFile() {
            // only trigger if click is not on a child interactive element
        }

        /* ── File selected ── */
        function onFileSelected(input) {
            if (!input.files || !input.files[0]) return;
            var file = input.files[0];

            // Validate size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5 MB.');
                input.value = '';
                return;
            }

            // Validate extension
            var ext = file.name.split('.').pop().toLowerCase();
            if (!['xlsx', 'xls'].includes(ext)) {
                alert('Format file harus .xlsx atau .xls');
                input.value = '';
                return;
            }

            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = formatSize(file.size);
            document.getElementById('fileSelected').classList.add('show');
            document.getElementById('submitBtn').disabled = false;

            // Update dropzone visual
            dropzone.style.borderColor = '#22C55E';
            dropzone.style.background = '#F0FDF4';
        }

        function clearFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('fileSelected').classList.remove('show');
            document.getElementById('submitBtn').disabled = true;
            dropzone.style.borderColor = '';
            dropzone.style.background = '';
        }

        function startProgress() {
            document.getElementById('progressWrap').classList.add('show');
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML =
                '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Mengimport...';
        }

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1024 / 1024).toFixed(1) + ' MB';
        }

        /* ── Spin animation ── */
        var style = document.createElement('style');
        style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
        document.head.appendChild(style);
    </script>
@endpush
