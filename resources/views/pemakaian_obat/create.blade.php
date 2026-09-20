{{-- resources/views/pemakaian_obat/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Catat Pemakaian Obat')
@section('page-title', 'Pemakaian Obat')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

        .cp {
            --gold: #E2B96F;
            --gold2: #C9953A;
            --gold-dim: rgba(226, 185, 111, 0.08);
            --gold-glow: rgba(226, 185, 111, 0.15);
            --bg2: #13161D;
            --bg3: #1A1E28;
            --bg4: #222838;
            --border: rgba(255, 255, 255, 0.07);
            --border2: rgba(226, 185, 111, 0.2);
            --tx1: #F0EDE6;
            --tx2: #8C95A6;
            --tx3: #4A5568;
            --green: #4ADE80;
            --red: #F87171;
            --blue: #60A5FA;
            --amber: #FCD34D;
            --orange: #FB923C;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            color: var(--tx1);
            max-width: 100%;
        }

        /* ── Header ── */
        .cp-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cp-eyebrow {
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

        .cp-eyebrow::before {
            content: '';
            display: block;
            width: 18px;
            height: 1.5px;
            background: var(--gold);
            border-radius: 2px;
        }

        .cp-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--tx1);
            letter-spacing: -.5px;
            line-height: 1;
        }

        .cp-sub {
            font-size: 12.5px;
            color: var(--tx2);
            margin-top: 5px;
        }

        .cp-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 9px;
            font-family: 'Outfit', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--tx2);
            text-decoration: none;
            transition: all .15s;
        }

        .cp-btn-back:hover {
            border-color: var(--border2);
            color: var(--tx1);
        }

        /* ── Alert ── */
        .cp-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .cp-alert-err {
            background: rgba(248, 113, 113, .1);
            color: #fca5a5;
            border: 1px solid rgba(248, 113, 113, .2);
        }

        /* ── Card ── */
        .cp-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .4);
        }

        .cp-card-top {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(90deg, var(--gold-dim) 0%, transparent 60%);
        }

        .cp-card-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--gold-dim);
            border: 1px solid var(--border2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            flex-shrink: 0;
        }

        .cp-card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--tx1);
        }

        .cp-card-sub {
            font-size: 11.5px;
            color: var(--tx2);
            margin-top: 1px;
        }

        .cp-card-body {
            padding: 28px 24px;
        }

        /* ── Form fields ── */
        .cp-field {
            margin-bottom: 22px;
        }

        .cp-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--tx2);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .cp-label span {
            color: var(--red);
            margin-left: 2px;
        }

        .cp-select,
        .cp-input,
        .cp-textarea {
            width: 100%;
            padding: 11px 14px;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            color: var(--tx1);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
            -webkit-appearance: none;
        }

        .cp-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%238C95A6' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .cp-select option {
            background: #1A1E28;
            color: var(--tx1);
        }

        .cp-select:focus,
        .cp-input:focus,
        .cp-textarea:focus {
            border-color: var(--border2);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .cp-select::placeholder,
        .cp-input::placeholder {
            color: var(--tx3);
        }

        .cp-input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(.4);
            cursor: pointer;
        }

        .cp-textarea {
            resize: vertical;
            min-height: 70px;
            line-height: 1.5;
        }

        /* Error state */
        .cp-select.is-err,
        .cp-input.is-err {
            border-color: rgba(248, 113, 113, .5);
        }

        .cp-err-msg {
            font-size: 11.5px;
            color: #fca5a5;
            margin-top: 6px;
        }

        /* ── Stok info box ── */
        .cp-stok-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .cp-stok-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx2);
        }

        .cp-stok-total {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: rgba(74, 222, 128, .1);
            border: 1px solid rgba(74, 222, 128, .2);
            font-size: 12px;
            font-weight: 700;
            color: var(--green);
            font-family: 'JetBrains Mono', monospace;
        }

        .cp-stok-total.danger {
            background: rgba(248, 113, 113, .1);
            border-color: rgba(248, 113, 113, .2);
            color: var(--red);
        }

        .cp-stok-box {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn .25s ease;
        }

        .cp-batch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            gap: 12px;
            flex-wrap: wrap;
        }

        .cp-batch-row:last-child {
            border-bottom: none;
        }

        .cp-batch-no {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--tx3);
            margin-right: 2px;
        }

        .cp-batch-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx1);
        }

        .cp-batch-qty {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--blue);
        }

        .cp-batch-exp {
            font-size: 11.5px;
            color: var(--tx3);
        }

        .cp-batch-status {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .04em;
        }

        .st-aman {
            background: rgba(74, 222, 128, .1);
            color: #86efac;
            border: 1px solid rgba(74, 222, 128, .2);
        }

        .st-kritis {
            background: rgba(251, 146, 60, .1);
            color: #fdba74;
            border: 1px solid rgba(251, 146, 60, .2);
        }

        .st-expired {
            background: rgba(248, 113, 113, .1);
            color: #fca5a5;
            border: 1px solid rgba(248, 113, 113, .2);
        }

        .st-warning {
            background: rgba(96, 165, 250, .1);
            color: #93c5fd;
            border: 1px solid rgba(96, 165, 250, .2);
        }

        .cp-stok-loading {
            padding: 16px 14px;
            text-align: center;
            font-size: 12.5px;
            color: var(--tx3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .cp-spinner {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .1);
            border-top-color: var(--gold);
            animation: spin .6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Jumlah helper ── */
        .cp-qty-wrap {
            position: relative;
        }

        .cp-qty-wrap .cp-input {
            padding-right: 80px;
        }

        .cp-qty-badge {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            font-weight: 600;
            color: var(--tx3);
            font-family: 'JetBrains Mono', monospace;
            background: var(--bg4);
            border: 1px solid var(--border);
            padding: 2px 8px;
            border-radius: 5px;
        }

        .cp-hint {
            font-size: 11.5px;
            margin-top: 7px;
        }

        .cp-hint.ok {
            color: #86efac;
        }

        .cp-hint.err {
            color: #fca5a5;
        }

        .cp-hint.neu {
            color: var(--tx3);
        }

        /* ── 2-col grid ── */
        .cp-grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 640px) {
            .cp-grid2 {
                grid-template-columns: 1fr;
            }
        }

        /* ── Divider ── */
        .cp-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 0 22px;
        }

        /* ── Submit ── */
        .cp-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            background: rgba(0, 0, 0, .15);
        }

        .cp-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: linear-gradient(135deg, var(--gold), var(--gold2));
            color: #1a0f00;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 20px rgba(226, 185, 111, .25);
        }

        .cp-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(226, 185, 111, .4);
        }

        .cp-btn-submit:disabled {
            opacity: .5;
            cursor: not-allowed;
            transform: none;
        }

        .cp-btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 20px;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--tx2);
            text-decoration: none;
            transition: all .15s;
        }

        .cp-btn-cancel:hover {
            border-color: var(--border2);
            color: var(--tx1);
        }

        .cp-submit-hint {
            font-size: 11.5px;
            color: var(--tx3);
            margin-left: auto;
        }
    </style>
@endpush

@section('content')
    <div class="cp">

        {{-- Header --}}
        <div class="cp-header">
            <div>
                <div class="cp-eyebrow">Stok & Pemakaian</div>
                <div class="cp-title">Catat Pemakaian</div>
                <div class="cp-sub">Input pemakaian obat — stok akan berkurang otomatis (FIFO)</div>
            </div>
            <a href="{{ route('pemakaian-obat.index') }}" class="cp-btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Alert --}}
        @if (session('error'))
            <div class="cp-alert cp-alert-err">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" x2="12" y1="8" y2="12" />
                    <line x1="12" x2="12.01" y1="16" y2="16" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Card --}}
        <div class="cp-card">
            <div class="cp-card-top">
                <div class="cp-card-icon">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                        <rect x="9" y="3" width="6" height="4" rx="1" />
                        <line x1="9" y1="12" x2="15" y2="12" />
                        <line x1="9" y1="16" x2="13" y2="16" />
                    </svg>
                </div>
                <div>
                    <div class="cp-card-title">Form Pemakaian Obat</div>
                    <div class="cp-card-sub">Semua field bertanda * wajib diisi</div>
                </div>
            </div>

            <form action="{{ route('pemakaian-obat.store') }}" method="POST" id="formPemakaian">
                @csrf
                <div class="cp-card-body">

                    {{-- Pilih Varian --}}
                    <div class="cp-field">
                        <label class="cp-label">Varian Obat <span>*</span></label>
                        <select name="id_varian" id="id_varian"
                            class="cp-select {{ $errors->has('id_varian') ? 'is-err' : '' }}"
                            onchange="cekStok(this.value)">
                            <option value="">— Pilih varian obat —</option>
                            @foreach ($varian as $v)
                                <option value="{{ $v->id_varian }}"
                                    {{ old('id_varian') == $v->id_varian ? 'selected' : '' }}>
                                    {{ $v->nama_merek }}
                                    {{ $v->dosis_mg }}mg
                                    — stok: {{ $v->total_stok }} unit
                                </option>
                            @endforeach
                        </select>
                        @error('id_varian')
                            <div class="cp-err-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info Batch --}}
                    <div id="info-stok" style="display:none;" class="cp-field">
                        <div class="cp-stok-header">
                            <span class="cp-stok-label">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:4px;">
                                    <path d="M20 7H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z" />
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                </svg>
                                Detail Batch (FIFO — atas dipakai duluan)
                            </span>
                            <span class="cp-stok-total" id="stok-total-badge">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <span id="stok-total-num">0</span> unit tersedia
                            </span>
                        </div>
                        <div class="cp-stok-box" id="list-batch">
                            <div class="cp-stok-loading">
                                <div class="cp-spinner"></div>
                                Memuat data batch...
                            </div>
                        </div>
                    </div>

                    <div class="cp-grid2">
                        {{-- Jumlah --}}
                        <div class="cp-field" style="margin-bottom:0;">
                            <label class="cp-label">Jumlah Dipakai <span>*</span></label>
                            <div class="cp-qty-wrap">
                                <input type="number" name="jumlah_pakai" id="jumlah_pakai"
                                    class="cp-input {{ $errors->has('jumlah_pakai') ? 'is-err' : '' }}"
                                    value="{{ old('jumlah_pakai') }}" min="1" placeholder="0"
                                    oninput="updateHint()">
                                <span class="cp-qty-badge">unit</span>
                            </div>
                            <div class="cp-hint neu" id="info-sisa">Pilih varian obat terlebih dahulu</div>
                            @error('jumlah_pakai')
                                <div class="cp-err-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="cp-field" style="margin-bottom:0;">
                            <label class="cp-label">Tanggal Pemakaian <span>*</span></label>
                            <input type="date" name="tanggal_pakai"
                                class="cp-input {{ $errors->has('tanggal_pakai') ? 'is-err' : '' }}"
                                value="{{ old('tanggal_pakai', date('Y-m-d')) }}">
                            @error('tanggal_pakai')
                                <div class="cp-err-msg">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="cp-divider"></div>

                    {{-- Keterangan --}}
                    <div class="cp-field" style="margin-bottom:0;">
                        <label class="cp-label">Keterangan <span
                                style="color:var(--tx3);font-weight:400;">(opsional)</span></label>
                        <input type="text" name="keterangan" class="cp-input" value="{{ old('keterangan') }}"
                            placeholder="cth: Pasien a/n Budi, Poli Umum">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="cp-footer">
                    <button type="submit" class="cp-btn-submit" id="btnSimpan">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Pemakaian
                    </button>
                    <a href="{{ route('pemakaian-obat.index') }}" class="cp-btn-cancel">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Batal
                    </a>
                    <span class="cp-submit-hint" id="submit-hint">Pilih varian & masukkan jumlah</span>
                </div>
            </form>
        </div>
    </div>

    <script>
        let totalStok = 0;

        const statusClass = {
            expired: 'st-expired',
            kritis: 'st-kritis',
            warning: 'st-warning',
            aman: 'st-aman',
        };
        const statusLabel = {
            expired: 'Expired',
            kritis: 'Kritis',
            warning: 'Perhatian',
            aman: 'Aman',
        };

        async function cekStok(idVarian) {
            const infoBox = document.getElementById('info-stok');
            const listBox = document.getElementById('list-batch');
            const badge = document.getElementById('stok-total-badge');
            const badgeNum = document.getElementById('stok-total-num');

            if (!idVarian) {
                infoBox.style.display = 'none';
                totalStok = 0;
                updateHint();
                return;
            }

            infoBox.style.display = 'block';
            listBox.innerHTML = '<div class="cp-stok-loading"><div class="cp-spinner"></div>Memuat data batch...</div>';

            try {
                const res = await fetch(`{{ route('pemakaian-obat.cek-stok') }}?id_varian=${idVarian}`);
                const data = await res.json();
                totalStok = data.total_stok;

                badgeNum.textContent = totalStok.toLocaleString('id-ID');
                badge.className = 'cp-stok-total' + (totalStok === 0 ? ' danger' : '');

                if (data.batches.length === 0) {
                    listBox.innerHTML = '<div class="cp-stok-loading">Tidak ada stok tersedia untuk varian ini.</div>';
                } else {
                    listBox.innerHTML = data.batches.map((b, i) => `
                <div class="cp-batch-row">
                    <div style="display:flex;align-items:center;gap:8px;flex:1;min-width:0;">
                        <span class="cp-batch-no">${i + 1}.</span>
                        <div>
                            <div class="cp-batch-name">Batch ${b.no_batch}</div>
                            <div class="cp-batch-exp">Exp: ${b.tanggal_kadaluarsa}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
                        <span class="cp-batch-qty">${b.jumlah.toLocaleString('id-ID')} unit</span>
                        <span class="cp-batch-status ${statusClass[b.status] || 'st-aman'}">
                            ${statusLabel[b.status] || b.status}
                        </span>
                    </div>
                </div>
            `).join('');
                }
                updateHint();
            } catch (e) {
                listBox.innerHTML = '<div class="cp-stok-loading" style="color:#fca5a5;">Gagal memuat info stok.</div>';
            }
        }

        function updateHint() {
            const el = document.getElementById('info-sisa');
            const hint = document.getElementById('submit-hint');
            const jumlah = parseInt(document.getElementById('jumlah_pakai').value) || 0;
            const varian = document.getElementById('id_varian').value;

            if (!varian) {
                el.className = 'cp-hint neu';
                el.textContent = 'Pilih varian obat terlebih dahulu';
                hint.textContent = 'Pilih varian & masukkan jumlah';
                return;
            }
            if (totalStok === 0) {
                el.className = 'cp-hint err';
                el.textContent = 'Stok habis — tidak bisa dipakai';
                hint.textContent = 'Stok tidak tersedia';
                return;
            }
            if (jumlah <= 0) {
                el.className = 'cp-hint neu';
                el.textContent = `Stok tersedia: ${totalStok.toLocaleString('id-ID')} unit`;
                hint.textContent = 'Masukkan jumlah pemakaian';
                return;
            }
            const sisa = totalStok - jumlah;
            if (jumlah > totalStok) {
                el.className = 'cp-hint err';
                el.textContent = `Melebihi stok! Maksimal ${totalStok.toLocaleString('id-ID')} unit`;
                hint.textContent = 'Jumlah melebihi stok';
            } else {
                el.className = 'cp-hint ok';
                el.textContent = `Sisa stok setelah pemakaian: ${sisa.toLocaleString('id-ID')} unit`;
                hint.textContent = `Siap disimpan`;
            }
        }

        document.getElementById('formPemakaian').addEventListener('submit', function(e) {
            const jumlah = parseInt(document.getElementById('jumlah_pakai').value) || 0;
            const varian = document.getElementById('id_varian').value;

            if (varian && totalStok === 0) {
                e.preventDefault();
                alert('Stok untuk varian ini sudah habis.');
                return;
            }
            if (varian && jumlah > totalStok) {
                e.preventDefault();
                alert('Jumlah melebihi stok tersedia (' + totalStok + ' unit). Silakan kurangi jumlahnya.');
                return;
            }

            const btn = document.getElementById('btnSimpan');
            btn.disabled = true;
            btn.innerHTML = '<div class="cp-spinner" style="border-top-color:#1a0f00;"></div> Menyimpan...';
        });

        // Load stok jika ada old value
        const oldVarian = document.getElementById('id_varian').value;
        if (oldVarian) cekStok(oldVarian);
    </script>

@endsection
