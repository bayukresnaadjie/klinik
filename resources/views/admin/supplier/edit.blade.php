@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Edit Supplier')

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

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 18px;
            align-items: start;
        }

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

        .rating-input-wrap {
            position: relative;
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

        /* Sidebar */
        .side-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .side-card-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .side-card-body {
            padding: 14px 16px;
        }

        /* Supplier preview */
        .supplier-preview {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .preview-logo {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-sm);
            background: #EFF6FF;
            color: var(--clr-blue);
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .preview-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .preview-sub {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .meta-row:last-child {
            border-bottom: none;
        }

        .meta-label {
            color: var(--tx-muted);
        }

        .meta-val {
            font-weight: 500;
            color: var(--tx-base);
        }

        .badge-aktif {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: #DCFCE7;
            color: #166534;
        }

        .badge-nonaktif {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: #F3F4F6;
            color: #6B7280;
        }

        .star-f {
            color: #F59E0B;
        }

        .star-e {
            color: #E5E7EB;
        }

        /* Danger zone */
        .danger-zone {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: var(--radius);
            padding: 14px 16px;
        }

        .danger-title {
            font-size: 12px;
            font-weight: 600;
            color: #991B1B;
            margin-bottom: 6px;
        }

        .danger-desc {
            font-size: 11px;
            color: #B91C1C;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .btn-danger {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            width: 100%;
            justify-content: center;
        }

        .btn-danger:hover {
            background: #FEE2E2;
            border-color: var(--clr-red);
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
            <div class="back-title">Edit Supplier</div>
            <div class="back-sub">Perbarui informasi supplier</div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.supplier.update', $supplier->id_supplier) }}">
        @csrf @method('PUT')
        <div class="form-layout">

            {{-- ── FORM UTAMA ── --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-header-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </div>
                    <div>
                        <div class="form-card-title">Edit Informasi Supplier</div>
                        <div class="form-card-sub">Perubahan akan langsung tersimpan</div>
                    </div>
                </div>
                <div class="form-card-body">

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="form-label">
                            Nama Supplier <span class="req">*</span>
                        </label>
                        <input type="text" name="nama" class="form-input {{ $errors->has('nama') ? 'error' : '' }}"
                            value="{{ old('nama', $supplier->nama) }}">
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
                                class="form-input {{ $errors->has('kota') ? 'error' : '' }}"
                                value="{{ old('kota', $supplier->kota) }}">
                            @error('kota')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rating</label>
                            <div class="rating-input-wrap">
                                <input type="number" name="rating" step="0.1" min="0" max="5"
                                    class="form-input {{ $errors->has('rating') ? 'error' : '' }}"
                                    value="{{ old('rating', $supplier->rating) }}">
                                <span class="rating-suffix">/ 5.0</span>
                            </div>
                            @error('rating')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="form-input {{ $errors->has('alamat') ? 'error' : '' }}">{{ old('alamat', $supplier->alamat) }}</textarea>
                        @error('alamat')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kontak & Email --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="kontak"
                                class="form-input {{ $errors->has('kontak') ? 'error' : '' }}"
                                value="{{ old('kontak', $supplier->kontak) }}">
                            @error('kontak')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                                value="{{ old('email', $supplier->email) }}">
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status Supplier</label>
                        <div class="toggle-group">
                            <div class="toggle-info">
                                <div class="toggle-title">Supplier Aktif</div>
                                <div class="toggle-desc">Supplier aktif dapat digunakan untuk pengadaan obat</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="aktif" value="1"
                                    {{ old('aktif', $supplier->aktif) ? 'checked' : '' }}>
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
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.supplier.index') }}" class="btn-cancel">Batal</a>
                </div>
            </div>

            {{-- ── SIDEBAR ── --}}
            <div style="display:flex; flex-direction:column; gap:14px">

                {{-- Preview Supplier --}}
                <div class="side-card">
                    <div class="side-card-header">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Info Supplier
                    </div>
                    <div class="side-card-body">
                        <div class="supplier-preview">
                            <div class="preview-logo">
                                {{ strtoupper(substr($supplier->nama, 0, 2)) }}
                            </div>
                            <div>
                                <div class="preview-name">{{ $supplier->nama }}</div>
                                <div class="preview-sub">{{ $supplier->kota ?? 'Kota belum diisi' }}</div>
                            </div>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Status</span>
                            @if ($supplier->aktif)
                                <span class="badge-aktif">Aktif</span>
                            @else
                                <span class="badge-nonaktif">Non-Aktif</span>
                            @endif
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Rating</span>
                            <span class="meta-val" style="display:flex;align-items:center;gap:2px">
                                @for ($s = 1; $s <= 5; $s++)
                                    <span class="{{ $s <= round($supplier->rating) ? 'star-f' : 'star-e' }}"
                                        style="font-size:13px">★</span>
                                @endfor
                                <span style="margin-left:4px;font-size:12px;color:var(--tx-muted)">
                                    {{ number_format($supplier->rating, 1) }}
                                </span>
                            </span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Ditambahkan</span>
                            <span class="meta-val">{{ $supplier->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Terakhir diubah</span>
                            <span class="meta-val">{{ $supplier->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="danger-zone">
                    <div class="danger-title">⚠ Hapus Supplier</div>
                    <div class="danger-desc">
                        Menghapus supplier bersifat permanen dan tidak dapat dibatalkan.
                        Pastikan supplier tidak memiliki data stok terkait.
                    </div>
                    <form method="POST" action="{{ route('admin.supplier.destroy', $supplier->id_supplier) }}"
                        id="form-hapus-supplier">
                        onsubmit="return confirmHapusSupplier(event)">
                        @csrf @method('DELETE')
                        <button type="button" class="btn-danger" onclick="konfirmasiHapus()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14H6L5 6" />
                                <path d="M10 11v6M14 11v6M9 6V4h6v2" />
                            </svg>
                            Hapus Supplier Ini
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </form>

@endsection

@push('scripts')
    <script>
        function konfirmasiHapus() {
            showConfirmModal({
                type: 'reject',
                title: 'Hapus Supplier?',
                message: 'Data "{{ $supplier->nama }}" akan dihapus permanen dan tidak bisa dikembalikan.',
                onConfirm: () => document.getElementById('form-hapus-supplier').submit(),
            });
        }
    </script>
@endpush
