@extends('layouts.app')

@section('title', 'Buat Pengajuan')
@section('page-title', 'Buat Pengajuan Baru')

@push('styles')
    <style>
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            max-width: 100%;
        }

        .form-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-header-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tx-muted);
        }

        .form-header-title {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--tx-base);
        }

        .form-header-sub {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .form-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--tx-base);
            margin-bottom: 6px;
            letter-spacing: .02em;
        }

        .form-label .required {
            color: var(--clr-red);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            color: var(--tx-base);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            appearance: none;
        }

        .form-control:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .08);
            background: #fff;
        }

        .form-control.is-invalid {
            border-color: var(--clr-red);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .07);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .invalid-feedback {
            font-size: 11.5px;
            color: var(--clr-red);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint {
            font-size: 11.5px;
            color: var(--tx-muted);
            margin-top: 5px;
        }

        /* Tipe selector — card style */
        .tipe-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .tipe-option {
            position: relative;
        }

        .tipe-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            margin: 0;
            z-index: 1;
        }

        .tipe-label {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            cursor: pointer;
            transition: all .15s;
            user-select: none;
        }

        .tipe-option input:checked+.tipe-label {
            border-color: var(--clr-blue);
            background: #EFF6FF;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, .12);
        }

        .tipe-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .tipe-text {
            flex: 1;
        }

        .tipe-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .tipe-desc {
            font-size: 11px;
            color: var(--tx-muted);
            margin-top: 1px;
        }

        .check-icon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .tipe-option input:checked~.tipe-label .check-icon {
            background: var(--clr-blue);
            border-color: var(--clr-blue);
        }

        /* Form footer */
        .form-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--sb-bg);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-submit:hover {
            opacity: .85;
        }

        .btn-submit:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: var(--tx-muted);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-cancel:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        @media (max-width: 600px) {
            .tipe-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    <div class="form-card">
        <div class="form-header">
            <div class="form-header-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="12" y1="18" x2="12" y2="12" />
                    <line x1="9" y1="15" x2="15" y2="15" />
                </svg>
            </div>
            <div>
                <div class="form-header-title">Buat Pengajuan Baru</div>
                <div class="form-header-sub">Pengajuan akan dikirim ke Manager untuk disetujui</div>
            </div>
        </div>

        <form action="{{ route('approval-requests.store') }}" method="POST" id="approval-form">
            @csrf

            <div class="form-body">

                {{-- Judul --}}
                <div class="form-group">
                    <label class="form-label" for="judul">
                        Judul <span class="required">*</span>
                    </label>
                    <input type="text" id="judul" name="judul"
                        class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}" value="{{ old('judul') }}"
                        placeholder="Contoh: Restock Paracetamol 500mg" autocomplete="off">
                    @error('judul')
                        <div class="invalid-feedback">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        placeholder="Jelaskan alasan pengajuan ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Opsional. Maksimal 255 karakter.</div>
                </div>

                {{-- Tipe --}}
                <div class="form-group">
                    <label class="form-label">
                        Tipe Pengajuan <span class="required">*</span>
                    </label>
                    <div class="tipe-grid">

                        <label class="tipe-option">
                            <input type="radio" name="tipe" value="restock"
                                {{ old('tipe', 'restock') === 'restock' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-icon" style="background:#EFF6FF">📦</div>
                                <div class="tipe-text">
                                    <div class="tipe-name">Restock</div>
                                    <div class="tipe-desc">Permintaan penambahan stok</div>
                                </div>
                                <div class="check-icon">
                                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" stroke="white"
                                        stroke-width="2.5">
                                        <polyline points="2 6 5 9 10 3" />
                                    </svg>
                                </div>
                            </div>
                        </label>

                        <label class="tipe-option">
                            <input type="radio" name="tipe" value="supplier"
                                {{ old('tipe') === 'supplier' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-icon" style="background:#F0FDF4">🏭</div>
                                <div class="tipe-text">
                                    <div class="tipe-name">Supplier</div>
                                    <div class="tipe-desc">Penambahan supplier baru</div>
                                </div>
                                <div class="check-icon">
                                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" stroke="white"
                                        stroke-width="2.5">
                                        <polyline points="2 6 5 9 10 3" />
                                    </svg>
                                </div>
                            </div>
                        </label>

                        <label class="tipe-option">
                            <input type="radio" name="tipe" value="hapus_batch"
                                {{ old('tipe') === 'hapus_batch' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-icon" style="background:#FEF2F2">🗑️</div>
                                <div class="tipe-text">
                                    <div class="tipe-name">Hapus Batch</div>
                                    <div class="tipe-desc">Penghapusan batch kadaluarsa</div>
                                </div>
                                <div class="check-icon">
                                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none"
                                        stroke="white" stroke-width="2.5">
                                        <polyline points="2 6 5 9 10 3" />
                                    </svg>
                                </div>
                            </div>
                        </label>

                        <label class="tipe-option">
                            <input type="radio" name="tipe" value="tambah_obat"
                                {{ old('tipe') === 'tambah_obat' ? 'checked' : '' }}>
                            <div class="tipe-label">
                                <div class="tipe-icon" style="background:#FFF7ED">💊</div>
                                <div class="tipe-text">
                                    <div class="tipe-name">Tambah Obat</div>
                                    <div class="tipe-desc">Pendaftaran obat baru</div>
                                </div>
                                <div class="check-icon">
                                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none"
                                        stroke="white" stroke-width="2.5">
                                        <polyline points="2 6 5 9 10 3" />
                                    </svg>
                                </div>
                            </div>
                        </label>

                    </div>
                    @error('tipe')
                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn-submit" id="btn-submit">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="22" y1="2" x2="11" y2="13" />
                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                    </svg>
                    Kirim Pengajuan
                </button>
                <a href="{{ route('approval-requests.index') }}" class="btn-cancel">Batal</a>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('approval-form').addEventListener('submit', function() {
            var btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML =
                '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin .8s linear infinite"><polyline points="23 4 23 11 16 11"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 11"/></svg> Mengirim...';
        });
    </script>
    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
