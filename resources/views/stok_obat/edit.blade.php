@extends('layouts.app')

@section('title', 'Edit Stok Obat — ' . ($stokObat->varianObat->nama_merek ?? 'Stok'))
@section('page-title', 'Edit Stok Obat')

@push('styles')
    <style>
        .es-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px
        }

        .es-header-left {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .es-back {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tx-muted);
            text-decoration: none;
            flex-shrink: 0;
            transition: border-color .15s, color .15s, box-shadow .15s
        }

        .es-back:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08)
        }

        .es-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em
        }

        .es-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px
        }

        .es-status-badge {
            font-size: 11px;
            padding: 4px 11px;
            border-radius: 20px;
            font-weight: 600
        }

        .es-status-badge.aman {
            background: rgba(16, 185, 129, .1);
            color: #065F46;
            border: 1px solid rgba(16, 185, 129, .25)
        }

        .es-status-badge.warning {
            background: rgba(245, 158, 11, .1);
            color: #92400E;
            border: 1px solid rgba(245, 158, 11, .25)
        }

        .es-status-badge.expired {
            background: rgba(239, 68, 68, .1);
            color: #991B1B;
            border: 1px solid rgba(239, 68, 68, .25)
        }

        .es-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 18px;
            align-items: start;
            width: 100%
        }

        @media(max-width:600px) {
            .es-grid {
                grid-template-columns: 1fr
            }
        }

        .es-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            overflow: hidden
        }

        .es-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA
        }

        .es-card-icon {
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .es-card-icon.green {
            background: #ECFDF5;
            color: #059669
        }

        .es-card-icon.orange {
            background: #FFF7ED;
            color: #EA580C
        }

        .es-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base)
        }

        .es-card-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px
        }

        .es-card-body {
            padding: 18px
        }

        .es-varian-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
            margin-bottom: 18px
        }

        .es-varian-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .es-varian-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tx-base)
        }

        .es-varian-meta {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 2px
        }

        .es-varian-tags {
            display: flex;
            gap: 5px;
            margin-top: 5px;
            flex-wrap: wrap
        }

        .es-tag {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600
        }

        .es-tag.green {
            background: rgba(16, 185, 129, .1);
            color: #065F46;
            border: 1px solid rgba(16, 185, 129, .2)
        }

        .es-tag.gray {
            background: var(--page-bg);
            color: var(--tx-muted);
            border: 1px solid var(--border)
        }

        .es-field {
            margin-bottom: 14px
        }

        .es-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            margin-bottom: 5px;
            letter-spacing: .02em
        }

        .es-req {
            color: var(--clr-red);
            font-size: 10px
        }

        .es-input {
            width: 100%;
            padding: 8px 11px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            -webkit-appearance: none;
            box-sizing: border-box
        }

        .es-input:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1)
        }

        .es-input::placeholder {
            color: var(--tx-sub)
        }

        .es-input:disabled {
            background: var(--page-bg);
            opacity: .7;
            cursor: not-allowed
        }

        .es-input.is-invalid {
            border-color: var(--clr-red);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .08)
        }

        .es-input.font-mono {
            font-family: 'Courier New', monospace
        }

        .es-error {
            font-size: 11px;
            color: var(--clr-red);
            margin-top: 4px
        }

        .es-input-group {
            display: flex;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: border-color .15s, box-shadow .15s
        }

        .es-input-group:focus-within {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1)
        }

        .es-input-group.is-invalid {
            border-color: var(--clr-red)
        }

        .es-input-group .es-input {
            border: none !important;
            box-shadow: none !important;
            border-radius: 0;
            flex: 1;
            min-width: 0
        }

        .es-input-addon {
            padding: 8px 11px;
            background: var(--page-bg);
            color: var(--tx-muted);
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            white-space: nowrap;
            border-left: 1px solid var(--border)
        }

        .es-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        @media(max-width:480px) {
            .es-field-row {
                grid-template-columns: 1fr
            }
        }

        .es-disabled-note {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 5px;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border)
        }

        .es-hint {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 4px
        }

        .es-batch-info {
            padding: 14px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
            margin-bottom: 14px
        }

        .es-batch-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px
        }

        .es-batch-label {
            font-size: 11.5px;
            color: var(--tx-muted);
            font-weight: 500
        }

        .es-batch-value {
            font-size: 11.5px;
            font-weight: 700
        }

        .es-batch-value.green {
            color: #059669
        }

        .es-batch-value.yellow {
            color: #D97706
        }

        .es-batch-value.red {
            color: var(--clr-red)
        }

        .es-progress-bar {
            width: 100%;
            height: 5px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 12px
        }

        .es-progress-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .3s
        }

        .es-progress-fill.green {
            background: #10b981
        }

        .es-progress-fill.yellow {
            background: #F59E0B
        }

        .es-progress-fill.red {
            background: var(--clr-red)
        }

        .es-alert {
            display: flex;
            gap: 9px;
            padding: 11px 13px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            line-height: 1.6
        }

        .es-alert.green {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46
        }

        .es-alert.yellow {
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            color: #92400E
        }

        .es-alert.red {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B
        }

        .es-alert-icon {
            flex-shrink: 0;
            margin-top: 1px
        }

        .es-alert-title {
            font-weight: 700;
            font-size: 12.5px;
            margin-bottom: 1px
        }

        .es-alert-meta {
            font-size: 11px;
            opacity: .85
        }

        .es-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .es-info-list li {
            display: flex;
            gap: 7px;
            font-size: 11.5px;
            color: var(--tx-muted);
            line-height: 1.6
        }

        .es-info-list li span.dot {
            color: var(--border);
            flex-shrink: 0;
            margin-top: 1px
        }

        .es-data-row {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .es-data-key {
            font-size: 10.5px;
            color: var(--tx-sub);
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 2px
        }

        .es-data-val {
            font-size: 13px;
            color: var(--tx-base);
            font-weight: 500
        }

        .es-data-val.mono {
            font-family: 'Courier New', monospace;
            font-size: 12px
        }

        .es-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 12px 0
        }

        .es-btn {
            width: 100%;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: opacity .15s, box-shadow .15s, transform .1s;
            margin-top: 4px;
            text-decoration: none
        }

        .es-btn:active {
            transform: scale(0.985)
        }

        .es-btn-primary {
            background: linear-gradient(135deg, #C9A84C, #b8932f);
            color: #1a1208
        }

        .es-btn-primary:hover {
            opacity: .9;
            box-shadow: 0 4px 14px rgba(201, 168, 76, .35)
        }

        .es-btn-secondary {
            background: var(--page-bg);
            color: var(--tx-muted);
            border: 1px solid var(--border) !important;
            margin-top: 8px
        }

        .es-btn-secondary:hover {
            border-color: var(--tx-muted) !important;
            color: var(--tx-base)
        }
    </style>
@endpush

@section('content')

    @php
        $today = now();
        $masuk = $stokObat->tanggal_masuk;
        $kadaluarsa = $stokObat->tanggal_kadaluarsa;
        $sisaHari = $kadaluarsa ? (int) $today->diffInDays($kadaluarsa, false) : null;
        $totalHari = $masuk && $kadaluarsa ? max(1, $masuk->diffInDays($kadaluarsa)) : 1;
        $persen = $sisaHari !== null && $totalHari > 0 ? min(100, max(0, ($sisaHari / $totalHari) * 100)) : 0;
        $isExpired = $sisaHari !== null && $sisaHari < 0;
        $isWarning = $sisaHari !== null && $sisaHari <= 90 && $sisaHari >= 0;
        $barColor = $isExpired ? 'red' : ($isWarning ? 'yellow' : 'green');
        $badgeClass = $isExpired ? 'expired' : ($isWarning ? 'warning' : 'aman');
        $badgeLabel = $isExpired ? 'Kadaluarsa' : ($isWarning ? 'Segera Habis' : 'Aman');

        $varian = $stokObat->varianObat;
        $obat = $varian?->obat;
    @endphp

    {{-- Page Header --}}
    <div class="es-header">
        <div class="es-header-left">
            <a href="{{ route('stok-obat.index') }}" class="es-back" title="Kembali">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </a>
            <div>
                <div class="es-title">Edit Stok Obat</div>
                <div class="es-sub">Ubah jumlah, no. batch, atau tanggal kadaluarsa</div>
            </div>
        </div>
        <span class="es-status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
    </div>

    <div class="es-grid">

        {{-- ── Card Kiri: Form ── --}}
        <div class="es-card">
            <div class="es-card-header">
                <div class="es-card-icon green">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <div class="es-card-title">Data Stok</div>
                    <div class="es-card-sub">Ubah jumlah dan informasi batch</div>
                </div>
            </div>
            <div class="es-card-body">

                {{-- Varian Preview --}}
                <div class="es-varian-preview">
                    <div class="es-varian-icon">💊</div>
                    <div>
                        <div class="es-varian-name">
                            {{ $varian->nama_merek ?? '-' }}
                            @if ($varian?->dosis_mg)
                                <span style="font-weight:400;font-size:12px;color:var(--tx-muted)">
                                    {{ $varian->dosis_mg }} mg
                                </span>
                            @endif
                        </div>
                        <div class="es-varian-meta">
                            Stok saat ini: <strong>{{ $stokObat->jumlah }} unit</strong>
                        </div>
                        <div class="es-varian-tags">
                            <span class="es-tag green">{{ $obat->nama_obat ?? '-' }}</span>
                            <span class="es-tag gray">{{ $obat->jenisObat->nama_jenis ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('stok-obat.update', $stokObat->id_stok) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Validasi error global --}}
                    @if ($errors->any())
                        <div
                            style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;border-radius:6px;padding:10px 13px;font-size:12px;margin-bottom:14px">
                            <strong>Terdapat kesalahan:</strong>
                            <ul style="margin:4px 0 0 16px;padding:0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- No. Batch --}}
                    <div class="es-field">
                        <label class="es-label" for="no_batch">No. Batch</label>
                        <input id="no_batch" name="no_batch" type="text"
                            class="es-input font-mono {{ $errors->has('no_batch') ? 'is-invalid' : '' }}"
                            value="{{ old('no_batch', $stokObat->no_batch) }}" placeholder="Contoh: BATCH001"
                            style="text-transform:uppercase">
                        @error('no_batch')
                            <div class="es-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah Stok — name="jumlah" sesuai controller --}}
                    <div class="es-field">
                        <label class="es-label" for="jumlah">
                            Jumlah Stok <span class="es-req">*</span>
                        </label>
                        <div class="es-input-group {{ $errors->has('jumlah') ? 'is-invalid' : '' }}">
                            <input id="jumlah" name="jumlah" type="number" min="0" class="es-input"
                                value="{{ old('jumlah', $stokObat->jumlah) }}" placeholder="0" required>
                            <span class="es-input-addon">unit</span>
                        </div>
                        <div class="es-hint">Isi 0 jika stok batch ini sudah habis / dimusnahkan.</div>
                        <div id="warn-zero"
                            style="display:none;margin-top:6px;padding:7px 10px;border-radius:6px;background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;font-size:11.5px;font-weight:500">
                            ⚠️ Stok akan ditandai <strong>habis/musnah</strong> jika disimpan dengan nilai 0.
                        </div>
                        @error('jumlah')
                            <div class="es-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="es-field-row">
                        <div class="es-field" style="margin-bottom:0">
                            <label class="es-label">Tanggal Masuk</label>
                            <input type="date" value="{{ $stokObat->tanggal_masuk?->format('Y-m-d') }}" class="es-input"
                                disabled readonly>
                            <div class="es-disabled-note">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Tidak dapat diubah.
                            </div>
                        </div>
                        <div class="es-field" style="margin-bottom:0">
                            <label class="es-label" for="tanggal_kadaluarsa">
                                Tanggal Kadaluarsa <span class="es-req">*</span>
                            </label>
                            <input id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" type="date"
                                class="es-input {{ $errors->has('tanggal_kadaluarsa') ? 'is-invalid' : '' }}"
                                value="{{ old('tanggal_kadaluarsa', $stokObat->tanggal_kadaluarsa?->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_kadaluarsa')
                                <div class="es-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="es-field" style="margin-top:14px">
                        <label class="es-label" for="keterangan">Keterangan</label>
                        <input id="keterangan" name="keterangan" type="text"
                            class="es-input {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                            value="{{ old('keterangan', $stokObat->keterangan ?? '') }}"
                            placeholder="Supplier / catatan tambahan (opsional)">
                        @error('keterangan')
                            <div class="es-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="es-btn es-btn-primary" style="margin-top:18px">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('stok-obat.index') }}" class="es-btn es-btn-secondary">Batal</a>

                </form>
            </div>
        </div>

        {{-- ── Card Kanan: Info Batch ── --}}
        <div class="es-card">
            <div class="es-card-header">
                <div class="es-card-icon orange">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
                <div>
                    <div class="es-card-title">Info Batch</div>
                    <div class="es-card-sub">Status dan masa berlaku batch</div>
                </div>
            </div>
            <div class="es-card-body">

                @if ($kadaluarsa)
                    <div class="es-batch-info">
                        <div class="es-batch-info-row">
                            <span class="es-batch-label">Masa berlaku batch</span>
                            <span class="es-batch-value {{ $barColor }}">
                                @if ($isExpired)
                                    Sudah kadaluarsa
                                @else
                                    Sisa {{ $sisaHari }} hari
                                @endif
                            </span>
                        </div>
                        <div class="es-progress-bar">
                            <div class="es-progress-fill {{ $barColor }}" style="width:{{ $persen }}%"></div>
                        </div>

                        @if ($isExpired)
                            <div class="es-alert red">
                                <div class="es-alert-icon">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="15" y1="9" x2="9" y2="15" />
                                        <line x1="9" y1="9" x2="15" y2="15" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="es-alert-title">Batch sudah kadaluarsa!</div>
                                    <div class="es-alert-meta" id="alert-meta">
                                        Kadaluarsa {{ $kadaluarsa->format('d M Y') }} · Stok: {{ $stokObat->jumlah }} unit
                                    </div>
                                </div>
                            </div>
                        @elseif ($isWarning)
                            <div class="es-alert yellow">
                                <div class="es-alert-icon">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                        <line x1="12" y1="9" x2="12" y2="13" />
                                        <line x1="12" y1="17" x2="12.01" y2="17" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="es-alert-title">Batch mendekati kadaluarsa</div>
                                    <div class="es-alert-meta" id="alert-meta">
                                        Kadaluarsa {{ $kadaluarsa->format('d M Y') }} · Stok: {{ $stokObat->jumlah }} unit
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="es-alert green">
                                <div class="es-alert-icon">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                        <polyline points="22 4 12 14.01 9 11.01" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="es-alert-title">Batch ini masih aman</div>
                                    <div class="es-alert-meta" id="alert-meta">
                                        Kadaluarsa {{ $kadaluarsa->format('d M Y') }} · Stok: {{ $stokObat->jumlah }} unit
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Data Summary --}}
                <div class="es-data-row">
                    <div class="es-data-item">
                        <div class="es-data-key">No. Batch</div>
                        <div class="es-data-val mono" id="panel-batch">{{ $stokObat->no_batch ?? '—' }}</div>
                    </div>
                    <div class="es-data-item">
                        <div class="es-data-key">Jumlah Stok</div>
                        <div class="es-data-val" id="panel-qty"><strong>{{ $stokObat->jumlah }}</strong> unit</div>
                    </div>
                    <div class="es-data-item">
                        <div class="es-data-key">Tanggal Masuk</div>
                        <div class="es-data-val">{{ $stokObat->tanggal_masuk?->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="es-data-item">
                        <div class="es-data-key">Tanggal Kadaluarsa</div>
                        <div class="es-data-val" id="panel-exp">
                            {{ $stokObat->tanggal_kadaluarsa?->format('d M Y') ?? '—' }}</div>
                    </div>

                    {{-- Stok Minimum --}}
                    @if ($varian?->alert_minimum && $varian->stok_minimum > 0)
                        <div class="es-data-item">
                            <div class="es-data-key">Stok Minimum</div>
                            <div class="es-data-val">
                                {{ $varian->stok_minimum }} unit
                                @php $statusStok = $varian->status_stok; @endphp
                                @if ($statusStok === 'habis')
                                    <span
                                        style="margin-left:6px;font-size:10px;padding:2px 7px;border-radius:20px;background:rgba(75,85,99,.25);color:#9CA3AF;border:1px solid rgba(156,163,175,.15);font-weight:600">Habis</span>
                                @elseif ($statusStok === 'kritis')
                                    <span
                                        style="margin-left:6px;font-size:10px;padding:2px 7px;border-radius:20px;background:rgba(146,64,14,.25);color:#FCD34D;border:1px solid rgba(252,211,77,.2);font-weight:600">Di
                                        bawah min.</span>
                                @elseif ($statusStok === 'minimum')
                                    <span
                                        style="margin-left:6px;font-size:10px;padding:2px 7px;border-radius:20px;background:rgba(30,64,175,.25);color:#93C5FD;border:1px solid rgba(147,197,253,.2);font-weight:600">Tepat
                                        min.</span>
                                @else
                                    <span
                                        style="margin-left:6px;font-size:10px;padding:2px 7px;border-radius:20px;background:rgba(6,95,70,.25);color:#6EE7B7;border:1px solid rgba(110,231,183,.2);font-weight:600">Aman</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <hr class="es-divider">

                <div style="margin-bottom:8px">
                    <div style="font-size:11.5px;font-weight:600;color:var(--tx-muted);margin-bottom:8px">Panduan</div>
                    <ul class="es-info-list">
                        <li><span class="dot">•</span> No. batch opsional namun disarankan untuk traceability.</li>
                        <li><span class="dot">•</span> Tanggal masuk tidak bisa diubah setelah tersimpan.</li>
                        <li><span class="dot">•</span> Isi stok 0 untuk menandai batch habis atau musnah.</li>
                        <li><span class="dot">•</span> Periksa tanggal kadaluarsa secara berkala.</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            const qtyInput = document.getElementById('jumlah');
            const batchInput = document.getElementById('no_batch');
            const expInput = document.getElementById('tanggal_kadaluarsa');
            const warnZero = document.getElementById('warn-zero');
            const panelBatch = document.getElementById('panel-batch');
            const panelQty = document.getElementById('panel-qty');
            const panelExp = document.getElementById('panel-exp');
            const alertMeta = document.getElementById('alert-meta');

            function formatTgl(val) {
                if (!val) return '—';
                return new Date(val).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            qtyInput?.addEventListener('input', function() {
                const v = parseInt(this.value) || 0;
                if (panelQty) panelQty.innerHTML = `<strong>${v}</strong> unit`;
                warnZero.style.display = v === 0 ? 'block' : 'none';
                if (alertMeta) alertMeta.textContent = alertMeta.textContent.replace(/Stok: \d+ unit/,
                    `Stok: ${v} unit`);
            });

            batchInput?.addEventListener('input', function() {
                if (panelBatch) panelBatch.textContent = this.value.toUpperCase() || '—';
            });

            expInput?.addEventListener('change', function() {
                const f = formatTgl(this.value);
                if (panelExp) panelExp.textContent = f;
                if (alertMeta) alertMeta.textContent = alertMeta.textContent.replace(/Kadaluarsa .+? ·/,
                    `Kadaluarsa ${f} ·`);
            });
        </script>
    @endpush

@endsection
