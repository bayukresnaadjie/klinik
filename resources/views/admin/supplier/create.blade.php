@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')

@push('styles')
    <style>
        .back-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--card-bg);
            color: var(--tx-muted);
            text-decoration: none;
            transition: all .15s;
            flex-shrink: 0;
        }

        .btn-back:hover {
            border-color: var(--clr-blue);
            color: var(--clr-blue);
        }

        .back-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .back-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        /* ── Layout ── */
        .form-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 18px;
            align-items: start;
        }

        /* ── Card ── */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .form-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-card-header-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            background: #EFF6FF;
            color: var(--clr-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .form-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .form-card-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .form-card-body {
            padding: 20px;
        }

        /* ── Form elements ── */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
            margin-bottom: 6px;
        }

        .form-label .req {
            color: var(--clr-red);
        }

        .form-input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--tx-base);
            background: var(--page-bg);
            outline: none;
            font-family: 'DM Sans', sans-serif;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-input:focus {
            border-color: var(--clr-blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
        }

        .form-input.error {
            border-color: var(--clr-red);
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .08);
        }

        .form-hint {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 4px;
        }

        .form-error {
            font-size: 11px;
            color: var(--clr-red);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Rating input visual */
        .rating-input-wrap {
            position: relative;
        }

        .rating-input-wrap input {
            padding-right: 40px;
        }

        .rating-suffix {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--tx-sub);
            pointer-events: none;
        }

        /* Toggle switch */
        .toggle-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: border-color .15s;
        }

        .toggle-group:has(input:checked) {
            border-color: #BBF7D0;
            background: #F0FDF4;
        }

        .toggle-info .toggle-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--tx-base);
        }

        .toggle-info .toggle-desc {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .toggle-switch {
            position: relative;
            width: 38px;
            height: 22px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: #D1D5DB;
            border-radius: 22px;
            cursor: pointer;
            transition: .2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
        }

        input:checked+.toggle-slider {
            background: var(--clr-green);
        }

        input:checked+.toggle-slider::before {
            transform: translateX(16px);
        }

        /* ── Sidebar card ── */
        .info-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .info-card-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .info-card-body {
            padding: 14px 16px;
        }

        .info-item {
            display: flex;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-item-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-item-title {
            font-size: 12px;
            font-weight: 500;
            color: var(--tx-base);
        }

        .info-item-desc {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
            line-height: 1.4;
        }

        /* ── Footer actions ── */
        .form-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: var(--page-bg);
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-save {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: var(--clr-blue);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity .15s;
            box-shadow: 0 2px 6px rgba(59, 130, 246, .25);
        }

        .btn-save:hover {
            opacity: .88;
        }

        .btn-cancel {
            display: flex;
            align-items: center;
            padding: 9px 16px;
            background: none;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--tx-muted);
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-cancel:hover {
            border-color: var(--tx-muted);
            color: var(--tx-base);
        }

        @media (max-width: 900px) {
            .form-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Back Header --}}
    <div class="back-header">
        <a href="{{ route('admin.supplier.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6" />
            </svg>
        </a>
        <div>
            <div class="back-title">Tambah Supplier Baru</div>
            <div class="back-sub">Isi informasi lengkap supplier obat</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.supplier.store') }}">
        @csrf
        <div class="form-layout">

            {{-- ── FORM UTAMA ── --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-header-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </div>
                    <div>
                        <div class="form-card-title">Informasi Supplier</div>
                        <div class="form-card-sub">Data utama dan kontak supplier</div>
                    </div>
                </div>
                <div class="form-card-body">

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="form-label">
                            Nama Supplier <span class="req">*</span>
                        </label>
                        <input type="text" name="nama" class="form-input {{ $errors->has('nama') ? 'error' : '' }}"
                            value="{{ old('nama') }}" placeholder="contoh: PT Kimia Farma Tbk" autofocus>
                        @error('nama')
                            <div class="form-error">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kota & Rating --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="kota"
                                class="form-input {{ $errors->has('kota') ? 'error' : '' }}" value="{{ old('kota') }}"
                                placeholder="contoh: Jakarta">
                            @error('kota')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rating Awal</label>
                            <div class="rating-input-wrap">
                                <input type="number" name="rating" step="0.1" min="0" max="5"
                                    class="form-input {{ $errors->has('rating') ? 'error' : '' }}"
                                    value="{{ old('rating', 0) }}">
                                <span class="rating-suffix">/ 5.0</span>
                            </div>
                            <div class="form-hint">Isi 0 jika belum pernah bertransaksi</div>
                            @error('rating')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="form-input {{ $errors->has('alamat') ? 'error' : '' }}"
                            placeholder="Jl. Contoh No.1, Kelurahan, Kecamatan, Kota">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kontak & Email --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="kontak"
                                class="form-input {{ $errors->has('kontak') ? 'error' : '' }}" value="{{ old('kontak') }}"
                                placeholder="021-xxxxxxx">
                            @error('kontak')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-input {{ $errors->has('email') ? 'error' : '' }}" value="{{ old('email') }}"
                                placeholder="email@supplier.com">
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="form-group">
                        <label class="form-label">Status Supplier</label>
                        <div class="toggle-group">
                            <div class="toggle-info">
                                <div class="toggle-title">Supplier Aktif</div>
                                <div class="toggle-desc">Supplier aktif dapat digunakan untuk pengadaan obat</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="aktif" value="1"
                                    {{ old('aktif', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="form-footer">
                    <button type="submit" class="btn-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Supplier
                    </button>
                    <a href="{{ route('admin.supplier.index') }}" class="btn-cancel">Batal</a>
                </div>
            </div>

            {{-- ── SIDEBAR INFO ── --}}
            <div style="display:flex; flex-direction:column; gap:14px">

                {{-- Panduan Rating --}}
                <div class="info-card">
                    <div class="info-card-header">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="display:inline;margin-right:5px;vertical-align:middle">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        Panduan Rating
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <div class="info-item-icon" style="background:#DCFCE7;color:#166534">★</div>
                            <div>
                                <div class="info-item-title">4.0 – 5.0 · Sangat Baik</div>
                                <div class="info-item-desc">Pengiriman tepat waktu, kualitas terjaga</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-icon" style="background:#FEF3C7;color:#92400E">★</div>
                            <div>
                                <div class="info-item-title">2.5 – 3.9 · Cukup</div>
                                <div class="info-item-desc">Perlu pengawasan, ada catatan minor</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-icon" style="background:#FEE2E2;color:#991B1B">★</div>
                            <div>
                                <div class="info-item-title">0 – 2.4 · Perlu Evaluasi</div>
                                <div class="info-item-desc">Pertimbangkan penggantian supplier</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="info-card">
                    <div class="info-card-header">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="display:inline;margin-right:5px;vertical-align:middle">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        Tips
                    </div>
                    <div class="info-card-body">
                        <div class="info-item">
                            <div>
                                <div class="info-item-desc">Gunakan nama resmi perusahaan sesuai dokumen legal (PT, CV,
                                    dll).</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div>
                                <div class="info-item-desc">Isi nomor telepon kantor, bukan nomor pribadi sales.</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div>
                                <div class="info-item-desc">Rating dapat diubah kapan saja melalui tombol Edit.</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

@endsection
