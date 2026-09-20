@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Profil Saya')

@push('styles')
    <style>
        /* ══ LAYOUT ══ */
        .ep-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 860px) {
            .ep-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ══ CARD ══ */
        .ep-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .ep-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #FAFAFA;
        }

        .ep-card-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ep-card-icon.blue {
            background: #EFF6FF;
            color: var(--clr-blue);
        }

        .ep-card-icon.yellow {
            background: #FEF3C7;
            color: #d97706;
        }

        .ep-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-base);
        }

        .ep-card-sub {
            font-size: 11px;
            color: var(--tx-sub);
            margin-top: 1px;
        }

        .ep-card-body {
            padding: 20px;
        }

        /* ══ LEFT COLUMN — Avatar Card ══ */
        .ep-avatar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 28px 20px;
            text-align: center;
        }

        .ep-avatar-ring {
            position: relative;
            margin-bottom: 14px;
        }

        .ep-avatar-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border);
        }

        .ep-avatar-initials {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sb-accent, #F5A623), #f97316);
            color: #412402;
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #fff;
            box-shadow: 0 0 0 1px var(--border);
        }

        .ep-avatar-upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--clr-blue);
            color: #fff;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .15s;
        }

        .ep-avatar-upload-btn:hover {
            background: #2563EB;
        }

        .ep-avatar-name {
            font-family: 'Sora', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--tx-base);
        }

        .ep-avatar-email {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 3px;
        }

        .ep-avatar-role {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            background: rgba(245, 166, 35, .1);
            color: #92400E;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid rgba(245, 166, 35, .22);
        }

        .ep-avatar-hint {
            margin-top: 12px;
            font-size: 11px;
            color: var(--tx-sub);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: var(--page-bg);
            border: 1px solid var(--border);
            line-height: 1.6;
            text-align: left;
        }

        /* ══ FORM ══ */
        .ep-field {
            margin-bottom: 16px;
        }

        .ep-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tx-muted);
            margin-bottom: 5px;
            letter-spacing: .02em;
        }

        .ep-req {
            color: var(--clr-red);
            font-size: 10px;
        }

        .ep-input {
            width: 100%;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--tx-base);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .ep-input:focus {
            border-color: var(--clr-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .1);
            background: #fff;
        }

        .ep-input::placeholder {
            color: var(--tx-sub);
        }

        .ep-input:disabled {
            opacity: .6;
            cursor: not-allowed;
            background: #F3F4F6;
        }

        .ep-input.is-invalid {
            border-color: var(--clr-red);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .08);
        }

        .ep-error {
            font-size: 11px;
            color: var(--clr-red);
            margin-top: 4px;
        }

        /* Password field with toggle */
        .ep-pw-wrap {
            position: relative;
        }

        .ep-pw-wrap .ep-input {
            padding-right: 38px;
        }

        .ep-pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--tx-sub);
            display: flex;
            align-items: center;
            transition: color .15s;
            padding: 0;
        }

        .ep-pw-toggle:hover {
            color: var(--clr-blue);
        }

        /* Row 2 cols */
        .ep-row2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 600px) {
            .ep-row2 {
                grid-template-columns: 1fr;
            }
        }

        /* ══ BUTTONS ══ */
        .ep-btn-row {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 4px;
        }

        .ep-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all .15s;
        }

        .ep-btn:active {
            transform: scale(.98);
        }

        .ep-btn-primary {
            background: var(--clr-blue);
            color: #fff;
            border-color: var(--clr-blue);
        }

        .ep-btn-primary:hover {
            opacity: .88;
            box-shadow: 0 4px 12px rgba(59, 130, 246, .25);
        }

        .ep-btn-danger {
            background: var(--clr-red);
            color: #fff;
            border-color: var(--clr-red);
        }

        .ep-btn-danger:hover {
            opacity: .88;
            box-shadow: 0 4px 12px rgba(239, 68, 68, .25);
        }

        .ep-btn-ghost {
            background: var(--card-bg);
            color: var(--tx-muted);
            border-color: var(--border);
        }

        .ep-btn-ghost:hover {
            background: var(--page-bg);
            color: var(--tx-base);
        }

        /* ══ DIVIDER ══ */
        .ep-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            color: var(--tx-sub);
            font-size: 11px;
        }

        .ep-divider::before,
        .ep-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ══ WARN BOX ══ */
        .ep-warn {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            padding: 11px 13px;
            border-radius: var(--radius-sm);
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            font-size: 12px;
            color: #92400E;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .ep-warn svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ══ PAGE TITLE ══ */
        .ep-page-header {
            margin-bottom: 20px;
        }

        .ep-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--tx-base);
            letter-spacing: -.01em;
        }

        .ep-page-sub {
            font-size: 12px;
            color: var(--tx-muted);
            margin-top: 2px;
        }

        /* File input hidden */
        #fotoInput {
            display: none;
        }
    </style>
@endpush

@section('content')

    {{-- Page Header --}}
    <div class="ep-page-header">
        <div class="ep-page-title">Profil Saya</div>
        <div class="ep-page-sub">Kelola informasi akun dan keamanan Anda</div>
    </div>

    <div class="ep-grid">

        {{-- ══ LEFT: Avatar Card ══ --}}
        <div>
            <div class="ep-card">
                <div class="ep-avatar-wrap">
                    <div class="ep-avatar-ring">
                        @if (auth()->user()->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="ep-avatar-img"
                                id="previewImg">
                        @else
                            <div class="ep-avatar-initials" id="avatarInitials">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <label for="fotoInput" class="ep-avatar-upload-btn" title="Ganti foto">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>
                        </label>
                    </div>

                    <div class="ep-avatar-name">{{ auth()->user()->name }}</div>
                    <div class="ep-avatar-email">{{ auth()->user()->email }}</div>
                    <div class="ep-avatar-role">✦ {{ ucfirst(auth()->user()->role ?? 'User') }}</div>

                    <div class="ep-avatar-hint">
                        📷 Klik ikon kamera untuk mengganti foto profil.<br>
                        Format: <strong>JPG / PNG</strong> — Maks. <strong>2 MB</strong>
                    </div>
                </div>
            </div>

            {{-- Info akun --}}
            <div class="ep-card" style="margin-top:14px;">
                <div class="ep-card-header">
                    <div class="ep-card-icon blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <div class="ep-card-title">Info Akun</div>
                        <div class="ep-card-sub">Detail akun Anda</div>
                    </div>
                </div>
                <div class="ep-card-body" style="padding:16px 20px;">
                    @php
                        $rows = [
                            ['label' => 'ID Akun', 'val' => '#' . auth()->id()],
                            ['label' => 'Role', 'val' => ucfirst(auth()->user()->role ?? '-')],
                            ['label' => 'Bergabung', 'val' => auth()->user()->created_at?->format('d M Y') ?? '-'],
                            [
                                'label' => 'Login Terakhir',
                                'val' => auth()->user()->last_login_at
                                    ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans()
                                    : 'Sekarang',
                            ],
                        ];
                    @endphp
                    @foreach ($rows as $row)
                        <div
                            style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                            <span style="font-size:11.5px;color:var(--tx-muted);">{{ $row['label'] }}</span>
                            <span style="font-size:12px;font-weight:600;color:var(--tx-base);">{{ $row['val'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══ RIGHT COLUMN ══ --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Card 1: Informasi Profil --}}
            <div class="ep-card">
                <div class="ep-card-header">
                    <div class="ep-card-icon blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <div class="ep-card-title">Informasi Profil</div>
                        <div class="ep-card-sub">Perbarui nama, jabatan, dan nomor telepon</div>
                    </div>
                </div>
                <div class="ep-card-body">
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data"
                        id="formProfil">
                        @csrf
                        @method('PUT')

                        {{-- Hidden foto input --}}
                        <input type="file" id="fotoInput" name="foto" accept="image/jpeg,image/png"
                            onchange="previewFoto(this)">

                        <div class="ep-row2">
                            <div class="ep-field">
                                <label class="ep-label" for="name">
                                    Nama Lengkap <span class="ep-req">*</span>
                                </label>
                                <input id="name" name="name" type="text"
                                    class="ep-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="ep-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="ep-field">
                                <label class="ep-label" for="jabatan">Jabatan</label>
                                <input id="jabatan" name="jabatan" type="text"
                                    class="ep-input {{ $errors->has('jabatan') ? 'is-invalid' : '' }}"
                                    value="{{ old('jabatan', auth()->user()->jabatan ?? '') }}"
                                    placeholder="contoh: Apoteker, Admin...">
                                @error('jabatan')
                                    <div class="ep-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ep-row2">
                            <div class="ep-field">
                                <label class="ep-label" for="email">Email</label>
                                <input id="email" type="email" class="ep-input"
                                    value="{{ auth()->user()->email }}" disabled>
                                <div style="font-size:11px;color:var(--tx-sub);margin-top:4px;">Email tidak dapat diubah.
                                </div>
                            </div>
                            <div class="ep-field">
                                <label class="ep-label" for="no_telepon">No. Telepon</label>
                                <input id="no_telepon" name="no_telepon" type="text"
                                    class="ep-input {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}"
                                    value="{{ old('no_telepon', auth()->user()->no_telepon ?? '') }}"
                                    placeholder="contoh: 08123456789">
                                @error('no_telepon')
                                    <div class="ep-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ep-btn-row">
                            <button type="reset" class="ep-btn ep-btn-ghost">Batal</button>
                            <button type="submit" class="ep-btn ep-btn-primary">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card 2: Ganti Password --}}
            <div class="ep-card">
                <div class="ep-card-header">
                    <div class="ep-card-icon yellow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>
                    <div>
                        <div class="ep-card-title">Ganti Password</div>
                        <div class="ep-card-sub">Perbarui kata sandi akun Anda</div>
                    </div>
                </div>
                <div class="ep-card-body">

                    <div class="ep-warn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                            <line x1="12" x2="12.01" y1="17" y2="17" />
                        </svg>
                        <span>Password baru minimal <strong>8 karakter</strong>. Pastikan Anda mengingat password baru
                            setelah disimpan.</span>
                    </div>

                    <form action="{{ route('profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="ep-field">
                            <label class="ep-label" for="current_password">
                                Password Lama <span class="ep-req">*</span>
                            </label>
                            <div class="ep-pw-wrap">
                                <input id="current_password" name="current_password" type="password"
                                    class="ep-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                    placeholder="Masukkan password saat ini" autocomplete="current-password">
                                <button type="button" class="ep-pw-toggle" onclick="togglePw('current_password', this)">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="ep-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ep-row2">
                            <div class="ep-field">
                                <label class="ep-label" for="password">
                                    Password Baru <span class="ep-req">*</span>
                                </label>
                                <div class="ep-pw-wrap">
                                    <input id="password" name="password" type="password"
                                        class="ep-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        placeholder="Minimal 8 karakter" autocomplete="new-password">
                                    <button type="button" class="ep-pw-toggle" onclick="togglePw('password', this)">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="ep-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="ep-field">
                                <label class="ep-label" for="password_confirmation">
                                    Konfirmasi Password <span class="ep-req">*</span>
                                </label>
                                <div class="ep-pw-wrap">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        class="ep-input" placeholder="Ulangi password baru" autocomplete="new-password">
                                    <button type="button" class="ep-pw-toggle"
                                        onclick="togglePw('password_confirmation', this)">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Password strength bar --}}
                        <div id="pwStrengthWrap" style="display:none;margin-bottom:14px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span style="font-size:11px;color:var(--tx-muted);">Kekuatan password</span>
                                <span id="pwStrengthLabel" style="font-size:11px;font-weight:600;"></span>
                            </div>
                            <div style="height:5px;background:var(--page-bg);border-radius:99px;overflow:hidden;">
                                <div id="pwStrengthBar"
                                    style="height:100%;border-radius:99px;transition:width .3s,background .3s;width:0%;">
                                </div>
                            </div>
                        </div>

                        <div class="ep-btn-row">
                            <button type="reset" class="ep-btn ep-btn-ghost">Batal</button>
                            <button type="submit" class="ep-btn ep-btn-danger">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>{{-- /right col --}}
    </div>{{-- /grid --}}

@endsection

@push('scripts')
    <script>
        /* ── Toggle password visibility ── */
        function togglePw(inputId, btn) {
            var inp = document.getElementById(inputId);
            var isText = inp.type === 'text';
            inp.type = isText ? 'password' : 'text';
            btn.querySelector('svg').innerHTML = isText ?
                '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>' :
                '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        }

        /* ── Password strength ── */
        document.getElementById('password').addEventListener('input', function() {
            var val = this.value;
            var wrap = document.getElementById('pwStrengthWrap');
            var bar = document.getElementById('pwStrengthBar');
            var label = document.getElementById('pwStrengthLabel');

            if (!val) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = 'block';

            var score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            var configs = [{
                    pct: '25%',
                    bg: '#EF4444',
                    text: 'Lemah',
                    color: '#EF4444'
                },
                {
                    pct: '50%',
                    bg: '#F59E0B',
                    text: 'Cukup',
                    color: '#F59E0B'
                },
                {
                    pct: '75%',
                    bg: '#3B82F6',
                    text: 'Kuat',
                    color: '#3B82F6'
                },
                {
                    pct: '100%',
                    bg: '#22C55E',
                    text: 'Sangat Kuat',
                    color: '#22C55E'
                },
            ];
            var cfg = configs[Math.max(0, score - 1)];
            bar.style.width = cfg.pct;
            bar.style.background = cfg.bg;
            label.textContent = cfg.text;
            label.style.color = cfg.color;
        });

        /* ── Preview foto ── */
        function previewFoto(input) {
            if (!input.files || !input.files[0]) return;
            var file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto maksimal 2 MB.');
                input.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                var initials = document.getElementById('avatarInitials');
                var preview = document.getElementById('previewImg');
                if (initials) {
                    initials.style.display = 'none';
                    if (!preview) {
                        var img = document.createElement('img');
                        img.id = 'previewImg';
                        img.className = 'ep-avatar-img';
                        initials.parentNode.insertBefore(img, initials);
                        preview = img;
                    }
                    preview.style.display = 'block';
                }
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);

            // Auto-submit the profile form to save photo
            document.getElementById('formProfil').submit();
        }
    </script>
@endpush
